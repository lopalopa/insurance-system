<?php
require_once '../../includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $dob = $_POST['dob'] ?: null;
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);

    // Check if username already exists
    $checkStmt = $pdo->prepare("SELECT id FROM customers WHERE username = ?");
    $checkStmt->execute([$username]);
    if ($checkStmt->rowCount() > 0) {
        $message = "Error: Username already exists!";
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO customers (name, username, password, dob, phone, email, address) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        if ($stmt->execute([$name, $username, $password, $dob, $phone, $email, $address])) {
            $message = "✅ Customer added successfully!";
        } else {
            $message = "❌ Error adding customer.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Customer - Insurance Management</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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
    .form-card {
      background: #fff;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      max-width: 500px;
      width: 100%;
      animation: fadeIn 0.6s ease-in-out;
    }
    .form-title {
      font-weight: 700;
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
    }
    .form-control {
      border-radius: 10px;
      padding: 0.75rem;
    }
    .btn-submit {
      width: 100%;
      border-radius: 10px;
      padding: 0.75rem;
      font-weight: 600;
      background: #4facfe;
      border: none;
      transition: background 0.3s ease;
    }
    .btn-submit:hover {
      background: #00c6ff;
    }
    .alert {
      text-align: center;
      font-weight: 500;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>

  <div class="form-card">
    <h2 class="form-title"><i class="fas fa-user-plus"></i> Add Customer</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo strpos($message, 'successfully') !== false ? 'success' : 'danger'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label"><i class="fas fa-id-card"></i> Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="fas fa-user"></i> Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="fas fa-lock"></i> Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="fas fa-calendar-alt"></i> Date of Birth</label>
        <input type="date" name="dob" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="fas fa-phone"></i> Phone</label>
        <input type="text" name="phone" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
        <input type="email" name="email" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="fas fa-home"></i> Address</label>
        <textarea name="address" class="form-control"></textarea>
      </div>

      <button type="submit" class="btn btn-submit"><i class="fas fa-save"></i> Add Customer</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
