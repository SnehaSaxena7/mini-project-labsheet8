<?php
// Partial: book card — expects $book variable in scope
$disc = $book['original'] > 0
  ? round((1 - $book['price'] / $book['original']) * 100)
  : 0;
$badge_class = match(strtolower($book['badge'] ?? '')) {
  'hot'      => 'hot',
  'classic'  => 'classic',
  'new'      => 'new',
  default    => ''
};
$stars = str_repeat('★', round($book['rating'])) . str_repeat('☆', 5 - round($book['rating']));
?>
<div class="book-card">
  <div class="book-cover">
    <img src="<?= htmlspecialchars($book['cover']) ?>"
         alt="<?= htmlspecialchars($book['title']) ?>"
         loading="lazy"
         onerror="this.src='https://via.placeholder.com/200x300/C8860A/white?text=<?= urlencode($book['title']) ?>'">

    <?php if ($book['badge']): ?>
      <span class="book-badge <?= $badge_class ?>"><?= htmlspecialchars($book['badge']) ?></span>
    <?php endif; ?>

    <div class="book-actions-overlay">
      <!-- Add to cart -->
      <form method="POST" action="index.php">
        <input type="hidden" name="action" value="add_cart">
        <input type="hidden" name="id" value="<?= $book['id'] ?>">
        <button type="submit" class="btn-cart-overlay">🛒 Add to Cart</button>
      </form>
      <!-- Wishlist -->
      <form method="POST" action="index.php">
        <input type="hidden" name="action" value="toggle_wish">
        <input type="hidden" name="id" value="<?= $book['id'] ?>">
        <button type="submit" class="btn-wish-overlay">
          <?= is_wished($book['id']) ? '💛 Wishlisted' : '🤍 Add to Wishlist' ?>
        </button>
      </form>
      <a href="book.php?id=<?= $book['id'] ?>" class="btn-view-overlay">View Details</a>
    </div>
  </div>

  <div class="book-info">
    <div class="book-cat"><?= htmlspecialchars($book['cat']) ?></div>
    <div class="book-title">
      <a href="book.php?id=<?= $book['id'] ?>" style="color:inherit;"><?= htmlspecialchars($book['title']) ?></a>
    </div>
    <div class="book-author"><?= htmlspecialchars($book['author']) ?></div>
    <div>
      <span class="stars"><?= $stars ?></span>
      <span class="stars-count">(<?= number_format($book['reviews']) ?>)</span>
    </div>
    <div class="book-pricing">
      <span class="price-current">$<?= number_format($book['price'], 2) ?></span>
      <?php if ($book['original'] > $book['price']): ?>
        <span class="price-original">$<?= number_format($book['original'], 2) ?></span>
        <span class="price-discount">-<?= $disc ?>%</span>
      <?php endif; ?>
    </div>
  </div>
</div>
