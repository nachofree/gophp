<?
/* * *********************************
 * The way the js is included below is stupid
 * but it apparently has to be in that order 
 * in order to work.
 * ********************************** */

if (!isset($_SESSION)) {
    session_name("MAIN");
    session_start();
}

if (isset($_GET['problem'])) {
    //so i can link to a particular problem?
    $_SESSION['problem_id'] = $_GET['problem'];
}

if (!isset($_SESSION['username'])) {
    logMe("Stupid username not set", 'error');

    header("Location: ./login.php");
}
$display = (basename($_SERVER['PHP_SELF']) == 'page2.php');
$sortable = (basename($_SERVER['PHP_SELF']) == 'results.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>PHP Programming</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>

<?
//we only care to do the following if we are looking at page2.php
if ($display) {
    ?>
            <script src="ace/ace.js"></script>
            <script src="ace/mode-php.js"></script>

            <script src="js/my.js"></script>
            <script>
                var addingQuestion = <?= $addingQuestion; ?>;
                var typeSelect = <?= (isset($type_select)) ? $type_select : 'false'; ?>;
            </script> 
<?
}
if ($sortable) {
    ?>
            <script src="js/tablesorter.js" type="text/javascript"></script>
            <script src="js/results.js" type="text/javascript"></script>
            <script src="js/filter.js" type="text/javascript"></script>

            <?
        }
        ?>
    </head>
    <body>
        <div id="mainPage">



