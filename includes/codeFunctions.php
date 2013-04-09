<?php

include_once(dirname(__FILE__) . '/../config.php');
include_once(DOCROOT . 'classes/person.php');
include_once(DOCROOT . 'includes/databaseFunctions.php');
include_once(DOCROOT . 'classes/question.php');

function showError($eMessage) {
    return "<img src=" . IMG_NOTCORRECT . " /><p id=outputResults>$eMessage</p>";
}

function clean_user_code($code) {
    if ($code == '') {
        $code = "echo 'nothing entered';";
    }
    $debugOutput = '';
    if (get_magic_quotes_gpc()) {
        $code = stripslashes($code);
    }

    if (preg_match('{#((?:\\\\[rn]){1,2})}', $code, $m)) {
        $newLineBreak = str_replace(array('\\n', '\\r'), array("\n", "\r"), $m[1]);
        $code = preg_replace('#(\r?\n|\r\n?)#', $newLineBreak, $code);
    }

    return $code;
}

function saveProblemAsCorrect($userID, $questionID, $isCorrect, $codeText) {
    $user = new Person($userID);
    $mysqli = getMysqliConnector();
    logMe("Trying to save problem for user: $userID qID: $questionID, correct: $isCorrect, code: $codeText", 'code');
    $num_attempts = 1;

    if (!$user->userDidProblem($questionID)) {
        logMe('doing insert', 'code');
        $query = "INSERT INTO php_console_person_question (
                    student_id, question_id, num_attempts, correct, code)
                    VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        logMe("Query: $query", 'code');
        logMe("Params: $userID, $questionID, $num_attempts, $isCorrect, $codeText");
        if (!$stmt->bind_param('siiis', $userID, $questionID, $num_attempts, $isCorrect, $codeText)) {
            throw new Exception('Unable to bind params' . $mysqli->error);
            exit(1);
        }
    } else {
        logMe('doing update', 'code');
        $stmt = $mysqli->prepare("UPDATE php_console_person_question 
            SET num_attempts = num_attempts + ?, correct = ?, code = ?
            WHERE student_id = ? and question_id = ?");
        //this needs to auto increment (not auto_increment field though)
        $stmt->bind_param('iissi', $num_attempts, $isCorrect, $codeText, $userID, $questionID);
    }
    if (!$stmt) {
        throw new Exception(ERR_MESSAGE_PREPARED_STATEMENT_FAILED . $mysqli->error);
        exit(1);
    }
    //logMe(var_dump($stmt), 'code');
    if (!$stmt->execute()) {
        throw new Exception("MYSQL ERROR" . $mysqli->error);
        exit(1);
    }
    $stmt->close();
    logMe('Done saveing problem', 'code');
}

function process_code($questionID, $userCode, $userID) {
    set_time_limit(MAX_EXECUTION_TIME);
    //if ob is turned on we will not see the thrown error messages.
    $userCode = clean_user_code($userCode);
    //if we are not debugging
    (DEBUGGING) ? '' : ob_start();
    $question_obj = new Question($questionID);
    logMe($question_obj, 'objects');
    $r = $question_obj->compare($userCode);

    if ($r) {
        logMe('Outputs were the same', 'code');
        $img = IMG_CORRECT;
        $text = 'correct';
        //update db to save code and mark as correct
        $correct = 1;
    } else {
        logMe('Outputs were different', 'code');
        $img = IMG_NOTCORRECT;
        $text = 'incorrect';
        //update db to save code and mark as incorrect
        $correct = 0;
    }
    
    saveProblemAsCorrect($userID, $questionID, $correct, $userCode);

    $results = "<img src='$img' /><p id=outputResults>$text</p>";
    $debugOutput = (DEBUGGING) ? $results : ob_get_clean();

    if(!$r && $question_obj->getType() != "Session")
    {
        logMe($question_obj->getType(), 'error');
        //this is an array(arr, arr)
        $outputs = $question_obj->getCodeOutput();
        $mine = $other = '';
        
        if(is_array($outputs[0]) && is_array($outputs[1]))
        {
            $mine = implode(',',$outputs[0]);
            $other = implode(',', $outputs[1]);
        }
        $s = " <br/> My outputs: $mine <br/> Your outputs: $other";
        logMe($s, 'code');
        $debugOutput.=$s;
    }
    $toReturn = json_encode(array('scriptResults' => $results, 'messages' => $debugOutput));
    //$toReturn = json_encode(array('scriptResults' => $questionID, 'messages' => $userCode));
    return $toReturn;
}

//end process code
//Am I actually using this funciton anywhere?
//function custom_warning_handler($errno, $errstr) {
//    if (!(error_reporting() & $errno)) {
//        // This error code is not included in error_reporting
//        return;
//    }
//
//    switch ($errno) {
//        case E_ERROR:
//        case E_USER_ERROR:
//            echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
//            echo "  Fatal error on line $errline in file $errfile";
//            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
//            echo "Aborting...<br />\n";
//            exit(1);
//            break;
//        case E_WARNING:
//        case E_USER_WARNING:
//            echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
//            break;
//
//        case E_USER_NOTICE:
//        case E_NOTICE:
//            echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
//            break;
//
//        default:
//            echo "Unknown error type: [$errno] $errstr<br />\n";
//            break;
//    }
//
//    /* Don't execute PHP internal error handler */
//    return true;
//}

function getUserCodeTextValFromDB($sID, $qID) {
    $s = '';

    $mysqli = new mysqli('p:' . DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    $table = DB_TABLE_PREFIX . 'person_question';

    $qry = "SELECT code from $table as pq where pq.student_id = '$sID' and pq.question_id = $qID";

    $result = $mysqli->query($qry);

    if ($result) {
        $row = mysqli_fetch_array($result);
        $code = $row[0];
        return $code;
    }
    return False;
}

?>