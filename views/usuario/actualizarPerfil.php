<?php if (isset($_SESSION['estudiante']) || isset($_SESSION['psiquiatra'])): ?>
    <h3>Actualizar Datos - Perfil de <?= $_SESSION['identity']->nombre ?> <?= $_SESSION['identity']->apellidos ?></h3>
    <div class="row">    
        <div class="col-md-6">
            <?php if (isset($_SESSION['update']) && $_SESSION['update'] == 'complete'): ?>
                <strong class='alert-green'>Datos actualizados correctamente</strong>
                <?php
            elseif (isset($_SESSION['update']) && $_SESSION['update'] != 'complete'):
                $error = $_SESSION['update'];
                echo $error;
            endif;
            ?>
            <form id="actualizar-datos" action="<?= base_url ?>usuario/update" method="POST" enctype="multipart/form-data">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?= $_SESSION['identity']->nombre ?>"/>
                <label for="apellidos">Apellidos:</label>
                <input type="text" name="apellidos" value="<?= $_SESSION['identity']->apellidos ?>"/>
                <label for="fnacimiento">Fecha de Nacimiento:</label>
                <?php
                $fecha_actual = date("Y-m-d");
                $fecha_min = date("Y-m-d", strtotime($fecha_actual . "-40 year"));
                $fecha_max = date("Y-m-d", strtotime($fecha_actual . "-16 year"));
                ?>
                <input type="date" name="fnacimiento" min="<?= $fecha_min ?>" max="<?= $fecha_max ?>" value="<?= $_SESSION['identity']->fnacimiento ?>"/>
                <label>Foto de Perfil:</label>
                <?php if ($_SESSION['identity']->imagen != null): ?>
                    <img src="../uploads/images/<?= $_SESSION['identity']->imagen ?>" width="100" heigth="100"/>
                <?php endif; ?>
                <input class="perfil" type="file" name="imagen" accept="image/*"/>
                <ul class="accion-cancelar">
                    <li><input type="submit" value="Actualizar"/></li>
                    <?php
                    if (isset($_SESSION['estudiante'])):
                        $cancelar = "perfilEstudiante";
                    elseif (isset($_SESSION['psiquiatra'])):
                        $cancelar = "perfilPsiquiatra";
                    endif;
                    ?>
                    <a href="<?= base_url ?>usuario/<?= $cancelar ?>" class="cancelar"><li>Cancelar</a>
                </ul>
            </form>
        </div>
        <div class="col-md-6">
            <img id="edit" src="../assets/images/edit.png"/>
        </div>
    </div>
<?php endif; ?>
