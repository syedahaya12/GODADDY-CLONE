<?php
// dashboard.php - User dashboard for managing domains
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first.'); redirectTo('login.php');</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch domains
$stmt = $conn->prepare("SELECT * FROM domains WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$domains = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Handle remove
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {
    $domain_id = $_POST['domain_id'];
    $stmt = $conn->prepare("DELETE FROM domains WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $domain_id, $user_id);
    if ($stmt->execute()) {
        echo "<script>alert('Domain removed.'); window.location.reload();</script>";
    } else {
        echo "<script>alert('Error removing domain.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoDaddy Clone - Dashboard</title>
    <style>
        /* Internal CSS - Professional, real-looking, amazing design */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; color: #333; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        tr:hover { background-color: #f1f1f1; }
        button { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; margin-right: 5px; }
        .renew { background-color: #ffc107; color: #212529; }
        .renew:hover { background-color: #e0a800; }
        .transfer { background-color: #17a2b8; color: white; }
        .transfer:hover { background-color: #138496; }
        .remove { background-color: #dc3545; color: white; }
        .remove:hover { background-color: #c82333; }
        .nav { text-align: right; padding: 10px; background-color: #007bff; color: white; }
        .nav a { color: white; margin: 0 10px; text-decoration: none; }
        .nav a:hover { text-decoration: underline; }
        @media (max-width: 768px) { table { font-size: 14px; } button { width: 100%; margin: 5px 0; } }
    </style>
</head>
<body>
    <div class="nav">
        <a href="#" onclick="redirectTo('index.php')">Home</a>
        <a href="#" onclick="redirectTo('login.php')">Logout</a> <!-- Simple logout, actual logout needs session destroy -->
    </div>
    <div class="container">
        <h2>Your Domains</h2>
        <table>
            <tr>
                <th>Domain</th>
                <th>Registration Date</th>
                <th>Expiration Date</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($domains as $dom): ?>
                <tr>
                    <td><?php echo htmlspecialchars($dom['domain_name'] . $dom['extension']); ?></td>
                    <td><?php echo $dom['registration_date']; ?></td>
                    <td><?php echo $dom['expiration_date']; ?></td>
                    <td>
                        <button class="renew" onclick="alert('Renewal non-functional')">Renew</button>
                        <button class="transfer" onclick="alert('Transfer non-functional')">Transfer</button>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="domain_id" value="<?php echo $dom['id']; ?>">
                            <input type="hidden" name="remove" value="1">
                            <button type="submit" class="remove">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script>
        // Internal JS for redirection
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
