<?php

include_once(dirname(__FILE__) . '/../config.php');
include_once(DOCROOT . 'includes/databaseFunctions.php');
include_once(DOCROOT . 'classes/code.php');

class Question {

    public function __construct($id = Null) {
        if (isset($id)) {
            $this->id = $id;
            //$this->loadProblemFromDB();
            $this->loadAttributeFromDB('type');
            $this->loadAttributeFromDB('name');
            $this->loadAttributeFromDB('text');
        }
    }
    
    public function getNewID() {
        if (!isset($this->id)) {
            if (isset($this->type)) {
                $mysqli = getMysqliConnector();
                $questionTable = DB_TABLE_PREFIX . 'questions';

                $query = "INSERT INTO $questionTable (question_type) VALUES (?)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('i', $this->type);
                $stmt->execute();
                $this->id = $mysqli->insert_id;
                logMe("ID: $this->id was created in teh database", 'database');
            }
            else
                throw new Exception("You must set a question type prior to calling this");
        }
        else {
            throw new Exception("This function is only used to create a new question, not change an ID");
        }

        return (isset($this->id));
    }

    public function getType() {
        switch ($this->type) {
            case TYPE_DB:
                return "Database";
                break;
            case TYPE_FUNCTION;
                return "Function";
                break;
            case TYPE_SESSION;
                return "Session";
                break;
            case TYPE_OUTPUT:
                return "Output";
                break;
        }
    }
    
    public function setType($type) {
        //these numbers come from defined TYPES above
        if ($type == TYPE_DB || $type == TYPE_FUNCTION || $type == TYPE_OUTPUT || $type == TYPE_SESSION) {
            $this->type = $type;
        } else {
            throw new Exception("Invalid question type");
            exit(1);
        }
    }

    public function saveQuestion() {

        if (isset($this->type) && isset($this->code) && isset($this->text) && isset($this->name)) {
            if (!isset($this->id)) {
                $this->getNewID();
            }
            $mysqli = getMysqliConnector();
            $questionTable = DB_TABLE_PREFIX . 'questions';

            $query = "UPDATE $questionTable set question_type = ?, question_name = ?, question_text = ?, question_solution = ?
            where question_id = ?";
            logMe("Query $query", 'database');

            $stmt = $mysqli->prepare($query);
            if (!$stmt) {
                throw new Exception("Failed to create statement for: $query", 'database');
                exit(1);
            }
            if (!$stmt->bind_param('isssi', $this->type, $this->name, $this->text, $this->code, $this->id)) {
                throw new Exception($mysqli->error);
                exit(1);
            }
            if (!$stmt->execute()) {
                throw new Exception($mysqli->error);
                exit(1);
            }
            $mysqli->close();
        } else {
            $errText = "Unable to save question, qTYpe: $this->type, qCode= $this->code, text: $this->text, name: $this->name";
            logMe($errText, 'database');
            throw new Exception($errText);
            exit(1);
        }
    }

    private function loadAttributeFromDB($attrName) {
        $mysqli = getMysqliConnector();
        $questionTable = DB_TABLE_PREFIX . 'questions';

        $query = "SELECT question_$attrName
        FROM $questionTable
        where question_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();

        $stmt->bind_result($this->$attrName);
        $stmt->fetch();


        //get all inputs for the problem
    }

    //this is only used when saving new questions via ajaxSave.php
    public function setCode($code) {
        $codeObj = new Code($code, $this->type);
        logMe("Created code obj", 'code');
        $this->checkFileSizeAndParseErrors($codeObj);
        logMe("passed parse errors", 'code');
        $codeObj->evaluate();
        logMe("passed evaluate", 'code');
        $this->code = $codeObj->getExecutableCode();
    }

    public function getCode() {
        if (!isset($this->solution)) {
            $this->loadAttributeFromDB('solution');
            return $this->solution;
        } else {
            return 'No solution present.';
        }
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setQuestionText($text) {
        //get rid of any weird html characters
        $text = htmlentities($text);
        $this->text = $text;
    }

    public function getQuestionText() {
        if (isset($this->text))
            return $this->text;
        else
            return 'Need to add text to question';
    }

    private function checkFileSizeAndParseErrors($code_obj) {
        if (!$code_obj->fileSizeIsGood()) {
            throw new Exception(ERR_MESSAGE_FILE_TOO_BIG_ERROR);
            exit(1);
        }

        if ($code_obj->areParseErrors()) {
            throw new Exception(ERR_MESSAGE_PARSE_ERROR);
            exit(1);
        }
    }
    
      private function get_random_string() {
        $name_length = mt_rand(0, 10);
        $alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return substr(str_shuffle($alpha_numeric), 0, $name_length);
    }

    private function get_random_integer() {
        return mt_rand(0, 1000);
    }

    private function get_random_float() {
        return mt_rand(100, 1000) / 100;
    }

    private function getSomeInputs($numArgs, $type) {
        $aryArgs = array();
        switch ($type) {
            case 'TYPE_STRING':
                for ($i = 0; $i < $numArgs; $i++) {
                    $aryArgs [] = $this->get_random_string();
                }
                break;
            case 'TYPE_INTEGER':
                for ($i = 0; $i < $numArgs; $i++) {
                    $aryArgs [] = $this->get_random_integer();
                }
                break;
            case 'TYPE_FLOAT':
                for ($i = 0; $i < $numArgs; $i++) {
                    $aryArgs [] = $this->get_random_float();
                }
                break;
        }
        return $aryArgs;
    }
    
    public function generateInputs(){
        $this->inputs = array();
        $numArgs = FUNCTION_MAX_ARGS;
        
        //how many times will we call each function with each type of input?
        $numTests = 3;
        
        for($i = 0; $i<$numTests; $i++)
        {
            $this->inputs[] = $this->getSomeInputs($numArgs, 'TYPE_STRING');
            $this->inputs[] = $this->getSomeInputs($numArgs, 'TYPE_INTEGER');
            $this->inputs[] = $this->getSomeInputs($numArgs, 'TYPE_FLOAT');
        }
    }
    public function getCodeOutput(){
        if(isset($this->mycode_outputs) && (isset($this->othercode_outputs)))
        {
            return array($this->mycode_outputs, $this->othercode_outputs);
        }
    }

    public function compare($other_code) {
        //compare my toexec with other_code
        $this->getCode();
        $mycode_outputs = '';
        $othercode_outputs = '';
        try {
            if ($this->type == TYPE_FUNCTION) {
                $this->generateInputs();
            }
            else{
                $this->inputs = Null;
            }
            $my_code = new Code($this->solution, $this->type, $this->inputs);
            $other_code = new Code($other_code, $this->type, $this->inputs);
            logMe($my_code, 'code');
            logMe($other_code, 'code');

            $this->checkFileSizeAndParseErrors($other_code);
            
            logMe('now evaluating my code', 'code');
            $my_code->evaluate();

            logMe("now evaluating other code", 'code');
            $other_code->evaluate();

            $this->mycode_outputs = $my_code->getOutputs();
            $this->othercode_outputs = $other_code->getOutputs();
            logMe("mycode_outputs are ", 'code');
            logMe($this->mycode_outputs, 'code');
            logMe("othercode_outputs are ", 'code');
            logMe($this->othercode_outputs, 'code');

            if ($this->mycode_outputs == $this->othercode_outputs) {
                return True;
            } else {
                throw new Exception("Expected outputs do not match");
                return False;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}

?>