<?php
require 'db.php';
session_start();

$title = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);

    if (!empty($title) && isset($_FILES['image'])) {
        $imageName = basename($_FILES['image']['name']);
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath = "uploads/" . $imageName;

        if (move_uploaded_file($imageTmp, $imagePath)) {
            $stmt = $conn->prepare("INSERT INTO items (title, image) VALUES (?, ?)");
            $stmt->bind_param("ss", $title, $imageName);

            if ($stmt->execute()) {
                $message = "Record created successfully.";
                $title = ""; // reset form field
            } else {
                $message = "Database error: " . $conn->error;
            }
            $stmt->close();
        } else {
            $message = "Failed to upload image.";
        }
    } else {
        $message = "Please enter a title and select an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Record</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Create New Record</h2>
    <?php if (!empty($message)): ?>
        <div class="alert alert-info"> <?= $message ?> </div>
    <?php endif; ?>

    <form method="POST" action="add.php" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
