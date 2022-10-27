<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/styles.css"/>
        <title>Sistema para detectar trastornos emocionales en estudiantes universitarios de lima metropolitana usando herramientas de comprensión de lenguaje natural</title>
    </head>
    <body>
        <div id="container">
            <header id="header">
                <div id="logo">
                    <img src="assets/images/keva.png" alt="KEVA"/>
                    <a href="index.php">
                        K.E.V.A
                    </a>
                </div>
            </header>
            <nav id="menu" class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Ingresar</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <aside id="lateral-right">
                <img src="assets/images/bot.png" alt="BOT"/>
            </aside>
            <section class="container-fluid">
                <h3>Las Emociones, Depresión, Estrés y otros trastornos emocionales:</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="ratio ratio-16x9">
                            <iframe src="assets/videos/video-intro.mp4" width="400" height="650"></iframe>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p>Estamos encantados de que haya podido ingresar a nuestro sistema. Le brindaremos un servicio
                            personalizado de calidad, el cual contará con una interacción y unos tests psicológicos validados
                            por expertos.</p>
                        <p>No esperes más, inicia ahora!</p>
                        <img id="psiquiatra" src="assets/images/psiquiatra-intro.png"/>
                        <img id="bot-psiquiatra" src="assets/images/bot-psiquiatra.png"/>
                    </div>
                </div>
            </section>
            <footer id="footer">
                <p>Desarrollado por Gabriel Chapiama - Renzo Castro &copy; <?= date('Y') ?></p>
            </footer>
        </div>
    </body>
</html>
