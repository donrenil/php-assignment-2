<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT image FROM items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $imagePath = 'uploads/' . $row['image'];
    if (!empty($row['image']) && file_exists($imagePath)) {
        unlink($imagePath);
    }
}
$stmt->close();

// Delete the record
$delete = $conn->prepare("DELETE FROM items WHERE id = ?");
$delete->bind_param("i", $id);
$delete->execute();
$delete->close();

header("Location: index.php");
exit();
?>
