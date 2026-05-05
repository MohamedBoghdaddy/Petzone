<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Pet – PetZone</title>
  <?php include "../pages/sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php
require_once "../../includes/auth.php";
require_login();
include "../../control/functions/patientsFunctions.php";
?>

<div class="container py-5 flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <div class="card pz-form-card p-4">
        <div class="card-body">
          <div class="text-center mb-4">
            <i class="bi bi-heart-fill text-danger" style="font-size:2.2rem"></i>
            <h2 class="fw-bold mt-2">Add a Pet</h2>
            <p class="text-muted">Register your pet's profile</p>
          </div>

          <form method="post" action="" novalidate>
            <input type="hidden" name="addedBy" value="<?= htmlspecialchars($_SESSION['Username'] ?? '') ?>">

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Pet Name <span class="text-danger">*</span></label>
                <input type="text" name="petname" class="form-control" required minlength="2" maxlength="50" placeholder="e.g. Milo">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Species <span class="text-danger">*</span></label>
                <input type="text" name="species" class="form-control" required minlength="2" maxlength="50" placeholder="e.g. Cat, Dog">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Breed</label>
                <input type="text" name="breed" class="form-control" maxlength="50" placeholder="e.g. Persian">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Gender</label>
                <select name="gender" class="form-select">
                  <option value="Unknown">Unknown</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Age (years) <span class="text-danger">*</span></label>
                <input type="number" name="age" class="form-control" required min="0" max="50" placeholder="3">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Weight (kg) <span class="text-danger">*</span></label>
                <input type="number" step="0.1" name="weight" class="form-control" required min="0" max="200" placeholder="4.5">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Color</label>
                <input type="text" name="color" class="form-control" maxlength="50" placeholder="e.g. White">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Notes</label>
                <textarea name="notes" class="form-control" rows="2" placeholder="Any special conditions or notes..."></textarea>
              </div>
            </div>

            <div class="d-grid mt-4">
              <button type="submit" name="addPatient" class="btn btn-success fw-semibold py-2">
                <i class="bi bi-plus-circle me-1"></i>Add Pet
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
