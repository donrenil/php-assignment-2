<?php
session_start();
require 'db.php';

$loggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Records</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-3">All Records</h2>

    <?php if ($loggedIn): ?>
        <p>Hello, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
        <a href="create.php" class="btn btn-success mb-3">Create New Record</a>
        <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
    <?php else: ?>
        <p class="text-muted">Login to add or manage records. <a href="login.php">Login</a> or <a href="register.php">Register</a></p>
    <?php endif; ?>

    <?php
    $sql = "SELECT * FROM items";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Image</th>
                    <th>View</th>
                    <?php if ($loggedIn): ?><th>Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td>
                        <?php if (!empty($row['image'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" width="100">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="read.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">View</a>
                    </td>
                    <?php if ($loggedIn): ?>
                        <td>
                            <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Update</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No records found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
