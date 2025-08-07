<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $imageName = '';

    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imageName = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $imageName;

       
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        
        } else {
            echo "<p>Image upload failed. Please check file permissions.</p>";
            exit();
        }
    }

   
    $stmt = $conn->prepare("INSERT INTO items (title, image) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $imageName);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "<p>Database error: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    header("Location: create.php");
    exit();
}
?>
