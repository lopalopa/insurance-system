<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$userName = $_SESSION['user_name'] ?? null;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Insurance System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/insurance-system-full/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container">
    <a class="navbar-brand" href="/insurance-system-full/public/index.php">IMS</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/insurance-system-full/public/customers/list.php">Customers</a></li>
        <li class="nav-item"><a class="nav-link" href="/insurance-system-full/public/policies/list.php">Policies</a></li>
        <li class="nav-item"><a class="nav-link" href="/insurance-system-full/public/claims/list.php">Claims</a></li>
      </ul>
      <ul class="navbar-nav">
        <?php if ($userName): ?>
          <li class="nav-item"><span class="nav-link">Hello, <?=htmlspecialchars($userName)?></span></li>
          <li class="nav-item"><a class="nav-link" href="/insurance-system-full/public/logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/insurance-system-full/public/login.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
