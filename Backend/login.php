<?php
session_start();
header("Content-Type: application/json");

// DB config
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "myapp";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

$email = trim($_POST['email'] ?? "");
$password = $_POST['password'] ?? "";

if ($email === "" || $password === "") {
    echo json_encode(["status" => "error", "message" => "Email and password required"]);
    exit;
}

// Get user
$stmt = $conn->prepare("SELECT id, full_name, email, user_password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    exit;
}

$user = $res->fetch_assoc();
$stored_hash = $user["user_password"];

// ---- FIXED: verify password normally ----
if (!password_verify($password, $stored_hash)) {
    echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
    exit;
}

// Rehash if algorithm changed
if (password_needs_rehash($stored_hash, PASSWORD_BCRYPT)) {
    $newHash = password_hash($password, PASSWORD_BCRYPT);
    $u = $conn->prepare("UPDATE users SET user_password = ? WHERE id = ?");
    $u->bind_param("si", $newHash, $user["id"]);
    $u->execute();
}

// Store session
$_SESSION["user_id"] = $user["id"];
$_SESSION["user_name"] = $user["full_name"];
$_SESSION["user_email"] = $user["email"];

echo json_encode(["status" => "success", "message" => "Login successful"]);
exit;
?>
