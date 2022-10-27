<?php if (isset($t)): ?>
    <h3><?= $t->nombre ?></h3>
    <div class="row">
        <div class="col-md-11">
            <?php if (isset($_SESSION['completed']) && $_SESSION['completed'] == 'complete'): ?>
                <strong class='alert-green'>Test completado</strong>
            <?php endif; ?>
            <form action="<?= base_url ?>test/saveRespuesta&id=<?= $t->id ?>" method="POST">
                <label for="respuesta1"><?= $t->pregunta1 ?></label>
                <p class="test-p">Sí: <input class="form-check-input" type="radio" name="respuesta1" value="Si"></p>
                <p class="test-p">No: <input class="form-check-input" type="radio" name="respuesta1" value="No"></p>
                <br>
                <?php if ($t->pregunta2 != ""): ?>
                    <label for="respuesta2"><?= $t->pregunta2 ?></label>
                    <p class="test-p">Sí: <input class="form-check-input" type="radio" name="respuesta2" value="Si"></p>
                    <p class="test-p">No: <input class="form-check-input" type="radio" name="respuesta2" value="No"></p>
                    <br>
                <?php endif; ?>
                <?php if ($t->pregunta3 != ""): ?>
                    <label for="respuesta3"><?= $t->pregunta3 ?></label>     
                    <p class="test-p">Sí: <input class="form-check-input" type="radio" name="respuesta3" value="Si"></p>
                    <p class="test-p">No: <input class="form-check-input" type="radio" name="respuesta3" value="No"></p>
                    <br>
                <?php endif; ?>
                <?php if ($t->pregunta4 != ""): ?>
                    <label for="respuesta4"><?= $t->pregunta4 ?></label>
                    <p class="test-p">Sí: <input class="form-check-input" type="radio" name="respuesta4" value="Si"></p>
                    <p class="test-p">No: <input class="form-check-input" type="radio" name="respuesta4" value="No"></p>
                    <br>
                <?php endif; ?>
                <?php if ($t->pregunta5 != ""): ?>
                    <label for="respuesta5"><?= $t->pregunta5 ?></label>
                    <p class="test-p">Sí: <input class="form-check-input" type="radio" name="respuesta5" value="Si"></p>
                    <p class="test-p">No: <input class="form-check-input" type="radio" name="respuesta5" value="No"></p>
                    <br>
                <?php endif; ?>
                <?php if ($t->pregunta6 != ""): ?>
                    <label for="respuesta6"><?= $t->pregunta6 ?></label>
                    <p class="test-p">Sí: <input class="form-check-input" type="radio" name="respuesta6" value="Si"></p>
                    <p class="test-p">No: <input class="form-check-input" type="radio" name="respuesta6" value="No"></p>
                    <br>
                <?php endif; ?>
                <?php if ($t->pregunta7 != ""): ?>
                    <label for="respuesta7"><?= $t->pregunta7 ?></label>
                    <p class="test-p">Sí: <input class="form-check-input" type="radio" name="respuesta7" value="Si"></p>
                    <p class="test-p">No: <input class="form-check-input" type="radio" name="respuesta7" value="No"></p>
                    <br>
                <?php endif; ?>
                <?php if ($t->pregunta8 != ""): ?>
                    <label for="respuesta8"><?= $t->pregunta8 ?></label>
                    <p class="test-p">Sí: <input class="form-check-input" type="radio" name="respuesta8" value="Si"></p>
                    <p class="test-p">No: <input class="form-check-input" type="radio" name="respuesta8" value="No"></p>
                    <br>
                <?php endif; ?>
                <?php if ($t->pregunta9 != ""): ?>
                    <label for="respuesta9"><?= $t->pregunta9 ?></label>
                    <p class="test-p">Sí: <input class="form-check-input" type="radio" name="respuesta9" value="Si"></p>
                    <p class="test-p">No: <input class="form-check-input" type="radio" name="respuesta9" value="No"></p>
                    <br>
                <?php endif; ?>
                <?php if ($t->pregunta10 != ""): ?>
                    <label for="respuesta10"><?= $t->pregunta10 ?></label>
                    <p class="test-p">Sí: <input class="form-check-input" type="radio" name="respuesta10" value="Si"></p>
                    <p class="test-p">No: <input class="form-check-input" type="radio" name="respuesta10" value="No"></p>
                <?php endif; ?>
                <input type="submit" value="Enviar"/>
            </form>
        </div>
    </div>
<?php endif; ?>
