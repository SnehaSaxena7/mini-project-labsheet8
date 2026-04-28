<?php
$page_title = 'My Wishlist — BookVault';
$active = 'wishlist';
require_once 'includes/header.php';

$wished = array_filter($books, fn($b) => is_wished($b['id']));
?>

<div class="page-header">
  <h1 style="font-family:var(--ff-serif);">💛 My Wishlist</h1>
  <div class="breadcrumb">
    <a href="index.php">Home</a> › Wishlist
    <?php if (!empty($wished)): ?>
      <span style="margin-left:.5rem;background:var(--amber);color:white;padding:.15rem .5rem;border-radius:4px;font-size:.75rem;">
        <?= count($wished) ?> item<?= count($wished)!==1?'s':'' ?>
      </span>
    <?php endif; ?>
  </div>
</div>

<?php if (empty($wished)): ?>
  <div class="empty-state" style="padding:5rem 2rem;">
    <span class="empty-icon">💛</span>
    <h3>Your wishlist is empty</h3>
    <p>Save books you love to revisit them later.</p>
    <a href="search.php" class="btn-primary" style="display:inline-block;margin-top:1.5rem;">Discover Books →</a>
  </div>
<?php else: ?>
  <div class="section">
    <div class="books-grid">
      <?php foreach ($wished as $book): ?>
        <?php include 'includes/book_card.php'; ?>
      <?php endforeach; ?>
    </div>

    <div style="margin-top:2rem;text-align:center;">
      <!-- Move all to cart -->
      <form method="POST" style="display:inline;">
        <?php foreach ($wished as $b): ?>
          <!-- We'd loop-add in a real app; here we just redirect -->
        <?php endforeach; ?>
        <a href="search.php" class="btn-primary" style="display:inline-block;">Continue Shopping →</a>
      </form>
    </div>
  </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
