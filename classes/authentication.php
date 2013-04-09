<?php

include_once('./config.php');

class Authentication {

    public function __construct($user, $password, $type) {

        $this->ldapconfig['host'] = 'ldap.cs.dixie.edu';
        $this->ldapconfig['port'] = 389;
        $this->ldapconfig['basedn'] = 'dc=cs,dc=dixie,dc=edu';
        $this->user = $user;
        $this->password = $password;
        $this->type = $type;
    }

    private function ldapAuthenticate() {
        $user_dn = "uid=$this->user,ou=People,dc=cs,dc=dixie,dc=edu";
        $ldap_handle = ldap_connect("ldap.cs.dixie.edu");
        ldap_set_option($ldap_handle, LDAP_OPT_PROTOCOL_VERSION, 3);
        $rvalue = false;
        if ($ldap_handle and @ldap_bind($ldap_handle, $user_dn, $this->password)) {
            $rvalue = true;
        }
        if ($ldap_handle) {
            ldap_close($ldap_handle);
        }
        return $rvalue;
    }

    public function isAuthentic() {
        try {
            if ($this->type == AUTH_TYPE_LDAP) {
                return $this->ldapAuthenticate();
            }
            elseif ($this->type == AUTH_TYPE_NONE){
                return True;
            }
            else
            {
                throw new Exception(ERR_MESSAGE_TYPE_NOT_IMPLEMENTED);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}

//$n = new Authentication('test', 'asb', AUTH_TYPE_LDAP);
//echo $n->isAuthentic();
?>
