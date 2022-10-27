<?php if (isset($_SESSION['admin'])): ?>
    <h3>Gestión de Usuarios</h3>
<?php elseif (isset($_SESSION['psiquiatra'])): ?>
    <h3>Estudiantes Asignados del Psiquiatra: <?= $_SESSION['identity']->nombre . " " . $_SESSION['identity']->apellidos ?></h3>
<?php endif; ?>

<div class="row">
    <div class="col-md-3">
        <?php
        if (isset($_SESSION['admin'])):
            $action = "gestion";
        elseif (isset($_SESSION['psiquiatra'])):
            $action = "estudiantesAsignados";
        endif;
        ?>
        <form action="<?= base_url ?>usuario/<?= $action ?>" method="POST">
            <label class="estandar" for="buscador">Buscador</label>
            <input type="text" name="buscador"/>
            <input type="submit" id="button-buscar" value="Buscar"/>
        </form>
    </div>
</div>
    
<?php if (isset($_SESSION['admin'])): ?>
    <div class="row">
        <div class="col-md-12" align="right">
            <a href="<?= base_url ?>usuario/registrarPsiquiatra" type="button" class="btn btn-primary">
                + Psiquiatra
            </a>
        </div>
    </div>
<?php endif; ?>
    
<table>
    <tr>
        <th>Id</th>
        <th>NOMBRES</th>
        <th>APELLIDOS</th>
        <th>CORREO</th>
        <th>ROL</th>
        <th>ACCIÓN</th>
    </tr>

    <?php while ($usu = $usuarios->fetch_object()): ?>
        <tr>
            <td><?= $usu->id; ?></td>
            <td><?= $usu->nombre; ?></td>
            <td><?= $usu->apellidos; ?></td>
            <td><?= $usu->email; ?></td>
            <td><?= ucwords($usu->rol); ?></td>
            <td><a type="button" class="btn btn-outline-primary btn-sm" href="<?= base_url ?>usuario/verPerfil&id=<?= $usu->id ?>">Ver</a></td>
        </tr>
    <?php endwhile; ?>

</table>

<div class="row">
    <img src="../assets/images/blanco.jpg" height="50" width="450"/>
</div>
<div class="row">
    <div class="col-md-12" align="right">
        <a href="<?= base_url ?>usuario/imprimir" class="btn btn-success">
            Imprimir Lista
        </a>
    </div>
</div>