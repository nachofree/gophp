<?php

include_once(dirname(__FILE__) . '/config.php');
include_once(DOCROOT . 'includes/codeFunctions.php');
include_once(DOCROOT . 'classes/question.php');

function save_new_question($questionText, $code, $questionType, $questionName) {
    //set_time_limit(MAX_EXECUTION_TIME);
    try {
        $q = new Question();
        $q->setType($questionType);
        $q->setQuestionText($questionText);
        $q->setName($questionName);
        $q->setCode($code);
        $q->saveQuestion();
        $output = "Question was saved.";
    } catch (Exception $e) {
        $output = "Question not saved " . $e->getMessage();
    }
    logMe("$output", 'ajax');
    $toReturn = json_encode(array('scriptResults' => $code, 'messages' => $output));
    logMe("Returning from save_new_question" . $toReturn, 'ajax');
    return $toReturn;
}

$debugOutput = '';
logMe("Ajax save attempt made", 'ajax');
logMe($_POST, 'ajax');
if (isset($_POST['code'])) {
    $code = $_POST['code'];
    $questionText = $_POST['questionText'];
    $questionName = $_POST['questionName'];
    $questionType = $_POST['questionType'];


    $debugOutput = save_new_question($questionText, $code, $questionType, $questionName);

    if (isset($_GET['js'])) {
        header('Content-Type: text/plain');
        echo $debugOutput;
        die();
    }
}
?>
