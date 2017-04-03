<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= APP_NAME; ?> - Formularz logowania </title>
		<link href="<?= BASEURI; ?>assets/css/login-form.css" rel="stylesheet">
	</head>
	<body>
		<!-- Header -->
		<hgroup>
			<h1>Logowanie do systemu</h1>
			<h2><?= APP_NAME; ?></h2>
		</hgroup><!-- /Header -->
		<!-- Form -->
		<form action="">
			<div class="group">
				<input type="text" name="login" required><span class="highlight"></span><span class="bar"></span>
				<label>Login</label>
			</div>
			<div class="group">
				<input type="password" name="password" required><span class="highlight"></span><span class="bar"></span>
				<label>Hasło</label>
			</div>
			<button type="button" class="button buttonBlue">Zaloguj
				<div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
			</button>
		</form><!-- /Form -->
		<!-- Footer -->
		<footer>
			<p><a href="<?= URI_HOME; ?>"><?= APP_NAME; ?></a> &copy; <?= CURRENT_YEAR; ?></p>
		</footer><!-- /Footer -->
		<script src="<?= BASEURI; ?>assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="<?= BASEURI; ?>assets/js/login-form.min.js" type="text/javascript"></script>
	</body>
</html>
