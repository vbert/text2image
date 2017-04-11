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
		<?= $footer; ?><!-- /Footer -->
		<!-- Debug -->
		<?php if ($debug): ?><?= $debug; ?><?php endif; ?><!-- /Debug -->
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