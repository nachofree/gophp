<?php

include_once('./config.php');
include_once(DOCROOT . 'includes/codeFunctions.php');
include_once(DOCROOT . 'includes/pageFunctions.php');
include_once(DOCROOT . 'includes/databaseFunctions.php');
include_once(DOCROOT . 'classes/question.php');
include_once(DOCROOT . 'classes/person.php');


error_reporting(E_ALL);
ini_set('display_errors', 0);
register_shutdown_function('shutdown');

if(!isset($_SESSION)){
    session_name("MAIN");
    session_start();
}

which_problem();

if(isset($_GET['id'])){
  $_SESSION['problem_id'] = $_GET['id'];
  logMe("You passed in an id via get, so ireset the session var", 'error');
}

$addingQuestion = False;

//first condition (are they coming from the results page?
if (isset($_GET['studentID']) && isset($_GET['qID']))
   {

   $p = new Person($_SESSION['username']);
   if($p->isAdmin())
   {
    $user_code = getUserCodeTextValFromDB($_GET['studentID'], $_GET['qID']);
    $id = $_GET['qID'];
    $user = $_GET['studentID'];
    logMe("Loading problem with id: $id for user $user", 'object');
    }
    logMe("you are not admin", 'error');
    }
elseif (isset($_SESSION['problem_id'])) {
    //first visit, or redirected from earlier page?
    //should load problem with that corresponding id
    $id = $_SESSION['problem_id'];
    //does the user already have code of that id?
    $user_code = getUserCodeTextValFromDB($_SESSION['username'], $id);
    
    if (!$user_code){

      //is that really a valid id?
      //if it's not a valid id, we will redirect them to the index page with an error of 1
      $mysqli = getMysqliConnector();
      $qry = "SELECT * FROM php_console_questions where question_id = $id";
      $stmt = $mysqli->query($qry);
      if ($stmt->num_rows < 1) {
        //redirect;
        if (isset($_SESSION['problem_id'])) {
	  unset($_SESSION['problem_id']);
        }
	logMe("Redirecting to index with error of 1", 'error');
        header("Location: ./index.php?error=1");
      }
    }
    logMe('Loading problem with id: $id', 'objects');
} elseif (isset($_GET['add'])) {
    //probably make sure we are admin here
    $p = new Person($_SESSION['username']);
    if ($p->isAdmin()) {
        $addingQuestion = True;
    } else {
      logMe("You weren't admin, redirecting", 'error');
        header("Location: ./index.php");
    }
} else {
    //nothing was set, redirect them to index page
    logMe('nothing was set DANGER', 'error');
    header("Location: ./index.php");
}


$qt = '';
$questionName = '';
$questionType = '';
$type_select = '';


try {

    if ($addingQuestion) {
        $c = new Question();
        logMe('adding new question', 'objects');
        $id = Null;
        $type_select = getAllQuestionTypesAsSelect();
        logMe('Select of all types: ' . $type_select, 'error');
    } else {
        $c = new Question($id);
        logMe($c, 'objects');
        $qt = $c->getQuestionText();
        $questionName = $c->getName();
        $questionType = $c->getType();
//var_dump($c);
    }
} catch (Exception $e) {
    //if there was an error above this should display it at top of page when it loads
    $debugOutput = $e->getMessage();
}




//$codesample = json_encode($c);
$addingQuestion = json_encode($addingQuestion);   //used by my.js to decide what page should look like.
$type_select = json_encode($type_select);
//if the user has typed in code, that is what we want to display
$codeToDisplay = (isset($user_code)) ? $user_code : "";
logMe("codeToDisplay: $codeToDisplay", 'objects');
//logMe("json encoded value: " . $codesample, 'objects');
$debugOutput = '';

/* * *****************************
 * 
 * RENDER THE PAGE
 * 
 * ***************************** */
include_once './includes/pageHeader.php';
show_banner();
//display the page
show_form2($id, $questionName, $qt, $questionType, $codeToDisplay, $debugOutput);
include_once './includes/pageFooter.php';


