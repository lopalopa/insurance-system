<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();
include __DIR__ . '/../includes/header.php';

$counts = [];
try {
    $counts['customers'] = $pdo->query('SELECT COUNT(*) FROM customers')->fetchColumn();
    $counts['policies'] = $pdo->query('SELECT COUNT(*) FROM policies')->fetchColumn();
    $counts['claims'] = $pdo->query('SELECT COUNT(*) FROM claims')->fetchColumn();
} catch (Exception $e) {
    $counts = ['customers'=>0,'policies'=>0,'claims'=>0];
}
?>
<h1>Dashboard</h1>
<div class="row">
  <div class="col-md-4">
    <div class="card text-white bg-primary mb-3">
      <div class="card-body">
        <h5 class="card-title">Customers</h5>
        <p class="card-text display-6"><?=intval($counts['customers'])?></p>
        <a href="/insurance-system-full/public/customers/list.php" class="btn btn-light">View</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-white bg-success mb-3">
      <div class="card-body">
        <h5 class="card-title">Policies</h5>
        <p class="card-text display-6"><?=intval($counts['policies'])?></p>
        <a href="/insurance-system-full/public/policies/list.php" class="btn btn-light">View</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-white bg-warning mb-3">
      <div class="card-body">
        <h5 class="card-title">Claims</h5>
        <p class="card-text display-6"><?=intval($counts['claims'])?></p>
        <a href="/insurance-system-full/public/claims/list.php" class="btn btn-light">View</a>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
