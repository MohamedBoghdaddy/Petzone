<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile – PetZone</title>
  <?php include "../pages/sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php
require_once "../../includes/auth.php";
require_login();
include_once "../../control/functions/usersFunctions.php";
$u = current_user();
?>

<div class="container py-5 flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-sm-10 col-md-7 col-lg-5">
      <div class="card pz-form-card p-4">
        <div class="card-body">
          <div class="text-center mb-4">
            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                 style="width:72px;height:72px">
              <i class="bi bi-person-fill text-success" style="font-size:2rem"></i>
            </div>
            <h2 class="fw-bold">Edit Profile</h2>
            <span class="badge bg-success"><?= htmlspecialchars($u['accountType']) ?></span>
          </div>

          <form method="post" action="" novalidate>
            <div class="mb-3">
              <label class="form-label fw-semibold">First Name</label>
              <input type="text" name="firstname" class="form-control"
                     value="<?= htmlspecialchars($u['firstname']) ?>" required minlength="2" maxlength="50">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Last Name</label>
              <input type="text" name="lastname" class="form-control"
                     value="<?= htmlspecialchars($u['lastname']) ?>" required minlength="2" maxlength="50">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Email</label>
              <input type="email" name="Email" class="form-control"
                     value="<?= htmlspecialchars($u['Email']) ?>" required>
            </div>
            <div class="mb-4">
              <label class="form-label fw-semibold">
                New Password
                <span class="text-muted fw-normal small">(leave blank to keep current)</span>
              </label>
              <input type="password" name="password" class="form-control" minlength="8" placeholder="••••••••">
            </div>

            <div class="d-grid gap-2">
              <button type="submit" name="edituser" class="btn btn-success fw-semibold py-2">
                <i class="bi bi-save me-1"></i>Save Changes
              </button>
              <button type="submit" name="deleteuser" class="btn btn-outline-danger"
                      onclick="return confirm('Are you sure? This will permanently delete your account and all pet data.')">
                <i class="bi bi-trash me-1"></i>Delete My Account
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
