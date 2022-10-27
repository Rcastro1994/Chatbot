<?php if (isset($_SESSION['psiquiatra'])): ?>
    <h3>Perfil de <?= $_SESSION['identity']->nombre ?></h3>
    <div class="col-md-6">
        <div class="row">
            <strong class="perfil">Nombre: <?= $_SESSION['identity']->nombre ?></strong>
        </div>
    </div>
    <div class="col-md-6">
        <?php if ($_SESSION['identity']->imagen != null): ?>
            <img class="foto-perfil" src="<?= base_url ?>uploads/images/<?= $_SESSION['identity']->imagen ?>"/>
        <?php else: ?>
            <img class="foto-perfil" src="<?= base_url ?>assets/images/perfilPsiquiatra.jpg"/>
        <?php endif; ?>
    </div>
    <div class="col-md-4">
        <div class="row">
            <strong class="perfil">Apellidos: <?= $_SESSION['identity']->apellidos ?></strong>
        </div>
        <div class="row">
            <?php
            $fnacimiento = $_SESSION['identity']->fnacimiento;
            $nacimiento = new DateTime($fnacimiento);
            $ahora = new DateTime(date("Y-m-d"));
            $diferencia = $ahora->diff($nacimiento);
            $edad = $diferencia->format("%y");
            ?>
            <strong class="perfil">Fecha de Nacimiento: <?= $fnacimiento ?></strong>
        </div>
        <div class="row">
            <strong class="perfil">Edad: <?= $edad ?></strong>
        </div>
        <div class="row">
            <strong class="perfil">Email: <?= $_SESSION['identity']->email ?></strong>
        </div>
        <div class="row">
            <strong class="perfil">Rol: <?= ucwords($_SESSION['identity']->rol) ?></strong>
        </div>
    </div>
    <div class="col-md-10" align="center">
        <a  type="button" class="btn btn-outline-primary btn-sm" href="<?= base_url ?>usuario/actualizarPerfil">Actualizar Datos</a>
    </div>
<?php endif; ?>

