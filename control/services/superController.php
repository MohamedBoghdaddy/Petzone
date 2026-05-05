<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';

start_session();

abstract class SuperController {
    protected PDO $db;

    public function __construct() {
        $this->db = db();
    }
}
