<?php
// Unified Bootstrap 5 navbar — included in all view pages & forms.
require_once __DIR__ . '/../../includes/auth.php';
start_session();
$user = current_user();
$type = $user['accountType'];
?>
<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style/custom.css">

<nav class="navbar navbar-expand-lg pz-navbar sticky-top">
  <div class="container-fluid px-4">

    <!-- Brand -->
    <a class="navbar-brand fw-bold" href="../pages/home.php">
      <i class="bi bi-heart-pulse-fill text-warning me-1"></i>PetZone
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pzNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="pzNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link" href="../pages/home.php"><i class="bi bi-house me-1"></i>Home</a>
        </li>

        <?php if (!empty($user['ID'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="../pages/dashboard.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="../pages/patientsManagement.php"><i class="bi bi-heart me-1"></i>My Pets</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="../pages/AppointmentsManagement.php"><i class="bi bi-calendar-check me-1"></i>Appointments</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="../pages/health_records.php"><i class="bi bi-clipboard2-pulse me-1"></i>Health Records</a>
          </li>

          <?php if ($type === 'Admin' || $type === 'Employee'): ?>
          <li class="nav-item">
            <a class="nav-link" href="../pages/userManagement.php"><i class="bi bi-people me-1"></i>Users</a>
          </li>
          <?php endif; ?>

        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link" href="../pages/store.php"><i class="bi bi-shop me-1"></i>Store</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="../pages/shop.php"><i class="bi bi-geo-alt me-1"></i>Locations</a>
        </li>

      </ul>

      <!-- Right side -->
      <ul class="navbar-nav ms-auto align-items-center gap-2">
        <?php if (!empty($user['ID'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle fs-5"></i>
              <span><?= htmlspecialchars($user['firstname']) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="../forms/profile.php"><i class="bi bi-pencil me-2"></i>Edit Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="../../control/functions/signout.php"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="btn btn-outline-light btn-sm" href="../forms/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-warning btn-sm fw-semibold" href="../forms/register.php">Sign Up</a>
          </li>
        <?php endif; ?>
      </ul>
    </div><!-- /.collapse -->
  </div>
</nav>

<!-- Toast container (flash messages) -->
<?php
$successMsg = get_flash('success');
$errorMsg   = get_flash('error');
?>
<?php if ($successMsg || $errorMsg): ?>
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:9999">
  <?php if ($successMsg): ?>
  <div class="toast align-items-center text-bg-success border-0 show" role="alert">
    <div class="d-flex">
      <div class="toast-body"><i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($successMsg) ?></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
  <?php endif; ?>
  <?php if ($errorMsg): ?>
  <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
    <div class="d-flex">
      <div class="toast-body"><i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($errorMsg) ?></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
  <?php endif; ?>
</div>
<?php endif; ?>
