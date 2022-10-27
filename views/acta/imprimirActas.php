<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>Lista de Actas de Reunión</title>
        <style type="text/css">
            #cabecera img{
                float:left;
                margin-left: 30px;
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
                <h2 text-align='center'>Lista de Actas de Reunión</h2>
            </div>
            <br>
            <?php while ($a = $actas->fetch_object()): ?>
                <table text-align='left' border='1px #ccc'>
                    <tr>
                        <th>Id - Acta de Reunión</th>
                        <td><?= $a->id; ?></td>
                    </tr>
                    <?php
                    $id = $a->id;
                    $get_id = $acta->setId($id);
                    $estudiante = $acta->getEstudianteById();
                    $psiquiatra = $acta->getPsiquiatraById();
                    ?>
                    <tr>
                        <th>Estudiante Universitario</th>
                        <td><?=$estudiante->nombre_apellidos?></td>
                    </tr>
                    <tr>
                        <th>Psiquiatra</th>
                        <td><?=$psiquiatra->nombre_apellidos?></td>
                    </tr>
                    <tr>
                        <th>Dirección</th>
                        <td>Calle Los Girasoles 1448 dpto. 106</td>
                    </tr>
                    <tr>
                        <th>Distrito</th>
                        <td>San Borja</td>
                    </tr>
                    <tr>
                        <th>Ciudad</th>
                        <td>Lima</td>
                    </tr>
                    <tr>
                        <th>Fecha</th>
                        <td><?= $a->fecha; ?></td>
                    </tr>
                    <tr>
                        <th>Hora</th>
                        <td><?= $a->hora; ?></td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td><?= $a->estado; ?></td>
                    </tr>
                </table>
                <br><br>
            <?php endwhile; ?>
        </body>
    </html>
