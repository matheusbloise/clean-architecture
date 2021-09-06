<?php

return [
    'mysql' => [
        'host' => 'clean-arch-youtube-db',
        'username' => 'root',
        'password' => 'secret',
        'port' => '3306',
        'dbname' => 'clean_arch_youtube',
        'charset' => 'utf8',
        'dsn' => 'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => TRUE
        ]
    ]
];
