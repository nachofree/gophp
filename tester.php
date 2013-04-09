<?php

class a {

    public function __construct() {

        $this->fn = $fn = function (){echo "hi";};
        echo $this->fn;
    }

    public function doit() {
        call_user_func('$this->fn');
    }

}

$mya = new a();
$mya->doit();
?>