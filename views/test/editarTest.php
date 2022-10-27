<?php if (isset($t)): ?>
    <h3>Editar Test Psicológico:  <?= $t->nombre ?></h3>
    <form action='<?= base_url ?>test/update&id=<?= $t->id ?>' method='POST'>
        <div class='col-md-11'>
            <table class='table table-hover'>
                <tr>
                    <th width='20%'>Nombre</th>
                    <td width='80%'><input type="text" name="nombre" value="<?= $t->nombre ?>"/></td>
                </tr>
                <tr>
                    <th width='20%'>Pregunta 1</th>
                    <td width='80%'><input type="text" name="pregunta1" value="<?= $t->pregunta1 ?>"/></td>
                </tr>
                <tr>
                    <th width='20%'>Pregunta 2</th>
                    <td width='80%'><input type="text" name="pregunta2" value="<?= $t->pregunta2 ?>"/></td>
                </tr>
                <tr>
                    <th width='20%'>Pregunta 3</th>
                    <td width='80%'><input type="text" name="pregunta3" value="<?= $t->pregunta3 ?>"/></td>
                </tr>
                <tr>
                    <th width='20%'>Pregunta 4</th>
                    <td width='80%'><input type="text" name="pregunta4" value="<?= $t->pregunta4 ?>"/></td>
                </tr>
                <tr>
                    <th width='20%'>Pregunta 5</th>
                    <td width='80%'><input type="text" name="pregunta5" value="<?= $t->pregunta5 ?>"/></td>
                </tr>
                <tr>
                    <th width='20%'>Pregunta 6</th>
                    <td width='80%'><input type="text" name="pregunta6" value="<?= $t->pregunta6 ?>"/></td>
                </tr>
                <tr>
                    <th width='20%'>Pregunta 7</th>
                    <td width='80%'><input type="text" name="pregunta7" value="<?= $t->pregunta7 ?>"/></td>
                </tr>
                <tr>
                    <th width='20%'>Pregunta 8</th>
                    <td width='80%'><input type="text" name="pregunta8" value="<?= $t->pregunta8 ?>"/></td>
                </tr>
                <tr>
                    <th width='20%'>Pregunta 9</th>
                    <td width='80%'><input type="text" name="pregunta9" value="<?= $t->pregunta9 ?>"/></td>
                </tr>
                <tr>
                    <th width='20%'>Pregunta 10</th>
                    <td width='80%'><input type="text" name="pregunta10" value="<?= $t->pregunta10 ?>"/></td>
                </tr>          
            </table>
        </div>
        <div align='right' class='col-md-11'>
            <input type="submit" value="Actualizar Test"/>
        </div>
    </form>
<?php else: ?>
    <h3>El test psicológico no existe</h3>
    <img id="image-404" src="../assets/images/404.png"/>
<?php endif; ?>

