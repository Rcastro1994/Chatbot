<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>Generar Acta de Reunión</title>
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

            #sello{
                opacity: 0.5;
                float:right;
                margin-right: 100px;
            }

        </style>
    </head>
    <body>
        <?php if (isset($a)): ?>
            <div id="cabecera">
                <img src="<?= base_url ?>assets/images/logo-completo.png" width="150" height="50"/>
                <br>
                <br>
                <br>
                <h2 align="center">Acta de Reunión Nro.<?= $a->id ?></h2> 
            </div>
            <br>
            <br>
            <table id="tabla" text-align='left' border='0px #ccc'>
                <tr>
                    <th>Id - Acta de Reunión:</th>
                    <td><?= $a->id; ?></td>
                </tr>
                <br>
                <tr>
                    <th>Estudiante Universitario:</th>
                    <td><?= $estudiante->nombre_apellidos ?></td>
                </tr>
                <br>
                <tr>
                    <th>Psiquiatra:</th>
                    <td><?= $psiquiatra->nombre_apellidos ?></td>
                </tr>
                <br>
                <tr>
                    <th>Dirección:</th>
                    <td>Calle Los Girasoles 1448 dpto. 106</td>
                </tr>
                <br>
                <tr>
                    <th>Distrito:</th>
                    <td>San Borja</td>
                </tr>
                <br>
                <tr>
                    <th>Ciudad:</th>
                    <td>Lima</td>
                </tr>
                <br>
                <tr>
                    <th>Fecha:</th>
                    <td><?= $a->fecha; ?></td>
                </tr>
                <br>
                <tr>
                    <th>Hora:</th>
                    <td><?= $a->hora; ?></td>
                </tr>
                <tr>
                    <th>Estado:</th>
                    <td><?= $a->estado; ?></td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <img id="sello" src="<?= base_url ?>assets/images/sello.png" width="60" height="100"/>
        <?php endif; ?>
    </body>
</html>



