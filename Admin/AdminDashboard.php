<?php
session_start();
include("../Includes/db.php");
include("../Functions/functions.php");

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
	echo "<script>window.open('../auth/AdminLogin.php','_self')</script>";
	exit();
}

// Get dashboard statistics
$farmers_query = "SELECT COUNT(*) as total_farmers FROM farmerregistration";
$farmers_result = mysqli_query($con, $farmers_query);
$farmers_data = mysqli_fetch_assoc($farmers_result);
$total_farmers = $farmers_data['total_farmers'];

$buyers_query = "SELECT COUNT(*) as total_buyers FROM buyerregistration";
$buyers_result = mysqli_query($con, $buyers_query);
$buyers_data = mysqli_fetch_assoc($buyers_result);
$total_buyers = $buyers_data['total_buyers'];

$products_query = "SELECT COUNT(*) as total_products FROM products";
$products_result = mysqli_query($con, $products_query);
$products_data = mysqli_fetch_assoc($products_result);
$total_products = $products_data['total_products'];

$orders_query = "SELECT COUNT(*) as total_orders FROM orders";
$orders_result = mysqli_query($con, $orders_query);
$orders_data = mysqli_fetch_assoc($orders_result);
$total_orders = $orders_data['total_orders'];

$total_revenue_query = "SELECT SUM(total) as total_revenue FROM orders";
$total_revenue_result = mysqli_query($con, $total_revenue_query);
$total_revenue_data = mysqli_fetch_assoc($total_revenue_result);
$total_revenue = $total_revenue_data['total_revenue'] ? $total_revenue_data['total_revenue'] : 0;
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Admin Dashboard - AgroCraft</title>
	<script src="https://kit.fontawesome.com/c587fc1763.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
		@import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);

		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: Raleway, sans-serif;
			background-color: #f5f8fa;
			color: #212529;
		}

		.navbar-custom {
			background-color: #292b2c;
		}

		.navbar-custom .navbar-brand,
		.navbar-custom .navbar-text,
		.navbar-custom .navbar-nav .nav-link {
			color: goldenrod !important;
		}

		.navbar-custom .nav-item.active .nav-link,
		.navbar-custom .nav-item:hover .nav-link {
			color: #ffd700 !important;
		}

		.sidebar {
			background-color: #292b2c;
			color: goldenrod;
			min-height: 100vh;
			padding: 20px;
		}

		.sidebar a {
			color: goldenrod;
			text-decoration: none;
			display: block;
			padding: 10px 15px;
			margin: 5px 0;
			border-radius: 5px;
			transition: all 0.3s ease;
		}

		.sidebar a:hover {
			background-color: #1a1b1c;
			color: #ffd700;
		}

		.sidebar .active {
			background-color: goldenrod;
			color: #292b2c;
		}

		.main-content {
			padding: 30px;
		}

		.stat-card {
			background: white;
			border-left: 4px solid goldenrod;
			padding: 20px;
			margin-bottom: 20px;
			border-radius: 5px;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		}

		.stat-card h5 {
			color: #292b2c;
			font-weight: bold;
			margin-bottom: 10px;
		}

		.stat-card .stat-number {
			font-size: 32px;
			color: goldenrod;
			font-weight: bold;
		}

		.stat-card .stat-icon {
			font-size: 40px;
			color: goldenrod;
			float: right;
			opacity: 0.3;
		}

		.page-title {
			color: #292b2c;
			margin-bottom: 30px;
			border-bottom: 2px solid goldenrod;
			padding-bottom: 10px;
		}

		.btn-custom {
			background-color: #292b2c;
			color: goldenrod;
			border: none;
		}

		.btn-custom:hover {
			background-color: #1a1b1c;
			color: #ffd700;
		}

		.table-custom {
			background-color: white;
			border-radius: 5px;
			overflow: hidden;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		}

		.table-custom thead {
			background-color: #292b2c;
			color: goldenrod;
		}

		.table-custom tbody tr:hover {
			background-color: #f9f9f9;
		}

		.logout-btn {
			background-color: #dc3545;
			color: white;
			border: none;
			padding: 8px 15px;
			border-radius: 5px;
			cursor: pointer;
			transition: all 0.3s ease;
		}

		.logout-btn:hover {
			background-color: #c82333;
		}

		@media only screen and (max-width: 768px) {
			.sidebar {
				display: none;
			}

			.main-content {
				padding: 15px;
			}

			.stat-card {
				margin-bottom: 15px;
			}
		}
	</style>
