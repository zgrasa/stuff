<?php require_once __DIR__.'/../controllers/menu_controller.php'; ?>

<header id="header">
	<h1><a href="index.php">The Ultimate Blog</a></h1>
	<nav class="links">
		<ul>
			<li><a href="index.php">Home</a></li>
			<?php echo $header_nav?>
		</ul>
	</nav>
	<nav class="main">
		<ul>
			<li class="menu">
				<a href="#menu">Menu</a>
			</li>
		</ul>
	</nav>
</header>

<section id="menu">
	<h1>Menu</h1>
	<?php echo $login_status?>
</section>