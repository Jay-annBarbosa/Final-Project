<?php
session_start();
include("../Includes/db.php");

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo "<script>window.open('../auth/AdminLogin.php','_self')</script>";
    exit();
}

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if ($product_id <= 0) {
    echo "<p>Invalid product id.</p><p><a href='ManageProducts.php'>Back to products</a></p>";
    exit();
}

$query = "SELECT * FROM products WHERE product_id = $product_id LIMIT 1";
$result = mysqli_query($con, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>Product not found.</p><p><a href='ManageProducts.php'>Back to products</a></p>";
    exit();
}
$product = mysqli_fetch_assoc($result);
// If requested via AJAX, return a fragment suitable for loading into a modal
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    echo '<div class="container">';
    echo '<h4>Product Details</h4>';
    echo '<table class="table table-bordered">';
    foreach ($product as $k => $v) {
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
    <title>View Product - Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container">
        <h2>Product Details</h2>
        <table class="table table-bordered">
            <tbody>
                <?php foreach ($product as $k => $v): ?>
                    <tr>
                        <th><?php echo htmlspecialchars($k); ?></th>
                        <td><?php echo htmlspecialchars($v); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="ManageProducts.php" class="btn btn-secondary">Back to Products</a>
    </div>
</body>
</html>