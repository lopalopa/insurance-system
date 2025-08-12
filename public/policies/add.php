<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';
requireLogin();
include __DIR__ . '/../../includes/header.php';

$customers = $pdo->query('SELECT id, name FROM customers ORDER BY name')->fetchAll();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $policy_number = trim($_POST['policy_number'] ?? '');
    $customer_id = (int)($_POST['customer_id'] ?? 0);
    $policy_type = trim($_POST['policy_type'] ?? '');
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;
    $premium = $_POST['premium'] ?? 0;

    if ($policy_number === '' || !$customer_id) {
        $err = 'Policy number & customer are required.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO policies (policy_number, customer_id, policy_type, start_date, end_date, premium) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$policy_number, $customer_id, $policy_type, $start_date, $end_date, $premium]);
        header('Location: /insurance-system-full/public/policies/list.php');
        exit;
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    body {
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        min-height: 100vh;
    }
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    .btn-primary {
        background: linear-gradient(45deg, #36d1dc, #5b86e5);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(45deg, #5b86e5, #36d1dc);
        transform: scale(1.03);
    }
    .btn-secondary:hover {
        transform: scale(1.03);
    }
</style>

<div class="container py-5">
    <div class="card p-4 bg-light mt-5">
        <h2 class="mb-4 text-primary">
            <i class="bi bi-file-earmark-plus"></i> Add Policy
        </h2>

        <?php if ($err): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-hash"></i> Policy Number</label>
                <input name="policy_number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-person"></i> Customer</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">-- Select Customer --</option>
                    <?php foreach ($customers as $c): ?>
                        <option value="<?= htmlspecialchars($c['id']) ?>"><?= htmlspecialchars($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-file-text"></i> Policy Type</label>
                <input name="policy_type" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-calendar-event"></i> Start Date</label>
                <input name="start_date" type="date" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-calendar-check"></i> End Date</label>
                <input name="end_date" type="date" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-cash-coin"></i> Premium</label>
                <input name="premium" type="number" step="0.01" class="form-control">
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary">
                    <i class="bi bi-save"></i> Add Policy
                </button>
                <a href="list.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
