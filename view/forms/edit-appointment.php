<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Appointment – PetZone</title>
  <?php include "../pages/sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php
require_once "../../includes/auth.php";
require_login();
include "../../control/functions/appointmentsFunctions.php";

$id     = isset($_GET['ID'])    ? (int)   $_GET['ID']    : 0;
$aDate  = isset($_GET['aDate']) ? htmlspecialchars($_GET['aDate']) : '';
$status = isset($_GET['status'])? htmlspecialchars($_GET['status']): 'Pending';
$type   = $_SESSION['accountType'] ?? 'Client';
?>

<div class="container py-5 flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-sm-10 col-md-7 col-lg-5">
      <div class="card pz-form-card p-4">
        <div class="card-body">
          <div class="text-center mb-4">
            <i class="bi bi-calendar-event-fill text-primary" style="font-size:2.2rem"></i>
            <h2 class="fw-bold mt-2">Edit Appointment</h2>
          </div>

          <form method="post" action="" novalidate>
            <input type="hidden" name="ID" value="<?= $id ?>">

            <div class="mb-3">
              <label class="form-label fw-semibold">New Date <span class="text-danger">*</span></label>
              <input type="date" name="aDate" class="form-control"
                     required min="<?= date('Y-m-d') ?>" value="<?= $aDate ?>">
            </div>

            <?php if ($type === 'Admin' || $type === 'Employee'): ?>
            <div class="mb-3">
              <label class="form-label fw-semibold">Status</label>
              <select name="status" class="form-select">
                <?php foreach (['Pending','Confirmed','Cancelled'] as $s): ?>
                <option value="<?= $s ?>" <?= $status === $s ? 'selected' : '' ?>><?= $s ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <?php else: ?>
              <input type="hidden" name="status" value="<?= htmlspecialchars($status) ?>">
            <?php endif; ?>

            <div class="mb-4">
              <label class="form-label fw-semibold">Notes</label>
              <textarea name="notes" class="form-control" rows="2" placeholder="Optional notes..."></textarea>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" name="editAppointment" class="btn btn-primary flex-grow-1 fw-semibold py-2">
                <i class="bi bi-save me-1"></i>Update
              </button>
              <button type="submit" name="deleteAppointment" class="btn btn-outline-danger fw-semibold py-2"
                      onclick="return confirm('Delete this appointment?')">
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
