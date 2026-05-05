<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Health Records – PetZone</title>
  <?php include "sidebar.php"; ?>
  <style>
    .record-type-badge {
      font-size: 0.8rem;
      font-weight: 600;
      padding: 0.4rem 0.8rem;
    }
    .status-upcoming {
      background-color: #3498db;
      color: white;
    }
    .status-completed {
      background-color: #2ecc71;
      color: white;
    }
    .status-ongoing {
      background-color: #f39c12;
      color: white;
    }
    .status-critical {
      background-color: #e74c3c;
      color: white;
    }
    .search-filter-card {
      background: white;
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 2px 8px rgba(0,0,0,.08);
    }
    .stat-item {
      text-align: center;
      padding: 1.5rem;
    }
    .stat-icon {
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }
    .stat-number {
      font-size: 2rem;
      font-weight: bold;
      margin: 0.5rem 0;
    }
    .stat-label {
      color: #7f8c8d;
      font-size: 0.9rem;
    }
    .record-action-btn {
      padding: 0.35rem 0.7rem;
      font-size: 0.85rem;
    }
    .empty-state-icon {
      font-size: 5rem;
      margin-bottom: 1rem;
    }
  </style>
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

// Filter by pet_id if coming from pet cards
$filter_pet_id = isset($_GET['pet_id']) ? (int) $_GET['pet_id'] : null;
$filter_type = isset($_GET['filter_type']) && $_GET['filter_type'] !== '' ? $_GET['filter_type'] : null;
$search_pet = isset($_GET['search_pet']) ? trim($_GET['search_pet']) : '';

// Get health records based on user role and filters
$sql = 'SELECT * FROM health_records WHERE 1=1';
$params = [];

if ($type === 'Client') {
    $sql .= ' AND addedBy = :username';
    $params[':username'] = $un;
}

if ($filter_pet_id) {
    $sql .= ' AND pet_id = :pet_id';
    $params[':pet_id'] = $filter_pet_id;
}

if ($filter_type) {
    $sql .= ' AND record_type = :record_type';
    $params[':record_type'] = $filter_type;
}

if ($search_pet) {
    $sql .= ' AND petname LIKE :petname';
    $params[':petname'] = '%' . $search_pet . '%';
}

$sql .= ' ORDER BY visit_date DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$records = $stmt->fetchAll();

// Calculate stats
$upcoming_count = 0;
$completed_count = 0;
$ongoing_count = 0;
$critical_count = 0;

$today = date('Y-m-d');
foreach ($records as $r) {
    if ($r['next_visit_date'] && $r['next_visit_date'] > $today) {
        $upcoming_count++;
    } elseif ($r['next_visit_date'] && $r['next_visit_date'] <= $today) {
        $critical_count++;
    }
    if ($r['visit_date'] <= $today) {
        $completed_count++;
    }
}

// Get unique pets for filter dropdown (for clients)
$petsStmt = $pdo->prepare('SELECT DISTINCT petname, pet_id FROM health_records WHERE ' . 
    ($type === 'Client' ? 'addedBy = :username' : '1=1') . 
    ' ORDER BY petname ASC');
if ($type === 'Client') {
    $petsStmt->execute([':username' => $un]);
} else {
    $petsStmt->execute();
}
$unique_pets = $petsStmt->fetchAll();

// Get record type options
$record_types = ['Vaccination', 'Checkup', 'Surgery', 'Medication', 'Other'];
?>

