<?php
header("Content-Type: application/json");

// DATABASE CONFIG
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "myapp";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

// READ POST INPUT
$full_name = trim($_POST["name"] ?? "");
$email     = trim($_POST["email"] ?? "");
$password  = $_POST["password"] ?? "";

// VALIDATION
if ($full_name === "" || $email === "" || $password === "") {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Invalid email format"]);
    exit;
}

// CHECK EMAIL DUPLICATION
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Email already exists"]);
    exit;
}

// HASH PASSWORD (secure)
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// INSERT USER INTO DB
$stmt = $conn->prepare("INSERT INTO users (full_name, email, user_password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $full_name, $email, $hashed_password);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Account created successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to create account"]);
}

$stmt->close();
$conn->close();
?>
