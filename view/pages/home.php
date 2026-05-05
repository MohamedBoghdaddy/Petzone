<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetZone – Professional Pet Care</title>
  <?php include "sidebar.php"; ?>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- ── Hero ── -->
<section class="pz-hero text-white py-5">
  <div class="container py-4">
    <div class="row align-items-center g-4">
      <div class="col-lg-6">
        <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill">🐾 Trusted Veterinary Care</span>
        <h1 class="fw-bold lh-sm mb-3">
          Your Pet Deserves<br>
          <span class="text-success">The Best Care</span>
        </h1>
        <p class="lead text-white-50 mb-4">
          PetZone is your all-in-one platform for managing pet profiles, booking vet appointments,
          tracking health records, and shopping for premium pet products.
        </p>
        <div class="d-flex flex-wrap gap-3">
          <?php if (empty($_SESSION['ID'])): ?>
          <a href="../forms/register.php" class="btn btn-success btn-lg fw-semibold px-4">
            <i class="bi bi-person-plus me-2"></i>Get Started Free
          </a>
          <a href="../forms/login.php" class="btn btn-outline-light btn-lg px-4">Sign In</a>
          <?php else: ?>
          <a href="dashboard.php" class="btn btn-success btn-lg fw-semibold px-4">
            <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
          </a>
          <a href="../forms/create-appointment.php" class="btn btn-outline-light btn-lg px-4">
            <i class="bi bi-calendar-plus me-2"></i>Book Appointment
          </a>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-6 text-center d-none d-lg-block">
        <img src="../banners/image13.jpg" alt="Pet care" class="img-fluid rounded-4 shadow"
             style="max-height:380px;object-fit:cover;width:100%">
      </div>
    </div>
  </div>
</section>

<!-- ── Stats bar ── -->
<section class="bg-success bg-opacity-10 py-3 border-bottom">
  <div class="container">
    <div class="row text-center g-2">
      <div class="col-4">
        <div class="fw-bold fs-4 text-success">500+</div>
        <div class="text-muted small">Happy Pets</div>
      </div>
      <div class="col-4">
        <div class="fw-bold fs-4 text-success">3</div>
        <div class="text-muted small">Clinic Locations</div>
      </div>
      <div class="col-4">
        <div class="fw-bold fs-4 text-success">10+</div>
        <div class="text-muted small">Experienced Vets</div>
      </div>
    </div>
  </div>
</section>

<!-- ── Services ── -->
<section class="py-5 bg-white">
  <div class="container">
    <h2 class="fw-bold text-center mb-1">Our Services</h2>
    <p class="text-muted text-center mb-5">Everything your pet needs, all in one place</p>

    <div class="row g-4">
      <?php
      $services = [
        ['icon'=>'bi-capsule',         'color'=>'text-danger',  'bg'=>'bg-danger',  'title'=>'Medication',     'desc'=>'Prescribed treatments and ongoing medication management for chronic conditions.'],
        ['icon'=>'bi-scissors',        'color'=>'text-warning', 'bg'=>'bg-warning', 'title'=>'Surgical Care',  'desc'=>'Safe, modern surgical procedures performed by certified veterinary surgeons.'],
        ['icon'=>'bi-shield-plus',     'color'=>'text-success', 'bg'=>'bg-success', 'title'=>'Vaccination',    'desc'=>'Core and lifestyle vaccines to keep your pet protected year-round.'],
        ['icon'=>'bi-clipboard2-pulse','color'=>'text-primary', 'bg'=>'bg-primary', 'title'=>'Health Checkup', 'desc'=>'Regular wellness exams to catch issues early and keep pets thriving.'],
      ];
      foreach ($services as $s): ?>
      <div class="col-sm-6 col-lg-3">
        <div class="card pz-service-card h-100 text-center p-4 shadow-sm">
          <div class="<?= $s['bg'] ?> bg-opacity-10 rounded-circle d-inline-flex align-items-center
                      justify-content-center mx-auto mb-3" style="width:70px;height:70px">
            <i class="bi <?= $s['icon'] ?> <?= $s['color'] ?>" style="font-size:1.8rem"></i>
          </div>
          <h5 class="fw-bold"><?= $s['title'] ?></h5>
          <p class="text-muted small mb-0"><?= $s['desc'] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── CTA ── -->
<section class="bg-success text-white py-5">
  <div class="container text-center">
    <h2 class="fw-bold mb-2">Ready to care for your pet?</h2>
    <p class="lead mb-4 text-white-50">Create a free account and book your first appointment today.</p>
    <?php if (empty($_SESSION['ID'])): ?>
    <a href="../forms/register.php" class="btn btn-light btn-lg fw-semibold px-5">
      <i class="bi bi-heart-pulse me-2"></i>Register Now
    </a>
    <?php else: ?>
    <a href="../forms/create-appointment.php" class="btn btn-light btn-lg fw-semibold px-5">
      <i class="bi bi-calendar-plus me-2"></i>Book Appointment
    </a>
    <?php endif; ?>
  </div>
</section>

<!-- ── Featured Products Preview ── -->
<?php
require_once "../../includes/db.php";
require_once "../../config.php";
$featuredProducts = db()->query('SELECT * FROM products LIMIT 3')->fetchAll();
?>
<?php if (!empty($featuredProducts)): ?>
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-center mb-1">Pet Shop</h2>
    <p class="text-muted text-center mb-5">Premium products for your furry friends</p>
    <div class="row g-4 justify-content-center">
      <?php foreach ($featuredProducts as $p): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="card pz-product-card shadow-sm">
          <?php if ($p['image'] && file_exists("../banners/{$p['image']}")): ?>
          <img src="../banners/<?= htmlspecialchars($p['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>">
          <?php else: ?>
          <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;border-radius:14px 14px 0 0">
            <i class="bi bi-bag fs-1 text-muted"></i>
          </div>
          <?php endif; ?>
          <div class="card-body">
            <span class="badge bg-secondary small mb-1"><?= htmlspecialchars($p['category']) ?></span>
            <h6 class="fw-bold"><?= htmlspecialchars($p['name']) ?></h6>
            <p class="text-muted small"><?= htmlspecialchars(substr($p['description'] ?? '', 0, 60)) ?>...</p>
            <div class="fw-bold text-success"><?= number_format($p['price'], 2) ?> EGP</div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a href="store.php" class="btn btn-outline-success px-5 fw-semibold">
        <i class="bi bi-shop me-1"></i>View All Products
      </a>
    </div>
  </div>
</section>
<?php endif; ?>

<?php include "../components/footer.php"; ?>
</body>
</html>
