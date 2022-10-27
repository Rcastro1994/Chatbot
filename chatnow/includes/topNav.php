<?php define ("base_url", "http://localhost/proyecto/");?>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if (!isset($_SESSION['identity'])): ?>
                <li class="nav-item	">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">My Bots</a>
                </li>
                <!--<li class="nav-item">
              <a class="nav-link" href="#" onClick="alert('Coming soon!');">Help</a>
            </li>-->
                <?php
                if (isset($_SESSION['userName'])) {
                    echo '<li class="nav-item">
					<a class="nav-link" href="#" data-toggle="modal" data-target="#editPopout">My Account</a>
					</li>';
                    echo '<li class="nav-item">
        			<a class="nav-link" href="logout.php">Logout</a>
      				</li>';
                }
                ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['identity'])): ?>
                <li class="nav-item	">
                    <a class="nav-link" href="<?= base_url ?>">Inicio</a>
                </li>
                <li class="nav-item	">
                    <a class="nav-link" href="<?= base_url ?>usuario/perfilEstudiante">Mi perfil</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
