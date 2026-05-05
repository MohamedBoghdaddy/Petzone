<?php
/**
 * PDO database singleton.
 * Call db() anywhere to get the shared PDO instance.
 */
function db(): PDO {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    // Load from .env if present (XAMPP-friendly fallback to config.php constants)
    $envFile = dirname(__DIR__) . '/.env';
    if (file_exists($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
            [$key, $val] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($val);
        }
    }

    $server   = $_ENV['DB_SERVER']   ?? (defined('DB_SERVER')   ? DB_SERVER   : 'localhost');
    $user     = $_ENV['DB_USER']     ?? (defined('DB_USER')     ? DB_USER     : 'root');
    $pass     = $_ENV['DB_PASS']     ?? (defined('DB_PASS')     ? DB_PASS     : '');
    $database = $_ENV['DB_DATABASE'] ?? (defined('DB_DATABASE') ? DB_DATABASE : 'petzone');

    $dsn = "mysql:host={$server};dbname={$database};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        // Don't expose connection details to the browser
        error_log('DB connection failed: ' . $e->getMessage());
        die('<div style="font-family:sans-serif;padding:2rem;color:#c00">'
            . '<h2>Database unavailable</h2>'
            . '<p>Please make sure MySQL is running and the <code>petzone</code> database exists.</p>'
            . '</div>');
    }

    return $pdo;
}
