<?php

include_once('./config.php');
include_once(DOCROOT . 'includes/databaseFunctions.php');
include_once(DOCROOT . 'includes/pageFunctions.php');
include_once(DOCROOT . 'classes/personQuestion.php');

// Open a known directory, and proceed to read its contents
function file_array($path, $exclude = ".|..") {
    $path = rtrim($path, "/") . "/";
    $folder_handle = opendir($path);
    $exclude_array = explode("|", $exclude);
    $result = array();
    while (false !== ($filename = readdir($folder_handle))) {
        if (!in_array(strtolower($filename), $exclude_array)) {
            //remove trailing filename
            $filename = substr($filename, 0, strpos($filename, '.'));
            //split filename on convention
            $parts = explode('_', $filename);
            $result[] = $parts;
        }
    }
    return $result;
}

function getQuestionsFromDatabase() {
    $mysqli = getMysqliConnector();
    $questionTable = DB_TABLE_PREFIX . "questions";
    $questionTypeTable = DB_TABLE_PREFIX . "question_type";

    $query = "SELECT question_name, type_val, question_id FROM $questionTable as q
    JOIN $questionTypeTable as qt
    ON q.question_type = qt.type_id";
    $result = $mysqli->query($query);
    $ary = array();
    while ($row = $result->fetch_assoc()) {
        $ary[] = array('question_name' => $row['question_name'], 'type_val' => $row['type_val'], 'question_id' => $row['question_id']);
    }
    return $ary;
}

function getAllQuestionsOfTypeFromArray($aryQuestions, $type) {
    $ary = array();
    foreach ($aryQuestions as $q) {
        if ($q['type_val'] == $type) {
            $ary[] = $q;
        }
    }
    return $ary;
}

//what different types of questions do we have?
function getAllTypesFromArray($aryQuestions) {
    $aryTypes = array();
    foreach ($aryQuestions as $q) {
        if (!in_array($q['type_val'], $aryTypes)) {
            $aryTypes[] = $q['type_val'];
        }
    }
    return $aryTypes;
}




/******************************************************
 * Before we render the index page lets see if there is something
 * in the session variable that already indicates what problem we want to view
 * if that problem does exist, redirect to page2 with that problem.
 * 
 ******************************************************/


which_problem();

if(isset($_GET['clear'])){
  if(isset($_SESSION['problem_id']))
    {
      unset($_SESSION['problem_id']);
    }
}
else if(isset($_SESSION['problem_id']))
{

    header("Location:./page2.php?id=$_SESSION[problem_id]");
    logMe('Redirecting to page2', 'error');
}


include_once 'config.php';
include_once 'includes/pageHeader.php';

$all_questions = getQuestionsFromDatabase();
$question_types = getAllTypesFromArray($all_questions);
$p = new Person($_SESSION['username']);
$done_questions = $p->getDoneQuestionsForUser();
logMe('Questions that are done:', 'index');
logMe($done_questions, 'index');
show_banner();

foreach ($question_types as $qt) {
    $questionsOfType = getAllQuestionsOfTypeFromArray($all_questions, $qt);
    echo "<fieldset class='output output2'>";
    echo "<legend>$qt</legend>";
    echo "<div class=columns>";
    echo "<ol>";
    foreach ($questionsOfType as $question) {
        $addHTML = '';
        $qID = $question['question_id'];
        $img = Null;

        //check to see if that question has been done by this user
        foreach ($done_questions as $pq) {
            if ($pq->question_id == $qID) {
                if ($pq->getNumAttempts() > 0) {
                    if ($pq->getIsCorrect()) {
                        $img = IMG_CORRECT;
                    } else {
                        $img = IMG_NOTCORRECT;
                    }
                }
            }
        }
        $addHTML = (isset($img) ? "<img src=$img class='iconsmall'/>" : "n/a");
        echo "<li><a href=./page2.php?id=$qID>$question[question_name]</a>$addHTML</li>";
    }
    echo "</ol>";
    echo "</div>";
    echo "</fieldset>";
}


include_once 'includes/pageFooter.php';
?>
