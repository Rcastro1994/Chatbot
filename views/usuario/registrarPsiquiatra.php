<h3>Registrar Psiquiatra</h3>
<div class="row">
    <div class="col-md-6">
        <?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
            <strong class='alert-green'>Registro completado correctamente</strong>
            <?php
        elseif (isset($_SESSION['register']) && $_SESSION['register'] != 'complete'):
            $error = $_SESSION['register'];
            echo $error;
        endif;
        ?>
        <?php Utils::deleteSession('register'); ?>
        <form id="form-registrarp" action="<?= base_url ?>usuario/save" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre"/>
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos"/>
            <?php
            $fecha_actual = date("Y-m-d");
            $fecha_min = date("Y-m-d", strtotime($fecha_actual . "-80 year"));
            $fecha_max = date("Y-m-d", strtotime($fecha_actual . "-18 year"));
            ?>
            <label for="fnacimiento">Fecha de Nacimiento:</label>
            <input type="date" min="<?=$fecha_min?>" max="<?=$fecha_max?>" name="fnacimiento"/>
            <label for="email">Email:</label>
            <input type="email" name="email"/>
            <label for="password">Contraseña:</label>
            <input type="password" name="password"/>
            <label for="password2">Repetir contraseña:</label>
            <input type="password" name="password2"/>
            <label for="imagen">Foto de Perfil:</label>
            <input type="file" name="imagen" accept="image/*"/>
            <ul class="accion-cancelar">
                <li><input type="submit" value="Registrar"/></li>
                <li><a href="<?= base_url ?>usuario/gestion" class="cancelar">Regresar</a></li>
            </ul>
        </form>
    </div>
    <div class="col-md-6">
        <img id="img-registrarp" src="../assets/images/queesunpsiquiatra.jpg"/>
    </div>
</div>