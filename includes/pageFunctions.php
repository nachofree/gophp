<?php
include_once(dirname(__FILE__) . '/../config.php');
include_once(DOCROOT . 'classes/person.php');
include_once(DOCROOT . 'includes/logFunctions.php');


function get_name() {
    echo $_SESSION['firstName'] . " " . $_SESSION['lastName'];
}

function which_problem(){
  if(!isset($_SESSION)){
    session_name("MAIN");
    session_start();
  }
  if(isset($_GET['problem_id']))
  {
    $_SESSION['problem_id'] = $_GET['problem_id'];
      $id = $_SESSION['problem_id'];
      logMe("A problem was set as a session var: $id", 'error');
  }

}
function checkForErrors() {
    $aErrors = array();
    if (isset($_GET['error'])) {
        switch ($_GET['error']) {
            case 1:
                $aErrors[] = 'Invalid problem id. Please choose the correct problem below';
        }
    }

    $s = '';
    foreach ($aErrors as $k => $v) {
        $s.="<p>$v</p>";
    }

    if (count($aErrors) > 0) {
        logMe("Errors in checkForErrors: $s", 'error');
    }
    return $s;
}

function adminLinks() {
    ?>  
    <div id=div_nav><a href=./page2.php?add>add</a></div>
    <div id=div_nav><a href=./results.php>results</a></div>

    <?
}

function show_banner() {


    echo "<div class='output'><div class='banner_div'><p>PHP Programming Practice</p></div>";

    if (isset($_COOKIE[ini_get('session.name')])) {
        if (isset($_SESSION['firstName'])) {
            $lo_string = "<a href=./login.php>logout</a>";
            //$person = new Person($_SESSION['username']);
            $fName = $_SESSION['firstName'];
            $lName = $_SESSION['lastName'];
            echo "<div id=div_user>";
            echo "Current User: $fName $lName";
            echo "</div>";
            echo "<div id=div_logout>$lo_string</div>";
        }
    }

    $current_file_name = basename($_SERVER['PHP_SELF']);

    if ($current_file_name == 'login.php') {
        echo "<div id=div_login>
           <form id='frmLogin' action='$_SERVER[PHP_SELF]' method='POST'>
                <input type='text' class='login_input' id='username' name='username' value='username'>
                <input type='password' class='login_input' id='password' name='password' value='password'>
                <input type='submit' class='login_input' value='login' name='doLogin'>
            </form>
        </div>";
    } else {
        echo "<div id=div_nav><a href=./index.php?clear>problem list</a></div>";
        echo "<div id=div_nav><a href=./help.php>help/schema</a></div>";
        $p = new Person($_SESSION['username']);
    }

    if (isset($p) && $p->isAdmin()) {
        adminLinks();
    }
    //check to see if we need to display any errors
    //returns html string
    $sErrors = checkForErrors();

    echo "<div class='errors'>$sErrors</div>";
    echo "</div>";
}

function show_results() {
    ?>
    <span class="aTextHeader">Results:<br/></span>
    <div class=results> Your results will go here.</div>
    <?
}

function shutdown() {
    $error = error_get_last();
    $text = 'Unknown error, script aborted. msg:' . $error['message'] . 'file: ' . $error[file] . 'line: ' . $error[line];
    //$text = ob_get_clean();
    //this shutdown is always called when php is done executing!
    //logMe($text, 'error');
    throw new Exception($text);
    exit(1);
}

function getAllQuestionTypesAsSelect() {
    $mysqli = getMysqliConnector();
    $table = DB_TABLE_PREFIX . 'question_type';

    $query = "SELECT * FROM $table";
    logMe("Query: $query", 'database');
    if ($result = $mysqli->query($query)) {

        /* fetch associative array */
        $s = "<select name='select_type' id='select_type'>";

        while ($row = $result->fetch_assoc()) {
            $val = $row['type_val'];
            $id = $row['type_id'];
            $s .="<option value='$id'>$val</option>";
        }
        $s .= "</select>";
        return $s;
    } else {
        throw new Exception('Unable to get all question types' . $mysqli->error);
    }
}

function show_form2($id, $qName, $qt, $qType, $codeToDisplay, $debugOutput) {
    echo "<div class=output2>Script output: $debugOutput</div>";
    ?>
    <div class="input" id="container">
        <div id="editor" class="editor"><?= $codeToDisplay ?></div>
        <div class="aText mini">
            <span class="aTextHeader">Name:</span>
            <span class="aTextOther" id="spanQuestionName"> <?= $qName ?></span><br/><br/><br/><br/>
            <span class="aTextHeader">Type:</span>
            <span class="aTextOther" id="spanQuestionType"> <?= $qType ?></span><br/>
        </div>
        <div class="aText maxi">
            <span class="aTextHeader">Question:<br/></span>
            <span class="aTextOther" id="spanQuestionText"> <?= $qt ?></span>
        </div>
        <div class="aText mini">
            <? show_results(); ?>
        </div>
        <div class="statusbar">
            <span class="position">Line: 1, Column: 1</span>
        </div>
    </div>
    <div id="div_form">
        <form name="aceForm" id="aceForm" method="POST">
            <input type="button" id="btnAceSubmit" value="Execute!" class="pageBtn"/>
            <input type="button" id="btnAceClear" value="Clear" class="pageBtn"/>
            <input type='hidden' id='codeID' value="<?= $id ?>"/>

        </form>
    </div>
    <?php
}
?>