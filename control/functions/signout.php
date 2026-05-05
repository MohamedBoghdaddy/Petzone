<?php
require_once __DIR__ . '/../../includes/auth.php';
start_session();
session_unset();
session_destroy();
header('Location: ../../view/pages/home.php');
exit;
