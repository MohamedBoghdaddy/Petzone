<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard – PetZone</title>
  <?php include "sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php
require_once "../../includes/auth.php";
require_once "../../config.php";
require_once "../../includes/db.php";
require_login();

$u    = current_user();
$pdo  = db();
$type = $u['accountType'];
$un   = $u['Username'];

// Stats
if ($type === 'Admin') {
    $petCount  = (int) $pdo->query('SELECT COUNT(*) FROM patients')->fetchColumn();
    $userCount = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    $apptCount = (int) $pdo->query("SELECT COUNT(*) FROM appointments WHERE status='Pending'")->fetchColumn();
    $pendingText = 'Pending (all)';
} elseif ($type === 'Employee') {
    $s = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE EmployeeName=:u AND status='Pending'");
    $s->execute([':u' => $un]);
    $apptCount = (int) $s->fetchColumn();
    $petCount  = (int) $pdo->query('SELECT COUNT(*) FROM patients')->fetchColumn();
    $userCount = null;
    $pendingText = 'Your Pending';
} else {
    $s = $pdo->prepare('SELECT COUNT(*) FROM patients WHERE addedBy=:u');
    $s->execute([':u' => $un]);
    $petCount  = (int) $s->fetchColumn();
    $s = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE petOwner=:u AND status='Pending'");
    $s->execute([':u' => $un]);
    $apptCount = (int) $s->fetchColumn();
    $s = $pdo->prepare('SELECT COUNT(*) FROM health_records WHERE addedBy=:u');
    $s->execute([':u' => $un]);
    $hrCount   = (int) $s->fetchColumn();
    $userCount = null;
    $pendingText = 'Pending Appts';
}

// Upcoming appointments
$upcomingQ = match($type) {
    'Admin'    => 'SELECT * FROM appointments WHERE aDate >= CURDATE() ORDER BY aDate ASC LIMIT 5',
    'Employee' => 'SELECT * FROM appointments WHERE EmployeeName=:u AND aDate >= CURDATE() ORDER BY aDate ASC LIMIT 5',
    default    => 'SELECT * FROM appointments WHERE petOwner=:u AND aDate >= CURDATE() ORDER BY aDate ASC LIMIT 5',
};
if ($type === 'Admin') {
    $upcoming = $pdo->query($upcomingQ)->fetchAll();
} else {
    $s2 = $pdo->prepare($upcomingQ);
    $s2->execute([':u' => $un]);
    $upcoming = $s2->fetchAll();
}

// My pets (client)
$myPets = [];
if ($type === 'Client') {
    $s3 = $pdo->prepare('SELECT * FROM patients WHERE addedBy=:u ORDER BY petname LIMIT 6');
    $s3->execute([':u' => $un]);
    $myPets = $s3->fetchAll();
}

$statusColor = ['Pending'=>'warning','Confirmed'=>'success','Cancelled'=>'danger'];
?>

