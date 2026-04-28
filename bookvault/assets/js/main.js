// BookVault — main.js

// Hamburger menu
const hamburger = document.getElementById('hamburger');
const catNav = document.querySelector('.cat-nav');
if (hamburger) {
  hamburger.addEventListener('click', () => {
    catNav.classList.toggle('open');
  });
}

// Auto-submit qty changes in cart
document.querySelectorAll('.qty-input').forEach(input => {
  input.addEventListener('change', function() {
    this.closest('form').submit();
  });
});

// Newsletter subscription
function handleNewsletter(e) {
  e.preventDefault();
  const input = e.target.querySelector('input');
  input.value = '';
  showToast('✅ Subscribed! Check your inbox.');
}

// Toast notification
function showToast(msg) {
  const toast = document.createElement('div');
  toast.style.cssText = `
    position:fixed;bottom:2rem;right:2rem;background:#3D2B1F;color:#FAF0E4;
    padding:.9rem 1.6rem;border-radius:10px;font-size:.9rem;font-weight:500;
    box-shadow:0 8px 30px rgba(0,0,0,.25);z-index:9999;
    animation:slideUp .3s ease;
  `;
  toast.textContent = msg;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}

// Add slideUp keyframe
const style = document.createElement('style');
style.textContent = `@keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}`;
document.head.appendChild(style);

// Coupon code
function applyCoupon() {
  const val = document.getElementById('coupon')?.value.trim().toUpperCase();
  const msg = document.getElementById('coupon-msg');
  const discountRow = document.getElementById('discount-row');
  const discountAmt = document.getElementById('discount-amt');
  const totalEl = document.getElementById('total-display');
  
  const coupons = { 'BOOK10': 10, 'SAVE15': 15, 'READ20': 20 };
  
  if (coupons[val]) {
    const pct = coupons[val];
    if (msg) { msg.textContent = `✅ ${pct}% discount applied!`; msg.style.color = '#27AE60'; }
    if (discountRow) discountRow.style.display = 'flex';
    // Update discount amount via hidden input
    const hiddenDiscount = document.getElementById('hidden-discount');
    if (hiddenDiscount) hiddenDiscount.value = pct;
    showToast(`🎉 Coupon applied! ${pct}% off`);
  } else {
    if (msg) { msg.textContent = '❌ Invalid coupon code.'; msg.style.color = '#C0392B'; }
  }
}

// Highlight active nav on scroll (homepage sections)
const sections = document.querySelectorAll('section[id]');
if (sections.length) {
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        document.querySelectorAll('.cat-nav a').forEach(a => {
          a.classList.toggle('active', a.getAttribute('href') === '#' + e.target.id);
        });
      }
    });
  }, { threshold: 0.4 });
  sections.forEach(s => obs.observe(s));
}
