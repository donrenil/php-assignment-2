<?php
require 'db.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$title = "";
$image = "";
$message = "";

$stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $title = $row['title'];
    $image = $row['image'];
} else {
    $message = "Record not found.";
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>View Record</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-warning"> <?= $message ?> </div>
    <?php else: ?>
        <div class="mb-3">
            <strong>Title:</strong>
            <p><?= htmlspecialchars($title) ?></p>
        </div>
        <div class="mb-3">
            <strong>Image:</strong><br>
            <?php if (!empty($image)): ?>
                <img src="uploads/<?= htmlspecialchars($image) ?>" width="200">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary">Back</a>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

