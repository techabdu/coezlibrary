<?php
/**
 * Database Configuration Template
 * Copy this file to database.php and update the credentials
 */

return [
    'host' => 'localhost',
    'dbname' => 'library_db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];