<?php
require_once __DIR__ . '/View/body/head.html';
require_once __DIR__ . '/Controller/sessionController.php';
require_once __DIR__ . '/Model/Users.php';
SessionController::initializeSessionManager();

$usermapper = new Users();
?>

<body>
	<div id="wrapper">
    	<div id="main">
            <header>
                <div class="title">
                    <h2>Logout</h2>
                    
                    <?php
					if(SessionController::isLoggedIn() == true) {
					    SessionController::set("isLoggedIn", false);
					    SessionController::killSession();
					    echo $usermapper->getUserById(SessionController::get('id'))->getEmail().' wurde erfolgreich ausgelogged';
					} else {
					    echo 'Sie sind gar nicht eingelogged';
					}
					?>
                    
                    <nav class="links">
                        <ul>
                            <li class="home"><a href="index.php">Home</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
		</div>
	</div>
<?php include_once __DIR__ . '/View/body/footer.html'; ?>
</body>
</html>

