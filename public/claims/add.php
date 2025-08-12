<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id     = trim($_POST['customer_id'] ?? '');
    $policy_id       = trim($_POST['policy_id'] ?? '');
    $claimed_amount  = trim($_POST['claimed_amount'] ?? '');
    $status          = trim($_POST['status'] ?? 'submitted');
    $description     = trim($_POST['description'] ?? '');

    // Generate unique claim number
    $claim_number = 'CLM' . time();

    // File upload
    $document = null;
    if (!empty($_FILES['document']['name'])) {
        $uploadDir = '../../uploads/claims/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . basename($_FILES['document']['name']);
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['document']['tmp_name'], $targetFilePath)) {
            $document = $fileName;
        } else {
            $error = "Error uploading document.";
        }
    }

    // Validation
    if (empty($error)) {
        if (empty($customer_id) || empty($policy_id) || empty($claimed_amount)) {
            $error = "All required fields must be filled.";
        } else {
            // Check customer exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM customers WHERE id = ?");
            $stmt->execute([$customer_id]);
            if ($stmt->fetchColumn() == 0) {
                $error = "Invalid customer selected.";
            }

            // Check policy exists
            if (empty($error)) {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM policies WHERE id = ?");
                $stmt->execute([$policy_id]);
                if ($stmt->fetchColumn() == 0) {
                    $error = "Invalid policy selected.";
                }
            }
        }
    }

    // Insert claim
    if (empty($error)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO claims 
                (claim_number, policy_id, customer_id, claimed_amount, approved_amount, status, description, document, created_at) 
                VALUES (?, ?, ?, ?, 0.00, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $claim_number,
                $policy_id,
                $customer_id,
                $claimed_amount,
                $status,
                $description,
                $document
            ]);
            $success = "Claim added successfully.";
        } catch (PDOException $e) {
            $error = $e->getCode() == 23000
                ? "Duplicate claim number. Please try again."
                : "Database error: " . $e->getMessage();
        }
    }
}

// Dropdown data
$customers = $pdo->query("SELECT id, name FROM customers ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$policies  = $pdo->query("SELECT id, policy_number FROM policies ORDER BY policy_number ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Claim</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background-color: #f8f9fa;">

<div class="container mt-5">
    <div class="card shadow-lg mt-5">
        <div class="card-header bg-primary text-white">
            <h4>Add Claim</h4>
        </div>
        <div class="card-body">

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Customer</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">Select Customer</option>
                        <?php foreach ($customers as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Policy</label>
                    <select name="policy_id" class="form-select" required>
                        <option value="">Select Policy</option>
                        <?php foreach ($policies as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['policy_number']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Claim Amount</label>
                    <input type="number" name="claimed_amount" step="0.01" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="submitted">Submitted</option>
                        <option value="under_review">Under Review</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="settled">Settled</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Document</label>
                    <input type="file" name="document" accept=".pdf,.jpg,.jpeg,.png" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Add Claim</button>
                <a href="list.php" class="btn btn-secondary">Back</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>
