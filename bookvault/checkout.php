<?php
$page_title = 'Checkout — BookVault';
$active = 'cart';
require_once 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) { header('Location: cart.php'); exit; }

$subtotal = cart_total($books);
$shipping = $subtotal >= 35 ? 0 : 4.99;
$tax      = round($subtotal * 0.08, 2);
$total    = round($subtotal + $shipping + $tax, 2);

// Handle order submission
$order_placed = false;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
  $req = ['fname','lname','email','address','city','zip','country'];
  foreach ($req as $f) {
    if (empty(trim($_POST[$f] ?? ''))) $errors[] = ucfirst($f) . ' is required.';
  }
  if (empty($errors)) {
    // In a real app: save order to DB, send email, process payment
    $_SESSION['cart'] = [];
    $_SESSION['order_id'] = 'BV' . strtoupper(substr(md5(uniqid()), 0, 8));
    header('Location: order_confirm.php');
    exit;
  }
}
?>

<div class="page-header">
  <h1 style="font-family:var(--ff-serif);">Secure Checkout</h1>
  <div class="breadcrumb">
    <a href="index.php">Home</a> › <a href="cart.php">Cart</a> › Checkout
  </div>
</div>

<?php if (!empty($errors)): ?>
  <div class="flash flash-error"><?= implode(' · ', array_map('htmlspecialchars', $errors)) ?></div>
<?php endif; ?>

