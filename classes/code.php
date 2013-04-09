<?php

include_once(dirname(__FILE__) . '/../config.php');

class Code {

    public function __construct($toexec, $type, $inputs = Null) {
        $this->text = trim($toexec);
        $this->tempfile = '';
        $this->outputs = array();
        $this->type = $type;
        $this->inputs = $inputs;
        if ($this->type == TYPE_FUNCTION)
            $this->cleanFunction();
        else {
            $this->endWithSemicolon();
        }
    }

    private function endWithSemicolon() {
        //make sure it ends with a semi-colon
        //but we only care if it ends with a semicolon if it doesn't end with a }
        if (!$this->endsWith($this->text, '}')) {
            if (!$this->endsWith($this->text, ';')) {
                throw new Exception(ERR_MESSAGE_SEMICOLON);
            }
        }
    }

    public function getExecutableCode() {
        return $this->text;
    }

    private function cleanFunction() {
        $count = 0;

        $regexp = "/function ([A-Za-z0-9]*)/";

        $this->text = preg_replace($regexp, "function", $this->text, -1, $count);

        //all functions (transparently) need to end with a semicolon
        $this->text = ($this->endsWith($this->text, ';') ? $this->text : $this->text . ';');

        //if it is a function need to preface with the following string
        $this->text = '$this->text = ' . $this->text;
        if ($count == 0) {
            throw new Exception(ERR_MESSAGE_NOT_A_FUNCTION);
        }
    }

    public function getOutputs() {
        return $this->outputs;
    }

    public function evaluate() {

        logMe('IN evaluate function', 'code');
        logMe('The type is' . $this->type, 'code');
        ob_start();

        switch ($this->type) {
            case TYPE_FUNCTION:
            case "function":
                $this->test_function();
                break;
            case TYPE_DB:
            case "database":
                $this->test_database();
                break;
            case TYPE_OUTPUT:
            case "output":
                $this->test_output();
                break;
            case TYPE_SESSION:
            case "session";
                $this->test_session();
                break;
            default:
                throw new Exception(ERR_MESSAGE_INVALID_PROBLEM);
        }//end switch
        ob_get_clean();
    }

    private function test_database() {
        /* i need to rollback after we do anything here!
         * This is VERY UNSAFE
         * 
         * Change to use mysqli anyways!!!
         * TABLE MUST BE INNOdB
         */

        logMe("Testing DATABASE:", 'code');
        $app_conn = mysqli_connect(APP_DB_HOST, APP_DB_USER, APP_DB_PASSWORD, APP_DB_DATABASE);
        if (!$app_conn) {
            throw new Exception("Unable to connect to database");
        } else {

            $isDirty = False;

            eval($this->text);

            //$sql should exist as a variable when evaled

            if (isset($sql)) {
                $res = mysqli_query($app_conn, $sql);
                logMe("Query: $sql", 'code');

                //uncommenting the following log line breaks things!!
                //logMe("Result: $res", 'code');
                if (!$res) {
                    @$s = mysqli_error($app_conn);
                    throw new Exception("MySQL Error , check your syntax : $s");
                } else {
                    //could use the following to see what table it is
                    //and check if innoDB, if not throw error
                    //$fields = mysqli_fetch_fields();
                    //logMe("Table name $fields->table");
                    //$this->outputs = print_r($res, true);
                    //$this->outputs = print_r($res, true);
                    $fields = 0;
                    $all = 0;
                    $numRows = 0;
                    $numFields = 0;
                    if(is_object($res))
                    {
                        $fields = print_r(mysqli_fetch_fields($res), true);
                        $all = print_r(mysqli_fetch_all($res), true);
                        $numRows = mysqli_num_rows($res);
                        $numFields = mysqli_num_fields($res);
                    }

                    $this->outputs = array(
                        'numRows' =>$numRows, 
                        'numFields' => $numFields, 
                        'affectedRows' => mysqli_affected_rows($app_conn),
                        'fields' => $fields,
                        'all' => $all
                        );
                    $isDirty = True;
                }
            } else {
                throw new Exception('Variable $sql was not found');
            }
            
           //close the daatabase connection
            mysqli_close($app_conn);
        }
        //get database back to norm... THis is after committing otherwise
        //i cannot pull numRows, fields, etc... above
        /* if($isDirty)
          {
          //should fix all APP tables back to NORMAL state here
          return;
          } */
    }

