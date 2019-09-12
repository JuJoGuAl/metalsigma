<?php
include_once("./html/report_css.php");
global $titulo, $ntran, $ftran, $dtran, $datos_origen;
$cab=$datos_origen["cab"];
$det=$datos_origen["det"];
$telefono = ($cab['tel_fijo']=="") ? "+56 9 ".$cab['tel_movil'] : "+56 2 ".$cab['tel_fijo']." / +56 9 ".$cab['tel_movil'] ;
?>
<page backtop="20mm" backbottom="20mm" backleft="10mm" backright="10mm" style="font-size: 12px;">
    <?php include_once("./html/report_footer_lan.php"); ?>
    <page_header>
        <table style="width: 100%; padding-top: 15px;">
            <tr>
                <td style="width:20%; padding-left: 20px; padding-right: -20px" align="left"><img src="../../images/logo_report.png"></td>
                <td style="width:60%;" align="center"><?php echo $titulo; ?></td>
                <td style="width:20%; padding-left: 3px; text-align: right; font-size: 12px;" align="rigth">
                    <p style="padding: 0; margin: 2;"><strong><?php echo $ntran; ?>: </strong><?php echo $dtran; ?></p>
                    <p style="padding: 0; margin: 2;"><strong>FECHA: </strong><?php echo $ftran; ?></p>
                    <p style="padding: 0; margin: 2;"><strong>PAGINA: </strong>[[page_cu]] / [[page_nb]]</p>
                </td>
            </tr>
        </table>
    </page_header>
    <h4>DATOS DEL PROVEEDOR</h4>
    <table style="width: 100%;" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width: 15%; text-align: left; "><strong>RUT</strong></td>
            <td style="width: 30%; text-align: left;"><?php echo $cab["code"]; ?></td>
            <td style="width: 15%; text-align: left; "><strong>PROVEEDOR</strong></td>
            <td style="width: 40%; text-align: left;"><?php echo $cab["data"]; ?></td>
        </tr>
        <tr>
            <td style="width: 15%; text-align: left; "><strong>DIRECCION</strong></td>
            <td colspan="3" style="width: 85%; text-align: left;"><?php echo $cab["direccion"]; ?></td>
        </tr>
        <tr>
            <td style="width: 15%; text-align: left; "><strong>TELEFONO</strong></td>
            <td style="width: 30%; text-align: left;"><?php echo $telefono; ?></td>
            <td style="width: 15%; text-align: left; "><strong>COND. DE PAGO</strong></td>
            <td style="width: 40%; text-align: left;"><?php echo $cab["pago"]; ?></td>
        </tr>
    </table>
    <h4>DETALLES DE LA ODC</h4>
    <table style="width: 100%;" class="table_dets" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ffc000">
            <td style="width: 5%; text-align: center; ">#</td>
            <td style="width: 15%; text-align: center; ">CODIGO</td>
            <td style="width: 30%; text-align: center; ">ITEM</td>
            <td style="width: 10%; text-align: center; ">CANT</td>
            <td style="width: 10%; text-align: center; ">COSTO U</td>
            <td style="width: 10%; text-align: center; ">IMP (%)</td>
            <td style="width: 10%; text-align: center; ">IMP</td>
            <td style="width: 10%; text-align: center; ">COSTO T</td>
        </tr>
        <?php 
        if(!empty($det)){
            $count=$total=$subtotal=$imp=0;
            foreach ($det as $key => $value) {
                $count++;
                $total = $total + $value["costot"];
                $subtotal = $subtotal + ($value["costou"]*$value["cant"]);
                $imp = $imp + $value["imp_m"];
                echo '<tr class="row_dets">
                <td style="width: 5%;">'.$count.'</td>
                <td style="width: 15%;">'.$value["codigo2"].'</td>
                <td style="width: 30%;">'.$value["articulo"].'</td>
                <td style="width: 10%; text-align: center; ">'.numeros($value["cant"],0).'</td>
                <td style="width: 10%; text-align: center; ">'.numeros($value["costou"],0).'</td>
                <td style="width: 10%; text-align: center; ">'.numeros($value["imp_p"],0).' % </td>
                <td style="width: 10%; text-align: center; ">'.numeros($value["imp_m"],0).'</td>
                <td style="width: 10%; text-align: center; ">'.numeros($value["costot"],0).'</td>
                </tr>
                ';
            }
            echo '<tr class="row_dets" style="text-align: right;">
            <td colspan="7" style="padding-right: 5px; border: 0px;"><strong>TOTAL NETO</strong></td><td style="text-align: center; ">'.numeros($subtotal,0).'</td>
            </tr>';
            echo '<tr class="row_dets" style="text-align: right;">
            <td colspan="7" style="padding-right: 5px; border: 0px;"><strong>TOTAL IMP</strong></td><td style="text-align: center; ">'.numeros($imp,0).'</td>
            </tr>';
            echo '<tr class="row_dets" style="text-align: right;">
            <td colspan="7" style="padding-right: 5px; border: 0px;"><strong>TOTAL</strong></td><td style="text-align: center; ">'.numeros($total,0).'</td>
            </tr>';
        }
        ?>
    </table>
    <br>
    <table class="firmas" style="padding-left: 10px; padding-top: 50px;" cellspacing='0' border='0' align="left">
        <tr>
            <td style="width:60%;" valign="top" align="left"><h4><?php echo $cab["crea_user"]; ?></h4><p style="padding-top: -10px;"><?php echo $cab["cargo_crea"]; ?></p></td>
        </tr>
    </table>
</page>