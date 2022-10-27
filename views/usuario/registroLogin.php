<div class="row">
    <div class="col-md-6">
        <h3>Login</h3>
    </div>
    <div class="col-md-6">
        <h3>Registro</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?php if (isset($_SESSION['error_login'])): ?>
            <strong class="alert-red"><?= $_SESSION['error_login'] ?></strong>
        <?php endif; ?>
        <form id="form-login" action="<?= base_url ?>usuario/login" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email"/>
            <label for="password">Contraseña:</label>
            <input type="password" name="password"/>
            <input type="submit" value="Ingresar"/>
        </form>
    </div>
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
        <form id="form-signup" action="<?= base_url ?>usuario/save" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre"/>
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos"/>
            <label for="fnacimiento">Fecha de Nacimiento:</label>
            <?php
            $fecha_actual = date("Y-m-d");
            $fecha_min = date("Y-m-d", strtotime($fecha_actual . "-40 year"));
            $fecha_max = date("Y-m-d", strtotime($fecha_actual . "-16 year"));
            ?>
            <input type="date" min="<?=$fecha_min?>" max="<?=$fecha_max?>" name="fnacimiento"/>
            <label for="email">Email:</label>
            <input type="email" name="email"/>
            <label for="password">Contraseña:</label>
            <input type="password" name="password"/>
            <label for="password2">Repita contraseña:</label>
            <input type="password" name="password2"/>
            <label for="imagen">Foto de Perfil:</label>
            <input type="file" name="imagen" accept="image/*"/>
            <input type="submit" value="Registrarse"/>
        </form>
    </div>
</div>
