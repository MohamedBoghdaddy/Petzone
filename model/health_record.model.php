<?php
class HealthRecord {
    public int    $ID;
    public int    $pet_id;
    public string $petname;
    public string $addedBy;
    public string $record_type;
    public string $title;
    public ?string $description;
    public ?string $vet_name;
    public string  $visit_date;
    public ?string $next_visit_date;

    public function __construct(
        int $ID, int $pet_id, string $petname, string $addedBy,
        string $record_type, string $title, ?string $description,
        ?string $vet_name, string $visit_date, ?string $next_visit_date
    ) {
        $this->ID              = $ID;
        $this->pet_id          = $pet_id;
        $this->petname         = $petname;
        $this->addedBy         = $addedBy;
        $this->record_type     = $record_type;
        $this->title           = $title;
        $this->description     = $description;
        $this->vet_name        = $vet_name;
        $this->visit_date      = $visit_date;
        $this->next_visit_date = $next_visit_date;
    }
}
