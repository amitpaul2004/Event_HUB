<?php
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "myapp";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status"=>"error","message"=>"DB failed"]);
    exit;
}

$title = $_POST["title"] ?? "";
$desc = $_POST["description"] ?? "";
$date = $_POST["event_date"] ?? "";
$location = $_POST["location"] ?? "";
$att = intval($_POST["attendees"] ?? 0);

$stmt = $conn->prepare("INSERT INTO events (title, description, event_date, location, attendees, created_at) 
VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("ssssi", $title, $desc, $date, $location, $att);

if ($stmt->execute()) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error"]);
}
?>
