<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Health Record – PetZone</title>
  <?php include "../pages/sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php
require_once "../../includes/auth.php";
require_login();
include "../../control/functions/healthFunctions.php";
include_once "../../control/functions/patientsFunctions.php";

$patientsService = PatientsController::getInstance();
$myPets          = $patientsService->getPatients('my');
?>

<div class="container py-5 flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <div class="card pz-form-card p-4">
        <div class="card-body">
          <div class="text-center mb-4">
            <i class="bi bi-clipboard2-plus-fill text-success" style="font-size:2.2rem"></i>
            <h2 class="fw-bold mt-2">Add Health Record</h2>
            <p class="text-muted">Log a medical visit or health event</p>
          </div>

          <?php if (empty($myPets)): ?>
          <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-1"></i>
            No pets registered yet. <a href="create-patient.php" class="fw-semibold">Add a pet first →</a>
          </div>
          <?php else: ?>
          <form method="post" action="" novalidate>
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label fw-semibold">Select Pet <span class="text-danger">*</span></label>
                <select name="pet_id" id="petSelect" class="form-select" required onchange="syncPetName()">
                  <?php foreach ($myPets as $p): ?>
                  <option value="<?= $p['ID'] ?>" data-name="<?= htmlspecialchars($p['petname']) ?>">
                    <?= htmlspecialchars($p['petname']) ?> (<?= htmlspecialchars($p['species']) ?>)
                  </option>
                  <?php endforeach; ?>
                </select>
                <input type="hidden" name="petname" id="petname">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Record Type <span class="text-danger">*</span></label>
                <select name="record_type" class="form-select" required>
                  <?php foreach (['Vaccination','Checkup','Surgery','Medication','Other'] as $rt): ?>
                  <option value="<?= $rt ?>"><?= $rt ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Visit Date <span class="text-danger">*</span></label>
                <input type="date" name="visit_date" class="form-control" required
                       max="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>">
              </div>

              <div class="col-12">
                <label class="form-label fw-semibold">Title / Diagnosis <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" required maxlength="100"
                       placeholder="e.g. Annual Vaccine, Dental Cleaning">
              </div>

              <div class="col-12">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3"
                          placeholder="Detailed notes about the visit, medications given, etc."></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Vet Name</label>
                <input type="text" name="vet_name" class="form-control" maxlength="100"
                       placeholder="Dr. Sarah Jones">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Next Visit Date</label>
                <input type="date" name="next_visit_date" class="form-control"
                       min="<?= date('Y-m-d') ?>">
              </div>
            </div>

            <div class="d-grid mt-4">
              <button type="submit" name="addRecord" class="btn btn-success fw-semibold py-2">
                <i class="bi bi-plus-circle me-1"></i>Save Health Record
              </button>
            </div>
          </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "../components/footer.php"; ?>

<script>
function syncPetName() {
  const sel = document.getElementById('petSelect');
  document.getElementById('petname').value =
    sel.options[sel.selectedIndex].getAttribute('data-name');
}
syncPetName();
</script>
</body>
</html>
