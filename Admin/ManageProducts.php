<?php
session_start();
include("../Includes/db.php");
include("../Functions/functions.php");

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
	echo "<script>window.open('../auth/AdminLogin.php','_self')</script>";
	exit();
}

// Handle delete product
if (isset($_GET['delete_product'])) {
	$product_id = mysqli_real_escape_string($con, $_GET['delete_product']);
	$delete_query = "DELETE FROM products WHERE product_id = '$product_id'";
	if (mysqli_query($con, $delete_query)) {
		$_SESSION['success_message'] = "Product deleted successfully!";
	} else {
		$_SESSION['error_message'] = "Error deleting product!";
	}
	echo "<script>window.open('ManageProducts.php','_self')</script>";
}

// Get all products
$products_query = "SELECT * FROM products ORDER BY product_id DESC";
$products_result = mysqli_query($con, $products_query);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Manage Products - Admin Panel</title>
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

		.page-title {
			color: #292b2c;
			margin-bottom: 30px;
			border-bottom: 2px solid goldenrod;
			padding-bottom: 10px;
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

		.btn-custom {
			background-color: #292b2c;
			color: goldenrod;
			border: none;
			padding: 5px 10px;
			border-radius: 3px;
			cursor: pointer;
			transition: all 0.3s ease;
			margin: 2px;
			font-size: 12px;
		}

		.btn-custom:hover {
			background-color: #1a1b1c;
			color: #ffd700;
		}

		.btn-delete {
			background-color: #dc3545;
			color: white;
		}

		.btn-delete:hover {
			background-color: #c82333;
		}

		.alert-custom {
			margin-bottom: 20px;
		}

		@media only screen and (max-width: 768px) {
			.sidebar {
				display: none;
			}

			.main-content {
				padding: 15px;
			}

			.table-responsive {
				font-size: 12px;
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
				<a href="AdminDashboard.php"><i class="fas fa-home"></i> Dashboard</a>
				<a href="ManageFarmers.php"><i class="fas fa-users"></i> Manage Farmers</a>
				<a href="ManageBuyers.php"><i class="fas fa-shopping-cart"></i> Manage Buyers</a>
				<a href="ManageProducts.php" class="active"><i class="fas fa-box"></i> Manage Products</a>
				<a href="ManageOrders.php"><i class="fas fa-receipt"></i> Manage Orders</a>
				<a href="AdminSettings.php"><i class="fas fa-cog"></i> Settings</a>
				<hr style="border-color: goldenrod;">
				<a href="AdminLogout.php" style="color: #dc3545;"><i class="fas fa-sign-out-alt"></i> Logout</a>
			</div>

			<!-- Main Content -->
			<div class="col-md-9 main-content">
				<h1 class="page-title"><i class="fas fa-box"></i> Manage Products</h1>

				<?php
				if (isset($_SESSION['success_message'])) {
					echo "<div class='alert alert-success alert-custom alert-dismissible fade show' role='alert'>
						" . $_SESSION['success_message'] . "
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						</button>
					</div>";
					unset($_SESSION['success_message']);
				}
				if (isset($_SESSION['error_message'])) {
					echo "<div class='alert alert-danger alert-custom alert-dismissible fade show' role='alert'>
						" . $_SESSION['error_message'] . "
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						</button>
					</div>";
					unset($_SESSION['error_message']);
				}
				?>

				<div class="table-responsive table-custom">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Product ID</th>
								<th>Title</th>
								<th>Category</th>
								<th>Type</th>
								<th>Price</th>
								<th>Stock</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (mysqli_num_rows($products_result) > 0) {
								while ($product = mysqli_fetch_assoc($products_result)) {
									echo "<tr>";
									echo "<td>" . $product['product_id'] . "</td>";
									echo "<td>" . substr($product['product_title'], 0, 20) . "...</td>";
									echo "<td>" . $product['product_cat'] . "</td>";
									echo "<td>" . $product['product_type'] . "</td>";
									echo "<td>PHP " . $product['product_price'] . "</td>";
									echo "<td>" . $product['product_stock'] . "</td>";
									echo "<td>";
									echo "<button class='btn btn-custom view-btn' data-url='ViewProduct.php?product_id=" . $product['product_id'] . "&ajax=1'><i class='fas fa-eye'></i> View</button>";
									echo "<a href='ManageProducts.php?delete_product=" . $product['product_id'] . "' class='btn btn-custom btn-delete' onclick='return confirm(\"Are you sure?\")'><i class='fas fa-trash'></i> Delete</a>";
									echo "</td>";
									echo "</tr>";
								}
							} else {
								echo "<tr><td colspan='7' class='text-center'>No products found</td></tr>";
							}
							?>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>

<!-- Modal used for viewing details -->
<div class="modal fade" id="adminViewModal" tabindex="-1" role="dialog" aria-labelledby="adminViewModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="adminViewModalLabel">Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">Loading...</div>
		</div>
	</div>
</div>

<script>
$(document).on('click', '.view-btn', function(e) {
		e.preventDefault();
		var url = $(this).data('url');
		$('#adminViewModal .modal-body').html('Loading...');
		$('#adminViewModal').modal('show');
		$.get(url, function(data) {
				$('#adminViewModal .modal-body').html(data);
		}).fail(function() {
				$('#adminViewModal .modal-body').html('<div class="text-danger">Unable to load details.</div>');
		});
});
</script>

</body>

</html>
