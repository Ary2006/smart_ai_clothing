<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo "FORM SUBMITTED<br>";

    if (!isset($_POST['title'])) {
        die("TITLE NOT FOUND");
    }

    if (!isset($_FILES['image'])) {
        die("IMAGE NOT FOUND");
    }

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $image = $_FILES['image']['name'];

    echo "TITLE: $title<br>";
    echo "IMAGE: $image<br>";

    $sql = "INSERT INTO sliders (title, image) VALUES ('$title', '$image')";

    if ($conn->query($sql)) {
        echo "INSERT SUCCESS";
    } else {
        die("SQL ERROR: " . $conn->error);
    }
}
