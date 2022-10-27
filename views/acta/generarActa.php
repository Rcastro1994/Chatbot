<h3>Generar Acta de Reunión</h3>
<?php if (isset($_SESSION['register']) && $_SESSION['register'] != 'complete'): ?>
    <?php $error = $_SESSION['register']; ?>
    <?php echo $error; ?>
<?php endif; ?>
<?php Utils::deleteSession('register'); ?>

<form action="<?= base_url ?>acta/save" method="POST">
    <div class="row">
        <div class="form-group col-md-5">
            <label for="psiquiatra"><strong>Psiquiatra:</strong></br> <?= $_SESSION['identity']->nombre_apellidos ?></label>
        </div>
        <?php $estudiantes = Utils::showEstudiantes(); ?>
        <div class="form-group col-md-6">
            <label for="estudiante">Estudiante Universitario:</label>   
            <select name="estudiante">
                <?php while ($est = $estudiantes->fetch_object()): ?>
                    <option>
                        <?= $est->nombre_apellidos ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    </div>
    </br>
    <div class="row">
        <div class="form-group col-md-7">
            <label>Dirección:</label>
            <input type="text"class="form-control" value="Calle Los Girasoles 1448 dpto. 106"/>
        </div>
        <div class="form-group col-md-4">
            <label>Ciudad:</label>
            <input type="text" class="form-control" value="Lima"/>
        </div>
    </div>
    </br>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Distrito:</label>
            <input type="text"class="form-control" value="San Borja"/>
        </div>
        <div class="form-group col-md-3">
            <label for="fecha">Fecha:</label>
            <?php
            $fecha_actual = date("Y-m-d");
            $fecha_max = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
            ?>
            <input name="fecha" type="date" min="<?= $fecha_actual ?>" max="<?= $fecha_max ?>" class="form-control"/>
        </div>
        <div class="form-group col-md-2">
            <label for="hora">Hora:</label>
            <input name="hora" type="time" min="09:00" max="19:00" class="form-control"/>
        </div>
    </div>
    </br>
    <div class=row>
        <div class="col-md-3">
            <button type="submit" class="btn btn-dark">Generar Acta de Reunión</button>
        </div>
    </div>
</form>