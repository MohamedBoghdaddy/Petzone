<?php
class Patient {
    public $ID;
    public $addedBy;
    public $petname;
    public $species;
    public $age;
    public $weight;

    function __construct($ID,$addedBy="",$petname="",$species="",$age="", $weight="")
    {
        $this->ID = $ID;
        $this->addedBy = $addedBy;
        $this->petname = $petname;
        $this->species = $species;
        $this->age = $age;
        $this->weight = $weight;
    }
}
?>