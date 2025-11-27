<?php
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "myapp";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$res = $conn->query("SELECT * FROM events ORDER BY id DESC");

$events = [];
while ($row = $res->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);
?>
