<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Pets – PetZone</title>
  <?php include "sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php
require_once "../../includes/auth.php";
require_login();
include "../../control/functions/patientsFunctions.php";

$svc  = PatientsController::getInstance();
$type = $_SESSION['accountType'] ?? 'Client';
$pets = $svc->getPatients($type === 'Admin' ? 'all' : 'my');
?>

<div class="container py-4 flex-grow-1">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
      <h2 class="fw-bold mb-0"><i class="bi bi-heart-fill text-danger me-2"></i>
        <?= $type === 'Admin' ? 'All Pets' : 'My Pets' ?>
      </h2>
      <p class="text-muted mb-0"><?= count($pets) ?> pet(s) registered</p>
    </div>
    <?php if ($type === 'Client'): ?>
    <a href="../forms/create-patient.php" class="btn btn-success fw-semibold">
      <i class="bi bi-plus-circle me-1"></i>Add Pet
    </a>
    <?php endif; ?>
  </div>

  <?php if (empty($pets)): ?>
  <div class="text-center py-5">
    <i class="bi bi-emoji-frown text-muted" style="font-size:4rem"></i>
    <h5 class="mt-3 text-muted">No pets found</h5>
    <?php if ($type === 'Client'): ?>
    <a href="../forms/create-patient.php" class="btn btn-success mt-2">
      <i class="bi bi-plus-circle me-1"></i>Add your first pet
    </a>
    <?php endif; ?>
  </div>

  <?php else: ?>
  <!-- Cards grid -->
  <div class="row g-4">
    <?php foreach ($pets as $p): ?>
    <div class="col-sm-6 col-lg-4">
      <div class="card pz-pet-card border-0 shadow-sm h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-start justify-content-between mb-3">
            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                 style="width:54px;height:54px">
              <i class="bi bi-heart text-success fs-3"></i>
            </div>
            <span class="badge bg-light text-dark border species-badge">
              <?= htmlspecialchars($p['species']) ?>
            </span>
          </div>
          <h5 class="fw-bold mb-1"><?= htmlspecialchars($p['petname']) ?></h5>
          <?php if (!empty($p['breed'])): ?>
          <p class="text-muted small mb-2"><?= htmlspecialchars($p['breed']) ?></p>
          <?php endif; ?>

          <div class="row g-2 text-sm mt-2">
            <div class="col-6">
              <div class="text-muted small">Age</div>
              <div class="fw-semibold"><?= (int) $p['age'] ?> yr<?= $p['age'] != 1 ? 's' : '' ?></div>
            </div>
            <div class="col-6">
              <div class="text-muted small">Weight</div>
              <div class="fw-semibold"><?= number_format((float)$p['weight'], 1) ?> kg</div>
            </div>
            <?php if (!empty($p['gender'])): ?>
            <div class="col-6">
              <div class="text-muted small">Gender</div>
              <div class="fw-semibold"><?= htmlspecialchars($p['gender']) ?></div>
            </div>
            <?php endif; ?>
            <?php if (!empty($p['color'])): ?>
            <div class="col-6">
              <div class="text-muted small">Color</div>
              <div class="fw-semibold"><?= htmlspecialchars($p['color']) ?></div>
            </div>
            <?php endif; ?>
            <?php if ($type === 'Admin'): ?>
            <div class="col-12">
              <div class="text-muted small">Owner</div>
              <div class="fw-semibold"><?= htmlspecialchars($p['addedBy']) ?></div>
            </div>
            <?php endif; ?>
          </div>

          <?php if (!empty($p['notes'])): ?>
          <p class="text-muted small mt-2 mb-0 fst-italic">
            <?= htmlspecialchars(substr($p['notes'], 0, 60)) ?><?= strlen($p['notes']) > 60 ? '…' : '' ?>
          </p>
          <?php endif; ?>
        </div>

        <?php if ($type === 'Client' || $type === 'Admin'): ?>
        <div class="card-footer bg-transparent border-top d-flex gap-2">
          <a href="../forms/edit-patient.php?ID=<?= $p['ID'] ?>"
             class="btn btn-sm btn-outline-warning flex-grow-1">
            <i class="bi bi-pencil me-1"></i>Edit
          </a>
          <a href="health_records.php?pet_id=<?= $p['ID'] ?>"
             class="btn btn-sm btn-outline-info flex-grow-1">
            <i class="bi bi-clipboard2-pulse me-1"></i>Records
          </a>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

</div>

<?php include "../components/footer.php"; ?>
</body>
</html>
