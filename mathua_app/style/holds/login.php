<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Matua Community</title>
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600;700&display=swap" rel="stylesheet">
	<link rel="shortcut icon" type="image/png" href="images/fav.png">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/green.css" id="style_theme">
	<link rel="stylesheet" href="css/responsive.css">
	<script src="js/modernizr.min.js"></script>
</head>

<body class="auth-bg vh-100">
	<div class="circle1"></div>
	<div class="circle2"></div>
	<div class="container v-middle">
		<div class="row position-relative">
			<div class="col-md-5 ml-md-2">
				<div class="proclinic-box-shadow">
					<h3 class="widget-title">Login</h3>
					<form class="widget-form">
						<div class="form-row">
							<div class="col-sm-12">
								<div class="input-group">
									<div class="input-group-prepend">
							          <div class="input-group-text"><span class="ti-user"></span></div>
							        </div>
									<input name="user" placeholder="Username" class="form-control" required="" data-validation="length alphanumeric" data-validation-length="3-12" data-validation-error-msg="User name has to be an alphanumeric value (3-12 chars)" data-validation-has-keyup-event="true">
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-12">
								<div class="input-group">
									<div class="input-group-prepend">
							          <div class="input-group-text"><span class="ti-key"></span></div>
							        </div>
									<input type="password" placeholder="Password" name="pass_confirmation" class="form-control" data-validation="strength" data-validation-strength="2" data-validation-has-keyup-event="true">
								</div>
							</div>
						</div>	
						<div class="form-row">
							<div class="col-sm-12 text-left">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input" type="checkbox" id="ex-check-2">
									<label class="custom-control-label" for="ex-check-2">Remember Me</label>
								</div>
							</div>
						</div>			
						<div class="button-btn-block">
							<button type="button" class="btn btn-primary btn-lg btn-block">Login</button>
						</div>	
						<div class="auth-footer-text">
							<small>New User, <a href="sign-up.html">Sign Up</a> Here</small>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-6">
				<div class="proclinic-box-shadow h-100">
					<h1 class="text-white">Welcome to Matua Community</h1>
				</div>
			</div>
		</div>
	</div>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/custom.js"></script>
</body>
</html>
