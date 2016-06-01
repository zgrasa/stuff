<?php

//Index_PHP
if(!isset($_SESSION)) {
	session_start();
}
require_once __DIR__. '/Class/userClass.php';
require_once __DIR__. '/Model/userMapper.php';
require_once __DIR__. '/Model/postMapper.php';
require_once __DIR__. '/Model/commentMapper.php';
?>

<!DOCTYPE HTML>
<html>
<?php include_once __DIR__. 'View/body/head.php' ?>

<body>

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Header -->
	<?php include_once __DIR__. 'View/body/header.php' ?>


		<!-- Menu -->
	<?php include_once __DIR__. 'View/body/menu.php' ?>


		<!-- Main -->
		<div id="main">
			<?php echo getAllPostsArticles(); ?>
		</div>

		<!-- Sidebar -->
		<section id="sidebar">

			<!-- Intro -->
			<section id="intro">
				<header>
					<h2>Blog</h2>
					<p>Willkommen auf dem Blog von Samuel Zgraggen</p>
				</header>
			</section>

			<!--Footer-->
			<?php include_once __DIR__. 'View/body/footer.php' ?>

		</section>

	</div>

	<!-- Scripts -->
	<?php include_once __DIR__. 'View/body/scripts.php' ?>

</body>

</html>