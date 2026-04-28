<?php
$page_title = 'BookVault — Your Literary Universe';
$active = 'home';
require_once 'includes/header.php';

// Pick 8 bestsellers for homepage
$featured = array_slice($books, 0, 8);
$new_arrivals = array_filter($books, fn($b) => $b['badge'] === 'New' || $b['badge'] === 'Hot');
$bestsellers  = array_filter($books, fn($b) => $b['badge'] === 'Bestseller');
?>

<!-- ── Hero ── -->
<section class="hero">
  <div class="hero-content">
    <div class="hero-eyebrow">✦ Over 10,000 titles available</div>
    <h1>Every Story<br>Deserves to be <em>Read.</em></h1>
    <p>Discover bestsellers, hidden gems, and timeless classics. Your next favourite book is waiting.</p>
    <div class="hero-ctas">
      <a href="search.php" class="btn-primary">Browse All Books →</a>
      <a href="search.php?cat=Fiction" class="btn-outline">Explore Fiction</a>
    </div>
  </div>
  <div class="hero-visual">
    <?php foreach (array_slice($books, 0, 6) as $b): ?>
      <div class="hero-book">
        <img src="<?= $b['cover'] ?>" alt="<?= htmlspecialchars($b['title']) ?>" loading="lazy">
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ── Trust bar ── -->
<div class="trust-bar">
  <div class="trust-item"><span class="trust-icon">🚚</span> Free Shipping over $35</div>
  <div class="trust-item"><span class="trust-icon">↩️</span> 30-Day Returns</div>
  <div class="trust-item"><span class="trust-icon">🔒</span> Secure Checkout</div>
  <div class="trust-item"><span class="trust-icon">⭐</span> 500k+ Happy Readers</div>
  <div class="trust-item"><span class="trust-icon">🎁</span> Gift Wrapping</div>
</div>

<!-- ── Shop by Genre ── -->
<section class="section">
  <div class="section-head">
    <h2>Shop by <span>Genre</span></h2>
    <a href="search.php" class="view-all">See all genres →</a>
  </div>
  <div class="genre-grid">
    <a href="search.php?cat=Fiction" class="genre-card genre-fiction">
      <span class="genre-icon">📖</span>
      <h3>Fiction</h3>
      <p>Stories that move you</p>
    </a>
    <a href="search.php?cat=Non-Fiction" class="genre-card genre-nonfiction">
      <span class="genre-icon">🌍</span>
      <h3>Non-Fiction</h3>
      <p>Knowledge & insight</p>
    </a>
    <a href="search.php?cat=Sci-Fi" class="genre-card genre-scifi">
      <span class="genre-icon">🚀</span>
      <h3>Sci-Fi</h3>
      <p>Explore the future</p>
    </a>
    <a href="search.php?cat=Mystery" class="genre-card genre-mystery">
      <span class="genre-icon">🔍</span>
      <h3>Mystery</h3>
      <p>Suspense & intrigue</p>
    </a>
  </div>
</section>

<!-- ── Bestsellers ── -->
<section class="section" style="background:var(--warm-white); margin:0; padding:3rem 5%;">
  <div class="section-head">
    <h2>🏆 <span>Bestsellers</span></h2>
    <a href="search.php?sort=rating" class="view-all">View all →</a>
  </div>
  <div class="books-grid">
    <?php foreach ($bestsellers as $book): ?>
      <?php include 'includes/book_card.php'; ?>
    <?php endforeach; ?>
  </div>
</section>

<!-- ── Promo Banner ── -->
<section class="section">
  <div class="promo-banner">
    <div class="promo-text">
      <h3>📚 Summer Reading Sale</h3>
      <p>Use code below at checkout for 20% off your entire order — today only!</p>
      <div class="promo-code">READ20</div>
    </div>
    <a href="search.php" class="btn-primary" style="white-space:nowrap;">Shop the Sale →</a>
  </div>
</section>

<!-- ── New Arrivals ── -->
<section class="section">
  <div class="section-head">
    <h2>🆕 New <span>Arrivals</span></h2>
    <a href="search.php?sort=new" class="view-all">View all →</a>
  </div>
  <div class="books-grid">
    <?php foreach ($new_arrivals as $book): ?>
      <?php include 'includes/book_card.php'; ?>
    <?php endforeach; ?>
  </div>
</section>

<!-- ── All Featured ── -->
<section class="section" style="background:var(--warm-white); margin:0; padding:3rem 5%;">
  <div class="section-head">
    <h2>✨ Featured <span>Picks</span></h2>
    <a href="search.php" class="view-all">View all books →</a>
  </div>
  <div class="books-grid">
    <?php foreach ($featured as $book): ?>
      <?php include 'includes/book_card.php'; ?>
    <?php endforeach; ?>
  </div>
</section>

<!-- ── Newsletter ── -->
<section class="newsletter-section">
  <h2>📬 Never Miss a New Release</h2>
  <p>Join 50,000+ readers and get weekly book recommendations, deals, and author spotlights.</p>
  <form class="newsletter-form" onsubmit="handleNewsletter(event)">
    <input type="email" placeholder="Enter your email address" required>
    <button type="submit">Subscribe Free</button>
  </form>
</section>

<?php include 'includes/footer.php'; ?>
