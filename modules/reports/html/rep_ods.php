<?php
include_once("./html/report_css.php");
global $titulo, $ntran, $ftran, $dtran, $cotiza,$datos_origen;
$cab=$cotiza["cab"];
$cab_cli=$cotiza["datos"];
$det=$cotiza["det"];
$art=$cotiza["art"];
$equipo=$datos_origen["content"];
$telefono = ($cab['tel_fijo']=="") ? "+56 9 ".$cab['tel_movil'] : "+56 2 ".$cab['tel_fijo']." / +56 9 ".$cab['tel_movil'] ;
?>
<page backtop="20mm" backbottom="20mm" backleft="10mm" backright="10mm" style="font-size: 12px;">
    <?php include_once("./html/report_header_lan.php"); ?>
    <?php include_once("./html/report_footer_lan.php"); ?>
    <h4>DATOS BASICOS</h4>
    <table style="width: 100%;" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width: 15%; text-align: left; "><strong>COTIZACION</strong></td>
            <td style="width: 30%; text-align: left;">COT-<?php echo $cab["cot_full"]; ?></td>
            <td style="width: 15%; text-align: left; "><strong>ODS</strong></td>
            <td style="width: 40%; text-align: left;">OS-ST<?php echo $cab["ods_full"]; ?></td>
        </tr>
        <tr>
            <td style="width: 15%; text-align: left; "><strong>RUT</strong></td>
            <td style="width: 30%; text-align: left;"><?php echo $cab_cli["code"]; ?></td>
            <td style="width: 15%; text-align: left; "><strong>CLIENTE</strong></td>
            <td style="width: 40%; text-align: left;"><?php echo $cab_cli["data"]; ?></td>
        </tr>
        <tr>
            <td style="width: 15%; text-align: left; "><strong>DIRECCION</strong></td>
            <td colspan="3" style="width: 85%; text-align: left;"><?php echo $cab_cli["direccion"]; ?></td>
        </tr>
        <tr>
            <td style="width: 15%; text-align: left; "><strong>TELEFONO</strong></td>
            <td style="width: 30%; text-align: left;"><?php echo $telefono; ?></td>
            <td style="width: 15%; text-align: left; "><strong>CONTACTO</strong></td>
            <td style="width: 40%; text-align: left;"><?php echo $cab_cli["contacto"]; ?></td>
        </tr>
        <tr>
            <td style="width: 15%; text-align: left; "><strong>EQUIPO</strong></td>
            <td colspan="3" style="width: 85%; text-align: left;"><?php echo $equipo["equipo"]." ".$equipo["marca"]." ".$equipo["modelo"].", SERIAL: #".$equipo["serial"]; ?></td>
        </tr>
    </table>
    <h4>COMPONENTE(S) / SISTEMA(S) / SERVICIO(S)</h4>
    <table style="width: 100%;" class="table_dets" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ffc000">
            <td rowspan="2" style="width: 2%; text-align: center; ">#</td>
            <td rowspan="2" style="width: 20%; text-align: center; ">SISTEMA</td>
            <td rowspan="2" style="width: 20%; text-align: center; ">COMPONENTE</td>
            <td rowspan="2" style="width: 20%; text-align: center; ">SERVICIO A APLICAR</td>
            <td colspan="2" style="width: 12%; text-align: center; ">HORAS</td>
            <td style="width: 6%; text-align: center; ">DIAS</td>
            <td colspan="2" style="width: 20%; text-align: center; ">FECHA</td>
        </tr>
        <tr bgcolor="#ffc000">
            <td style="width: 6%; text-align: center; ">TAL</td>
            <td style="width: 6%; text-align: center; ">TER</td>
            <td style="width: 6%; text-align: center; ">TALL</td>
            <td style="width: 10%; text-align: center; ">ENTRADA</td>
            <td style="width: 10%; text-align: center; ">SALIDA</td>
        </tr>
        <?php 
        if(!empty($det)){
            $count=$sum_hh_taller=$sum_hh_terreno=0;
            foreach ($det as $key => $value) {
                $count++;
                $sum_hh_terreno=$sum_hh_terreno+$value["hh_terreno"];
                $sum_hh_taller=$sum_hh_taller+$value["hh_taller"];
                echo '<tr class="row_dets">
                <td style="width: 2%;">'.$count.'</td>
                <td style="width: 20%;">'.$value["parte"].'</td>
                <td style="width: 20%;">'.$value["pieza"].'</td>
                <td style="width: 20%;">'.$value["articulo"].'</td>
                <td style="width: 6%; text-align: center; ">'.$value["hh_taller"].'</td>
                <td style="width: 6%; text-align: center; ">'.$value["hh_terreno"].'</td>
                <td style="width: 6%; text-align: center; ">'.$value["dias_taller"].'</td>
                <td style="width: 10%;">'.setDate($value["finicio"],"d-m-Y").'</td>
                <td style="width: 10%;">'.setDate($value["ffin"],"d-m-Y").'</td>
                </tr>
                ';
            }
            echo '<tr class="row_dets">
            <td colspan="4" style="text-align: center;">TOTAL DE HORAS</td>            
            <td style="text-align: center;">'.$sum_hh_taller.'</td>
            <td style="text-align: center;">'.$sum_hh_terreno.'</td>
            <td colspan="2" style="text-align: center; ">TOTAL HORAS</td>
            <td style="text-align: center;">'.($sum_hh_taller+$sum_hh_terreno).'</td>
            </tr>';
        }
        ?>
    </table>
    <?php 
    if(!empty($art)){
    ?>
    <h4>ARTICULOS / INSUMOS / SERVICIOS DE TERCEROS</h4>
    <table style="width: 100%;" class="table_dets" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ffc000">
            <td style="width: 5%; text-align: center; ">#</td>
            <td style="width: 15%; text-align: center; ">CODIGO</td>
            <td style="width: 35%; text-align: center; ">ITEM</td>
            <td style="width: 20%; text-align: center; ">CANT</td>
            <td style="width: 25%; text-align: center; ">TIPO</td>
        </tr>
    <?php
        $count=0;
        foreach ($art as $key => $value) {
            $count++;
            echo '<tr class="row_dets">
            <td>'.$count.'</td>
            <td>'.$value["codigo2"].'</td>
            <td>'.$value["articulo"].'</td>
            <td style="text-align: center; ">'.numeros($value["cant"],0).'</td>
            <td>'.$value["clasificacion"].'</td>
            </tr>
            ';
        }
    ?></table><?php
    }
    ?>
    <br>    
</page>