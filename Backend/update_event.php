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

$id = $_POST["id"] ?? "";
$title = $_POST["title"] ?? "";
$desc = $_POST["description"] ?? "";
$date = $_POST["event_date"] ?? "";
$location = $_POST["location"] ?? "";
$att = intval($_POST["attendees"] ?? 0);

if(!$id){
    echo json_encode(["status"=>"error","message"=>"Missing ID"]);
    exit;
}

$stmt = $conn->prepare("
    UPDATE events 
    SET title=?, description=?, event_date=?, location=?, attendees=? 
    WHERE id=?
");
$stmt->bind_param("ssssii", $title, $desc, $date, $location, $att, $id);

if ($stmt->execute()) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error","message"=>"Failed to update"]);
}
?>
