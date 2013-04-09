<?php
include_once('./config.php');
include_once(DOCROOT . 'classes/authentication.php');
include_once(DOCROOT . 'classes/person.php');
include_once(DOCROOT . 'includes/pageFunctions.php');

if (isset($_POST['doLogin'])) {
    if (($_POST['username'] != '') && ($_POST['password'] != '')) {
        $auth = new Authentication($_POST['username'], $_POST['password'], SELECTED_AUTH_TYPE);
        if ($auth->isAuthentic()) {
            try {
                (SELECTED_AUTH_TYPE == AUTH_TYPE_NONE) ? $name = $_POST['username'] : $name = '';
                $p = new Person($_POST['username'], $name, $name);
                if (!$p->existsInDatabase()) {
                    $p->insertInDatabase();
                }
                $userID = $p->getUserID();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            session_name("MAIN");
            session_start();
            logMe("User " . $_POST['username'] . " logged in", 'authentication');
	        //see if they have a preferred question?
	    which_problem();
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['firstName'] = $p->getFirstName();
            $_SESSION['lastName'] = $p->getLastName();
            
            header("Location: index.php");
        } else {
            echo ERR_MESSAGE_INVALID_CREDENTIALS;
        }
    } else {
        echo ERR_MESSAGE_EMPTY;
    }
} else {
    session_name("MAIN");
    session_start();
    $u = (isset($_SESSION['username'])) ? $_SESSION['username'] : NULL;

    if ($u) {
        logMe("Destroying session for $u", 'authentication');
        if (isset($_COOKIE[ini_get('session.name')])) {
            setcookie(ini_get('session.name'), "", time() - 3600);
        }
        session_destroy();
        header("Location: login.php");
    }

}

//print_r($_SESSION);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>PHP Programming Login</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css" />
    </head>
    <body>
        <? show_banner(); ?>
    </body>
</html>
<?
