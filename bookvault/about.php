<?php
$page_title = 'About Us — BookVault';
$active = 'about';
require_once 'includes/header.php';
?>

<div class="about-hero">
  <div style="font-size:3.5rem;margin-bottom:1rem;">📚</div>
  <h1>Our Story</h1>
  <p>BookVault was born from a simple belief: that every person deserves access to great stories and life-changing knowledge.</p>
</div>

<!-- Mission -->
<section class="section" style="max-width:800px;margin:0 auto;text-align:center;">
  <h2 style="font-family:var(--ff-serif);font-size:2rem;color:var(--brown);margin-bottom:1rem;">
    Why <span style="color:var(--amber);">BookVault?</span>
  </h2>
  <p style="color:var(--muted);font-size:1.05rem;line-height:1.8;max-width:620px;margin:0 auto 2rem;">
    We started BookVault in 2019 with 500 titles and a dream. Today, we stock over 10,000 books across every genre, serve readers in 40+ countries, and have helped over half a million people find their next favourite read.
  </p>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;text-align:center;">
    <?php foreach ([['10,000+','Titles in stock'],['500K+','Happy readers'],['40+','Countries served']] as [$num,$lbl]): ?>
      <div style="background:var(--warm-white);border:1px solid var(--border);border-radius:var(--radius-lg);padding:1.8rem;">
        <div style="font-family:var(--ff-serif);font-size:2.2rem;font-weight:800;color:var(--amber);"><?= $num ?></div>
        <div style="font-size:.85rem;color:var(--muted);margin-top:.3rem;"><?= $lbl ?></div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Values -->
<section class="section" style="background:var(--warm-white);margin:0;padding:3rem 5%;">
  <h2 style="font-family:var(--ff-serif);font-size:1.8rem;text-align:center;margin-bottom:2rem;">Our <span style="color:var(--amber);">Values</span></h2>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.5rem;max-width:900px;margin:0 auto;">
    <?php $vals = [['📖','Curated Quality','Every book is hand-picked by our editorial team for quality, depth, and reader delight.'],['🌍','Accessibility','Great books should be affordable and available to everyone, everywhere.'],['♻️','Sustainability','We use eco-friendly packaging and carbon-offset shipping for all orders.'],['❤️','Community','We support local libraries, literacy programs, and independent authors.']];
    foreach ($vals as [$icon,$title,$desc]): ?>
      <div style="padding:1.5rem;border:1px solid var(--border);border-radius:var(--radius-lg);background:var(--cream);">
        <span style="font-size:2rem;display:block;margin-bottom:.8rem;"><?= $icon ?></span>
        <h4 style="font-family:var(--ff-serif);margin-bottom:.5rem;color:var(--brown);"><?= $title ?></h4>
        <p style="font-size:.85rem;color:var(--muted);line-height:1.6;"><?= $desc ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Team -->
<section class="section">
  <h2 style="font-family:var(--ff-serif);font-size:1.8rem;text-align:center;margin-bottom:2rem;">Meet the <span style="color:var(--amber);">Team</span></h2>
  <div class="team-grid" style="padding:0;">
    <?php $team = [['👩‍💼','Priya Sharma','Founder & CEO'],['👨‍💻','Arjun Mehta','CTO'],['👩‍🎨','Sara Chen','Head of Design'],['📚','Rohan Gupta','Head Curator'],['📦','Leila Hassan','Operations'],['🤝','Tom Wright','Partnerships']];
    foreach ($team as [$avatar,$name,$role]): ?>
      <div class="team-card">
        <div class="team-avatar"><?= $avatar ?></div>
        <h4><?= $name ?></h4>
        <p><?= $role ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="newsletter-section">
  <h2>Join the BookVault Community</h2>
  <p>Get weekly picks, author interviews, and exclusive deals.</p>
  <form class="newsletter-form" onsubmit="handleNewsletter(event)">
    <input type="email" placeholder="your@email.com" required>
    <button type="submit">Subscribe Free</button>
  </form>
</section>

<?php include 'includes/footer.php'; ?>
