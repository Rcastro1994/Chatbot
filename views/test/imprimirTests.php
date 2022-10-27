<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>Lista de Tests Psicológicos</title>
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
                <h2 text-align='center'>Lista de Tests Psicológicos Registrados</h2>
            </div>
            <br>
            <?php while ($t = $tests->fetch_object()): ?>
                <table text-align='left' border='1px #ccc'>
                    <tr>
                        <th>Id</th>
                        <td><?= $t->id; ?></td>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <td><?= $t->nombre; ?></td>
                    </tr>
                    <tr>
                        <th>Pregunta 1</th>
                        <td><?= $t->pregunta1; ?></td>
                    </tr>
                    <?php if ($t->pregunta2 != ''): ?>
                        <tr>
                            <th>Pregunta 2</th>
                            <td><?= $t->pregunta2; ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($t->pregunta3 != ''): ?>
                        <tr>
                            <th>Pregunta 3</th>
                            <td><?= $t->pregunta3; ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($t->pregunta4 != ''): ?>
                        <tr>
                            <th>Pregunta 4</th>
                            <td><?= $t->pregunta4; ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($t->pregunta5 != ''): ?>
                        <tr>
                            <th>Pregunta 5</th>
                            <td><?= $t->pregunta5; ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($t->pregunta6 != ''): ?>
                        <tr>
                            <th>Pregunta 6</th>
                            <td><?= $t->pregunta6; ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($t->pregunta7 != ''): ?>
                        <tr>
                            <th>Pregunta 7</th>
                            <td><?= $t->pregunta7; ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($t->pregunta8 != ''): ?>
                        <tr>
                            <th>Pregunta 8</th>
                            <td><?= $t->pregunta8; ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($t->pregunta9 != ''): ?>
                        <tr>
                            <th>Pregunta 9</th>
                            <td><?= $t->pregunta9; ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($t->pregunta10 != ''): ?>
                        <tr>
                            <th>Pregunta 10</th>
                            <td><?= $t->pregunta10; ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
                <br><br>
            <?php endwhile; ?>
        </body>
    </html>
