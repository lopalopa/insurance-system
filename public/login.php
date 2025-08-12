<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$email || !$password) {
        $errors[] = 'Email and password required.';
    } else {
        $stmt = $pdo->prepare('SELECT id, password, name, role FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: /insurance-system-full/public/index.php');
            exit;
        } else {
            $errors[] = 'Invalid login.';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - IMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      background: rgba(255, 255, 255, 0.95);
      padding: 2rem;
      width: 100%;
      max-width: 420px;
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
    h4.card-title {
      font-weight: 700;
      color: #5e2ced;
      text-align: center;
      margin-bottom: 1.5rem;
      text-shadow: 1px 1px 5px rgba(94, 44, 237, 0.6);
    }
    .form-label {
      font-weight: 600;
      color: #4a3aff;
    }
    .btn-primary {
      background: linear-gradient(90deg, #5e2ced, #9a6cff);
      border: none;
      font-weight: 600;
      padding: 0.75rem;
      width: 100%;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(94, 44, 237, 0.4);
      transition: background 0.3s ease;
    }
    .btn-primary:hover {
      background: linear-gradient(90deg, #4820b9, #7a4ccf);
    }
    .alert-danger {
      background: #ff6b81;
      border: none;
      color: white;
      font-weight: 600;
      box-shadow: 0 0 10px #ff6b81;
      border-radius: 10px;
      text-align: center;
    }
    a {
      color: #764ba2;
      font-weight: 600;
      text-decoration: none;
    }
    a:hover {
      color: #5e2ced;
      text-decoration: underline;
    }
    hr {
      border-color: #ddd;
      margin-top: 1.5rem;
      margin-bottom: 1rem;
    }
    p.small {
      text-align: center;
      color: #666;
    }
  </style>
</head>
<body>
  <div class="card shadow-lg">
    <h4 class="card-title">Admin Login</h4>

    <?php foreach ($errors as $e): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>

    <form method="post" novalidate>
      <div class="mb-3">
        <label class="form-label" for="email">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          class="form-control"
          placeholder="Enter your email"
          required
          value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
          autofocus
        />
      </div>
      <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <input
          type="password"
          id="password"
          name="password"
          class="form-control"
          placeholder="Enter your password"
          required
        />
      </div>
      <button class="btn btn-primary" type="submit">Login</button>
    </form>

    <hr />

    <p class="small">Don't have an account? <a href="/insurance-system-full/public/register.php">Register here</a></p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
