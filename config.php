<?php

//to be included on ALL pages
include_once('./includes/logFunctions.php');


define('DOCROOT', './');


/************************************
 * Variables
 *************************************/

define('DEBUGGING', FALSE);

//ajax scripts can only run for this time
define('MAX_EXECUTION_TIME', 3);
ini_set('max_execution_time', MAX_EXECUTION_TIME);

//so that their code isn't too big
define('FILESIZE', 500);

//the max number of args a user function can have
define ('FUNCTION_MAX_ARGS', 3);

/*************************************
different authentication types
 I haven't made any more, but I could
 these need to exist and then you need to create a method for how to handle the selected authenticattion type
 should only add to these
 * 
 *************************************/
define('AUTH_TYPE_LDAP', 'auth_ldap');
define('AUTH_TYPE_NONE', 'no_authentication');

//selected auth type (which of the above do you want to use)
define('SELECTED_AUTH_TYPE',AUTH_TYPE_LDAP);



/************************************
 * MASTER Database configuration
 *************************************/
define('DB_HOST', 'gophp.cs.dixie.edu');
define('DB_USER', 'joe');
define('DB_PASSWORD', 'c00l10');
define('DB_DATABASE', 'gophp');
define('DB_TABLE_PREFIX', 'php_console_');


/************************************
 * DB Configuration for in app problems
 * right now they just happen to be the same
 * as above
 *************************************/
define('APP_DB_HOST', 'gophp.cs.dixie.edu');
define('APP_DB_USER', 'appman');
define('APP_DB_PASSWORD', 'sc00byd00');
define('APP_DB_DATABASE', 'app_gophp');

//for use on help.php
$SCHEMAS_TO_SEE = array('students', 'course', 'customers', 'comments', 'registration');


/************************************
 * Main page functionality
 *************************************/
//where are the questions located
//they probably should be put in a db at some point

define('QUESTION_DIR', "./questions");

//indentation level
//this probably isn't used either
$options = array(
    'tabsize' => 4,
);

/************************************
 * Error reporting
 *************************************/
ini_set('log_errors', 0);
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);


/*************************************
 * Types of questions that are allowed
 * 
 *************************************/

//these need to match the types in the database table
define('TYPE_SESSION', 1);
define('TYPE_DB', 2);
define('TYPE_OUTPUT', 3);
define('TYPE_FUNCTION', 4);

/*************************************
 * Icons
*************************************/

define('IMG_CORRECT', './images/green.png');
define('IMG_NOTCORRECT', './images/red.png');



//different error messages
define('ERR_MESSAGE_INVALID_AUTHENTICATION', 'Could not authenticate');
define('ERR_MESSAGE_PARSE_ERROR', 'Parse Error: Please check your syntax');
define('ERR_MESSAGE_INVALID_PROBLEM', 'Invalid problem type');
define('ERR_MESSAGE_CANNOT_PROCESS_FUNCTION', 'Cannot process this function');
define('ERR_MESSAGE_FILE_TOO_BIG_ERROR', 'File size is restricted to '.FILESIZE.' bytes');
define('ERR_MESSAGE_PREPARED_STATEMENT_FAILED', 'The prepared statement failed');
define('ERR_MESSAGE_NOT_A_FUNCTION', 'You do not even have a function in your code.');
define('ERR_MESSAGE_INVALID_CREDENTIALS', "Invalid credentials");
define('ERR_MESSAGE_EMPTY', "Username or password cannot be blank");
define('ERR_MESSAGE_TYPE_NOT_IMPLEMENTED', "The type of authentication you have selected is not implemented");
define('ERR_MESSAGE_SEMICOLON', 'All code should end with a semicolon (;)');

?>
