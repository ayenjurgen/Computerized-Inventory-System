<?php
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
	header('location: http://localhost/bikeshop/dashboard.php');
}

$errors = array();

if($_POST) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors[] = "Username is required";
		}

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {
		$sql = "SELECT * FROM users WHERE username = '$username'";
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			$password = md5($password);

			$mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];


				$_SESSION['userId'] = $user_id;

				header('location: http://localhost/bikeshop/dashboard.php');
			} else{

				$errors[] = "Incorrect username/password combination";
			}
		} else {
			$errors[] = "Username does not exists";
		}
	}

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>


	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">

	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">


  <link rel="stylesheet" href="custom/css/custom.css">

	 <link rel="stylesheet" href="custom/css/avatar.css">


	<script src="assests/jquery/jquery.min.js"></script>

  <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>


	<script src="assests/bootstrap/js/bootstrap.min.js"></script>
</head>
<body style="background-color:#333333;">
		<div class="row vertical">
			<div class="col-md-5 col-md-offset-4">
				<div class="imgcontainer">
					<img src="King Felix_wht.png" alt="Avatar" class="avatar" width="500px" height="auto">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Please Sign in</h3>
					</div>
					<div class="panel-body">

						<div class="messages">
							<?php if($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-warning" role="alert">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';
									}
								} ?>
						</div>

						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
							<fieldset>
							  <div class="form-group">
									<label for="username" class="col-sm-2 control-label">Username</label>
									<div class="col-sm-10">
									  <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" />
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">Password</label>
									<div class="col-sm-10">
									  <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
									  <button type="submit" class="btn btn-default"> <i class="glyphicon glyphicon-log-in"></i> Login</button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>

				</div>

			</div>

		</div>

	</div>

</body>
</html>
