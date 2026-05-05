<?php
require_once __DIR__ . '/superController.php';
require_once __DIR__ . '/../../model/patient.model.php';

class PatientsController extends SuperController {
    private static ?PatientsController $instance = null;

    private function __construct() { parent::__construct(); }

    public static function getInstance(): self {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    // ------------------------------------------------------------------ //

    public function addNewPatient(array $data): void {
        $stmt = $this->db->prepare(
            'INSERT INTO patients (addedBy, petname, species, breed, gender, age, weight, color, notes)
             VALUES (:by, :pn, :sp, :br, :gn, :ag, :wt, :cl, :nt)'
        );
        $stmt->execute([
            ':by' => $data['addedBy'],
            ':pn' => $data['petname'],
            ':sp' => $data['species'],
            ':br' => $data['breed']  ?? null,
            ':gn' => $data['gender'] ?? 'Unknown',
            ':ag' => (int) $data['age'],
            ':wt' => (float) $data['weight'],
            ':cl' => $data['color'] ?? null,
            ':nt' => $data['notes'] ?? null,
        ]);
        flash('success', 'Pet added successfully!');
        header('Location: ../pages/patientsManagement.php');
        exit;
    }

    public function editPatient(array $data): void {
        $stmt = $this->db->prepare(
            'UPDATE patients SET petname=:pn, species=:sp, breed=:br, gender=:gn,
             age=:ag, weight=:wt, color=:cl, notes=:nt WHERE ID=:id'
        );
        $stmt->execute([
            ':pn' => $data['petname'],
            ':sp' => $data['species'],
            ':br' => $data['breed']  ?? null,
            ':gn' => $data['gender'] ?? 'Unknown',
            ':ag' => (int) $data['age'],
            ':wt' => (float) $data['weight'],
            ':cl' => $data['color'] ?? null,
            ':nt' => $data['notes'] ?? null,
            ':id' => (int) $data['ID'],
        ]);
        flash('success', 'Pet updated successfully!');
        header('Location: ../pages/patientsManagement.php');
        exit;
    }

    public function deletePatient(int $id): void {
        // Health records cascade via FK; appointments deleted explicitly
        $stmt = $this->db->prepare('SELECT petname FROM patients WHERE ID=:id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if ($row) {
            $this->db->prepare('DELETE FROM appointments WHERE petname=:pn')
                     ->execute([':pn' => $row['petname']]);
        }
        $this->db->prepare('DELETE FROM patients WHERE ID=:id')->execute([':id' => $id]);
        flash('success', 'Pet removed.');
        header('Location: ../../view/pages/patientsManagement.php');
        exit;
    }

    public function deletePatientsByOwner(string $username): void {
        $stmt = $this->db->prepare('SELECT petname FROM patients WHERE addedBy=:u');
        $stmt->execute([':u' => $username]);
        foreach ($stmt->fetchAll() as $row) {
            $this->db->prepare('DELETE FROM appointments WHERE petname=:pn')
                     ->execute([':pn' => $row['petname']]);
        }
        $this->db->prepare('DELETE FROM patients WHERE addedBy=:u')->execute([':u' => $username]);
    }

    public function getPatients(string $type): array {
        if ($type === 'all') {
            return $this->db->query('SELECT * FROM patients ORDER BY petname')->fetchAll();
        }
        $stmt = $this->db->prepare('SELECT * FROM patients WHERE addedBy=:u ORDER BY petname');
        $stmt->execute([':u' => $_SESSION['Username']]);
        return $stmt->fetchAll();
    }

    public function getPatientById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM patients WHERE ID=:id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
