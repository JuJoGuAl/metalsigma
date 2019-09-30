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
    <h4>DATOS DE LA COTIZACION</h4>
    <strong>COTIZACION: </strong><?php echo $cab["origen"]; ?> - <strong>SUB COTIZACION: </strong><?php echo $cab["correlativo"]; ?>
    <br><br>
    <strong>EQUIPO: </strong><?php echo $equipo["equipo"]." ".$equipo["marca"]." ".$equipo["modelo"].", SERIAL: #".$equipo["serial"]; ?>
    <h4>DATOS DEL CLIENTE</h4>
    <table style="width: 100%;" align="center" cellpadding="0" cellspacing="0">
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
    </table>
    <h4>COMPONENTE(S) / SISTEMA(S) COTIZADO(S)</h4>
    <table style="width: 100%;" class="table_dets" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#ffc000">
            <td rowspan="2" style="width: 2%; text-align: center; ">#</td>
            <td rowspan="2" style="width: 24%; text-align: center; ">SISTEMA</td>
            <td rowspan="2" style="width: 24%; text-align: center; ">COMPONENTE</td>
            <td rowspan="2" style="width: 24%; text-align: center; ">SERVICIO A APLICAR</td>
            <td style="width: 6%; text-align: center; ">DIAS</td>
            <td colspan="2" style="width: 20%; text-align: center; ">FECHA</td>
        </tr>
        <tr bgcolor="#ffc000">
            <td style="width: 6%; text-align: center; ">TAL</td>
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
                <td style="width: 24%;">'.$value["parte"].'</td>
                <td style="width: 24%;">'.$value["pieza"].'</td>
                <td style="width: 24%;">'.$value["articulo"].'</td>
                <td style="width: 6%; text-align: center; ">'.$value["dias_taller"].'</td>
                <td style="width: 10%;">'.setDate($value["finicio"],"d-m-Y").'</td>
                <td style="width: 10%;">'.setDate($value["ffin"],"d-m-Y").'</td>
                </tr>
                ';
            }
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
            <td style="width: 20%; text-align: center; ">ITEM</td>
            <td style="width: 20%; text-align: center; ">CANT</td>
            <td style="width: 20%; text-align: center; ">PRECIO</td>
            <td style="width: 20%; text-align: center; ">TIPO</td>
        </tr>
    <?php
        $count=0;
        foreach ($art as $key => $value) {
            $count++;
            echo '<tr class="row_dets">
            <td style="width: 5%;">'.$count.'</td>
            <td style="width: 15%;">'.$value["codigo2"].'</td>
            <td style="width: 20%;">'.$value["articulo"].'</td>
            <td style="width: 20% text-align: center; ">'.numeros($value["cant"],0).'</td>
            <td style="width: 20% text-align: center; ">'.numeros($value["precio"],0).'</td>
            <td style="width: 20%;">'.$value["clasificacion"].'</td>
            </tr>
            ';
        }
    ?></table><?php
    }
    ?>
    <br>
    <h4>OBSERVACIONES</h4>
    <p><?php echo $cab["notas"]; ?></p>
    <h4>OFERTA ECONOMICA</h4>
    <p>EL PRECIO DE LOS SERVICIOS DESCRITOSEN LOS PUNTOS ANTERIORES SE DETALLA A CONTINUACION(PRECIOS EN PESOS CHILENOS):</p>
    <table style="width: 60%; " align="left" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width: 50%; text-align: left;">SERVICIO TECNICO (M.O.): </td>
            <td style="width: 50%; text-align: right;"><strong>$ <?php echo numeros($cab["m_serv"],0); ?></strong></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">REPUESTOS: </td>
            <td style="width: 50%; text-align: right;"><strong>$ <?php echo numeros($cab["m_rep"],0); ?></strong></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">INSUMOS: </td>
            <td style="width: 50%; text-align: right;"><strong>$ <?php echo numeros($cab["m_ins"],0); ?></strong></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">SERVICIOS TERCERIZADOS: </td>
            <td style="width: 50%; text-align: right;"><strong>$ <?php echo numeros($cab["m_stt"],0); ?></strong></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">TRASLADOS: </td>
            <td style="width: 50%; text-align: right;"><strong>$ <?php echo numeros($cab["m_tra"],0); ?></strong></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">MISCELANEOS: </td>
            <td style="width: 50%; text-align: right;"><strong>$ <?php echo numeros($cab["m_misc"],0); ?></strong></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">SUB TOTAL: </td>
            <td style="width: 50%; text-align: right;"><strong>$ <?php echo numeros($cab["m_subt"],0); ?></strong></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">DESCUENTOS ( <?php echo numeros($cab["m_descp"],0); ?> %): </td>
            <td style="width: 50%; text-align: right;"><strong>$ <?php echo numeros($cab["m_desc"],0); ?></strong></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">VALOR NETO: </td>
            <td style="width: 50%; text-align: right;"><strong>$ <?php echo numeros($cab["m_neto"],0); ?></strong></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">IMPUESTOS ( <?php echo numeros($cab["m_impp"],0); ?> %): </td>
            <td style="width: 50%; text-align: right;"><strong>$ <?php echo numeros($cab["m_imp"],0); ?></strong></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">VALOR TOTAL: </td>
            <td style="width: 50%; text-align: right;"><strong>$ <?php echo numeros($cab["m_bruto"],0); ?></strong></td>
        </tr>
    </table>
    <h4>POLITICA DE PAGO</h4>
    <p>EL PAGO DEBE SER EFECTUADO A MAS TARDAR <strong><?php echo $cab_cli["pago"] ?></strong> CORRIDOS, DESPUES DE HABER SIDO RECIBIDA LA ORDEN DE COMPRA.<br><br>LOS PAGOS DEBEN SER REALIZADOS MEDIANTE TRANSFERENCIA ELECTRONICA O DEPOSITO A LA SIGUIENTE CUENTA BANCARIA:</p>
    <table style="width: 100%;" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width: 50%; text-align: left;">RAZON SOCIAL: Heavytech SpA<br>RUT: 76.622.315-k<br>Cuenta corriente: 70861846 (Banco BCI)<br>Email: ventas@heavytech.cl</td>
            <td style="width: 50%; text-align: left;"><h4>VALIDEZ DE LA COTIZACION</h4><p>ESTA COTIZACION ES VALIDA POR 30 DIAS.</p></td>
        </tr>
    </table><br>
    <h4>POLITICA DE GARANTIA</h4>
    <p>LA POLITICA DE GARANTIA PARA EL SERVICIO DE REPARACION INCLUYE UN PERIODO DE OPERACION DE 1.000 HORAS O 1 AÑO DESDE LA FECHA DE FACTURACION DEL SERVICIO, FINALIZANDO CON LA PRIMERA CONDICION QUE SE CUMPLA.</p>
    <p>LA GARANTIA NO SERA APLICABLE EN LOS SIGUIENTES CASOS:</p>
    <ul>
        <li>EL EQUIPO O COMPONENTE EVIDENCIA DESPERFECTOS OCASIONADOS POR NEGLIGENCIA O MALA OPERACION O USO POR PARTE DEL CLIENTE.</li>
        <li>EL CLIENTE INTERVINO EL COMPONENTE O SISTEMA REPARADO POR <strong><?php echo constant("EMP_NOM"); ?></strong>.</li>
        <li>EL MONTAJE DEL COMPONENTE NO SE REALIZO DE ACUERDO CON EL MANUAL DE PROCEDIMIENTOS DEL FABRICANTE, EN CASO DE QUE EL MONTAJE DEL COMPONENTE NO SEA REALIZADO POR <strong><?php echo constant("EMP_NOM"); ?></strong>.</li>
        <li>EL EQUIPO PRESENTA DESPERFECTOS EN UN SISTEMA O COMPONENTE NO INTERVENIDO POR <strong><?php echo constant("EMP_NOM"); ?></strong>.</li>
        <li>EL EQUIPO O COMPONENTE NO HA SIDO MANTENIDO DE ACUERDO CON EL PLAN DE MANTENIMIENTO RECOMENDADO POR EL FABRICANTE.</li>
    </ul>
    <h4>CONSIDERACIONES GENERALES</h4>
    <p>SERVICIO EN TERRENO:</p>
    <ul>
        <li>EN CASO DE QUE POR RAZONES AJENAS A <strong><?php echo constant("EMP_NOM"); ?></strong> EL TRABAJO NO PUEDA SER EJECUTADO EN LA FECHA ACORDADA CON EL CLIENTE, YA SEA POR INDISPONIBILIDAD DEL EQUIPO, INDISPONIBILIDAD DE LOS REPUESTOS EN CASO DE SER SUMINISTRADOS POR EL CLIENTE, ETC., SE REALIZARA UN COBRO ADICIONAL DE 15 UF POR CADA JORNADA DE TRABAJO PERDIDA MAS GASTOS DE TRASLADOS, LO QUE SE SUMARA AL VALOR DEL SERVICIO SEÑALADO EN ESTA COTIZACION.</li>
    </ul>
    <p>SERVICIO EN TALLER:</p>
    <ul>
        <li>UNA VEZ EMITIDO EL PRESUPUESTO DE REPARACION, EL CLIENTE CONTARA CON 5 DIAS HABILES PARA LA APROBACION DEL PRESUPUESTO. EN CASO DE NO ACEPTAR EL PRESUPUESTO, EL CLIENTE CONTARA CON 3 DIAS PARA EL RETIRO DEL EQUIPO, PREVIA CANCELACION DE LOS GASTOS DE EVALUACION.</li>
        <li>EN CASO DE QUE EL CLIENTE DEFINA SUMINISTRAR LOS REPUESTOS PARA LA REPARACION, ESTE CONTARA CON 10 DIA HABILES PARA LA ENTREGA DE LA TOTALIDAD DE LOS REPUESTOS REQUERIDOS PARA LA REPARACION A <strong><?php echo constant("EMP_NOM"); ?></strong>.</li>
        <li>TODO DIA ADICIONAL A LA APROBACION DEL PRESUPUESTO O A LA ENTREGA DE REPUESTOS POR PARTE DEL CLIENTE, TENDRA UN COSTO ADICIONAL POR CONCEPTO DE ARRIENDO DE NAVE DE TRABAJO DE 1 UF POR DIA PARA UN EQUIPO Y DE 0,35 UF POR DIA PARA UN COMPONENTE.</li>
        <li>EN CASO DE QUE EL EQUIPO O COMPONENTE NO SEA RETIRADO, PREVIA CANCELACION DE LOS GASTOS DE EVALUACION Y ARRIENDO DE NAVE, ANTES DE 60 DIAS CORRIDOS DESPUES DE EMITIDO EL PRESUPUESTO O INFORME DE REPARACION, <strong><?php echo constant("EMP_NOM"); ?></strong> TENDRA LOS DERECHOS SOBRE EL EQUIPO PARA SU DISPOSICION FINAL.</li>
    </ul>
    <p>SERVICIO DE DIAGNOSTICO:</p>
    <ul>
        <li>EL SERVICIO DE DIAGNOSTICO CONSIDERA LA EJECUCION DE UN CONJUNTO DE PRUEBAS, OPERATIVAS, VISUALES E INSTRUMENTALES PARA DETERMINAR LA CAUSA RAIZ DE UN PROBLEMA QUE EL EQUIPO O COMPONENTE PRESENTE. EL SERVICIO DE DIAGNOSTICO NO INCLUYE LA REPARACION DEL EQUIPO O COMPONENTE.</li>
        <li>EN CASO DE QUE EL EQUIPO O COMPONENTE NO PRESENTE DESPERFECTO EN SU OPERACION, EL SERVICIO DE DIAGNOSTICO DEBE SER CANCELADO DE IGUAL MANERA.</li>
    </ul>
    <br>
    <table class="firmas" style="padding-left: 55px;" cellspacing='0' border='0' align="left">
        <tr>
            <td style="width:60%;" valign="top" align="left"><h4><?php echo $cab["crea_user"]; ?></h4><p style="padding-top: -10px;"><?php echo $cab["cargo_crea"]; ?></p></td>
        </tr>
    </table>
</page>