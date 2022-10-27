<h3>Gestión de Tests Psicológicos</h3>
<div class="row">
    <div class="col-md-12" align="right">
        <a href="<?= base_url ?>test/registrarTest" type="button" class="btn btn-primary">
            + Test
        </a>
    </div>
</div>
<?php if (isset($_SESSION['deleteTest']) && $_SESSION['deleteTest'] == 'deleted'): ?>
    <strong class='alert-red'>Test eliminado correctamente</strong>
<?php elseif (isset($_SESSION['edited']) && $_SESSION['edited'] == 'complete'): ?>
    <strong class='alert-green'>Test modificado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('deleteTest'); ?>
<?php Utils::deleteSession('edited'); ?>
<table>
    <tr>
        <th>Id</th>
        <th>NOMBRE</th>
        <th>PREGUNTA INICIAL</th>
        <th>ACCIÓN</th>
    </tr>

    <?php while ($t = $tests->fetch_object()): ?>
        <tr>
            <td width="5%"><?= $t->id; ?></td>
            <td width="20%"><?= $t->nombre; ?></td>
            <td width="60%"><?= $t->pregunta1; ?></td>
            <td width="15%">
                <a type="button" class="btn btn-outline-success btn-sm" href="<?= base_url ?>test/editarTest&id=<?= $t->id ?>">Editar</a>
                <a type="button" class="btn btn-outline-danger btn-sm" href="<?= base_url ?>test/eliminarTest&id=<?= $t->id ?>">Eliminar</a></td>
        </tr>
    <?php endwhile; ?>

</table>

<div class="row">
    <img src="../assets/images/blanco.jpg" height="80" width="450"/>
</div>
<div class="row">
    <div class="col-md-12" align="right">
        <a href="<?= base_url ?>test/imprimir" type="button" class="btn btn-success">
            Imprimir Lista
        </a>
    </div>
</div>