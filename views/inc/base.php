<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= APP_NAME; ?></title>
		<link href="<?= BASEURI; ?>assets/css/font-awesome.min.css" rel="stylesheet">
		<link href="<?= BASEURI; ?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= BASEURI; ?>assets/css/app.css" rel="stylesheet">
	</head>
	<body>
		<!-- Navbar -->
		<header>
			<nav class="navbar navbar-fixed-top navbar-default">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menubar-collapse" aria-expanded="false" aria-controls="menubar-collapse">
							<span class="sr-only">Włącz menu</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="<?= URI_HOME; ?>"><?= APP_NAME; ?></a>
					</div>
					<div id="menubar-collapse" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="active"><a href="#">Lista projektów</a></li>
							<!--
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li role="separator" class="divider"></li>
									<li class="dropdown-header">Nav header</li>
									<li><a href="#">Separated link</a></li>
									<li><a href="#">One more separated link</a></li>
								</ul>
							</li>
							-->
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</nav>
		</header><!-- /Navbar -->
		<!-- Page Content -->
		<main class="page-content">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?= $content; ?>
					</div>
				</div>
			</div>
		</main>
		<!-- /Page Content -->
		<!-- Footer -->
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-12">
						<p><a href="<?= URI_HOME; ?>"><span class="sol-txt"><?= APP_NAME; ?></span></a> &copy; <?= CURRENT_YEAR; ?></p>
					</div>
				</div>
			</div>
		</footer><!-- /Footer -->
		<?php if ($debug): ?>
			<div id="vb-debug">
				<h3 id="vb-debug-title">DEBUG:</h3>
				<div class="table-responsive in-vb-debug">
					<?php
					var_dump($debug);
					?>
				</div>
			</div>
		<?php endif; ?>
		<!-- JavaScript -->
		<script type="text/javascript">
			var Text2Image = {
				baseuri: "<?= BASEURI; ?>"
			};
		</script>
		<script src="<?= BASEURI; ?>assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="<?= BASEURI; ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?= BASEURI; ?>assets/js/app.js" type="text/javascript"></script>
	</body>
</html>