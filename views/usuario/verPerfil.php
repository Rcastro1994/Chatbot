<?php if (isset($usu)): ?>
    <h3>Perfil de <?= $usu->nombre . " " . $usu->apellidos ?></h3>
    <div class="col-md-6">
        <div class="row">
            <strong class="perfil">Nombre: <?= $usu->nombre ?></strong>
        </div>
    </div>
    <div class="col-md-6">
        <?php if ($usu->imagen != null): ?>
            <img class="foto-perfil" src="<?= base_url ?>uploads/images/<?= $usu->imagen ?>"/>
        <?php elseif ($usu->rol == 'estudiante'): ?>
            <img class="foto-perfil" src="<?= base_url ?>assets/images/perfilEstudiante.png"/>
        <?php else: ?>
            <img class="foto-perfil" src="<?= base_url ?>assets/images/perfilPsiquiatra.jpg"/>
        <?php endif; ?>
    </div>
    <div class="col-md-4">
        <div class="row">
            <strong class="perfil">Apellidos: <?= $usu->apellidos ?></strong>
        </div>
        <div class="row">
            <?php
            $fnacimiento = $usu->fnacimiento;
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
            <strong class="perfil">Email: <?= $usu->email ?></strong>
        </div>
        <div class="row">
            <strong class="perfil">Rol: <?= ucwords($usu->rol) ?></strong>
        </div>
    </div>
    <?php
    if (isset($_SESSION['admin'])):
        $action = "gestion";
    elseif (isset($_SESSION['psiquiatra'])):
        $action = "estudiantesAsignados";
    endif;
    ?>
    <div class="col-md-10" align="center">
        <a hover="white" type="button" class="btn btn-outline-primary btn-sm" href="<?= base_url ?>usuario/<?= $action ?>">Volver</a>
    </div>
<?php else: ?>
    <h3>El perfil no existe</h3>
    <img id="image-404" src="../assets/images/404.png"/>
<?php endif; ?>