    private function test_output() {
        logMe("Testing OUTPUT:", 'code');
        ob_start();
        $this->execute_me();
        //eval($this->text);
        $output = trim(ob_get_clean());
        logMe('Testing_output', 'code');
        logMe($output, 'code');
        $this->outputs[] = $output;
    }

    //this method is used to see if there are parse errors
    private function makeTempCodeFile() {
        $this->tempfile = tempnam('/tmp', 'php_console_');
        $fh = fopen($this->tempfile, 'w');
        fwrite($fh, "<?php \n");
        fwrite($fh, $this->text);
        fwrite($fh, "\n ?>");
        fclose($fh);
    }

    private function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        $start = $length * -1; //negative
        return (substr($haystack, $start) === $needle);
    }

    public function fileSizeIsGood() {
        if ($this->tempfile == '') {
            $this->makeTempCodeFile();
        }
        $size = filesize($this->tempfile);
        return ($size < FILESIZE);
    }

    public function areParseErrors() {
        ob_start();
        $cmd = "/usr/bin/php -l $this->tempfile";
        $output = system($cmd, $retval);
        unlink($this->tempfile);
        ob_get_clean();
        return preg_match("/Errors parsing/", $output);
    }

    private function test_function() {

        $res = null;

        logMe("Now testing the function with the following inputs:", 'function');
        logMe($this->inputs, 'function');

        logMe("this->text: " . $this->text, 'function');
        $this->execute_me();
        foreach ($this->inputs as $i) {
            $res = call_user_func_array($this->text, $i);
            (DEBUGGING) ? var_dump($res) : '';
            $this->outputs[] = trim($res);
        }

        if (!$res) {
            throw new Exception(ERR_MESSAGE_CANNOT_PROCESS_FUNCTION);
            exit(1);
        }
    }

    public function setSessionName($name) {
        $this->sessName = $name;
    }

    public function setSessionValue($val) {
        $this->sessValue = $val;
    }

    private function execute_me() {
        //prepend some timeout junk
        //make sure they aren't trying to reset the time limit? preg_match?
        //could perhaps search for bad commands (i.e. sys commands)
//        $pre = "set_time_limit(MAX_EXECUTION_TIME);";
//        $pre .= "function shut_me_down(){
//            throw Exception('Timeout Exceeded');
//            logMe('DEATH *****', 'error');
//            exit(1);
//};";
//        $pre .= "register_shutdown_function('shut_me_down');";
//        $this->text = $pre . $this->text;

        eval($this->text);
    }

    private function test_session() {
        $cur_session_items = count($_SESSION);
        $good_keys = array_keys($_SESSION);
        $exception = eval($this->text);
        if ($exception !== null) {
            throw new Exception("Testing session failed");
            exit(1);
        }
//        logMe("here is my session variable", 'session');
//        logMe($_SESSION, 'session');
        if (count($_SESSION) > $cur_session_items) {
            foreach ($_SESSION as $sess_key => $sess_value) {
                if(is_string($sess_value))
                {
                    $this->outputs[$sess_key] = trim($sess_value);
                }
                elseif (is_array($sess_value))
                {
//                    //maybe i want to save arrays as different way?
                    $this->outputs[$sess_key] = $sess_value;

                }
                else {
                    $this->outputs[$sess_key] = $sess_value;
                }
                logMe("Now seeing if $sess_key is in array", 'session');
                if (!in_array($sess_key, $good_keys)) {
                    logMe("I am going to unset the key $sess_key", 'session');
                    $_SESSION[$sess_key] = NULL;
                    unset($_SESSION[$sess_key]);
                }
            }
            logMe("The outputs of the session are ", 'session');
            logMe($this->outputs, 'session');
        } else {
            $text = " no session was set";
            logMe($text, 'session');
            throw new Exception($text);
        }
    }

    public function __destruct() {
//    if (file_exists($this->tempfile)) {
//              unlink($this->tempfile);
//          }
    }

}

?>