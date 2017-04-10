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
		<?= $navbar; ?><!-- /Navbar -->
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