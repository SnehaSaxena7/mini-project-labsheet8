<?php
require "../config.php";
$result = $conn->query("SELECT * FROM bookings ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bookings</title>
  <link rel="stylesheet" href="../style.css" />
  <style>
    body { padding: 24px; }
    .admin-wrap { max-width: 1200px; margin: 0 auto; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
    th, td { padding: 12px; border: 1px solid rgba(0,0,0,0.1); text-align: left; }
    th { background: #f6e6dc; }
  </style>
</head>
<body>
  <div class="admin-wrap">
    <h1 style="font-family:'Cormorant Garamond',serif; font-size:3rem;">Booking List</h1>
    <a class="btn" href="dashboard.php">Back to Dashboard</a>

    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Date</th>
        <th>Time</th>
        <th>Seats</th>
        <th>Preference</th>
        <th>Note</th>
        <th>Created</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row["id"]; ?></td>
        <td><?php echo htmlspecialchars($row["name"]); ?></td>
        <td><?php echo htmlspecialchars($row["phone"]); ?></td>
        <td><?php echo $row["booking_date"]; ?></td>
        <td><?php echo $row["booking_time"]; ?></td>
        <td><?php echo $row["seats"]; ?></td>
        <td><?php echo htmlspecialchars($row["seat_preference"]); ?></td>
        <td><?php echo htmlspecialchars($row["note"]); ?></td>
        <td><?php echo $row["created_at"]; ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>