<div class="container py-4 flex-grow-1">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
      <h2 class="fw-bold mb-0">
        <i class="bi bi-clipboard2-pulse text-info me-2"></i>Health Records
      </h2>
      <p class="text-muted mb-0">Track pets' medical history, vaccines, visits, and treatments</p>
    </div>
    <?php if ($type === 'Client'): ?>
    <a href="../forms/create-health-record.php" class="btn btn-info fw-semibold">
      <i class="bi bi-plus-circle me-1"></i>Add Health Record
    </a>
    <?php endif; ?>
  </div>

  <!-- Stats Dashboard -->
  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
      <div class="card pz-stat-card border-0 shadow-sm bg-white">
        <div class="stat-item">
          <div class="stat-icon text-info"><i class="bi bi-file-earmark-text"></i></div>
          <div class="stat-number"><?= count($records) ?></div>
          <div class="stat-label">Total Records</div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card pz-stat-card border-0 shadow-sm bg-white">
        <div class="stat-item">
          <div class="stat-icon text-warning"><i class="bi bi-calendar-event"></i></div>
          <div class="stat-number"><?= $upcoming_count ?></div>
          <div class="stat-label">Upcoming Visits</div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card pz-stat-card border-0 shadow-sm bg-white">
        <div class="stat-item">
          <div class="stat-icon text-success"><i class="bi bi-check-circle"></i></div>
          <div class="stat-number"><?= $completed_count ?></div>
          <div class="stat-label">Completed Visits</div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card pz-stat-card border-0 shadow-sm bg-white">
        <div class="stat-item">
          <div class="stat-icon text-danger"><i class="bi bi-exclamation-triangle"></i></div>
          <div class="stat-number"><?= $critical_count ?></div>
          <div class="stat-label">Attention Needed</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Search & Filter -->
  <div class="search-filter-card">
    <form method="GET" class="row g-2 g-md-3">
      <div class="col-md-4">
        <input 
          type="text" 
          name="search_pet" 
          class="form-control form-control-sm"
          placeholder="Search by pet name..."
          value="<?= htmlspecialchars($search_pet) ?>"
        >
      </div>

      <?php if (count($unique_pets) > 1): ?>
      <div class="col-md-3">
        <select name="pet_id" class="form-select form-select-sm">
          <option value="">All Pets</option>
          <?php foreach ($unique_pets as $p): ?>
          <option value="<?= $p['pet_id'] ?>" <?= $filter_pet_id == $p['pet_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['petname']) ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php endif; ?>

      <div class="col-md-3">
        <select name="filter_type" class="form-select form-select-sm">
          <option value="">All Types</option>
          <?php foreach ($record_types as $rt): ?>
          <option value="<?= $rt ?>" <?= $filter_type === $rt ? 'selected' : '' ?>>
            <?= htmlspecialchars($rt) ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-auto d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-primary">
          <i class="bi bi-search me-1"></i>Filter
        </button>
        <a href="health_records.php" class="btn btn-sm btn-secondary">
          <i class="bi bi-arrow-clockwise me-1"></i>Reset
        </a>
      </div>
    </form>
  </div>

  <!-- Records Table -->
  <?php if (empty($records)): ?>

  <div class="card border-0 shadow-sm text-center py-5">
    <div class="card-body">
      <i class="bi bi-inbox empty-state-icon text-muted"></i>
      <h5 class="text-muted mt-3 mb-3">No Health Records Found</h5>
      <p class="text-muted mb-3">
        <?php if ($search_pet || $filter_pet_id || $filter_type): ?>
          Try adjusting your search or filter criteria.
        <?php else: ?>
          Start tracking your pet's health by adding a new health record.
        <?php endif; ?>
      </p>
      <?php if ($type === 'Client'): ?>
      <a href="../forms/create-health-record.php" class="btn btn-info">
        <i class="bi bi-plus-circle me-1"></i>Add First Health Record
      </a>
      <?php endif; ?>
    </div>
  </div>

  <?php else: ?>

  <div class="card border-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0 pz-table">
        <thead>
          <tr>
            <th style="width: 15%">Pet Name</th>
            <th style="width: 12%">Record Type</th>
            <th style="width: 18%">Vet Name</th>
            <th style="width: 12%">Visit Date</th>
            <th style="width: 12%">Next Visit</th>
            <th style="width: 15%">Status</th>
            <th style="width: 16%">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($records as $r): ?>
          <?php
            // Determine status
            $status_class = 'status-completed';
            $status_text = 'Completed';
            
            if ($r['next_visit_date']) {
              if ($r['next_visit_date'] > $today) {
                $status_class = 'status-upcoming';
                $status_text = 'Upcoming';
              } elseif ($r['next_visit_date'] <= $today) {
                $status_class = 'status-critical';
                $status_text = 'Overdue';
              }
            }
          ?>
          <tr>
            <td class="fw-semibold">
              <i class="bi bi-heart-fill text-danger me-1"></i>
              <?= htmlspecialchars($r['petname']) ?>
            </td>
            <td>
              <span class="badge record-type-badge record-<?= strtolower($r['record_type']) ?>">
                <?= htmlspecialchars($r['record_type']) ?>
              </span>
            </td>
            <td class="text-muted small">
              <?= !empty($r['vet_name']) ? htmlspecialchars($r['vet_name']) : '—' ?>
            </td>
            <td class="small">
              <?= date('M d, Y', strtotime($r['visit_date'])) ?>
            </td>
            <td class="small">
              <?php if ($r['next_visit_date']): ?>
                <?= date('M d, Y', strtotime($r['next_visit_date'])) ?>
              <?php else: ?>
                <span class="text-muted">—</span>
              <?php endif; ?>
            </td>
            <td>
              <span class="badge <?= $status_class ?>">
                <?= $status_text ?>
              </span>
            </td>
            <td>
              <div class="d-flex gap-1">
                <button 
                  type="button" 
                  class="btn btn-sm btn-outline-info record-action-btn"
                  data-bs-toggle="modal" 
                  data-bs-target="#recordModal<?= $r['ID'] ?>"
                  title="View Details">
                  <i class="bi bi-eye"></i>
                </button>
                <?php if ($type === 'Client' || $type === 'Admin'): ?>
                <a 
                  href="../forms/edit-health-record.php?ID=<?= $r['ID'] ?>"
                  class="btn btn-sm btn-outline-warning record-action-btn"
                  title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <form method="POST" action="../../control/functions/healthFunctions.php" class="d-inline" 
                      onsubmit="return confirm('Delete this health record?');">
                  <input type="hidden" name="ID" value="<?= $r['ID'] ?>">
                  <button type="submit" name="deleteRecord" class="btn btn-sm btn-outline-danger record-action-btn"
                          title="Delete">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
                <?php endif; ?>
              </div>
            </td>
          </tr>

          <!-- Modal for viewing full details -->
          <div class="modal fade" id="recordModal<?= $r['ID'] ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header bg-light border-0">
                  <h5 class="modal-title fw-bold">
                    <i class="bi bi-clipboard2-pulse text-info me-2"></i>
                    <?= htmlspecialchars($r['petname']) ?> - <?= htmlspecialchars($r['record_type']) ?>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label text-muted small">Pet Name</label>
                        <div class="fw-semibold"><?= htmlspecialchars($r['petname']) ?></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label text-muted small">Record Type</label>
                        <div>
                          <span class="badge record-type-badge record-<?= strtolower($r['record_type']) ?>">
                            <?= htmlspecialchars($r['record_type']) ?>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="mb-3">
                        <label class="form-label text-muted small">Title</label>
                        <div class="fw-semibold"><?= htmlspecialchars($r['title']) ?></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label text-muted small">Veterinarian</label>
                        <div><?= !empty($r['vet_name']) ? htmlspecialchars($r['vet_name']) : 'Not specified' ?></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label text-muted small">Visit Date</label>
                        <div><?= date('M d, Y', strtotime($r['visit_date'])) ?></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label text-muted small">Next Visit Date</label>
                        <div>
                          <?php if ($r['next_visit_date']): ?>
                            <?= date('M d, Y', strtotime($r['next_visit_date'])) ?>
                          <?php else: ?>
                            <span class="text-muted">Not scheduled</span>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label text-muted small">Status</label>
                        <div>
                          <span class="badge <?= $status_class ?>">
                            <?= $status_text ?>
                          </span>
                        </div>
                      </div>
                    </div>
                    <?php if (!empty($r['description'])): ?>
                    <div class="col-12">
                      <div class="mb-3">
                        <label class="form-label text-muted small">Description / Notes</label>
                        <div class="p-3 bg-light rounded">
                          <?= nl2br(htmlspecialchars($r['description'])) ?>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="modal-footer bg-light border-0">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  <?php if ($type === 'Client' || $type === 'Admin'): ?>
                  <a href="../forms/edit-health-record.php?ID=<?= $r['ID'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil me-1"></i>Edit
                  </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
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
