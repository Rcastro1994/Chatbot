<h3>Registrar Test Psicológico</h3>

<div class="form-group">
    <div class="row">
        <?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
            <strong class='alert-green'>Registro completado correctamente</strong>
            <?php
        elseif (isset($_SESSION['register']) && $_SESSION['register'] != 'complete'):
            $error = $_SESSION['register'];
            echo $error;
        endif;
        ?>
        <?php Utils::deleteSession('register'); ?>
    </div>
    </br>
    <form action="<?= base_url ?>test/save" method="POST">
        <div class="row">
            <div align="center" class="col-md-6">
                <input type="text" name="nombre" placeholder="Nombre de Test"/>
            </div>
        </div>
        <div class="row">
            <div align="left" class="col-md-12">
                <table class="table table-hover" id="dynamic_field">
                    <tr>
                        <td><input type="text" name="pregunta1" placeholder="Pregunta" class="form-control name_list" /></td>
                        <td><button type="button" name="agregarCampo" id="add" class="btn btn-outline-success">Agregar Campo</button></td>
                    </tr>
                </table>
            </div>
        </div>
        <div align="right" class="col-md-11">
            <input type="submit" class="btn btn-outline-primary" value="Registrar Test" /> 
        </div>
    </form>
</div>
<br>
<div class="row">
    <img src="../assets/images/blanco.jpg" height="80" width="450"/>
</div>

<script>
    $(document).ready(function () {
        var i = 1;
        $('#add').click(function () {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="pregunta[]" placeholder="Nueva Pregunta" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

        $('#submit').click(function () {
            $.ajax({
                url: "name.php",
                method: "POST",
                data: $('#add_name').serialize(),
                success: function (data)
                {
                    alert(data);
                    $('#add_name')[0].reset();
                }
            });
        });

    });
</script>
