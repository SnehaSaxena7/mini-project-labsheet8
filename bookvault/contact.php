<?php
$page_title = 'Contact Us — BookVault';
$active = 'contact';
require_once 'includes/header.php';

$sent = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name    = trim($_POST['name']    ?? '');
  $email   = trim($_POST['email']   ?? '');
  $subject = trim($_POST['subject'] ?? '');
  $message = trim($_POST['message'] ?? '');

  if (!$name)    $errors[] = 'Name is required.';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required.';
  if (!$subject) $errors[] = 'Subject is required.';
  if (!$message) $errors[] = 'Message is required.';

  if (empty($errors)) {
    // In production: mail($to, $subject, $body);
    $sent = true;
  }
}
?>

<div class="page-header">
  <h1 style="font-family:var(--ff-serif);">📬 Contact Us</h1>
  <div class="breadcrumb"><a href="index.php">Home</a> › Contact</div>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:2rem;padding:2.5rem 5%;max-width:1000px;margin:0 auto;">

  <!-- Form -->
  <div>
    <?php if ($sent): ?>
      <div style="background:var(--warm-white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:3rem;text-align:center;">
        <div style="font-size:3.5rem;margin-bottom:1rem;">✅</div>
        <h2 style="font-family:var(--ff-serif);color:var(--brown);margin-bottom:.5rem;">Message Sent!</h2>
        <p style="color:var(--muted);">We'll get back to you within 24 hours. Happy reading! 📚</p>
        <a href="index.php" class="btn-primary" style="display:inline-block;margin-top:1.5rem;">← Back to Home</a>
      </div>
    <?php else: ?>
      <?php if (!empty($errors)): ?>
        <div class="flash flash-error"><?= implode(' · ', array_map('htmlspecialchars', $errors)) ?></div>
      <?php endif; ?>
      <div class="form-card">
        <h2 style="font-family:var(--ff-serif);font-size:1.4rem;margin-bottom:1.5rem;">Send Us a Message</h2>
        <form method="POST">
          <div class="form-row">
            <div class="form-group">
              <label>Your Name *</label>
              <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
              <label>Email Address *</label>
              <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label>Subject *</label>
            <select name="subject">
              <option value="">Select a subject…</option>
              <option value="order">Order Inquiry</option>
              <option value="return">Return / Refund</option>
              <option value="product">Product Question</option>
              <option value="shipping">Shipping Issue</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <label>Your Message *</label>
            <textarea name="message" placeholder="How can we help you today?"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
          </div>
          <button type="submit" class="btn-primary" style="width:100%;padding:.85rem;border-radius:8px;font-size:.95rem;">
            Send Message →
          </button>
        </form>
      </div>
    <?php endif; ?>
  </div>

  <!-- Info panel -->
  <div style="display:flex;flex-direction:column;gap:1rem;">
    <?php $infos = [
      ['📍','Our Address','123 Library Lane, Reading Town, RT 10203, India'],
      ['📧','Email Us','hello@bookvault.com'],
      ['📞','Call Us','+91 98765 43210'],
      ['⏰','Hours','Mon – Sat: 9 AM – 7 PM\nSun: 11 AM – 5 PM'],
    ]; foreach ($infos as [$icon,$title,$text]): ?>
      <div style="background:var(--warm-white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.3rem;display:flex;gap:1rem;align-items:flex-start;">
        <span style="font-size:1.6rem;flex-shrink:0;"><?= $icon ?></span>
        <div>
          <div style="font-weight:700;font-size:.9rem;color:var(--brown);margin-bottom:.3rem;"><?= $title ?></div>
          <div style="font-size:.85rem;color:var(--muted);white-space:pre-line;"><?= $text ?></div>
        </div>
      </div>
    <?php endforeach; ?>

    <div style="background:var(--amber);border-radius:var(--radius-lg);padding:1.3rem;color:white;">
      <div style="font-weight:700;font-size:.9rem;margin-bottom:.3rem;">📦 Track Your Order</div>
      <div style="font-size:.82rem;opacity:.9;margin-bottom:.8rem;">Enter your order ID to check delivery status.</div>
      <input type="text" placeholder="e.g. BV4F2A1B" style="width:100%;padding:.55rem .9rem;border-radius:8px;border:none;font-size:.85rem;background:rgba(255,255,255,.2);color:white;">
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
