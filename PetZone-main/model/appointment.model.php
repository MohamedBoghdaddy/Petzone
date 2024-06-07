<?php
class Appointment {
    public $ID;
    public $petOwner;
    public $EmployeeName;
    public $petname;
    public $aDate;
    public $price;

    function __construct($ID,$petOwner="",$EmployeeName="",$petname="",$aDate="", $price="")
    {
        $this->ID = $ID;
        $this->petOwner = $petOwner;
        $this->EmployeeName = $EmployeeName;
        $this->petname = $petname;
        $this->aDate = $aDate;
        $this->price = $price;
    }
}
?>