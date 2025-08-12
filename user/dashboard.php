<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Ensure customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header('Location: /insurance-system-full/user/login.php');
    exit;
}

$customer_id = (int) $_SESSION['customer_id'];

// Fetch customer details
$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    $_SESSION = [];
    session_destroy();
    header('Location: /insurance-system-full/user/login.php?error=notfound');
    exit;
}

// Fetch customer's policies
$policiesStmt = $pdo->prepare("SELECT * FROM policies WHERE customer_id = ? ORDER BY id DESC");
$policiesStmt->execute([$customer_id]);
$policies = $policiesStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch customer's claims
$claimsStmt = $pdo->prepare("
    SELECT c.*, p.policy_number 
    FROM claims c
    INNER JOIN policies p ON c.policy_id = p.id AND p.customer_id = :policy_customer_id
    WHERE c.customer_id = :claim_customer_id
    ORDER BY c.created_at DESC
");
$claimsStmt->execute([
    'policy_customer_id' => $customer_id,
    'claim_customer_id' => $customer_id,
]);
$claims = $claimsStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 12px;
        }
        .table th {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Welcome, <?= htmlspecialchars($customer['name']) ?></h1>
        <a href="/insurance-system-full/user/logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- My Details -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">My Details</div>
        <div class="card-body">
            <table class="table table-striped">
                <tr><th>Name</th><td><?= htmlspecialchars($customer['name']) ?></td></tr>
                <tr><th>Username</th><td><?= htmlspecialchars($customer['username']) ?></td></tr>
                <tr><th>Email</th><td><?= htmlspecialchars($customer['email'] ?? '') ?></td></tr>
                <tr><th>Phone</th><td><?= htmlspecialchars($customer['phone'] ?? '') ?></td></tr>
                <tr><th>Date of Birth</th><td><?= htmlspecialchars($customer['dob'] ?? '') ?></td></tr>
                <tr><th>Address</th><td><?= nl2br(htmlspecialchars($customer['address'] ?? '')) ?></td></tr>
            </table>
        </div>
    </div>

    <!-- My Policies -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">My Policies</div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Policy Number</th>
                    <th>Policy Type</th>
                    <th>Premium</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($policies)): ?>
                    <?php foreach ($policies as $policy): ?>
                        <tr>
                            <td><?= htmlspecialchars($policy['policy_number']) ?></td>
                            <td><?= htmlspecialchars($policy['policy_type'] ?? '') ?></td>
                            <td><?= isset($policy['premium']) ? number_format($policy['premium'], 2) : '' ?></td>
                            <td><?= htmlspecialchars($policy['start_date'] ?? '') ?></td>
                            <td><?= htmlspecialchars($policy['end_date'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center text-muted">No policies found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- My Claims -->
    <div class="card shadow-sm">
        <div class="card-header bg-warning">My Claims</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Claim Number</th>
                    <th>Policy Number</th>
                    <th>Claimed Amount</th>
                    <th>Approved Amount</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Document</th>
                    <th>Claim Date</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($claims)): ?>
                    <?php foreach ($claims as $claim): ?>
                        <tr>
                            <td><?= htmlspecialchars($claim['claim_number']) ?></td>
                            <td><?= htmlspecialchars($claim['policy_number'] ?? '') ?></td>
                            <td><?= isset($claim['claimed_amount']) ? number_format($claim['claimed_amount'], 2) : '' ?></td>
                            <td><?= isset($claim['approved_amount']) ? number_format($claim['approved_amount'], 2) : '0.00' ?></td>
                            <td><span class="badge bg-info text-dark"><?= htmlspecialchars($claim['status']) ?></span></td>
                            <td><?= nl2br(htmlspecialchars($claim['description'] ?? '')) ?></td>
                            <td>
                                <?php if (!empty($claim['document'])): ?>
                                    <a href="/insurance-system-full/uploads/claims/<?= rawurlencode($claim['document']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($claim['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-center text-muted">No claims found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
