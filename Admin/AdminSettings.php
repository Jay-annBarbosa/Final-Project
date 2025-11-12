<?php
session_start();
include("../Includes/db.php");
include("../Functions/functions.php");

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
	echo "<script>window.open('../auth/AdminLogin.php','_self')</script>";
	exit();
}

// Handle password change
if (isset($_POST['change_password'])) {
	$old_password = mysqli_real_escape_string($con, $_POST['old_password']);
	$new_password = mysqli_real_escape_string($con, $_POST['new_password']);
	$confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

	if ($new_password !== $confirm_password) {
		$_SESSION['error_message'] = "New passwords do not match!";
	} else {
		// Encrypt passwords
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;
		$encryption_iv = '2345678910111211';
		$encryption_key = "DE";

		$old_encrypted = openssl_encrypt($old_password, $ciphering, $encryption_key, $options, $encryption_iv);
		$new_encrypted = openssl_encrypt($new_password, $ciphering, $encryption_key, $options, $encryption_iv);

		// Verify old password
		$verify_query = "SELECT * FROM admin WHERE admin_id = '" . $_SESSION['admin_id'] . "' AND admin_password = '$old_encrypted'";
		$verify_result = mysqli_query($con, $verify_query);

		if (mysqli_num_rows($verify_result) > 0) {
			$update_query = "UPDATE admin SET admin_password = '$new_encrypted' WHERE admin_id = '" . $_SESSION['admin_id'] . "'";
			if (mysqli_query($con, $update_query)) {
				$_SESSION['success_message'] = "Password changed successfully!";
			} else {
				$_SESSION['error_message'] = "Error updating password!";
			}
		} else {
			$_SESSION['error_message'] = "Old password is incorrect!";
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Admin Settings - Admin Panel</title>
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

		.settings-card {
			background: white;
			padding: 30px;
			border-radius: 5px;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
			margin-bottom: 20px;
		}

		.settings-card h4 {
			color: #292b2c;
			margin-bottom: 20px;
			border-bottom: 2px solid goldenrod;
			padding-bottom: 10px;
		}

		.form-group label {
			color: #292b2c;
			font-weight: bold;
		}

		.form-control {
			border: 1px solid #ddd;
			border-radius: 3px;
		}

		.form-control:focus {
			border-color: goldenrod;
			box-shadow: 0 0 0 0.2rem rgba(218, 165, 32, 0.25);
		}

		.btn-custom {
			background-color: #292b2c;
			color: goldenrod;
			border: none;
			padding: 10px 20px;
			border-radius: 3px;
			cursor: pointer;
			transition: all 0.3s ease;
		}

		.btn-custom:hover {
			background-color: #1a1b1c;
			color: #ffd700;
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

			.settings-card {
				padding: 15px;
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
				<a href="ManageProducts.php"><i class="fas fa-box"></i> Manage Products</a>
				<a href="ManageOrders.php"><i class="fas fa-receipt"></i> Manage Orders</a>
				<a href="AdminSettings.php" class="active"><i class="fas fa-cog"></i> Settings</a>
				<hr style="border-color: goldenrod;">
				<a href="AdminLogout.php" style="color: #dc3545;"><i class="fas fa-sign-out-alt"></i> Logout</a>
			</div>

			<!-- Main Content -->
			<div class="col-md-9 main-content">
				<h1 class="page-title"><i class="fas fa-cog"></i> Admin Settings</h1>

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

				<!-- Change Password Section -->
				<div class="settings-card">
					<h4><i class="fas fa-lock"></i> Change Password</h4>
					<form method="POST" action="AdminSettings.php">
						<div class="form-group">
							<label for="old_password">Current Password</label>
							<input type="password" class="form-control" id="old_password" name="old_password" placeholder="Enter your current password" required>
						</div>

						<div class="form-group">
							<label for="new_password">New Password</label>
							<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required>
						</div>

						<div class="form-group">
							<label for="confirm_password">Confirm New Password</label>
							<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
						</div>

						<button type="submit" class="btn btn-custom" name="change_password">
							<i class="fas fa-save"></i> Change Password
						</button>
					</form>
				</div>

				<!-- System Information Section -->
				<div class="settings-card">
					<h4><i class="fas fa-info-circle"></i> System Information</h4>
					<div class="row">
						<div class="col-md-6">
							<p><strong>Admin Username:</strong> <?php echo $_SESSION['admin_username']; ?></p>
							<p><strong>Admin ID:</strong> <?php echo $_SESSION['admin_id']; ?></p>
						</div>
						<div class="col-md-6">
							<p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
							<p><strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

</body>

</html>
