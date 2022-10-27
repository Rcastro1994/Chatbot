<?php
if (isset($_SESSION['savedName'])):
    unset($_SESSION['savedName']);
endif;
?>
<h3>Las Emociones, Depresión, Estrés y otros trastornos emocionales:</h3>
<div class="row">
    <div class="col-md-6">
        <div class="ratio ratio-16x9">
            <img src="<?= base_url ?>assets/images/intro.jpg" width="400" height="650"/>
        </div>
    </div>
    <div class="col-md-6">
        <?php if (isset($_SESSION['estudiante'])): ?>
            <strong id="bienvenida-e">K.E.V.A te da la bienvenida</strong>
        <?php endif; ?>
        <?php if (isset($_SESSION['psiquiatra'])): ?>
            <strong id="bienvenida-p">K.E.V.A te da la bienvenida</strong>
        <?php endif; ?>
        <?php if (isset($_SESSION['admin'])): ?>
            <strong id="bienvenida-a">K.E.V.A te da la bienvenida</strong>
        <?php endif; ?>
        <?php if (!isset($_SESSION['psiquiatra']) && !isset($_SESSION['admin'])): ?>
            <p>Estamos encantados de que haya podido ingresar a nuestro sistema. Le brindaremos un servicio
                personalizado de calidad, el cual contará con una interacción y unos tests psicológicos validados
                por expertos.</p>
            <p>No esperes más, inicia ahora!</p>
        <?php endif; ?>
        <?php if (isset($_SESSION['psiquiatra'])): ?>
            <p>En determinados casos, usted se encargará de diagnosticar y tratar las enfermedades mentales de 
                estudiantes universitarios, prioritariamente, prescribiendo medicación u otro tipo de intervención 
                médica que sea necesaria a fin de equilibrar la bioquímica del cerebro y raparar o compensar la 
                fisiología que este deteriorada.</p>
            <p>"Da siempre lo mejor de ti. Lo que plantees ahora, lo cosecharás mas tarde"</p>
        <?php endif; ?>
        <?php if (isset($_SESSION['admin'])): ?>
            <p>Estimado administrador, está a cargo del mantenimiento del sistema; se ocupa de las incidencias de 
                los usuarios, y resuelve los problemas que les surgen. Asimismo, tiene la capacidad de solucionar 
                todas las ocurrencias que se presenten.</p>
            <p>"Saber cómo solucionar las necesidades y los problemas, es estar en continua formación"</p>
        <?php endif; ?>
        <img id="psiquiatra" src="<?= base_url ?>assets/images/psiquiatra-intro.png"/>
        <img id="bot-psiquiatra" src="<?= base_url ?>assets/images/bot-psiquiatra.png"/>
    </div>
</div>