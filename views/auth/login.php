<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/gif" href="<?= $basePath ?>/images/favicon.jpg" />
	<link rel="stylesheet" type="text/css" href="<?= $basePath ?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= $basePath ?>/css/login.css">
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="<?= $basePath ?>/login" method="post">
					<span class="login100-form-title p-b-33">
						SIGN IN
					</span>
					<hr>
					<br />
					<div class="wrap-input100 validate-input" data-validate="Username is required">
						<input class="input100" type="text" name="username" placeholder="Username" required>
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
					<div class="space"></div>
					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Password" required>
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
					<br />
					<div class="error">
						<?= htmlspecialchars($error ?? '', ENT_QUOTES, 'UTF-8') ?>
					</div>
					<br />
					<div class="container-login100-form-btn">
						<button type="submit" name="login" class="login100-form-btn">Sign In</button>
					</div>
				</form>
				<br />
				<div class="copyright">
					<center>Developer <img class="developer" src="<?= $basePath ?>/images/favicon.jpg"> &copy; Shakti 2023.
					</center>
				</div>
			</div>
		</div>
	</div>

</body>

</html>