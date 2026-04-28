<?php
// Process cart/wishlist actions before any output
require_once __DIR__ . '/data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);
    $qty    = (int)($_POST['qty'] ?? 1);
    $page   = $_POST['page'] ?? 'index';

    switch ($action) {
        case 'add_cart':    cart_add($id, $qty); break;
        case 'remove_cart': cart_remove($id);     break;
        case 'update_cart': cart_update($id, $qty); break;
        case 'toggle_wish': wish_toggle($id);    break;
    }
    header("Location: " . ($page === 'cart' ? 'cart.php' : ($_SERVER['HTTP_REFERER'] ?? 'index.php')));
    exit;
}

$page_title = $page_title ?? 'BookVault — Your Literary Universe';
$active     = $active ?? 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,800;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- ── Top bar ── -->
<div class="topbar">
  <span>📦 Free shipping on orders over $35</span>
  <span>|</span>
  <span>🎁 Gift wrapping available</span>
  <span>|</span>
  <span>📚 10,000+ titles in stock</span>
</div>

<!-- ── Nav ── -->
<nav class="navbar">
  <a href="index.php" class="logo">
    <span class="logo-icon">📖</span>
    <span class="logo-text">Book<em>Vault</em></span>
  </a>

  <div class="nav-search">
    <form action="search.php" method="GET">
      <div class="search-wrap">
        <input type="text" name="q" placeholder="Search books, authors, genres…" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button type="submit" aria-label="Search">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </button>
      </div>
    </form>
  </div>

  <div class="nav-actions">
    <a href="wishlist.php" class="nav-btn <?= $active==='wishlist'?'active':'' ?>" title="Wishlist">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
      <?php if (!empty($_SESSION['wishlist'])): ?>
        <span class="badge"><?= count($_SESSION['wishlist']) ?></span>
      <?php endif; ?>
    </a>
    <a href="cart.php" class="nav-btn cart-btn <?= $active==='cart'?'active':'' ?>" title="Cart">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      <?php if (cart_count() > 0): ?>
        <span class="badge"><?= cart_count() ?></span>
      <?php endif; ?>
    </a>
    <a href="account.php" class="nav-btn <?= $active==='account'?'active':'' ?>" title="Account">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </a>
  </div>

  <button class="hamburger" id="hamburger" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- ── Category nav ── -->
<div class="cat-nav">
  <a href="index.php" class="<?= $active==='home'?'active':'' ?>">Home</a>
  <a href="search.php?cat=Fiction" class="<?= ($_GET['cat']??'')==='Fiction'?'active':'' ?>">Fiction</a>
  <a href="search.php?cat=Non-Fiction" class="<?= ($_GET['cat']??'')==='Non-Fiction'?'active':'' ?>">Non-Fiction</a>
  <a href="search.php?cat=Sci-Fi" class="<?= ($_GET['cat']??'')==='Sci-Fi'?'active':'' ?>">Sci-Fi</a>
  <a href="search.php?cat=Mystery" class="<?= ($_GET['cat']??'')==='Mystery'?'active':'' ?>">Mystery</a>
  <a href="search.php" class="<?= $active==='search'&&!isset($_GET['cat'])?'active':'' ?>">All Books</a>
  <a href="about.php" class="<?= $active==='about'?'active':'' ?>">About</a>
  <a href="contact.php" class="<?= $active==='contact'?'active':'' ?>">Contact</a>
</div>

<!-- ── Flash messages ── -->
<?php if (!empty($_SESSION['flash'])): ?>
  <div class="flash flash-<?= $_SESSION['flash']['type'] ?>">
    <?= htmlspecialchars($_SESSION['flash']['msg']) ?>
  </div>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