<form method="POST" style="display:grid;grid-template-columns:1fr 360px;gap:2rem;padding:2rem 5%;align-items:start;" id="checkout-form">

  <div>
    <!-- Contact -->
    <div class="form-card" style="margin-bottom:1.5rem;">
      <h3 style="font-family:var(--ff-serif);font-size:1.2rem;margin-bottom:1.2rem;padding-bottom:.8rem;border-bottom:1px solid var(--border);">
        📬 Contact Information
      </h3>
      <div class="form-row">
        <div class="form-group">
          <label>First Name *</label>
          <input type="text" name="fname" value="<?= htmlspecialchars($_POST['fname'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label>Last Name *</label>
          <input type="text" name="lname" value="<?= htmlspecialchars($_POST['lname'] ?? '') ?>" required>
        </div>
      </div>
      <div class="form-group">
        <label>Email Address *</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label>Phone (optional)</label>
        <input type="tel" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
      </div>
    </div>

    <!-- Shipping -->
    <div class="form-card" style="margin-bottom:1.5rem;">
      <h3 style="font-family:var(--ff-serif);font-size:1.2rem;margin-bottom:1.2rem;padding-bottom:.8rem;border-bottom:1px solid var(--border);">
        🚚 Shipping Address
      </h3>
      <div class="form-group">
        <label>Street Address *</label>
        <input type="text" name="address" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>" required>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>City *</label>
          <input type="text" name="city" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label>ZIP / Postal Code *</label>
          <input type="text" name="zip" value="<?= htmlspecialchars($_POST['zip'] ?? '') ?>" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>State / Province</label>
          <input type="text" name="state" value="<?= htmlspecialchars($_POST['state'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label>Country *</label>
          <select name="country">
            <option value="">Select country…</option>
            <option value="IN" <?= ($_POST['country']??'')==='IN'?'selected':'' ?>>India</option>
            <option value="US" <?= ($_POST['country']??'')==='US'?'selected':'' ?>>United States</option>
            <option value="GB" <?= ($_POST['country']??'')==='GB'?'selected':'' ?>>United Kingdom</option>
            <option value="CA" <?= ($_POST['country']??'')==='CA'?'selected':'' ?>>Canada</option>
            <option value="AU" <?= ($_POST['country']??'')==='AU'?'selected':'' ?>>Australia</option>
          </select>
        </div>
      </div>

      <!-- Shipping method -->
      <div style="margin-top:1rem;">
        <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:.8rem;">Shipping Method</label>
        <label style="display:flex;align-items:center;gap:.8rem;padding:.7rem;border:1.5px solid var(--amber);border-radius:8px;margin-bottom:.5rem;cursor:pointer;">
          <input type="radio" name="shipping_method" value="standard" checked style="accent-color:var(--amber);">
          <span>
            <strong>Standard Shipping</strong>
            <span style="color:var(--muted);font-size:.82rem;"> — 5–7 business days</span>
          </span>
          <span style="margin-left:auto;font-weight:700;"><?= $subtotal >= 35 ? 'FREE' : '$4.99' ?></span>
        </label>
        <label style="display:flex;align-items:center;gap:.8rem;padding:.7rem;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;">
          <input type="radio" name="shipping_method" value="express" style="accent-color:var(--amber);">
          <span>
            <strong>Express Shipping</strong>
            <span style="color:var(--muted);font-size:.82rem;"> — 1–2 business days</span>
          </span>
          <span style="margin-left:auto;font-weight:700;">$12.99</span>
        </label>
      </div>
    </div>

    <!-- Payment -->
    <div class="form-card">
      <h3 style="font-family:var(--ff-serif);font-size:1.2rem;margin-bottom:1.2rem;padding-bottom:.8rem;border-bottom:1px solid var(--border);">
        💳 Payment Details
      </h3>
      <p style="font-size:.8rem;color:var(--muted);margin-bottom:1rem;">
        🔒 Your payment info is encrypted and secure. (Demo mode — no real charges.)
      </p>
      <div class="form-group">
        <label>Card Number</label>
        <input type="text" placeholder="1234 5678 9012 3456" maxlength="19"
               oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/(.{4})/g,'$1 ').trim()">
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Expiry Date</label>
          <input type="text" placeholder="MM / YY" maxlength="7">
        </div>
        <div class="form-group">
          <label>CVV</label>
          <input type="text" placeholder="123" maxlength="4">
        </div>
      </div>
      <div class="form-group">
        <label>Name on Card</label>
        <input type="text" placeholder="As it appears on your card">
      </div>
    </div>
  </div>

  <!-- ── Order summary panel ── -->
  <div>
    <div class="order-summary">
      <h3>Your Order</h3>
      <?php foreach ($cart as $id => $qty):
        $b = get_book($id, $books);
        if (!$b) continue;
      ?>
      <div style="display:flex;gap:.8rem;align-items:center;padding:.6rem 0;border-bottom:1px solid var(--border);">
        <img src="<?= htmlspecialchars($b['cover']) ?>" style="width:40px;border-radius:4px;flex-shrink:0;"
             onerror="this.src='https://via.placeholder.com/40x60/C8860A/white?text=Book'">
        <div style="flex:1;min-width:0;">
          <div style="font-size:.82rem;font-weight:600;color:var(--brown);
               white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($b['title']) ?></div>
          <div style="font-size:.75rem;color:var(--muted);">Qty: <?= $qty ?></div>
        </div>
        <div style="font-weight:700;font-size:.88rem;white-space:nowrap;">$<?= number_format($b['price']*$qty,2) ?></div>
      </div>
      <?php endforeach; ?>

      <div class="summary-row" style="margin-top:.5rem;"><span>Subtotal</span><span>$<?= number_format($subtotal,2) ?></span></div>
      <div class="summary-row"><span>Shipping</span><span><?= $shipping===0?'FREE':'$'.number_format($shipping,2) ?></span></div>
      <div class="summary-row"><span>Tax (8%)</span><span>$<?= number_format($tax,2) ?></span></div>
      <div class="summary-row total"><span>Total</span><span>$<?= number_format($total,2) ?></span></div>

      <button type="submit" name="place_order" class="btn-checkout">
        🔒 Place Order — $<?= number_format($total,2) ?>
      </button>

      <p style="font-size:.75rem;color:var(--muted);text-align:center;margin-top:.8rem;">
        By placing your order you agree to our Terms of Service & Privacy Policy.
      </p>
    </div>
  </div>

</form>

<?php include 'includes/footer.php'; ?>
