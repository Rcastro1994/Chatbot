<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>Lista de Usuarios Registrados</title>
        <style type="text/css">

            #cabecera img{
                float:left;
                margin-left: 30px;
            }

            #tabla{
                width: 100%;
                margin-left: 30px;
            }

            #tabla th,td{
                font-size: 15px;
            }
        </style>
    </head>
    <body>
        <div align="right">
            <p><?= date('d-m-Y') ?></p>
        </div>
        <div id="cabecera">
            <img src="<?= base_url ?>assets/images/logo-completo.png" width="150" height="50"/>
            <br>
            <br>
            <br>
            <?php if (isset($_SESSION['admin'])): ?>
                <h2 text-align='center'>Lista de Usuarios Registrados</h2>
            <?php elseif (isset($_SESSION['psiquiatra'])): ?>
                <h2 text-align='center'>Lista de Estudiantes Asignados del Psiquiatra: <?= $_SESSION['identity']->nombre . " " . $_SESSION['identity']->apellidos ?></h2>
            <?php endif; ?>
        </div>
        <table text-align='center' border='1px #ccc'>
            <tr>
                <th>Id</th>
                <th>NOMBRES</th>
                <th>APELLIDOS</th>
                <th>CORREO</th>
                <th>ROL</th>
            </tr>

            <?php while ($usu = $usuarios->fetch_object()): ?>
                <tr>
                    <td><?= $usu->id; ?></td>
                    <td><?= $usu->nombre; ?></td>
                    <td><?= $usu->apellidos; ?></td>
                    <td><?= $usu->email; ?></td>
                    <td><?= $usu->rol; ?></td>
                </tr>
            <?php endwhile; ?>

        </table>
    </body>
</html>
