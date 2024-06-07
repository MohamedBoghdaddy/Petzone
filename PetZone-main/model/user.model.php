<?php
class User {
    public $ID;
    public $firstname;
    public $lastname;
    public $Username;
    public $Email;
    public $password;
    public $accountType;

    public function __construct($ID,$firstname,$lastname,$Username,$Email,$password,$accountType)
    {
        $this->ID = $ID;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->Username = $Username;
        $this->Email = $Email;
        $this->password = $password;
        $this->accountType = $accountType;
    }
}
?>