<?php
require_once __DIR__ . '/superController.php';
require_once __DIR__ . '/../../model/health_record.model.php';

class HealthController extends SuperController {
    private static ?HealthController $instance = null;

    private function __construct() { parent::__construct(); }

    public static function getInstance(): self {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    // ------------------------------------------------------------------ //

    public function addRecord(array $data): void {
        $stmt = $this->db->prepare(
            'INSERT INTO health_records (pet_id, petname, addedBy, record_type, title, description, vet_name, visit_date, next_visit_date)
             VALUES (:pi, :pn, :by, :rt, :ti, :de, :vn, :vd, :nv)'
        );
        $stmt->execute([
            ':pi' => (int)    $data['pet_id'],
            ':pn' =>           $data['petname'],
            ':by' =>           $data['addedBy'],
            ':rt' =>           $data['record_type'],
            ':ti' =>           $data['title'],
            ':de' =>           $data['description'] ?? null,
            ':vn' =>           $data['vet_name']    ?? null,
            ':vd' =>           $data['visit_date'],
            ':nv' =>           $data['next_visit_date'] ?: null,
        ]);
        flash('success', 'Health record added.');
        header('Location: ../pages/health_records.php');
        exit;
    }

    public function deleteRecord(int $id): void {
        $this->db->prepare('DELETE FROM health_records WHERE ID=:id')->execute([':id' => $id]);
        flash('success', 'Record deleted.');
        header('Location: ../../view/pages/health_records.php');
        exit;
    }

    public function editRecord(array $data): void {
        $stmt = $this->db->prepare(
            'UPDATE health_records SET record_type=:rt, title=:ti, description=:de, vet_name=:vn, visit_date=:vd, next_visit_date=:nv WHERE ID=:id'
        );
        $stmt->execute([
            ':rt' => $data['record_type'],
            ':ti' => $data['title'],
            ':de' => $data['description'] ?? null,
            ':vn' => $data['vet_name']    ?? null,
            ':vd' => $data['visit_date'],
            ':nv' => $data['next_visit_date'] ?: null,
            ':id' => (int) $data['ID'],
        ]);
        flash('success', 'Health record updated.');
        header('Location: ../pages/health_records.php');
        exit;
    }

    public function getRecords(string $type): array {
        if ($type === 'all') {
            return $this->db->query('SELECT * FROM health_records ORDER BY visit_date DESC')->fetchAll();
        }
        $stmt = $this->db->prepare('SELECT * FROM health_records WHERE addedBy=:u ORDER BY visit_date DESC');
        $stmt->execute([':u' => $_SESSION['Username']]);
        return $stmt->fetchAll();
    }

    public function getRecordsForPet(int $petId): array {
        $stmt = $this->db->prepare('SELECT * FROM health_records WHERE pet_id=:id ORDER BY visit_date DESC');
        $stmt->execute([':id' => $petId]);
        return $stmt->fetchAll();
    }
}
