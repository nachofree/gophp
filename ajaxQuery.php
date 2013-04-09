<?php

session_name("MAIN");
session_start();

include_once(dirname(__FILE__) . '/config.php');
include_once(DOCROOT . 'includes/codeFunctions.php');



function custom_warning_handler($errNo, $errStr){
    $msg = "Error: ". $errStr;
    $results = "<img src='".IMG_NOTCORRECT."' /><p id=outputResults>$msg</p>";

    $toReturn = json_encode(array('scriptResults' => $results, 'messages' => $msg));

    die($toReturn);
}
set_error_handler("custom_warning_handler", E_NOTICE|E_WARNING);


$debugOutput = '';
logMe("Ajax query made", 'ajax');
logMe($_POST, 'ajax');
logMe("here is the session:", 'ajax');
logMe($_SESSION, 'ajax');
if (isset($_POST['code'])) {
    $code = $_POST['code'];
    $questionID = $_POST['questionID'];
    $userID = $_SESSION['username'];
    $debugOutput = process_code($questionID, $code, $userID);
    //$debugOutput = json_encode(array('scriptResults' => $code, 'messages' => $questionID));

    if (isset($_GET['js'])) {
        header('Content-Type: text/plain');
        echo $debugOutput;
        die();
    }
}
?>
