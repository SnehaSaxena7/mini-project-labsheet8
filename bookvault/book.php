<?php
require_once 'includes/data.php';
$id   = (int)($_GET['id'] ?? 0);
$book = get_book($id, $books);

if (!$book) {
  header('Location: index.php');
  exit;
}

$page_title = htmlspecialchars($book['title']) . ' — BookVault';
$active = 'search';

// Handle add-to-cart from this page
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  if ($action === 'add_cart')    { cart_add($id); }
  if ($action === 'toggle_wish') { wish_toggle($id); }
  header("Location: book.php?id=$id");
  exit;
}

require_once 'includes/header.php';

$disc  = $book['original'] > 0 ? round((1 - $book['price'] / $book['original']) * 100) : 0;
$stars = str_repeat('★', round($book['rating'])) . str_repeat('☆', 5 - round($book['rating']));

// Related books — same category
$related = array_filter($books, fn($b) => $b['cat'] === $book['cat'] && $b['id'] !== $book['id']);
$related = array_slice($related, 0, 4);
?>

<!-- Breadcrumb -->
<div class="page-header">
  <h1 style="font-size:1rem; font-weight:500; color:var(--muted);">Book Details</h1>
  <div class="breadcrumb">
    <a href="index.php">Home</a> ›
    <a href="search.php?cat=<?= urlencode($book['cat']) ?>"><?= htmlspecialchars($book['cat']) ?></a> ›
    <?= htmlspecialchars($book['title']) ?>
  </div>
</div>

<!-- Detail layout -->
<div class="detail-layout">
  <div>
    <div class="detail-cover">
      <img src="<?= htmlspecialchars($book['cover']) ?>"
           alt="<?= htmlspecialchars($book['title']) ?>"
           onerror="this.src='https://via.placeholder.com/300x450/C8860A/white?text=<?= urlencode($book['title']) ?>'">
    </div>
  </div>

  <div>
    <div class="detail-cat"><?= htmlspecialchars($book['cat']) ?></div>
    <h1 class="detail-title"><?= htmlspecialchars($book['title']) ?></h1>
    <p class="detail-author">by <strong><?= htmlspecialchars($book['author']) ?></strong></p>

    <div class="detail-rating">
      <span class="detail-stars"><?= $stars ?></span>
      <strong><?= $book['rating'] ?></strong>
      <span style="color:var(--muted);font-size:.85rem;">(<?= number_format($book['reviews']) ?> reviews)</span>
    </div>

    <div class="detail-price-wrap">
      <span class="detail-price">$<?= number_format($book['price'], 2) ?></span>
      <?php if ($disc > 0): ?>
        <span class="detail-original">$<?= number_format($book['original'], 2) ?></span>
        <span class="detail-save">Save <?= $disc ?>%</span>
      <?php endif; ?>
    </div>

    <p class="detail-desc"><?= htmlspecialchars($book['desc']) ?></p>

    <?php if ($book['stock'] <= 5 && $book['stock'] > 0): ?>
      <p style="color:#C0392B;font-size:.85rem;font-weight:600;margin-bottom:1rem;">
        ⚠️ Only <?= $book['stock'] ?> left in stock — order soon!
      </p>
    <?php elseif ($book['stock'] === 0): ?>
      <p style="color:#C0392B;font-size:.85rem;font-weight:600;margin-bottom:1rem;">❌ Out of Stock</p>
    <?php endif; ?>

    <div class="detail-ctas">
      <?php if ($book['stock'] > 0): ?>
        <form method="POST">
          <input type="hidden" name="action" value="add_cart">
          <button type="submit" class="btn-addcart">🛒 Add to Cart</button>
        </form>
      <?php endif; ?>

      <form method="POST">
        <input type="hidden" name="action" value="toggle_wish">
        <button type="submit" class="btn-wishlist">
          <?= is_wished($id) ? '💛 In Wishlist' : '🤍 Add to Wishlist' ?>
        </button>
      </form>
    </div>

    <div class="detail-meta">
      <div class="meta-row">
        <span class="meta-label">Category</span>
        <span class="meta-val"><?= htmlspecialchars($book['cat']) ?></span>
      </div>
      <div class="meta-row">
        <span class="meta-label">Author</span>
        <span class="meta-val"><?= htmlspecialchars($book['author']) ?></span>
      </div>
      <div class="meta-row">
        <span class="meta-label">In Stock</span>
        <span class="meta-val" style="color:<?= $book['stock'] > 0 ? 'var(--green)' : 'var(--red)' ?>">
          <?= $book['stock'] > 0 ? "Yes ({$book['stock']} units)" : 'Out of Stock' ?>
        </span>
      </div>
      <div class="meta-row">
        <span class="meta-label">Format</span>
        <span class="meta-val">Paperback / Hardcover</span>
      </div>
      <div class="meta-row">
        <span class="meta-label">Shipping</span>
        <span class="meta-val">Free on orders over $35</span>
      </div>
    </div>
  </div>
</div>

<!-- Related books -->
<?php if (!empty($related)): ?>
<section class="section" style="border-top:1px solid var(--border);">
  <div class="section-head">
    <h2>More <span>in <?= htmlspecialchars($book['cat']) ?></span></h2>
    <a href="search.php?cat=<?= urlencode($book['cat']) ?>" class="view-all">See all →</a>
  </div>
  <div class="books-grid">
    <?php foreach ($related as $book): ?>
      <?php include 'includes/book_card.php'; ?>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
