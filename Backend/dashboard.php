<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../Frontend/login.html");
    exit;
}
// SHOW PHP ERRORS
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Load dashboard.html content
echo file_get_contents("../Frontend/dashboard.html");

// DATABASE CONFIG
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "myapp";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed");
}

// ---------------------------------------------
// HANDLE AJAX EVENT CREATION
// ---------------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "create_event") {

    $title = trim($_POST["title"] ?? "");
    $desc = trim($_POST["description"] ?? "");
    $date = trim($_POST["event_date"] ?? "");
    $location = trim($_POST["location"] ?? "");
    $attendees = intval($_POST["attendees"] ?? 0);

    if ($title === "" || $date === "") {
        echo json_encode(["status" => "error", "message" => "Title and date are required"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, location, attendees, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssi", $title, $desc, $date, $location, $attendees);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Event created successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to create event"]);
    }

    exit;
}

// ---------------------------------------------
// LOAD EVENTS FROM DATABASE
// ---------------------------------------------
$events = [];
$res = $conn->query("SELECT * FROM events ORDER BY id DESC");

while ($row = $res->fetch_assoc()) {
    $events[] = $row;
}

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Dashboard - Event Hub</title>
<style>
/* your entire dashboard.html CSS here unchanged */
</style>
</head>

<body>

<!-- Your full dashboard.html UI goes here EXACTLY the same -->

<script>
// Replace the static events[] array with PHP-loaded events
const phpEvents = <?php echo json_encode($events); ?>;

// Render events in table
const tbody = document.getElementById("eventsTbody");
tbody.innerHTML = "";

phpEvents.forEach(ev => {
    tbody.innerHTML += `
        <tr>
            <td>${ev.title}</td>
            <td>${ev.event_date}</td>
            <td>${ev.location}</td>
            <td>${ev.attendees}</td>
            <td>
                <button class="btn">View</button>
            </td>
        </tr>
    `;
});

// Event CREATE handler
document.getElementById("submitCreate").addEventListener("click", function () {

    const formData = new FormData();
    formData.append("action", "create_event");
    formData.append("title", document.getElementById("evTitle").value);
    formData.append("description", document.getElementById("evDesc").value);
    formData.append("event_date", document.getElementById("evDate").value);
    formData.append("location", document.getElementById("evLocation").value);
    formData.append("attendees", document.getElementById("evAtt").value);

    fetch("dashboard.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") {
            location.reload();
        }
    });
});
</script>

</body>
</html>
