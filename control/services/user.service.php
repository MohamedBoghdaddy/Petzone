<?php
require_once __DIR__ . '/superController.php';
require_once __DIR__ . '/../../model/user.model.php';

class UsersController extends SuperController {
    private static ?UsersController $instance = null;

    private function __construct() { parent::__construct(); }

    public static function getInstance(): self {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    // ------------------------------------------------------------------ //

    public function addNewUser(array $data): void {
        $hash = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
            'INSERT INTO users (firstname, lastname, Username, Email, password, accountType)
             VALUES (:fn, :ln, :un, :em, :pw, :at)'
        );
        $ok = $stmt->execute([
            ':fn' => $data['firstname'],
            ':ln' => $data['lastname'],
            ':un' => $data['Username'],
            ':em' => $data['Email'],
            ':pw' => $hash,
            ':at' => $data['accountType'],
        ]);
        if ($ok) {
            flash('success', 'User created successfully.');
            $dest = is_logged_in() ? '../pages/userManagement.php' : '../forms/login.php';
            header('Location: ' . $dest);
            exit;
        }
        flash('error', 'Could not create user. Username or Email may already be taken.');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function login(array $data): void {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE Username = :un LIMIT 1');
        $stmt->execute([':un' => $data['Username']]);
        $row = $stmt->fetch();

        if ($row && password_verify($data['password'], $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['ID']          = $row['ID'];
            $_SESSION['firstname']   = $row['firstname'];
            $_SESSION['lastname']    = $row['lastname'];
            $_SESSION['Username']    = $row['Username'];
            $_SESSION['Email']       = $row['Email'];
            $_SESSION['accountType'] = $row['accountType'];
            header('Location: ../pages/dashboard.php');
            exit;
        }
        flash('error', 'Invalid username or password.');
        header('Location: ../forms/login.php');
        exit;
    }

    public function editMyUser(array $data): void {
        $id = (int) $_SESSION['ID'];

        // Only rehash if password field was actually filled in
        if (!empty($data['password'])) {
            $hash = password_hash($data['password'], PASSWORD_BCRYPT);
            $stmt = $this->db->prepare(
                'UPDATE users SET firstname=:fn, lastname=:ln, Email=:em, password=:pw WHERE ID=:id'
            );
            $stmt->execute([':fn'=>$data['firstname'],':ln'=>$data['lastname'],
                            ':em'=>$data['Email'],':pw'=>$hash,':id'=>$id]);
        } else {
            $stmt = $this->db->prepare(
                'UPDATE users SET firstname=:fn, lastname=:ln, Email=:em WHERE ID=:id'
            );
            $stmt->execute([':fn'=>$data['firstname'],':ln'=>$data['lastname'],
                            ':em'=>$data['Email'],':id'=>$id]);
        }

        $_SESSION['firstname'] = $data['firstname'];
        $_SESSION['lastname']  = $data['lastname'];
        $_SESSION['Email']     = $data['Email'];
        flash('success', 'Profile updated successfully.');
        header('Location: ../pages/userManagement.php');
        exit;
    }

    public function editUser(array $data): void {
        $id = (int) $data['ID'];
        if (!empty($data['password'])) {
            $hash = password_hash($data['password'], PASSWORD_BCRYPT);
            $stmt = $this->db->prepare(
                'UPDATE users SET firstname=:fn, lastname=:ln, Email=:em, password=:pw WHERE ID=:id'
            );
            $stmt->execute([':fn'=>$data['firstname'],':ln'=>$data['lastname'],
                            ':em'=>$data['Email'],':pw'=>$hash,':id'=>$id]);
        } else {
            $stmt = $this->db->prepare(
                'UPDATE users SET firstname=:fn, lastname=:ln, Email=:em WHERE ID=:id'
            );
            $stmt->execute([':fn'=>$data['firstname'],':ln'=>$data['lastname'],
                            ':em'=>$data['Email'],':id'=>$id]);
        }
        flash('success', 'User updated.');
        header('Location: ../pages/userManagement.php');
        exit;
    }

    public function deleteMyUser(): void {
        $id       = (int) $_SESSION['ID'];
        $username = $_SESSION['Username'];

        // Cascade: delete appointments + patients via DB foreign key or explicit delete
        $this->db->prepare('DELETE FROM appointments WHERE petOwner=:u OR EmployeeName=:u')
                 ->execute([':u' => $username]);
        $this->db->prepare('DELETE FROM patients WHERE addedBy=:u')
                 ->execute([':u' => $username]);
        $this->db->prepare('DELETE FROM users WHERE ID=:id')
                 ->execute([':id' => $id]);

        session_destroy();
        header('Location: ../../view/pages/home.php');
        exit;
    }

    public function deleteUser(array $data): void {
        $id       = (int) $data['ID'];
        $username = $data['Username'];

        $this->db->prepare('DELETE FROM appointments WHERE petOwner=:u OR EmployeeName=:u')
                 ->execute([':u' => $username]);
        $this->db->prepare('DELETE FROM patients WHERE addedBy=:u')
                 ->execute([':u' => $username]);
        $this->db->prepare('DELETE FROM users WHERE ID=:id')
                 ->execute([':id' => $id]);

        if ($id === (int) $_SESSION['ID']) {
            session_destroy();
            header('Location: ../../view/pages/home.php');
        } else {
            flash('success', 'User deleted.');
            header('Location: ../../view/pages/userManagement.php');
        }
        exit;
    }

    public function getUsers(string $type): array {
        $where = match($type) {
            'client'          => "accountType = 'Client'",
            'employee'        => "accountType = 'Employee'",
            'employee_client' => "accountType IN ('Employee','Client')",
            default           => '1',
        };
        $rows = $this->db->query("SELECT ID,firstname,lastname,Username,Email,accountType FROM users WHERE {$where}")->fetchAll();
        return $rows ?: [];
    }

    public function signout(): void {
        session_destroy();
        header('Location: ../../view/pages/home.php');
        exit;
    }
}
