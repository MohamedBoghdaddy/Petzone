<?php
/**
 * Auth & session helpers.
 * Include this at the top of any protected page.
 */

function start_session(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => false,   // set true if running HTTPS
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }
}

function is_logged_in(): bool {
    start_session();
    return !empty($_SESSION['ID']);
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: ../forms/login.php');
        exit;
    }
}

function require_login_deep(): void {
    // For pages two levels deep (e.g. control/functions/)
    if (!is_logged_in()) {
        header('Location: ../../view/forms/login.php');
        exit;
    }
}

function require_role(string ...$roles): void {
    require_login();
    if (!in_array($_SESSION['accountType'] ?? '', $roles, true)) {
        header('Location: ../pages/home.php');
        exit;
    }
}

function current_user(): array {
    start_session();
    return [
        'ID'          => $_SESSION['ID']          ?? null,
        'firstname'   => $_SESSION['firstname']   ?? '',
        'lastname'    => $_SESSION['lastname']     ?? '',
        'Username'    => $_SESSION['Username']     ?? '',
        'Email'       => $_SESSION['Email']        ?? '',
        'accountType' => $_SESSION['accountType']  ?? '',
    ];
}

function flash(string $key, string $msg): void {
    start_session();
    $_SESSION['_flash'][$key] = $msg;
}

function get_flash(string $key): ?string {
    start_session();
    $msg = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $msg;
}
