<?php if (isset($a)): ?>
    <h3>Editar Acta de Reunión Nro.<?= $a->id ?></h3>
    <form action="<?= base_url ?>acta/update&id=<?= $a->id ?>" method="POST">
        <div class="row">
            <div class="form-group col-md-5">
                <label for="psiquiatra"><strong>Psiquiatra:</strong></br> <?= $psiquiatra->nombre_apellidos ?></label>
            </div>
            <div class="form-group col-md-6">
                <label for="estudiante"><strong>Estudiante Universitario:</strong></br><?= $estudiante->nombre_apellidos ?></label>
            </div>
        </div>
        </br>
        <div class = "row">
            <div class = "form-group col-md-7">
                <label>Dirección:</label>
                <input type = "text"class = "form-control" value = "Calle Los Girasoles 1448 dpto. 106"/>
            </div>
            <div class = "form-group col-md-4">
                <label>Ciudad:</label>
                <input type = "text" class = "form-control" value = "Lima"/>
            </div>
        </div>
        </br>
        <div class = "row">
            <div class = "form-group col-md-4">
                <label>Distrito:</label>
                <input type = "text"class = "form-control" value = "San Borja"/>
            </div>
            <div class = "form-group col-md-3">
                <label for = "fecha">Fecha:</label>
                <?php
                $fecha_actual = date("Y-m-d");
                $fecha_max = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
                ?>
                <input name="fecha" type="date" value="<?= $a->fecha ?>" min="<?= $fecha_actual ?>" max="<?= $fecha_max ?>" class="form-control"/>
            </div>
            <div class="form-group col-md-2">
                <label for="hora">Hora:</label>
                <input name="hora" type="time" value="<?= $a->hora ?>" min="09:00" max="19:00" class="form-control"/>
            </div>
            <div class="form-group col-md-2">
                <label for="estado">Estado:</label>
                <select class="form-select" name="estado">
                    <?php if ($a->estado == 'Generada'): ?>
                        <option selected>Generada</option>
                        <option>Asistida</option>
                        <option>Cancelada</option>
                        <option>Pendiente</option>
                    <?php elseif ($a->estado == 'Asistida'): ?>
                        <option>Generada</option>
                        <option selected>Asistida</option>
                        <option>Cancelada</option>
                        <option>Pendiente</option>
                    <?php elseif ($a->estado == 'Cancelada'): ?>
                        <option>Generada</option>
                        <option>Asistida</option>
                        <option selected>Cancelada</option>
                        <option>Pendiente</option>
                    <?php else: ?>
                        <option>Generada</option>
                        <option>Asistida</option>
                        <option>Cancelada</option>
                        <option selected>Pendiente</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        </br>
        <div class=row>
            <div class="col-md-3">
                <button type="submit" class="btn btn-dark">Actualizar Acta de Reunión</button>
            </div>
        </div>
    </form>
<?php endif; ?>
