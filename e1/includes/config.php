<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'foodshare_pakistan');

// Application Constants
define('APP_NAME', 'FoodShare Pakistan');
define('APP_TAGLINE', 'Save Food, Feed People');
define('BASE_URL', 'http://localhost/foodshare-pakistan/'); // Adjust as needed

// Start Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database Connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Error connecting to database: " . $e->getMessage());
}

// Global Functions
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags(trim($data))));
}

function redirect($path) {
    header("Location: " . $path);
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getRole() {
    return $_SESSION['role'] ?? null;
}

function checkRole($role) {
    if (!isLoggedIn() || getRole() !== $role) {
        redirect('login.php');
    }
}

function updateImpact($meals, $kg, $families) {
    global $conn;
    $co2 = $kg * 2.5; // Estimated 2.5kg CO2 per kg food waste
    $water = $kg * 10; // Estimated 10L water per kg food waste
    $sql = "UPDATE impact_stats SET 
            meals_saved = meals_saved + $meals, 
            food_saved_kg = food_saved_kg + $kg, 
            families_helped = families_helped + $families,
            co2_reduced = co2_reduced + $co2,
            water_saved = water_saved + $water
            WHERE id = 1";
    return $conn->query($sql);
}
?>
