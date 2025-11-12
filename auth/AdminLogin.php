<?php
session_start();
include("../Includes/db.php");
include("../Functions/functions.php");
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Admin Login Portal</title>
	<script src="https://kit.fontawesome.com/c587fc1763.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
		@import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);

		body {
			margin: 0;
			font-size: .9rem;
			font-weight: 400;
			line-height: 1.6;
			color: #212529;
			text-align: left ! important;
			background-color: #f5f8fa;
			text-align: center;
			background-size: 100% 100%;
		}

		.my-form,
		.login-form {
			font-family: Raleway, sans-serif;
		}

		.my-form {
			padding-top: 1.5rem;
			padding-bottom: 1.5rem;
		}

		.my-form .row {
			margin-left: 0;
			margin-right: 0;
		}

		.login-form {
			padding-top: 1.5rem;
			padding-bottom: 1.5rem;
		}

		.login-form .row {
			margin-left: 0;
			margin-right: 0;
		}

		.card-header {
			background-color: #292b2c !important;
		}

		.card-header h4 {
			color: goldenrod;
			font-weight: bold;
		}

		.btn-primary {
			background-color: #292b2c !important;
			border-color: #292b2c !important;
			color: goldenrod !important;
		}

		.btn-primary:hover {
			background-color: #1a1b1c !important;
		}

		a {
			color: goldenrod;
		}

		a:hover {
			color: #ffd700;
		}

		.admin-badge {
			background-color: #dc3545;
			color: white;
			padding: 5px 10px;
			border-radius: 5px;
			font-size: 12px;
			margin-left: 10px;
		}

		@media only screen and (min-device-width:320px) and (max-device-width:480px) {
			.card {
				margin: 20px;
			}
		}
	</style>
</head>

<body>

	<main class="my-form">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">
							<h4>Admin Login <span class="admin-badge">ADMIN PANEL</span></h4>
						</div>
						<div class="card-body border border-dark">
							<?php
							if (isset($_SESSION['admin_error'])) {
								echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
									" . $_SESSION['admin_error'] . "
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
										<span aria-hidden='true'>&times;</span>
									</button>
								</div>";
								unset($_SESSION['admin_error']);
							}
							?>
							<form name="admin-login-form" action="AdminLogin.php" method="post">

								<div class="form-group row">
									<label for="username" class="col-md-4 col-form-label text-md-right"><i class="fas fa-user mr-2"></i><b>Username</b></label>
									<div class="col-md-6">
										<input type="text" id="username" class="form-control border border-dark" name="username" placeholder="Username" required>
									</div>
								</div>

								<div class="form-group row">
									<label for="password" class="col-md-4 col-form-label text-md-right"><i class="fas fa-lock mr-2"></i><b>Password</b></label>
									<div class="col-md-6">
										<input id="password" class="form-control border border-dark" type="password" name="password" placeholder="Password" required>
									</div>
								</div>

								<div class="col-md-6 offset-md-4">
									<button type="submit" class="btn btn-primary text-left border border-dark" name="login" value="Login">
										Login
									</button>
								</div>
								<br>
								<div class="col-md-6 offset-md-4">
									<label class="text-left"><a href="../index.html"><b style="color:black">Back to Home</b></a></label>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

</body>

</html>

<?php
if (isset($_POST['login'])) {

	$username = mysqli_real_escape_string($con, $_POST['username']);
	$password = mysqli_real_escape_string($con, $_POST['password']);

	// Fetch admin row by username first
	$query = "SELECT * FROM admin WHERE admin_username = '$username' LIMIT 1";
	$run_query = mysqli_query($con, $query);

	if (!$run_query || mysqli_num_rows($run_query) == 0) {
		// No such user
		$_SESSION['admin_error'] = "Invalid username or password. Please try again.";
		echo "<script>window.open('AdminLogin.php','_self')</script>";
		exit;
	}

	$row = mysqli_fetch_assoc($run_query);
	$stored = $row['admin_password'];

	$authenticated = false;

	// 1) If stored value looks like a bcrypt hash use password_verify
	if (is_string($stored) && strpos($stored, '$2y$') === 0) {
		if (password_verify($password, $stored)) {
			$authenticated = true;
		}
	} else {
		// 2) Use SHA-256 hashing (new method): compare stored hash to hex/bytes of SHA-256(password)
		$sha = hash('sha256', $password);

		// stored may be binary VARBINARY of hex (UNHEX was used when inserting), or plain text.
		// Compare a) as ASCII hex string, b) as raw binary (UNHEX), c) direct string.
		if (is_string($stored) && (strcasecmp($stored, $sha) === 0)) {
			$authenticated = true;
		} else {
			// If DB stored raw binary via UNHEX(hex_of_hash), compare binary
			if (bin2hex($stored) === strtolower($sha)) {
				$authenticated = true;
			} else {
				// last fallback: direct compare (in case of legacy formats)
				if ($stored === $sha) {
					$authenticated = true;
				}
			}
		}
	}

	if (!$authenticated) {
		$_SESSION['admin_error'] = "Invalid username or password. Please try again.";
		echo "<script>window.open('AdminLogin.php','_self')</script>";
		exit;
	}

	// Successful login
	$_SESSION['admin_id'] = $row['admin_id'];
	$_SESSION['admin_username'] = $row['admin_username'];
	$_SESSION['admin_logged_in'] = true;
	echo "<script>window.open('../Admin/AdminDashboard.php','_self')</script>";
}
?>
