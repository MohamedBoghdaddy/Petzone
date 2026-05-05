<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Health Record – PetZone</title>
  <?php include "../pages/sidebar.php"; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php
require_once "../../includes/auth.php";
require_login();
include "../../control/functions/healthFunctions.php";

$id = isset($_GET['ID']) ? (int) $_GET['ID'] : 0;
$record = null;

if ($id > 0) {
    $pdo = db();
    $stmt = $pdo->prepare('SELECT * FROM health_records WHERE ID=:id');
    $stmt->execute([':id' => $id]);
    $record = $stmt->fetch();
    
    if (!$record) {
        header('Location: ../pages/health_records.php');
        exit;
    }
}

if (!$record) {
    header('Location: ../pages/health_records.php');
    exit;
}
?>

<div class="container py-5 flex-grow-1">
  <div class="row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <div class="card pz-form-card p-4">
        <div class="card-body">
          <div class="text-center mb-4">
            <i class="bi bi-pencil-square text-warning" style="font-size:2.2rem"></i>
            <h2 class="fw-bold mt-2">Edit Health Record</h2>
            <p class="text-muted">Update medical information</p>
          </div>

          <form method="post" action="" novalidate>
            <input type="hidden" name="ID" value="<?= $record['ID'] ?>">

            <div class="row g-3">
              <div class="col-12">
                <label class="form-label fw-semibold">Pet Name</label>
                <div class="form-control-plaintext fw-semibold">
                  <?= htmlspecialchars($record['petname']) ?>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Record Type <span class="text-danger">*</span></label>
                <select name="record_type" class="form-select" required>
                  <?php foreach (['Vaccination','Checkup','Surgery','Medication','Other'] as $rt): ?>
                  <option value="<?= $rt ?>" <?= $record['record_type'] === $rt ? 'selected' : '' ?>>
                    <?= $rt ?>
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Visit Date <span class="text-danger">*</span></label>
                <input type="date" name="visit_date" class="form-control" required
                       value="<?= htmlspecialchars($record['visit_date']) ?>">
              </div>

              <div class="col-12">
                <label class="form-label fw-semibold">Title / Diagnosis <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" required maxlength="100"
                       value="<?= htmlspecialchars($record['title']) ?>">
              </div>

              <div class="col-12">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3"
                          placeholder="Detailed notes about the visit, medications given, etc."><?= htmlspecialchars($record['description'] ?? '') ?></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Vet Name</label>
                <input type="text" name="vet_name" class="form-control" maxlength="100"
                       value="<?= htmlspecialchars($record['vet_name'] ?? '') ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Next Visit Date</label>
                <input type="date" name="next_visit_date" class="form-control"
                       value="<?= htmlspecialchars($record['next_visit_date'] ?? '') ?>">
              </div>
            </div>

            <div class="d-flex gap-2 mt-4">
              <button type="submit" name="updateRecord" class="btn btn-warning flex-grow-1 fw-semibold py-2">
                <i class="bi bi-save me-1"></i>Update Record
              </button>
              <button type="submit" name="deleteRecord" class="btn btn-outline-danger fw-semibold py-2"
                      onclick="return confirm('Delete this health record?')">
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
