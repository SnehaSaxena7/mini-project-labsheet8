<?php
$page_title = 'Order Confirmed — BookVault';
$active = 'home';
require_once 'includes/header.php';

$order_id = $_SESSION['order_id'] ?? 'BV' . strtoupper(substr(md5(uniqid()), 0, 8));
unset($_SESSION['order_id']);
?>

<div style="max-width:600px;margin:4rem auto;padding:0 5%;text-align:center;">
  <div style="background:var(--warm-white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:3rem 2rem;">
    <div style="font-size:4rem;margin-bottom:1rem;">🎉</div>
    <h1 style="font-family:var(--ff-serif);font-size:2.2rem;color:var(--brown);margin-bottom:.5rem;">
      Order Confirmed!
    </h1>
    <p style="color:var(--muted);font-size:1rem;margin-bottom:1.5rem;">
      Thank you for your purchase. Your books are on their way!
    </p>

    <div style="background:var(--cream);border-radius:10px;padding:1.2rem;margin-bottom:2rem;display:inline-block;">
      <div style="font-size:.78rem;color:var(--muted);letter-spacing:.08em;text-transform:uppercase;margin-bottom:.3rem;">Order ID</div>
      <div style="font-size:1.4rem;font-weight:800;color:var(--amber);letter-spacing:.1em;"><?= $order_id ?></div>
    </div>

    <div style="border:1px solid var(--border);border-radius:10px;padding:1.2rem;margin-bottom:2rem;text-align:left;">
      <div style="display:flex;justify-content:space-between;padding:.5rem 0;font-size:.88rem;">
        <span style="color:var(--muted);">📧 Confirmation sent to</span>
        <span style="font-weight:600;">your@email.com</span>
      </div>
      <div style="display:flex;justify-content:space-between;padding:.5rem 0;font-size:.88rem;border-top:1px solid var(--border);">
        <span style="color:var(--muted);">🚚 Estimated delivery</span>
        <span style="font-weight:600;">5–7 business days</span>
      </div>
      <div style="display:flex;justify-content:space-between;padding:.5rem 0;font-size:.88rem;border-top:1px solid var(--border);">
        <span style="color:var(--muted);">📦 Status</span>
        <span style="color:var(--green);font-weight:700;">Processing</span>
      </div>
    </div>

    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
      <a href="index.php" class="btn-primary">← Continue Shopping</a>
      <a href="search.php" class="btn-outline" style="background:var(--cream);color:var(--brown);border:1.5px solid var(--border);">Browse More Books</a>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
