<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User – PetZone</title>
  <?php include "../pages/sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php
require_once "../../includes/auth.php";
require_role('Admin', 'Employee');
include_once "../../control/functions/usersFunctions.php";

// Values from URL (admin opens this by clicking Edit button)
$id       = isset($_GET['ID'])          ? (int)   $_GET['ID']                      : 0;
$fn       = isset($_GET['firstname'])   ? htmlspecialchars($_GET['firstname'])      : '';
$ln       = isset($_GET['lastname'])    ? htmlspecialchars($_GET['lastname'])       : '';
$un       = isset($_GET['Username'])    ? htmlspecialchars($_GET['Username'])       : '';
$em       = isset($_GET['Email'])       ? htmlspecialchars($_GET['Email'])          : '';
$at       = isset($_GET['accountType']) ? htmlspecialchars($_GET['accountType'])    : 'Client';
?>

<div class="container py-5 flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-sm-10 col-md-7 col-lg-5">
      <div class="card pz-form-card p-4">
        <div class="card-body">
          <div class="text-center mb-4">
            <i class="bi bi-person-gear text-warning" style="font-size:2.2rem"></i>
            <h2 class="fw-bold mt-2">Edit User</h2>
            <span class="badge bg-secondary"><?= $un ?></span>
          </div>

          <form method="post" action="" novalidate>
            <input type="hidden" name="ID"       value="<?= $id ?>">
            <input type="hidden" name="Username" value="<?= $un ?>">

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">First Name</label>
                <input type="text" name="firstname" class="form-control" value="<?= $fn ?>" required minlength="2">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Last Name</label>
                <input type="text" name="lastname" class="form-control" value="<?= $ln ?>" required minlength="2">
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="Email" class="form-control" value="<?= $em ?>" required>
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">
                  New Password <span class="text-muted fw-normal small">(leave blank to keep)</span>
                </label>
                <input type="password" name="password" class="form-control" minlength="8" placeholder="••••••••">
              </div>
            </div>

            <div class="d-flex gap-2 mt-4">
              <button type="submit" name="editOtherUser" class="btn btn-warning flex-grow-1 fw-semibold py-2">
                <i class="bi bi-save me-1"></i>Update User
              </button>
              <button type="submit" name="deleteOtherUser" class="btn btn-outline-danger fw-semibold py-2"
                      onclick="return confirm('Permanently delete this user and all their data?')">
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
