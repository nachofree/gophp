<?php

include_once(dirname(__FILE__) . '/../config.php');
include_once(DOCROOT . 'includes/databaseFunctions.php');


//1 is student
//2 is administrator
define('DEFAULT_ROLE_TYPE', 1);

class Person {

    public function __construct($username=Null, $firstName=Null, $lastName=Null) {
        $this->username = $username;
        $this->mysqli = Null;
        $this->studentTable = DB_TABLE_PREFIX . "person";
        $this->firstName = $firstName;
        $this->lastName = $lastName;
	$this->userID = Null;
    }

    private function openDatabase() {
        if (!($this->mysqli)) {
            $this->mysqli = getMysqliConnector();
        }
    }

    public function getFirstName() {
        ($this->firstName == '') ? $this->retrieveNameFromDB() : Null;
        return $this->firstName;
    }

    public function getLastName() {
        ($this->lastName == '') ? $this->retrieveNameFromDB() : Null;
        return $this->lastName;
    }

    private function getNameIfNotSet() {
        if (($this->firstName == '') || ($this->lastName == '')) {
            $this->retrieveLdapName();
        }
    }
    
    public function isAdmin(){
        $qry = "SELECT * FROM $this->studentTable where username = '$this->username' and role_id = 2";
        return $this->hasRows($qry);
    }

    //this is the auto_id generated in the mysql database
    //NOT ANY LDAP stuff
    public function getUserID() {
        return $this->userID;
    }

    public function getDoneQuestionsForUser() {
        $mysqli = getMysqliConnector();
        $personQuestionTable = DB_TABLE_PREFIX . "person_question";
        $query = "SELECT question_id, num_attempts, correct, last_modified, code FROM $personQuestionTable WHERE student_id = ?";
        logMe("Query: $query", 'database');
        $stmt = $mysqli->prepare($query);

        $stmt->bind_param('s', $this->username);
        $stmt->execute();
        $stmt->bind_result($question_id, $num_attempts, $correct, $last_modified, $code);
        $ary = array();
        while ($stmt->fetch()) {
            $pq = new personQuestion($this->username, $question_id, $num_attempts, $correct, $last_modified, $code);
            $ary[] = $pq;

            logMe($pq, 'code');
        }
        return $ary;
    }

    private function retrieveNameFromDB() {
        $this->openDatabase();
        $qry = "SELECT * FROM $this->studentTable where username = '$this->username'";
        $stmt = $this->mysqli->query($qry);
        if ($stmt->num_rows > 0) {
            $row = $stmt->fetch_assoc();
            $this->firstName = $row['fname'];
            $this->lastName = $row['lname'];
            $this->userID = $row['username'];
        } else {
            $this->firstName = 'unknown';
            $this->lastName = 'unknown';
        }
    }

    private function hasRows($qry) {
        $this->openDatabase();
        $stmt = $this->mysqli->query($qry);
        if ($stmt->num_rows > 0) {
            return True;
        }
        return False;
    }

    public function existsInDatabase() {
        $qry = "SELECT * FROM $this->studentTable where username = '$this->username'";
        return $this->hasRows($qry);
    }

    public function userDidProblem($questionID) {
        $qry = "SELECT * FROM php_console_person_question where student_id = '$this->username' and question_id = $questionID";
        return $this->hasRows($qry);
    }

    public function insertInDatabase() {

        try {
            $this->openDatabase();
            $this->getNameIfNotSet();
            $stmt = $this->mysqli->prepare("INSERT INTO $this->studentTable VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception(ERR_MESSAGE_PREPARED_STATEMENT_FAILED . $this->mysqli->error);
                exit(1);
            }
            $roleType = DEFAULT_ROLE_TYPE;
            $stmt->bind_param('sssi', $this->username, $this->firstName, $this->lastName, $roleType);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            echo "Could not insert user into database " . $e->getMessage();
        }
    }

    private function retrieveLdapName() {

        //probably should create an LDAP class to use for this AND authentication

        $filter = "(uid=$this->username)";
        $attr = array("uid", "cn", "departmentNumber");
        $bind_dn = "cn=readerman,ou=Etc,dc=cs,dc=dixie,dc=edu";
        $bind_pass = '#yominasai!';
        $user_dn = "uid=$this->username,ou=People,dc=cs,dc=dixie,dc=edu";

        $ldap_handle = ldap_connect("ldap.cs.dixie.edu");
        ldap_set_option($ldap_handle, LDAP_OPT_PROTOCOL_VERSION, 3);
        if ($ldap_handle and @ldap_bind($ldap_handle, $bind_dn, $bind_pass)) { // logged into ldap as administrator
            $student_record = ldap_search($ldap_handle, "dc=cs,dc=dixie,dc=edu", $filter, $attr);
            $info = ldap_get_entries($ldap_handle, $student_record);
            if ($info['count'] > 0) {
                //var_dump($info);
                $fullname = $info[0]['cn'][0];
                $fullname = explode(' ', $fullname);
                $this->firstName = $fullname[0];
                $this->lastName = $fullname[1];
            }
        }
    }

}

//try {
//    $p = new Person('jfrancom');
//    if (!$p->existsInDatabase()) {
//        $p->insertInDatabase();
//        }
//} catch (Exception $e) {
//    echo $e->getMessage();
//}
?>
