<?php
// login.php
session_start();
require_once 'includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Please fill in both fields.';
    } else {
        // Very basic example – in real project use password_hash() + password_verify()
        // For now we use plain text or simple md5 just to get started (replace later!)
        $stmt = $conn->prepare("SELECT username, role FROM Users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);  // ← change to hashed later
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $users = $result->fetch_assoc();
            $_SESSION['userID']   = $user['userID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];  // 'Owner', 'Cashier', 'Employee'

            header("Location: index.php");
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bike Repair Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Bike Repair Login</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>