<div class="container-fluid py-4 px-4 flex-grow-1">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
      <h2 class="fw-bold mb-0">
        Good <?= date('H') < 12 ? 'Morning' : (date('H') < 18 ? 'Afternoon' : 'Evening') ?>,
        <?= htmlspecialchars($u['firstname']) ?> 👋
      </h2>
      <p class="text-muted mb-0">Here's what's happening with your pets today.</p>
    </div>
    <span class="badge bg-dark px-3 py-2 rounded-pill"><?= htmlspecialchars($type) ?></span>
  </div>

  <!-- Stat Cards -->
  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
      <div class="card pz-stat-card bg-success text-white shadow-sm">
        <div class="card-body d-flex align-items-center gap-3 py-4">
          <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px">
            <i class="bi bi-heart-fill fs-3"></i>
          </div>
          <div>
            <div class="fs-2 fw-bold lh-1"><?= $petCount ?></div>
            <div class="small opacity-75"><?= $type === 'Client' ? 'My Pets' : 'Total Pets' ?></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card pz-stat-card bg-warning text-dark shadow-sm">
        <div class="card-body d-flex align-items-center gap-3 py-4">
          <div class="bg-dark bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px">
            <i class="bi bi-calendar-check fs-3"></i>
          </div>
          <div>
            <div class="fs-2 fw-bold lh-1"><?= $apptCount ?></div>
            <div class="small opacity-75"><?= $pendingText ?></div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($type === 'Admin' && $userCount !== null): ?>
    <div class="col-sm-6 col-lg-3">
      <div class="card pz-stat-card bg-primary text-white shadow-sm">
        <div class="card-body d-flex align-items-center gap-3 py-4">
          <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px">
            <i class="bi bi-people-fill fs-3"></i>
          </div>
          <div>
            <div class="fs-2 fw-bold lh-1"><?= $userCount ?></div>
            <div class="small opacity-75">Total Users</div>
          </div>
        </div>
      </div>
    </div>
    <?php elseif ($type === 'Client'): ?>
    <div class="col-sm-6 col-lg-3">
      <div class="card pz-stat-card bg-info text-white shadow-sm">
        <div class="card-body d-flex align-items-center gap-3 py-4">
          <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px">
            <i class="bi bi-clipboard2-pulse fs-3"></i>
          </div>
          <div>
            <div class="fs-2 fw-bold lh-1"><?= $hrCount ?? 0 ?></div>
            <div class="small opacity-75">Health Records</div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <div class="col-sm-6 col-lg-3">
      <div class="card pz-stat-card bg-dark text-white shadow-sm">
        <div class="card-body d-flex align-items-center gap-3 py-4">
          <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px">
            <i class="bi bi-clock-history fs-3"></i>
          </div>
          <div>
            <div class="fw-bold lh-1"><?= date('d M') ?></div>
            <div class="small opacity-75">Today</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <!-- Upcoming Appointments -->
    <div class="col-lg-<?= $type === 'Client' && !empty($myPets) ? '7' : '12' ?>">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
          <h6 class="fw-bold mb-0"><i class="bi bi-calendar-event me-2 text-primary"></i>Upcoming Appointments</h6>
          <a href="AppointmentsManagement.php" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body p-0">
          <?php if (empty($upcoming)): ?>
          <div class="text-center py-5 text-muted">
            <i class="bi bi-calendar-x fs-1 mb-2 d-block"></i>
            No upcoming appointments.
            <?php if ($type === 'Client'): ?>
            <br><a href="../forms/create-appointment.php" class="btn btn-sm btn-success mt-2">Book Now</a>
            <?php endif; ?>
          </div>
          <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
              <thead class="table-light">
                <tr>
                  <th>Pet</th>
                  <th><?= $type === 'Employee' ? 'Owner' : 'Vet' ?></th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($upcoming as $a): ?>
                <tr>
                  <td class="fw-semibold"><?= htmlspecialchars($a['petname']) ?></td>
                  <td class="text-muted small"><?= htmlspecialchars($type === 'Employee' ? $a['petOwner'] : $a['EmployeeName']) ?></td>
                  <td><?= htmlspecialchars($a['aDate']) ?></td>
                  <td>
                    <span class="badge badge-<?= strtolower($a['status']) ?>">
                      <?= htmlspecialchars($a['status']) ?>
                    </span>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- My Pets (client only) -->
    <?php if ($type === 'Client' && !empty($myPets)): ?>
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
          <h6 class="fw-bold mb-0"><i class="bi bi-heart me-2 text-danger"></i>My Pets</h6>
          <a href="patientsManagement.php" class="btn btn-sm btn-outline-danger">Manage</a>
        </div>
        <div class="card-body">
          <div class="row g-2">
            <?php foreach ($myPets as $pet): ?>
            <div class="col-6">
              <div class="card pz-pet-card border shadow-sm p-3 text-center h-100">
                <i class="bi bi-<?= strtolower($pet['species']) === 'cat' ? 'emoji-smile' : 'emoji-laughing' ?> text-warning fs-2 mb-1"></i>
                <div class="fw-semibold"><?= htmlspecialchars($pet['petname']) ?></div>
                <div class="text-muted small"><?= htmlspecialchars($pet['species']) ?>, <?= $pet['age'] ?> yrs</div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <a href="../forms/create-patient.php" class="btn btn-sm btn-outline-success w-100 mt-3">
            <i class="bi bi-plus-circle me-1"></i>Add Pet
          </a>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div><!-- /.row -->

  <!-- Quick Actions -->
  <div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white border-0 py-3">
      <h6 class="fw-bold mb-0"><i class="bi bi-lightning-charge me-2 text-warning"></i>Quick Actions</h6>
    </div>
    <div class="card-body d-flex flex-wrap gap-2">
      <?php if ($type === 'Client'): ?>
      <a href="../forms/create-patient.php"     class="btn btn-outline-success"><i class="bi bi-plus-circle me-1"></i>Add Pet</a>
      <a href="../forms/create-appointment.php" class="btn btn-outline-primary"><i class="bi bi-calendar-plus me-1"></i>Book Appointment</a>
      <a href="../forms/create-health-record.php" class="btn btn-outline-info"><i class="bi bi-clipboard2-plus me-1"></i>Add Health Record</a>
      <?php endif; ?>
      <a href="patientsManagement.php"      class="btn btn-outline-secondary"><i class="bi bi-heart me-1"></i>View Pets</a>
      <a href="AppointmentsManagement.php"  class="btn btn-outline-secondary"><i class="bi bi-calendar-check me-1"></i>Appointments</a>
      <a href="health_records.php"          class="btn btn-outline-secondary"><i class="bi bi-clipboard2-pulse me-1"></i>Health Records</a>
      <a href="store.php"                   class="btn btn-outline-secondary"><i class="bi bi-shop me-1"></i>Store</a>
    </div>
  </div>

</div>

<?php include "../components/footer.php"; ?>
</body>
</html>
