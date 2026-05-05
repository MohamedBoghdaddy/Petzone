<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pet – PetZone</title>
  <?php include "../pages/sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php
require_once "../../includes/auth.php";
require_login();
require_once "../../control/services/patient.service.php";
include "../../control/functions/patientsFunctions.php";

$petId = isset($_GET['ID']) ? (int) $_GET['ID'] : 0;
$svc   = PatientsController::getInstance();
$pet   = $svc->getPatientById($petId);

if (!$pet) {
    flash('error', 'Pet not found.');
    header('Location: ../pages/patientsManagement.php');
    exit;
}
// Clients can only edit their own pets
if ($_SESSION['accountType'] === 'Client' && $pet['addedBy'] !== $_SESSION['Username']) {
    flash('error', 'Access denied.');
    header('Location: ../pages/patientsManagement.php');
    exit;
}
?>

<div class="container py-5 flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <div class="card pz-form-card p-4">
        <div class="card-body">
          <div class="text-center mb-4">
            <i class="bi bi-pencil-square text-warning" style="font-size:2.2rem"></i>
            <h2 class="fw-bold mt-2">Edit Pet</h2>
            <p class="text-muted"><?= htmlspecialchars($pet['petname']) ?></p>
          </div>

          <form method="post" action="" novalidate>
            <input type="hidden" name="ID"      value="<?= $pet['ID'] ?>">
            <input type="hidden" name="addedBy" value="<?= htmlspecialchars($pet['addedBy']) ?>">

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Pet Name <span class="text-danger">*</span></label>
                <input type="text" name="petname" class="form-control" required minlength="2"
                       value="<?= htmlspecialchars($pet['petname']) ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Species <span class="text-danger">*</span></label>
                <input type="text" name="species" class="form-control" required minlength="2"
                       value="<?= htmlspecialchars($pet['species']) ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Breed</label>
                <input type="text" name="breed" class="form-control"
                       value="<?= htmlspecialchars($pet['breed'] ?? '') ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Gender</label>
                <select name="gender" class="form-select">
                  <?php foreach (['Unknown','Male','Female'] as $g): ?>
                  <option value="<?= $g ?>" <?= ($pet['gender'] ?? '') === $g ? 'selected' : '' ?>><?= $g ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Age (years) <span class="text-danger">*</span></label>
                <input type="number" name="age" class="form-control" required min="0" max="50"
                       value="<?= (int) $pet['age'] ?>">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Weight (kg) <span class="text-danger">*</span></label>
                <input type="number" step="0.1" name="weight" class="form-control" required min="0"
                       value="<?= htmlspecialchars($pet['weight']) ?>">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Color</label>
                <input type="text" name="color" class="form-control"
                       value="<?= htmlspecialchars($pet['color'] ?? '') ?>">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Notes</label>
                <textarea name="notes" class="form-control" rows="2"><?= htmlspecialchars($pet['notes'] ?? '') ?></textarea>
              </div>
            </div>

            <div class="d-flex gap-2 mt-4">
              <button type="submit" name="editPatient" class="btn btn-success flex-grow-1 fw-semibold py-2">
                <i class="bi bi-save me-1"></i>Save Changes
              </button>
              <button type="submit" name="deletePatient" class="btn btn-outline-danger fw-semibold py-2"
                      onclick="return confirm('Delete this pet and all associated records?')">
                <i class="bi bi-trash me-1"></i>Delete
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "../components/footer.php"; ?>
</body>
</html>
