<?php
include 'config/db.php';

// 1. Define the admin details
$name = "Super Admin";
$email = "admin@smartclothing.com";
$password = "admin123"; // This will be your password
$role = "ADMIN"; // MUST match the auth.php check exactly

// 2. Securely hash the password
// (This ensures it works whether he used password_verify or not, usually)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 3. Insert into Database
// Columns based on your screenshot: id, name, email, password, age, gender, profile_img, role, created_at
$sql = "INSERT INTO users (name, email, password, age, gender, role, created_at) 
        VALUES (?, ?, ?, 25, 'Male', ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $hashed_password, $role);

if ($stmt->execute()) {
    echo "<h1>Success!</h1>";
    echo "Admin created.<br>";
    echo "<strong>Email:</strong> $email<br>";
    echo "<strong>Password:</strong> $password<br>";
    echo "<br><a href='admin/login.php'>Go to Admin Login</a>";
} else {
    echo "Error: " . $conn->error;
}
?>