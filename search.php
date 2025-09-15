<?php
// search.php - Domain availability checker
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first.'); redirectTo('login.php');</script>";
    exit;
}

$extensions = ['.com', '.net', '.org', '.io', '.app'];
$domain = strtolower(trim($_POST['domain']));
$results = [];

foreach ($extensions as $ext) {
    $full_domain = $domain . $ext;
    $stmt = $conn->prepare("SELECT id FROM domains WHERE domain_name = ? AND extension = ?");
    $stmt->bind_param("ss", $domain, $ext);
    $stmt->execute();
    $stmt->store_result();
    $results[$ext] = $stmt->num_rows == 0 ? 'available' : 'taken';
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $selected_ext = $_POST['extension'];
    if ($results[$selected_ext] == 'available') {
        $reg_date = date('Y-m-d');
        $exp_date = date('Y-m-d', strtotime('+1 year'));
        $user_id = $_SESSION['user_id'];
        
        $stmt = $conn->prepare("INSERT INTO domains (user_id, domain_name, extension, registration_date, expiration_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $domain, $selected_ext, $reg_date, $exp_date);
        if ($stmt->execute()) {
            echo "<script>alert('Domain registered successfully!'); redirectTo('dashboard.php');</script>";
        } else {
            echo "<script>alert('Error registering domain.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Domain not available.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoDaddy Clone - Search Results</title>
    <style>
        /* Internal CSS - Professional, real-looking, amazing design */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; color: #333; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        .result { margin: 10px 0; padding: 10px; border: 1px solid #ddd; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; }
        .available { background-color: #d4edda; color: #155724; }
        .taken { background-color: #f8d7da; color: #721c24; }
        button { padding: 8px 16px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #218838; }
        .nav { text-align: right; padding: 10px; background-color: #007bff; color: white; }
        .nav a { color: white; margin: 0 10px; text-decoration: none; }
        .nav a:hover { text-decoration: underline; }
        @media (max-width: 768px) { .result { flex-direction: column; text-align: center; } button { margin-top: 10px; } }
    </style>
</head>
<body>
    <div class="nav">
        <a href="#" onclick="redirectTo('index.php')">Home</a>
        <a href="#" onclick="redirectTo('dashboard.php')">Dashboard</a>
    </div>
    <div class="container">
        <h2>Search Results for "<?php echo htmlspecialchars($domain); ?>"</h2>
        <?php foreach ($extensions as $ext): ?>
            <div class="result <?php echo $results[$ext]; ?>">
                <span><?php echo htmlspecialchars($domain . $ext); ?> is <?php echo $results[$ext]; ?></span>
                <?php if ($results[$ext] == 'available'): ?>
                    <form method="POST">
                        <input type="hidden" name="domain" value="<?php echo htmlspecialchars($domain); ?>">
                        <input type="hidden" name="extension" value="<?php echo $ext; ?>">
                        <input type="hidden" name="register" value="1">
                        <button type="submit">Register (Add to Cart - Non-functional Checkout)</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        // Internal JS for redirection
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
