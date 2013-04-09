<?php
/*
 * On this page the admin should be able to login and see the results of each student
 */
include_once './config.php';
include_once(DOCROOT . 'includes/pageFunctions.php');

function getStudentScores() {
    $s = '';

    $mysqli = new mysqli('p:' . DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

    $table = DB_TABLE_PREFIX . 'person_question';
    $stmt = $mysqli->query("SELECT * FROM $table");


    while ($row = mysqli_fetch_row($stmt)) {
        //var_dump($row);
        $s .= "<tr>";
        $s .= "<td>$row[0]</td>";
        $s .= "<td>$row[1]</td>";
        $s .= "<td>$row[2]</td>";
        $s .= "<td>$row[3]</td>";

        $img = ($row[4] == 1) ? IMG_CORRECT : IMG_NOTCORRECT;
        $s .= "<td><img src=$img class='icon'/></td>";


        //link to view students code.
        $s .= "<td><a href='./page2.php?studentID=$row[0]&qID=$row[1]'>view</a></td>";

        $s.="</tr>";
    }

    return $s;
}

include_once 'includes/pageHeader.php';
//if(!isset($_SESSION))
//{
//    session_name("MAIN");
//    session_start();
//}
//$p = new Person($_SESSION['username']);
show_banner();

echo "<fieldset class='output output2'>";
echo "<legend>Students</legend>";
?>
<form id="filter-form">Filter: <input name="filter" id="filter" value="" maxlength="30" size="30" type="text"></form><br>
<table id="myTable" class="tablesorter">
    <thead>
        <tr>
            <th>StudentID</th><th>Question ID</th><th>Number attempts</th><th>Last modified</th><th>Correct</th><th>Code</th>
        </tr>
    </thead>
    <tbody>
        <?= getStudentScores() ?>
    </tbody>
</table>

<?
include_once 'includes/pageFooter.php';
?>