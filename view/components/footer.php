<footer class="pz-footer mt-auto py-4">
  <div class="container">
    <div class="row gy-3">
      <div class="col-md-4">
        <h6 class="fw-bold"><i class="bi bi-heart-pulse-fill text-warning me-1"></i>PetZone Veterinary</h6>
        <p class="text-muted small mb-0">Professional care for your beloved pets. Modern facilities, experienced vets.</p>
      </div>
      <div class="col-md-4">
        <h6 class="fw-bold">Quick Links</h6>
        <ul class="list-unstyled small mb-0">
          <li><a href="../pages/home.php" class="text-muted text-decoration-none">Home</a></li>
          <li><a href="../pages/store.php" class="text-muted text-decoration-none">Store</a></li>
          <li><a href="../pages/shop.php" class="text-muted text-decoration-none">Locations</a></li>
          <li><a href="../forms/register.php" class="text-muted text-decoration-none">Register</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h6 class="fw-bold">Contact</h6>
        <ul class="list-unstyled small text-muted mb-0">
          <li><i class="bi bi-envelope me-1"></i>info@petzone.com</li>
          <li><i class="bi bi-telephone me-1"></i>+20 100 000 0000</li>
          <li><i class="bi bi-geo-alt me-1"></i>Cairo, Egypt</li>
        </ul>
        <div class="mt-2">
          <a href="#" class="text-muted me-2"><i class="bi bi-facebook fs-5"></i></a>
          <a href="#" class="text-muted me-2"><i class="bi bi-twitter-x fs-5"></i></a>
          <a href="#" class="text-muted"><i class="bi bi-instagram fs-5"></i></a>
        </div>
      </div>
    </div>
    <hr class="mt-3">
    <p class="text-center text-muted small mb-0">&copy; <?= date('Y') ?> PetZone. All rights reserved.</p>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto-dismiss toasts after 4 s
document.querySelectorAll('.toast').forEach(el => {
  const t = new bootstrap.Toast(el, {delay: 4000});
  t.show();
});
</script>