</head>

<body>

	<!-- Navigation Bar -->
	<nav class="navbar navbar-expand-lg navbar-custom">
		<div class="container-fluid">
			<a class="navbar-brand" href="#"><i class="fas fa-leaf"></i> AgroCraft Admin</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<span class="navbar-text">Welcome, <strong><?php echo $_SESSION['admin_username']; ?></strong></span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="AdminLogout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row">
			<!-- Sidebar -->
			<div class="col-md-3 sidebar">
				<h5 style="margin-bottom: 20px; color: goldenrod;"><i class="fas fa-bars"></i> Menu</h5>
				<a href="AdminDashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
				<a href="ManageFarmers.php"><i class="fas fa-users"></i> Manage Farmers</a>
				<a href="ManageBuyers.php"><i class="fas fa-shopping-cart"></i> Manage Buyers</a>
				<a href="ManageProducts.php"><i class="fas fa-box"></i> Manage Products</a>
				<a href="ManageOrders.php"><i class="fas fa-receipt"></i> Manage Orders</a>
				<a href="AdminSettings.php"><i class="fas fa-cog"></i> Settings</a>
				<hr style="border-color: goldenrod;">
				<a href="AdminLogout.php" style="color: #dc3545;"><i class="fas fa-sign-out-alt"></i> Logout</a>
			</div>

			<!-- Main Content -->
			<div class="col-md-9 main-content">
				<h1 class="page-title"><i class="fas fa-chart-line"></i> Dashboard</h1>

				<!-- Statistics Cards -->
				<div class="row">
					<div class="col-md-6">
						<div class="stat-card">
							<div class="stat-icon"><i class="fas fa-users"></i></div>
							<h5>Total Farmers</h5>
							<div class="stat-number"><?php echo $total_farmers; ?></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="stat-card">
							<div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
							<h5>Total Buyers</h5>
							<div class="stat-number"><?php echo $total_buyers; ?></div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="stat-card">
							<div class="stat-icon"><i class="fas fa-box"></i></div>
							<h5>Total Products</h5>
							<div class="stat-number"><?php echo $total_products; ?></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="stat-card">
							<div class="stat-icon"><i class="fas fa-receipt"></i></div>
							<h5>Total Orders</h5>
							<div class="stat-number"><?php echo $total_orders; ?></div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="stat-card">
							<div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
							<h5>Total Revenue</h5>
							<div class="stat-number">PHP <?php echo number_format($total_revenue, 2); ?></div>
						</div>
					</div>
				</div>

				<!-- Recent Orders Section -->
				<div class="row" style="margin-top: 30px;">
					<div class="col-md-12">
						<h3 class="page-title"><i class="fas fa-receipt"></i> Recent Orders</h3>
						<div class="table-responsive table-custom">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Order ID</th>
										<th>Product ID</th>
										<th>Quantity</th>
										<th>Total</th>
										<th>Payment</th>
										<th>Delivery</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$recent_orders_query = "SELECT * FROM orders ORDER BY order_id DESC LIMIT 10";
									$recent_orders_result = mysqli_query($con, $recent_orders_query);
									while ($order = mysqli_fetch_assoc($recent_orders_result)) {
										echo "<tr>";
										echo "<td>" . $order['order_id'] . "</td>";
										echo "<td>" . $order['product_id'] . "</td>";
										echo "<td>" . $order['qty'] . "</td>";
										echo "<td>PHP " . $order['total'] . "</td>";
										echo "<td>" . ucfirst($order['payment']) . "</td>";
										echo "<td>" . $order['delivery'] . "</td>";
										echo "</tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

</body>

</html>
