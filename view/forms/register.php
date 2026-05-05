<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register – PetZone</title>
  <?php include "../pages/sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php include_once "../../control/functions/usersFunctions.php"; ?>

<div class="container py-5 flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <div class="card pz-form-card p-4">
        <div class="card-body">
          <div class="text-center mb-4">
            <i class="bi bi-person-plus-fill text-success" style="font-size:2.5rem"></i>
            <h2 class="fw-bold mt-2">Create Account</h2>
            <p class="text-muted">Join PetZone to care for your pets</p>
          </div>

          <form method="post" action="" novalidate>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">First Name</label>
                <input type="text" name="firstname" class="form-control" minlength="2" maxlength="50" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Last Name</label>
                <input type="text" name="lastname" class="form-control" minlength="2" maxlength="50" required>
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Username</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-at"></i></span>
                  <input type="text" name="Username" class="form-control" minlength="4" maxlength="50" required placeholder="Choose a unique username">
                </div>
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                  <input type="email" name="Email" class="form-control" required placeholder="you@example.com">
                </div>
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-lock"></i></span>
                  <input type="password" name="password" id="pw" class="form-control"
                         minlength="8" required placeholder="Min 8 characters">
                  <button class="btn btn-outline-secondary" type="button" onclick="togglePw()">
                    <i class="bi bi-eye" id="eye-icon"></i>
                  </button>
                </div>
                <div class="form-text">At least 8 characters.</div>
              </div>

              <?php
              // Determine which account types this user can create
              $atypes = ['Client'];
              if (!empty($_SESSION['accountType'])) {
                  if ($_SESSION['accountType'] === 'Admin')     $atypes = ['Admin','Employee','Client'];
                  elseif ($_SESSION['accountType'] === 'Employee') $atypes = ['Employee','Client'];
              }
              if (count($atypes) > 1): ?>
              <div class="col-12">
                <label class="form-label fw-semibold">Account Type</label>
                <select name="accountType" class="form-select" required>
                  <?php foreach ($atypes as $t): ?>
                  <option value="<?= $t ?>"><?= $t ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <?php else: ?>
                <input type="hidden" name="accountType" value="Client">
              <?php endif; ?>
            </div><!-- /.row -->

            <button type="submit" name="addUser" class="btn btn-success w-100 fw-semibold py-2 mt-4">
              <i class="bi bi-person-plus me-1"></i>Create Account
            </button>
          </form>

          <p class="text-center mt-3 text-muted small">
            Already have an account? <a href="login.php" class="text-success fw-semibold">Sign in</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "../components/footer.php"; ?>

<script>
function togglePw() {
  const pw = document.getElementById('pw');
  const ic = document.getElementById('eye-icon');
  if (pw.type === 'password') { pw.type = 'text';     ic.className = 'bi bi-eye-slash'; }
  else                        { pw.type = 'password'; ic.className = 'bi bi-eye'; }
}
</script>
</body>
</html>
