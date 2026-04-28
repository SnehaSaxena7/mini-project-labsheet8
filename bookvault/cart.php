<?php
$page_title = 'Your Cart — BookVault';
$active = 'cart';
require_once 'includes/header.php';

$cart   = $_SESSION['cart'] ?? [];
$subtotal = cart_total($books);
$shipping = $subtotal >= 35 ? 0 : 4.99;
$tax      = round($subtotal * 0.08, 2);
$total    = round($subtotal + $shipping + $tax, 2);
?>

<div class="page-header">
  <h1 style="font-family:var(--ff-serif);">🛒 Your Cart</h1>
  <div class="breadcrumb">
    <a href="index.php">Home</a> › Cart
    <?php if (!empty($cart)): ?>
      <span style="margin-left:.5rem;background:var(--amber);color:white;padding:.15rem .5rem;border-radius:4px;font-size:.75rem;">
        <?= cart_count() ?> item<?= cart_count()!==1?'s':'' ?>
      </span>
    <?php endif; ?>
  </div>
</div>

<?php if (empty($cart)): ?>
  <div class="empty-state" style="padding:5rem 2rem;">
    <span class="empty-icon">🛒</span>
    <h3>Your cart is empty</h3>
    <p>Looks like you haven't added any books yet. Start exploring!</p>
    <a href="search.php" class="btn-primary" style="display:inline-block;margin-top:1.5rem;">Browse Books →</a>
  </div>
<?php else: ?>

<div class="cart-layout">

  <!-- ── Cart items ── -->
  <div>
    <table class="cart-table">
      <thead>
        <tr>
          <th>Book</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Subtotal</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cart as $id => $qty):
          $b = get_book($id, $books);
          if (!$b) continue;
          $line = $b['price'] * $qty;
        ?>
        <tr>
          <td>
            <div class="cart-book-info">
              <img src="<?= htmlspecialchars($b['cover']) ?>" alt="" class="cart-book-cover"
                   onerror="this.src='https://via.placeholder.com/55x82/C8860A/white?text=Book'">
              <div>
                <div class="cart-book-title">
                  <a href="book.php?id=<?= $b['id'] ?>" style="color:inherit;"><?= htmlspecialchars($b['title']) ?></a>
                </div>
                <div class="cart-book-author"><?= htmlspecialchars($b['author']) ?></div>
                <?php if ($b['stock'] <= 3): ?>
                  <div style="font-size:.72rem;color:var(--red);font-weight:600;">Only <?= $b['stock'] ?> left!</div>
                <?php endif; ?>
              </div>
            </div>
          </td>
          <td style="font-weight:600;">$<?= number_format($b['price'],2) ?></td>
          <td>
            <form method="POST" action="cart.php" style="display:inline;">
              <input type="hidden" name="action" value="update_cart">
              <input type="hidden" name="page"   value="cart">
              <input type="hidden" name="id"     value="<?= $id ?>">
              <input type="number" name="qty" value="<?= $qty ?>"
                     min="0" max="<?= $b['stock'] ?>"
                     class="qty-input"
                     onchange="this.form.submit()">
            </form>
          </td>
          <td style="font-weight:700;color:var(--brown);">$<?= number_format($line,2) ?></td>
          <td>
            <form method="POST" action="cart.php">
              <input type="hidden" name="action" value="remove_cart">
              <input type="hidden" name="page"   value="cart">
              <input type="hidden" name="id"     value="<?= $id ?>">
              <button type="submit" class="btn-remove" title="Remove">✕</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div style="margin-top:1.5rem;display:flex;gap:1rem;flex-wrap:wrap;">
      <a href="search.php" style="font-size:.88rem;color:var(--amber);font-weight:600;">← Continue Shopping</a>
    </div>
  </div>

  <!-- ── Order summary ── -->
  <div>
    <div class="order-summary">
      <h3>Order Summary</h3>

      <div class="summary-row">
        <span>Subtotal (<?= cart_count() ?> items)</span>
        <span>$<?= number_format($subtotal,2) ?></span>
      </div>
      <div class="summary-row">
        <span>Shipping</span>
        <span><?= $shipping === 0 ? '<span style="color:var(--green);font-weight:600;">FREE</span>' : '$'.number_format($shipping,2) ?></span>
      </div>
      <?php if ($shipping > 0): ?>
        <div style="font-size:.78rem;color:var(--muted);padding:.3rem 0;">
          Add $<?= number_format(35 - $subtotal, 2) ?> more for free shipping
        </div>
      <?php endif; ?>
      <div class="summary-row">
        <span>Tax (8%)</span>
        <span>$<?= number_format($tax,2) ?></span>
      </div>
      <div id="discount-row" class="summary-row" style="display:none;color:var(--green);">
        <span>Discount</span>
        <span id="discount-amt">-$0.00</span>
      </div>
      <div class="summary-row total">
        <span>Total</span>
        <span id="total-display">$<?= number_format($total,2) ?></span>
      </div>

      <!-- Coupon -->
      <p style="font-size:.8rem;font-weight:600;margin-top:1rem;margin-bottom:.4rem;">Have a coupon?</p>
      <div class="coupon-row">
        <input type="text" id="coupon" placeholder="e.g. READ20">
        <button class="btn-coupon" onclick="applyCoupon()">Apply</button>
      </div>
      <p id="coupon-msg" style="font-size:.78rem;min-height:1rem;"></p>
      <p style="font-size:.75rem;color:var(--muted);">Try: BOOK10 · SAVE15 · READ20</p>

      <a href="checkout.php" class="btn-checkout" style="display:block;text-align:center;text-decoration:none;">
        Proceed to Checkout →
      </a>

      <div style="display:flex;justify-content:center;gap:.8rem;margin-top:1rem;font-size:.75rem;color:var(--muted);">
        <span>🔒 Secure</span>
        <span>💳 All cards</span>
        <span>🍎 Apple Pay</span>
      </div>
    </div>
  </div>

</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
