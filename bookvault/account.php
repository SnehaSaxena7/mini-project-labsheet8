<?php
$page_title = 'My Account — BookVault';
$active = 'account';
require_once 'includes/header.php';

$logged_in = !empty($_SESSION['user']);
$msg = '';

// Simple demo login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['login'])) {
    if ($_POST['email'] === 'demo@bookvault.com' && $_POST['password'] === 'demo123') {
      $_SESSION['user'] = ['name' => 'Alex Reader', 'email' => 'demo@bookvault.com'];
      header('Location: account.php'); exit;
    } else {
      $msg = 'error:Invalid email or password. Try demo@bookvault.com / demo123';
    }
  }
  if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header('Location: account.php'); exit;
  }
}

if ($msg) {
  [$type, $text] = explode(':', $msg, 2);
}
?>

<div class="page-header">
  <h1 style="font-family:var(--ff-serif);">👤 My Account</h1>
  <div class="breadcrumb"><a href="index.php">Home</a> › Account</div>
</div>

<?php if (!empty($type)): ?>
  <div class="flash flash-<?= $type ?>"><?= htmlspecialchars($text) ?></div>
<?php endif; ?>

<?php if ($logged_in): ?>
  <!-- Dashboard -->
  <div style="max-width:720px;margin:2.5rem auto;padding:0 5%;">
    <div style="background:linear-gradient(135deg,var(--brown),var(--brown-lt));border-radius:var(--radius-lg);padding:2rem;color:#FAF0E4;margin-bottom:2rem;display:flex;align-items:center;gap:1.5rem;">
      <div style="width:64px;height:64px;border-radius:50%;background:var(--amber);display:flex;align-items:center;justify-content:center;font-size:2rem;flex-shrink:0;">
        📚
      </div>
      <div>
        <h2 style="font-family:var(--ff-serif);font-size:1.5rem;">Welcome back, <?= htmlspecialchars($_SESSION['user']['name']) ?>!</h2>
        <p style="opacity:.8;font-size:.9rem;"><?= htmlspecialchars($_SESSION['user']['email']) ?></p>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1rem;margin-bottom:2rem;">
      <?php $stats = [['📦','Orders','3'],['💛','Wishlist',count($_SESSION['wishlist']??[])],['🛒','In Cart',cart_count()],['⭐','Reviews','7']];
      foreach ($stats as [$icon,$label,$val]): ?>
        <div style="background:var(--warm-white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.3rem;text-align:center;">
          <div style="font-size:2rem;"><?= $icon ?></div>
          <div style="font-size:1.6rem;font-weight:800;color:var(--brown);margin:.3rem 0;"><?= $val ?></div>
          <div style="font-size:.8rem;color:var(--muted);"><?= $label ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Recent orders (demo) -->
    <div class="form-card" style="margin-bottom:1.5rem;">
      <h3 style="font-family:var(--ff-serif);font-size:1.1rem;margin-bottom:1rem;padding-bottom:.7rem;border-bottom:1px solid var(--border);">Recent Orders</h3>
      <?php $orders = [['BV4F2A1B','Atomic Habits + 2 more','$41.97','Delivered','2025-03-12'],['BVC39D82','Project Hail Mary','$13.99','Processing','2025-04-01']];
      foreach ($orders as [$oid,$items,$amt,$status,$date]): ?>
        <div style="display:flex;align-items:center;justify-content:space-between;padding:.8rem 0;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:.5rem;">
          <div>
            <div style="font-weight:700;font-size:.9rem;color:var(--amber);"><?= $oid ?></div>
            <div style="font-size:.82rem;color:var(--muted);"><?= $items ?> · <?= $date ?></div>
          </div>
          <div style="text-align:right;">
            <div style="font-weight:700;"><?= $amt ?></div>
            <div style="font-size:.75rem;color:<?= $status==='Delivered'?'var(--green)':'var(--amber)' ?>;font-weight:600;"><?= $status ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <form method="POST">
      <button type="submit" name="logout" style="background:none;border:1.5px solid var(--border);padding:.6rem 1.6rem;border-radius:50px;font-size:.88rem;color:var(--muted);font-weight:600;">Sign Out</button>
    </form>
  </div>

<?php else: ?>
  <!-- Login form -->
  <div class="form-page">
    <h1>Sign In</h1>
    <p class="sub">Welcome back to BookVault. Sign in to access your orders, wishlist, and more.</p>
    <div class="form-card">
      <p style="font-size:.82rem;background:#FFF3E0;border-radius:6px;padding:.7rem 1rem;margin-bottom:1.2rem;color:#7B4100;">
        🔑 Demo login: <strong>demo@bookvault.com</strong> / <strong>demo123</strong>
      </p>
      <form method="POST">
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="you@example.com" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="••••••••" required>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.2rem;">
          <label style="display:flex;align-items:center;gap:.5rem;font-size:.85rem;cursor:pointer;">
            <input type="checkbox" style="accent-color:var(--amber);"> Remember me
          </label>
          <a href="#" style="font-size:.82rem;color:var(--amber);">Forgot password?</a>
        </div>
        <button type="submit" name="login" class="btn-primary" style="width:100%;padding:.85rem;border-radius:8px;font-size:.95rem;">Sign In</button>
      </form>
      <p style="text-align:center;margin-top:1.2rem;font-size:.85rem;color:var(--muted);">
        New here? <a href="#" style="color:var(--amber);font-weight:600;">Create an account →</a>
      </p>
    </div>
  </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
