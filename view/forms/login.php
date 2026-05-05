<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login – PetZone</title>
  <?php include "../pages/sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php include_once "../../control/functions/usersFunctions.php"; ?>

<div class="container py-5 flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-sm-10 col-md-7 col-lg-5">
      <div class="card pz-form-card p-4">
        <div class="card-body">
          <div class="text-center mb-4">
            <i class="bi bi-heart-pulse-fill text-success" style="font-size:2.5rem"></i>
            <h2 class="fw-bold mt-2">Welcome Back</h2>
            <p class="text-muted">Sign in to manage your pets</p>
          </div>

          <form method="post" action="" novalidate>
            <div class="mb-3">
              <label class="form-label fw-semibold">Username</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="Username" class="form-control" placeholder="your_username" required autofocus>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="pw" class="form-control" placeholder="••••••••" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePw()">
                  <i class="bi bi-eye" id="eye-icon"></i>
                </button>
              </div>
            </div>

            <button type="submit" name="login" class="btn btn-success w-100 fw-semibold py-2">
              <i class="bi bi-box-arrow-in-right me-1"></i>Sign In
            </button>
          </form>

          <p class="text-center mt-3 text-muted small">
            Don't have an account? <a href="register.php" class="text-success fw-semibold">Register here</a>
          </p>

          <!-- Demo credentials hint -->
          <div class="alert alert-info small mt-3 mb-0 py-2">
            <strong>Demo accounts:</strong><br>
            Admin: <code>admin</code> / <code>password</code><br>
            Vet: <code>vet1</code> / <code>password</code><br>
            Client: <code>client1</code> / <code>password</code>
          </div>
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
