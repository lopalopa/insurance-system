<?php
// Run this once after importing DB to set admin password hash in DB.
require_once __DIR__ . '/includes/db.php';
$email = 'admin@example.com';
$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo 'Admin already exists.';
    exit;
}
$hash = password_hash('Admin@123', PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
$stmt->execute(['Admin', $email, $hash, 'admin']);
echo 'Admin created: admin@example.com / Admin@123';
