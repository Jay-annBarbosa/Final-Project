<?php
session_start();
include("../Includes/db.php");

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo "<script>window.open('../auth/AdminLogin.php','_self')</script>";
    exit();
}

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
if ($order_id <= 0) {
    echo "<p>Invalid order id.</p><p><a href='ManageOrders.php'>Back to orders</a></p>";
    exit();
}

$query = "SELECT * FROM orders WHERE order_id = $order_id LIMIT 1";
$result = mysqli_query($con, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>Order not found.</p><p><a href='ManageOrders.php'>Back to orders</a></p>";
    exit();
}
$order = mysqli_fetch_assoc($result);
// If requested via AJAX, return a fragment suitable for loading into a modal
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    echo '<div class="container">';
    echo '<h4>Order Details</h4>';
    echo '<table class="table table-bordered">';
    foreach ($order as $k => $v) {
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
    <title>View Order - Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container">
        <h2>Order Details</h2>
        <table class="table table-bordered">
            <tbody>
                <?php foreach ($order as $k => $v): ?>
                    <tr>
                        <th><?php echo htmlspecialchars($k); ?></th>
                        <td><?php echo htmlspecialchars($v); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="ManageOrders.php" class="btn btn-secondary">Back to Orders</a>
    </div>
</body>
</html>