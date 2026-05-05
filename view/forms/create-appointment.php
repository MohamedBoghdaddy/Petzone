<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Appointment – PetZone</title>
  <?php include "../pages/sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php
require_once "../../includes/auth.php";
require_login();
include "../../control/functions/appointmentsFunctions.php";
include "../../control/functions/patientsFunctions.php";
include_once "../../control/functions/usersFunctions.php";

$patientsService = PatientsController::getInstance();
$usersService    = UsersController::getInstance();
$myPets          = $patientsService->getPatients('my');
$vets            = $usersService->getUsers('employee');
?>

<div class="container py-5 flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <div class="card pz-form-card p-4">
        <div class="card-body">
          <div class="text-center mb-4">
            <i class="bi bi-calendar-plus-fill text-primary" style="font-size:2.2rem"></i>
            <h2 class="fw-bold mt-2">Book an Appointment</h2>
            <p class="text-muted">Schedule a visit for your pet</p>
          </div>

          <?php if (empty($myPets)): ?>
          <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-1"></i>
            You have no pets registered yet.
            <a href="create-patient.php" class="fw-semibold">Add a pet first →</a>
          </div>
          <?php else: ?>
          <form method="post" action="" novalidate>
            <input type="hidden" name="petOwner" value="<?= htmlspecialchars($_SESSION['Username'] ?? '') ?>">

            <div class="mb-3">
              <label class="form-label fw-semibold">Select Pet <span class="text-danger">*</span></label>
              <select name="petname" class="form-select" required>
                <?php foreach ($myPets as $p): ?>
                <option value="<?= htmlspecialchars($p['petname']) ?>">
                  <?= htmlspecialchars($p['petname']) ?> (<?= htmlspecialchars($p['species']) ?>)
                </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Veterinarian <span class="text-danger">*</span></label>
              <select name="EmployeeName" class="form-select" required>
                <?php if (empty($vets)): ?>
                <option value="">No vets available</option>
                <?php else: ?>
                <?php foreach ($vets as $v): ?>
                <option value="<?= htmlspecialchars($v['Username']) ?>">
                  Dr. <?= htmlspecialchars($v['firstname'] . ' ' . $v['lastname']) ?>
                </option>
                <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Service Type & Price <span class="text-danger">*</span></label>
              <select name="price" id="serviceSelect" class="form-select" required onchange="syncService()">
                <option value="100"  data-service="General Checkup">General Checkup – 100 EGP</option>
                <option value="150"  data-service="Vaccination">Vaccination – 150 EGP</option>
                <option value="300"  data-service="Small Animal Surgery">Small Animal Surgery – 300 EGP</option>
                <option value="350"  data-service="Orthopedics">Orthopedics – 350 EGP</option>
              </select>
              <input type="hidden" name="service_type" id="serviceType">
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Appointment Date <span class="text-danger">*</span></label>
              <input type="date" name="aDate" class="form-control" required min="<?= date('Y-m-d') ?>">
            </div>

            <div class="d-grid">
              <button type="submit" name="addAppointment" class="btn btn-primary fw-semibold py-2">
                <i class="bi bi-calendar-check me-1"></i>Book Appointment
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
function syncService() {
  const sel = document.getElementById('serviceSelect');
  document.getElementById('serviceType').value =
    sel.options[sel.selectedIndex].getAttribute('data-service');
}
syncService(); // init on page load
</script>
</body>
</html>
