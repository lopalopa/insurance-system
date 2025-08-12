<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Enter username and password.';
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password, name FROM customers WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $cust = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cust && password_verify($password, $cust['password'])) {
            $_SESSION['customer_id'] = $cust['id'];
            $_SESSION['customer_name'] = $cust['name'] ?? '';
            header('Location: /insurance-system-full/user/dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Customer Login - Insurance Management</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <style>
    body {
      background: linear-gradient(135deg, #4facfe, #00f2fe);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      background: #ffffff;
      padding: 2rem 2.5rem;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      max-width: 400px;
      width: 100%;
      animation: fadeIn 0.6s ease-in-out;
    }
    .login-title {
      font-weight: 700;
      color: #333;
      margin-bottom: 1.5rem;
      text-align: center;
    }
    .form-control {
      border-radius: 10px;
      padding: 0.75rem 1rem;
    }
    .btn-login {
      border-radius: 10px;
      font-weight: 600;
      padding: 0.75rem;
      width: 100%;
      background: #4facfe;
      border: none;
      transition: all 0.3s ease;
    }
    .btn-login:hover {
      background: #00c6ff;
    }
    .error-msg {
      background-color: #ff4d6d;
      padding: 0.75rem;
      border-radius: 8px;
      margin-bottom: 1rem;
      color: white;
      font-weight: 500;
    }
    .register-link {
      text-align: center;
      margin-top: 1rem;
    }
    .register-link a {
      text-decoration: none;
      color: #4facfe;
      font-weight: 500;
    }
    .register-link a:hover {
      text-decoration: underline;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h2 class="login-title"><i class="fas fa-user-circle"></i> Customer Login</h2>

    <?php if ($error): ?>
      <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label for="username" class="form-label"><i class="fas fa-user"></i> Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
      </div>

      <div class="mb-4">
        <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
      </div>

      <button type="submit" class="btn btn-login"><i class="fas fa-sign-in-alt"></i> Login</button>
    </form>

    <div class="register-link">
      <p>Don't have an account? <a href="/insurance-system-full/public/customers/add.php">Register here</a></p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
