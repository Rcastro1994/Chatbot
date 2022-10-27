<?php if (isset($_SESSION['admin'])): ?>
    <h3>Gestión de Actas de Reunión</h3>
<?php elseif (isset($_SESSION['psiquiatra'])): ?>
    <h3>Lista de Citas del Psiquiatra: <?= $_SESSION['identity']->nombre_apellidos ?></h3>
<?php endif; ?>

<?php if (isset($_SESSION['psiquiatra'])): ?>
    <div class="row">
        <div class="col-md-12" align="right">
            <a href="<?= base_url ?>acta/generar" type="button" class="btn btn-primary">
                + Acta de Reunión
            </a>
        </div>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['updated']) && $_SESSION['updated'] == 'complete'): ?>
    <strong class='alert-green'>Acta actualizada correctamente</strong>
    <?php
elseif (isset($_SESSION['updated']) && $_SESSION['updated'] != 'complete'):
    $error = $_SESSION['updated'];
    echo $error;
endif;
?>
<?php Utils::deleteSession('updated'); ?>
<table>
    <tr>
        <th>Id</th>
        <th>PSIQUIATRA</th>
        <th>ESTUDIANTE UNIVERSITARIO</th>
        <th>FECHA</th>
        <th>HORA</th>
        <th>ESTADO</th>
        <th>ACCIÓN</th>
    </tr>

    <?php while ($a = $actas->fetch_object()): ?>
        <tr>
            <td width="5%"><?= $a->id; ?></td>
            <?php
            $id = $a->id;
            $get_id = $acta->setId($id);
            $estudiante = $acta->getEstudianteById();
            $psiquiatra = $acta->getPsiquiatraById();
            ?>
            <td width="30%"><?= $psiquiatra->nombre_apellidos ?></td>
            <td width="30%"><?= $estudiante->nombre_apellidos; ?></td>
            <td width="10%"><?= $a->fecha; ?></td>
            <td width="10%"><?= $a->hora; ?></td>
            <td widht="10%"><?= $a->estado; ?></td>
            <td width="15%">
                <a type="button" class="btn btn-outline-primary btn-sm" href="<?= base_url ?>acta/imprimirActa&id=<?= $a->id ?>">Ver</a>
                <?php if (isset($_SESSION['psiquiatra'])): ?>
                    <a type="button" class="btn btn-outline-success btn-sm" href="<?= base_url ?>acta/editarActa&id=<?= $a->id ?>">Editar</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<div class="row">
    <img src="../assets/images/blanco.jpg" height="80" width="450"/>
</div>
<div class="row">
    <div class="col-md-12" align="right">
        <a href="<?= base_url ?>acta/imprimirLista" type="button" class="btn btn-success">
            Imprimir Lista
        </a>
    </div>
</div>
