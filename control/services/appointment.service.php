<?php
require_once __DIR__ . '/superController.php';
require_once __DIR__ . '/../../model/appointment.model.php';

class AppointmentsController extends SuperController {
    private static ?AppointmentsController $instance = null;

    private function __construct() { parent::__construct(); }

    public static function getInstance(): self {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    // ------------------------------------------------------------------ //

    public function addNewAppointment(array $data): void {
        $stmt = $this->db->prepare(
            'INSERT INTO appointments (petOwner, EmployeeName, petname, service_type, aDate, price, status)
             VALUES (:po, :en, :pn, :st, :ad, :pr, :ss)'
        );
        $stmt->execute([
            ':po' => $data['petOwner'],
            ':en' => $data['EmployeeName'],
            ':pn' => $data['petname'],
            ':st' => $data['service_type'] ?? null,
            ':ad' => $data['aDate'],
            ':pr' => (float) $data['price'],
            ':ss' => 'Pending',
        ]);
        flash('success', 'Appointment booked! Status: Pending.');
        header('Location: ../pages/AppointmentsManagement.php');
        exit;
    }

    public function editAppointment(array $data): void {
        $stmt = $this->db->prepare(
            'UPDATE appointments SET aDate=:ad, status=:ss, notes=:nt WHERE ID=:id'
        );
        $stmt->execute([
            ':ad' => $data['aDate'],
            ':ss' => $data['status'] ?? 'Pending',
            ':nt' => $data['notes']  ?? null,
            ':id' => (int) $data['ID'],
        ]);
        flash('success', 'Appointment updated.');
        header('Location: ../pages/AppointmentsManagement.php');
        exit;
    }

    public function updateStatus(int $id, string $status): void {
        $allowed = ['Pending', 'Confirmed', 'Cancelled'];
        if (!in_array($status, $allowed, true)) return;
        $this->db->prepare('UPDATE appointments SET status=:s WHERE ID=:id')
                 ->execute([':s' => $status, ':id' => $id]);
        flash('success', "Appointment marked as {$status}.");
        header('Location: ../pages/AppointmentsManagement.php');
        exit;
    }

    public function deleteAppointment(int $id): void {
        $this->db->prepare('DELETE FROM appointments WHERE ID=:id')->execute([':id' => $id]);
        flash('success', 'Appointment deleted.');
        header('Location: ../../view/pages/AppointmentsManagement.php');
        exit;
    }

    public function getAppointments(string $type): array {
        $sql = match($type) {
            'employee' => 'SELECT * FROM appointments WHERE EmployeeName=:u ORDER BY aDate ASC',
            'client'   => 'SELECT * FROM appointments WHERE petOwner=:u ORDER BY aDate ASC',
            default    => null,
        };
        if ($sql === null) {
            return $this->db->query('SELECT * FROM appointments ORDER BY aDate ASC')->fetchAll();
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':u' => $_SESSION['Username']]);
        return $stmt->fetchAll();
    }

    public function getUpcoming(string $username, int $limit = 5): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM appointments WHERE petOwner=:u AND aDate >= CURDATE()
             ORDER BY aDate ASC LIMIT :lim'
        );
        $stmt->bindValue(':u',   $username, PDO::PARAM_STR);
        $stmt->bindValue(':lim', $limit,    PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
