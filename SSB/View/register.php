<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
require_once __DIR__.'/../application/mappers/user_mapper.class.php';
//Wenn Benutzer bereits angemeldet auf Index weiterleiten
if (!user_mapper::getInstance()->getLoggedInUser() == null) {
	header('Location: index.php');
}
?>
<!DOCTYPE HTML>
<html>
<?php  include_once __DIR__.'/../application/templates/head.php' ?>
<body>

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Header -->
		<?php  include_once __DIR__.'/../application/templates/header.php' ?>


		<!-- Menu -->
		<?php  include_once __DIR__.'/../application/templates/menu.php' ?>


		<!-- Main -->
		<div id="main">

			<!-- Post -->
			<article class="post">
				<header>
					<div class="title">
						<h2>Benutzer-Registration</h2>
						<p>Erstelle hier dein Benutzer-Konto</p>
					</div>
				</header>
				<form method="post" id="register_form" enctype="multipart/form-data" action="../application/controllers/register_controller.php">


					<div class="row uniform">
						<div class="6u 12u$(xsmall)">
							<label>Benutzername ( 3-16 Zeichen, alphanummerisch erlaubt )</label>
							<input type="text" name="username" id="username" required>
							<label>Passwort ( min. 6 Zeichen, Gross-, Kleinbuchstaben und Zahlen )</label>
							<input type="password" name="password" id="password" required>
							<label>Passwort wiederholen</label>
							<input type="password" name="password_repeat" id="password_repeat" required>
						</div>
						<div class="6u$ 12u$(xsmall)">
							<label>Profilbild</label>
							<p>png oder jpg, maximal <?php echo ini_get('upload_max_filesize');?>B<br>wird mittig quadratisch zugeschnitten</p>
							<input type="file" name="profilepic" id="profilepic"/>
						</div>
						<div class="12u$">
							<hr>
							<label>Voller Name</label>
							<input type="text" name="name" id="name" required>
							<label>Kurzbeschreibung</label>
							<textarea name="summary" id="summary" placeholder="Hobbies, Interessen..." rows="6" required></textarea>
							<ul class="actions">
								<input type='hidden' name='create' value='user'>
								<li><input id="registersend" class="button big" type="button" value="Registrieren" name="create"></li>
								<li><input class="button big" type="reset" value="Zurücksetzen"></li>
							</ul>
						</div>
					</div>
				</form>
			</article>
		</div>


		<!-- Sidebar -->
		<section id="sidebar">

			<!-- Intro -->
			<section id="intro">
				<header>
					<h2>Blog</h2>
					<p>Um selber kommentieren zu könne, Benutzerkonto hier erstellen.</p>
				</header>
			</section>

			<!--Footer-->
			<?php include_once __DIR__.'/../application/templates/footer.php' ?>

		</section>

	</div>

	<!-- Scripts -->
	<?php include_once __DIR__.'/../application/templates/scripts.php' ?>

	<?php  include_once __DIR__.'/../application/templates/message.php' ?>
	<script>
			//Validierung initialisieren
			$(document).ready(function () {
				RegisterValidate();
			});
	</script>

</body>
</html>


<!--
<div class="container">
      <form method="post" action="/admin/registerAction">
        <div class="inline">
            <input class="field" type="text" id="prename" name="prename" required>
            <label class="label" for="prename">Vorname</label>
        </div>
        <div class="inline">
            <input class="field" type="text" id="name" name="name" required>
            <label class="label" for="name">Name</label>
        </div>
        <div class="inline">
            <input class="field" type="text" id="username" name="username" required>
            <label class="label" for="username">Username</label>
        </div>
        <div class="inline">
            <input class="field" type="password" id="password" name="password" required>
            <label class="label" for="password" id="passwordLabel">Passwort</label>
        </div>
        <div class="inline">
            <input class="field" type="password" id="repeatpassword" name="repeatpassword" required>
            <label class="label" for="repeatpassword" id="repeatpasswordLabel">Passwort wiederholen</label>
        </div>
        <div class="inline">
          <button class="button">
            Registrieren
          </button>
        </div>
        <?php
        if($this->fail == true) {
          echo "
          <div class=\"mdl-grid\">
          <p id=\"fail\">$this->failText</p>
          </div>";
        }
        ?>
        </form>
        </div>