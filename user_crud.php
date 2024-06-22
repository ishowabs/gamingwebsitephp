<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$action = $_GET['action'];

if ($action == 'update' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $level = $_POST['level'];
    $region = $_POST['region'];

    $stmt = $conn->prepare("UPDATE users SET level = :level, region = :region WHERE id = :id");
    $stmt->bindParam(':level', $level);
    $stmt->bindParam(':region', $region);
    $stmt->bindParam(':id', $_SESSION['user_id']);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
} elseif ($action == 'delete') {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['user_id']);

    if ($stmt->execute()) {
        session_destroy();
        header("Location: register.php");
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<?php if ($action == 'update'): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Update Profile</h1>
        <form method="POST" action="user_crud.php?action=update">
            <div class="form-group">
                <label for="level">Level</label>
                <input type="number" class="form-control" id="level" name="level" value="<?php echo $user['level']; ?>" required>
            </div>
            <div class="form-group">
                <label for="region">Region</label>
                <input type="text" class="form-control" id="region" name="region" value="<?php echo htmlspecialchars($user['region']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php endif; ?>
