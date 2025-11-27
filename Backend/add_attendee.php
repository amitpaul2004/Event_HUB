<?php
// DO NOT SEND JSON HEADERS BEFORE REDIRECT

// DB CONNECTION
$conn = new mysqli("localhost", "root", "", "myapp");

if ($conn->connect_error) {
    header("Location: ../Frontend/Fr.html?success=0");
    exit;
}

// Get POST fields
$event_id   = intval($_POST["event_id"] ?? 1);
$name       = trim($_POST["name"] ?? "");
$email      = trim($_POST["email"] ?? "");
$department = trim($_POST["department"] ?? "");
$roll       = trim($_POST["roll"] ?? "");
$phone      = trim($_POST["phone"] ?? "");
$food       = trim($_POST["food"] ?? "");

// Required validation
if ($name==="" || $email==="" || $department==="" || $roll==="" || $phone==="") {
    header("Location: ../Frontend/Fr.html?success=0");
    exit;
}

// Insert attendee
$stmt = $conn->prepare("
    INSERT INTO attendees (event_id, name, email, department, roll, phone, food)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("issssss",
    $event_id,
    $name,
    $email,
    $department,
    $roll,
    $phone,
    $food
);

if ($stmt->execute()) {

    // SUCCESS → redirect with success=1
    header("Location: ../Frontend/Fr.html?success=1");
    exit;

} else {

    // FAILURE → redirect with success=0
    header("Location: ../Frontend/Fr.html?success=0");
    exit;
}


$stmt->close();
$conn->close();
?>
