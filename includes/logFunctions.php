<?php

define('LOGDIR', './logs/');
date_default_timezone_set('America/Boise');

function logMe($stringToWrite, $fileName='unknown') {
    
    //check to see if LOGDIR exists, if not, create it.
    
    if(!is_dir(LOGDIR))
    {
        mkdir(LOGDIR);
    }
    
    $validFileNames = array('error', 'objects', 'authentication', 'ajax', 'code', 'database', 'index', 'session', 'function');
    $fn = (in_array($fileName, $validFileNames)) ? $fileName . '.log' : 'unknown.log';


    $stringToWrite = print_r($stringToWrite, true);
   
    if(is_array($stringToWrite))
            $stringToWrite = print_r($stringToWrite, true);
    
    //maybe log the user that had the problem too?
    $u = (isset($_SESSION['username']))?$_SESSION['username']:null;
    
    $fh = fopen(LOGDIR . $fn, 'a');
    fwrite($fh, date('m.d.y H:i:s') . ' - ' . $u . ' - ' . $stringToWrite . PHP_EOL);
    fclose($fh);
}

?>