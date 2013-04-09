<?php

class personQuestion {

    //put your code here
    function __construct($person_id, $question_id, $num_attempts=Null, $is_correct = Null, $last_modified = Null, $code = Null) {
        $this->person_id = $person_id;
        $this->question_id = $question_id;
        $this->num_attempts = $num_attempts;
        $this->is_correct = $is_correct;
        $this->last_modified = (isset($last_modified)?$last_modified: now());
        $this->code = $code;
        //$this->fetchInfo();
    }

    private function fetchInfo() {
        $mysqli = getMysqliConnector();
        $personQuestionTable = DB_TABLE_PREFIX . "person_question";
        $query = "SELECT num_attempts, correct, last_modified, code FROM $personQuestionTable WHERE student_id = ? and question_id = ?";
        logMe("Query: $query", 'database');
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('ss', $this->person_id, $this->question_id);
        $stmt->execute();
        $stmt->bind_result($this->num_attempts, $this->is_correct, $this->last_modified, $this->code);
        logMe("PersonQuestion: $this->num_attempts, $this->is_correct, $this->last_modified, $this->code", 'error');
    }

    public function getNumAttempts() {
        (!isset($this->num_attempts)) ? $this->fetchInfo() : Null;
        return $this->num_attempts;
    }

    public function getIsCorrect() {
        (!isset($this->is_correct)) ? $this->fetchInfo() : Null;
        return ($this->is_correct=='1')?True:False;
        //return $this->is_correct;
    }

    public function getLastModified() {
        (!isset($this->last_modified)) ? $this->fetchInfo() : Null;

        return $this->last_modified;
    }

    public function getUserCode() {
        (!isset($this->code)) ? $this->fetchInfo() : Null;
        return $this->code;
    }

}

?>
