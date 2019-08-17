<?php
include_once("../../class/class.parameter.php");
$parametros = new parametros();
$par=$parametros->list_all();
foreach ($par["content"] as $key => $value) {
    define($value["parametro"], $value["valor"]);
}
?>
<page_footer>	
    <table style="width: 100%;">
        <tr>
            <td style="text-align: center; width: 100%; font-size: 11px; padding: 5px;"><?php echo "<strong>".constant("BUSSINES NAME")."</strong> - ".constant("DIRECCION_COMERCIAL").", Telf:+56 2 28820070 / contacto@heavytech.cl , www.heavytech.cl"; ?></td>
        </tr>
    </table>
</page_footer>