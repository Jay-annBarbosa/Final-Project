<?php
session_start();
include("../Includes/db.php");

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo "<script>window.open('../auth/AdminLogin.php','_self')</script>";
    exit();
}

$buyer_id = isset($_GET['buyer_id']) ? intval($_GET['buyer_id']) : 0;
if ($buyer_id <= 0) {
    echo "<p>Invalid buyer id.</p><p><a href='ManageBuyers.php'>Back to buyers</a></p>";
    exit();
}

$query = "SELECT * FROM buyerregistration WHERE buyer_id = $buyer_id LIMIT 1";
$result = mysqli_query($con, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>Buyer not found.</p><p><a href='ManageBuyers.php'>Back to buyers</a></p>";
    exit();
}
$buyer = mysqli_fetch_assoc($result);
// If requested via AJAX, return a fragment suitable for loading into a modal
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    echo '<div class="container">';
    echo '<h4>Buyer Details</h4>';
    echo '<table class="table table-bordered">';
    foreach ($buyer as $k => $v) {
        echo '<tr><th>' . htmlspecialchars($k) . '</th><td>' . htmlspecialchars($v) . '</td></tr>';
    }
    echo '</table>';
    echo '<div style="text-align:right;"><button class="btn btn-secondary" data-dismiss="modal">Close</button></div>';
    echo '</div>';
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Buyer - Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container">
        <h2>Buyer Details</h2>
        <table class="table table-bordered">
            <tbody>
                <?php foreach ($buyer as $k => $v): ?>
                    <tr>
                        <th><?php echo htmlspecialchars($k); ?></th>
                        <td><?php echo htmlspecialchars($v); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="ManageBuyers.php" class="btn btn-secondary">Back to Buyers</a>
    </div>
</body>
</html>