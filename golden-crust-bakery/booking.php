<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["bname"] ?? "");
    $phone = trim($_POST["bphone"] ?? "");
    $date = trim($_POST["date"] ?? "");
    $time = trim($_POST["time"] ?? "");
    $seats = trim($_POST["seats"] ?? "");
    $seat = trim($_POST["seat"] ?? "");
    $note = trim($_POST["note"] ?? "");

    if ($name === "" || $phone === "" || $date === "" || $time === "" || $seats === "") {
        die("Please fill all required fields.");
    }

    $stmt = $conn->prepare("INSERT INTO bookings (name, phone, booking_date, booking_time, seats, seat_preference, note) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $phone, $date, $time, $seats, $seat, $note);

    if ($stmt->execute()) {
        header("Location: thanks.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>