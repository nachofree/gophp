<?php

include_once(dirname(__FILE__).'/../config.php');


function getMysqliConnector() {

    $mysqli = new mysqli('p:' . DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

    if ($mysqli->connect_errno) {
        throw new Exception($mysqli->connect_error);
    }
    else
    {
        return $mysqli;
    }
}

//not using the one in databaseFunctions because we need to connect to app
function getMysqliAPPConnector() {

    $mysqli = new mysqli('p:' . APP_DB_HOST, APP_DB_USER, APP_DB_PASSWORD, APP_DB_DATABASE);

    if ($mysqli->connect_errno) {
        throw new Exception($mysqli->connect_error);
    }
    else
    {
        return $mysqli;
    }
}

?>