<?php
$page_title = 'Browse Books — BookVault';
$active = 'search';
require_once 'includes/header.php';

$q    = trim($_GET['q']   ?? '');
$cat  = trim($_GET['cat'] ?? '');
$sort = trim($_GET['sort'] ?? '');
$max  = (float)($_GET['max_price'] ?? 100);
$min  = (float)($_GET['min_price'] ?? 0);

// Filter
$filtered = $books;

if ($q !== '') {
  $ql = strtolower($q);
  $filtered = array_filter($filtered, fn($b) =>
    str_contains(strtolower($b['title']),  $ql) ||
    str_contains(strtolower($b['author']), $ql) ||
    str_contains(strtolower($b['cat']),    $ql)
  );
}

if ($cat !== '' && $cat !== 'All') {
  $filtered = array_filter($filtered, fn($b) => $b['cat'] === $cat);
}

$filtered = array_filter($filtered, fn($b) => $b['price'] >= $min && $b['price'] <= $max);

// Sort
switch ($sort) {
  case 'price_asc':  usort($filtered, fn($a,$b) => $a['price'] <=> $b['price']); break;
  case 'price_desc': usort($filtered, fn($a,$b) => $b['price'] <=> $a['price']); break;
  case 'rating':     usort($filtered, fn($a,$b) => $b['rating'] <=> $a['rating']); break;
  case 'new':
    usort($filtered, fn($a,$b) => ($b['badge']==='New'?1:0) <=> ($a['badge']==='New'?1:0));
    break;
  default: // featured — keep original order
}

$count = count($filtered);
?>

<div class="page-header">
  <h1 style="font-family:var(--ff-serif);">
    <?php if ($q): ?>
      Search: "<?= htmlspecialchars($q) ?>"
    <?php elseif ($cat): ?>
      <?= htmlspecialchars($cat) ?>
    <?php else: ?>
      All Books
    <?php endif; ?>
  </h1>
  <div class="breadcrumb">
    <a href="index.php">Home</a> › 
    <?= $cat ? htmlspecialchars($cat) : 'All Books' ?>
    <?= $q ? ' › "'.htmlspecialchars($q).'"' : '' ?>
  </div>
</div>

<div class="search-layout">

  <!-- ── Sidebar filters ── -->
  <aside class="filter-sidebar">

    <!-- Search -->
    <div class="filter-card">
      <h4>Search</h4>
      <form method="GET">
        <?php if ($cat): ?><input type="hidden" name="cat" value="<?= htmlspecialchars($cat) ?>"><?php endif; ?>
        <div class="search-wrap" style="border-radius:8px;">
          <input type="text" name="q" placeholder="Title or author…" value="<?= htmlspecialchars($q) ?>">
          <button type="submit" aria-label="Search">🔍</button>
        </div>
      </form>
    </div>

    <!-- Category filter -->
    <div class="filter-card">
      <h4>Category</h4>
      <?php foreach ($categories as $c): ?>
        <label class="filter-option">
          <input type="radio" name="cat_filter"
                 value="<?= htmlspecialchars($c) ?>"
                 onchange="location='search.php?cat=<?= urlencode($c==='All'?'':$c) ?><?= $q ? '&q='.urlencode($q) : '' ?>'"
                 <?= ($cat === ($c === 'All' ? '' : $c)) ? 'checked' : '' ?>>
          <?= htmlspecialchars($c) ?>
        </label>
      <?php endforeach; ?>
    </div>

    <!-- Price filter -->
    <div class="filter-card">
      <h4>Max Price</h4>
      <form method="GET">
        <?php if ($cat): ?><input type="hidden" name="cat" value="<?= htmlspecialchars($cat) ?>"><?php endif; ?>
        <?php if ($q):  ?><input type="hidden" name="q"   value="<?= htmlspecialchars($q) ?>"><?php endif; ?>
        <input type="range" name="max_price" min="5" max="30" step="1"
               value="<?= $max ?>"
               oninput="document.getElementById('price-val').textContent=this.value"
               style="width:100%;accent-color:var(--amber);">
        <p style="font-size:.85rem;margin-top:.4rem;">
          Up to: <strong>$<span id="price-val"><?= $max ?></span></strong>
        </p>
        <button type="submit" class="btn-primary" style="width:100%;margin-top:.6rem;padding:.55rem;">Apply</button>
      </form>
    </div>

    <!-- Rating filter -->
    <div class="filter-card">
      <h4>Min Rating</h4>
      <?php foreach ([4.8, 4.5, 4.0] as $r): ?>
        <label class="filter-option">
          <input type="radio" name="min_rating"
                 onchange="location='search.php?cat=<?= urlencode($cat) ?>&min_rating=<?= $r ?>'">
          <?= str_repeat('★', (int)$r) ?> <?= $r ?>+
        </label>
      <?php endforeach; ?>
    </div>
  </aside>

  <!-- ── Results ── -->
  <div class="search-results">
    <div class="search-topbar">
      <span class="results-count">
        <strong><?= $count ?></strong> book<?= $count !== 1 ? 's' : '' ?> found
        <?= $q ? 'for "<em>'.htmlspecialchars($q).'</em>"' : '' ?>
      </span>
      <form method="GET" style="display:inline;">
        <?php if ($cat): ?><input type="hidden" name="cat" value="<?= htmlspecialchars($cat) ?>"><?php endif; ?>
        <?php if ($q):  ?><input type="hidden" name="q"   value="<?= htmlspecialchars($q) ?>"><?php endif; ?>
        <select name="sort" class="sort-select" onchange="this.form.submit()">
          <option value=""           <?= $sort===''          ?'selected':'' ?>>Featured</option>
          <option value="price_asc"  <?= $sort==='price_asc' ?'selected':'' ?>>Price: Low to High</option>
          <option value="price_desc" <?= $sort==='price_desc'?'selected':'' ?>>Price: High to Low</option>
          <option value="rating"     <?= $sort==='rating'    ?'selected':'' ?>>Highest Rated</option>
          <option value="new"        <?= $sort==='new'       ?'selected':'' ?>>Newest First</option>
        </select>
      </form>
    </div>

    <?php if ($count === 0): ?>
      <div class="empty-state">
        <span class="empty-icon">🔍</span>
        <h3>No books found</h3>
        <p>Try a different keyword, category, or price range.</p>
        <a href="search.php" class="btn-primary" style="display:inline-block;margin-top:1.2rem;">Browse All Books</a>
      </div>
    <?php else: ?>
      <div class="books-grid">
        <?php foreach ($filtered as $book): ?>
          <?php include 'includes/book_card.php'; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
