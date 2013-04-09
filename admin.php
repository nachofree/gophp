<?php

session_name("MAIN");
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
}

?>
<html>
    <head>
        
    </head>
    <body>
        <p>Administration page.</p>
        <p><a href="./results.php">Results</a></p>
        <p><a href="./add.php">Add question</a></p>
    </body>
</html>
