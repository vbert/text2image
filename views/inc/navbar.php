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
					<?php if ($items): ?>
						<?php foreach ($items as $item): ?>
							<li<?php if ($item['active']): ?> class="active"<?php endif; ?>><a href="<?= $item['uri']; ?>"><?= $item['title']; ?></a></li>
							<?php endforeach; ?>
						<?php endif; ?>

					<!--

					<li class="active"><a href="">Lista projektów</a></li>
					<li><a href="<?= URI_LOGOUT; ?>">Wyloguj</a></li>
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
</header>
