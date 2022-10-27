<?php
require '../vendor/autoload.php';
require_once '../models/usuario.php';
require_once '../controllers/UsuarioController.php';

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf();

ob_start();
?>
<table>
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

<div class="row">
    <img src="../assets/images/blanco.jpg" height="30" width="450"/>
</div>
<?php
$html .= ob_get_clean();

$html2pdf->writeHTML($html);
$html2pdf->output();
?>
