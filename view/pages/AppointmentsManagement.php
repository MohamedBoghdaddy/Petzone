<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointments – PetZone</title>
  <?php include "sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php
require_once "../../includes/auth.php";
require_login();
include "../../control/functions/appointmentsFunctions.php";

$svc  = AppointmentsController::getInstance();
$type = $_SESSION['accountType'] ?? 'Client';
$appts = $svc->getAppointments(
    $type === 'Admin' ? 'all' : ($type === 'Employee' ? 'employee' : 'client')
);

$statusColor = ['Pending'=>'warning','Confirmed'=>'success','Cancelled'=>'danger'];
?>

<div class="container py-4 flex-grow-1">

  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
      <h2 class="fw-bold mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Appointments</h2>
      <p class="text-muted mb-0"><?= count($appts) ?> appointment(s)</p>
    </div>
    <?php if ($type === 'Client'): ?>
    <a href="../forms/create-appointment.php" class="btn btn-primary fw-semibold">
      <i class="bi bi-calendar-plus me-1"></i>Book Appointment
    </a>
    <?php endif; ?>
  </div>

  <?php if (empty($appts)): ?>
  <div class="text-center py-5">
    <i class="bi bi-calendar-x text-muted" style="font-size:4rem"></i>
    <h5 class="mt-3 text-muted">No appointments found</h5>
    <?php if ($type === 'Client'): ?>
    <a href="../forms/create-appointment.php" class="btn btn-primary mt-2">
      <i class="bi bi-calendar-plus me-1"></i>Book your first appointment
    </a>
    <?php endif; ?>
  </div>

  <?php else: ?>
  <div class="card border-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0 pz-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Pet</th>
            <?php if ($type !== 'Client'): ?><th>Owner</th><?php endif; ?>
            <th>Veterinarian</th>
            <?php if ($type !== 'Client'): ?><th>Service</th><?php endif; ?>
            <th>Date</th>
            <th>Price (EGP)</th>
            <th>Status</th>
            <?php if ($type !== 'Employee' || true): ?><th>Actions</th><?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($appts as $a): ?>
          <tr>
            <td class="text-muted small"><?= $a['ID'] ?></td>
            <td class="fw-semibold"><?= htmlspecialchars($a['petname']) ?></td>
            <?php if ($type !== 'Client'): ?>
            <td class="text-muted"><?= htmlspecialchars($a['petOwner']) ?></td>
            <?php endif; ?>
            <td><?= htmlspecialchars($a['EmployeeName']) ?></td>
            <?php if ($type !== 'Client'): ?>
            <td class="text-muted small"><?= htmlspecialchars($a['service_type'] ?? '—') ?></td>
            <?php endif; ?>
            <td><?= htmlspecialchars($a['aDate']) ?></td>
            <td><?= number_format((float)$a['price'], 2) ?></td>
            <td>
              <span class="badge badge-<?= strtolower($a['status']) ?>">
                <?= htmlspecialchars($a['status']) ?>
              </span>
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="../forms/edit-appointment.php?ID=<?= $a['ID'] ?>&aDate=<?= urlencode($a['aDate']) ?>&status=<?= urlencode($a['status']) ?>"
                   class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-pencil"></i>
                </a>
                <?php if ($type === 'Admin' || $type === 'Employee'): ?>
                <form method="post" action="" class="d-inline">
                  <input type="hidden" name="ID" value="<?= $a['ID'] ?>">
                  <input type="hidden" name="status" value="Confirmed">
                  <button type="submit" name="updateStatus" class="btn btn-sm btn-outline-success"
                          title="Confirm" <?= $a['status']==='Confirmed' ? 'disabled' : '' ?>>
                    <i class="bi bi-check-circle"></i>
                  </button>
                </form>
                <form method="post" action="" class="d-inline">
                  <input type="hidden" name="ID" value="<?= $a['ID'] ?>">
                  <input type="hidden" name="status" value="Cancelled">
                  <button type="submit" name="updateStatus" class="btn btn-sm btn-outline-danger"
                          title="Cancel" <?= $a['status']==='Cancelled' ? 'disabled' : '' ?>>
                    <i class="bi bi-x-circle"></i>
                  </button>
                </form>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

</div>

<?php include "../components/footer.php"; ?>
</body>
</html>
