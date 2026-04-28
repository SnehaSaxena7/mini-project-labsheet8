<?php
require "../config.php";

$bookingCount = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()["total"];
$contactCount = $conn->query("SELECT COUNT(*) AS total FROM contacts")->fetch_assoc()["total"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../style.css" />
  <style>
    body { padding: 24px; }
    .admin-wrap { max-width: 1100px; margin: 0 auto; }
    .admin-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-top: 30px; }
    .admin-card { background: #fff; padding: 24px; border-radius: 18px; box-shadow: 0 12px 30px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.08); }
    .admin-card h2 { margin-bottom: 10px; font-family: "Cormorant Garamond", serif; }
    .admin-links a { display: inline-block; margin-right: 12px; margin-top: 14px; }
  </style>
</head>
<body>
  <div class="admin-wrap">
    <h1 style="font-family:'Cormorant Garamond',serif; font-size:3rem;">Admin Dashboard</h1>
    <p style="color:#6f5b52;">Golden Crust Bakery management panel</p>

    <div class="admin-grid">
      <div class="admin-card">
        <h2>Total Bookings</h2>
        <p style="font-size:2rem; font-weight:700;"><?php echo $bookingCount; ?></p>
      </div>

      <div class="admin-card">
        <h2>Total Messages</h2>
        <p style="font-size:2rem; font-weight:700;"><?php echo $contactCount; ?></p>
      </div>
    </div>

    <div class="admin-card" style="margin-top:20px;">
      <h2>Quick Links</h2>
      <div class="admin-links">
        <a class="btn" href="bookings.php">View Bookings</a>
        <a class="btn" href="contacts.php">View Messages</a>
      </div>
    </div>
  </div>
</body>
</html>