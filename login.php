<?php
// login.php - User login page
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password);
    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        echo "<script>alert('Login successful!'); redirectTo('dashboard.php');</script>";
    } else {
        echo "<script>alert('Invalid credentials.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoDaddy Clone - Login</title>
    <style>
        /* Internal CSS - Professional, real-looking, amazing design */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; color: #333; }
        .container { max-width: 600px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        form { display: flex; flex-direction: column; }
        input { margin: 10px 0; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        a { color: #007bff; text-decoration: none; text-align: center; display: block; margin-top: 10px; }
        a:hover { text-decoration: underline; }
        @media (max-width: 768px) { .container { margin: 20px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="#" onclick="redirectTo('register.php')">Don't have an account? Register</a>
    </div>
    <script>
        // Internal JS for redirection
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
