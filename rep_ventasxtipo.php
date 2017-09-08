<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{	cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");

//Definición de variables
	$hoy=date('Y-m-d');
	$inicio=$_POST['fechaini'];
	$final=$_POST['fechafin'];
	
	$selec="SELECT count(f.factura) as factura, sum(f.etico) as etico, sum(f.popular) as popular, sum(f.leches) as leches, sum(f.generico) as generico, sum(f.total) as total FROM facturas as f, cliente as c 
			WHERE f.Fecha >= '$inicio' AND f.Fecha <= '$final' AND c.tipo_cliente in('A','B','C','D','E','G','H') AND c.nit=f.cliente";
	$datosm1=mysql_query($selec,$link);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Dise&ntilde;o y Programaci&oacute;n LDCP</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<style type="text/css">
<!--
.Estilo53 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<style type="text/css">
<!--
.Estilo54 {font-size: 14px}
-->
</style>
<style type="text/css">
<!--
.Estilo55 {font-weight: bold}
-->
</style>
<style type="text/css">
<!--
.Estilo56 {font-size: 18px}
-->
</style>
<style type="text/css">
<!--
.Estilo57 {font-size: 18}
-->
</style>
<style type="text/css">
<!--
.Estilo58 {font-size: 9px}
-->
</style>
<style type="text/css">
<!--
.Estilo59 {color: #FF0000}
-->
</style>
<style type="text/css">
<!--
.Estilo60 {color: #000000}
-->
</style>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
-->
</style><!-- InstanceEndEditable -->
<link href="tablas-eec.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></HEAD>

<BODY>
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
  <form action="" method="post" name="form1" class="Estilo48">
    <table width="65%" border="1" align="center" cellpadding="1" cellspacing="1" frame="border" rules="all">
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td width="18%">Fecha inicio
       <? if (($Nivel==1) || ($Nivel==2)) { $fecha1=date('Y-m-01'); } else { $fecha1=$hoy; }?></td>
            <td width="23%"><img src="images/iconos/ew_calendar.gif" alt="Seleccione una fecha" name="cx_FECHA" id="cx_FECHA3" style="cursor:pointer;cursor:hand;">
              <input type="text" name="fechaini" id="fechaini" size="10" maxlength="10" value="<?php if(@$fecha1=='')@$fecha1=date('d-m-Y'); echo htmlspecialchars(@$fecha1) ?>"></td>
            <td width="59%" rowspan="2" align="center" valign="middle"><input type="submit" name="Submit3" value="Realizar Reporte"></td>
          </tr>
          <tr>
            <td>Fecha final</td>
            <td><img src="images/iconos/ew_calendar.gif" alt="Seleccione una fecha" name="cx_FECHA" id="cx_FECHA4" style="cursor:pointer;cursor:hand;">
              <input type="text" name="fechafin" id="fechafin" size="10" maxlength="10" value="<?php if(@$fecha=='')@$fecha=date('Y-m-d'); echo htmlspecialchars(@$fecha) ?>"></td>
            </tr>
        </table></td>
      </tr>
    </table>
<p>&nbsp;    </p>
    <table width="70%" border="0" align="center">
      <tr>
        <td><table width="100%" border="1" cellpadding="1" cellspacing="1" frame="box" rules="rows">
          <tr>
            <td colspan="6" bgcolor="#7E9DE5"><div align="center" class="Estilo71 Estilo49"><strong>REPORTE DE VENTAS </strong></div></td>
          </tr>
          <tr bgcolor="#D9E9CE">
            <td colspan="6"><div align="center" class="Estilo73 Estilo53 Estilo54">Per&iacute;odo: <span class="Estilo49"><? echo $inicio ?></span> al <span class="Estilo49"><? echo $final ?></span></div></td>
          </tr>
          <tr bordercolor="#ECE9D8" bgcolor="#FFFFCC">
            <td height="34" bgcolor="#7E9DE5"><div align="center" class="Estilo72 Estilo53 Estilo54 Estilo55">
                <div align="center">FACTURAS</div>
            </div></td>
            <td bgcolor="#7E9DE5"><div align="center" class="Estilo54 Estilo53"><strong><span class="Estilo72">ETICO</span></strong></div></td>
            <td bgcolor="#7E9DE5"><div align="center" class="Estilo54 Estilo53"><strong><span class="Estilo72">POPULAR</span></strong></div></td>
            <td align="center" bgcolor="#7E9DE5"><span class="Estilo54 Estilo53"><strong><span class="Estilo72">LECHES</span></strong></span></td>
            <td align="center" bgcolor="#7E9DE5"><span class="Estilo54 Estilo53"><strong><span class="Estilo72">GENERICO</span></strong></span></td>
            <td bgcolor="#7E9DE5"><div align="center" class="Estilo54 Estilo53"><strong><span class="Estilo72">TOTAL GENERAL </span></strong></div></td>
          </tr>
          <tr bordercolor="#9CD8A7">
            <? 
		while($report=mysql_fetch_array($datosm1))
		{
			$facturas=$report['factura'];
			$etico=$report['etico'];
			$popular=$report['popular'];
			$leches=$report['leches'];
			$generic=$report['generico'];
			$total=$report['total'];
		?>
            <td height="38" bgcolor="#D9E9CE"><div align="center" class="Estilo53 Estilo54 Estilo56 Estilo57"><? echo $facturas ?></div></td>
            <td bordercolor="#9CD8A7" bgcolor="#F0F0F0"><div align="center" class="Estilo53 Estilo57"><? echo number_format($etico,2) ?></div></td>
            <td bgcolor="#D9E9CE"><div align="center" class="Estilo53 Estilo57"><? echo number_format($popular,2) ?></div></td>
            <td align="center" bgcolor="#F0F0F0"><span class="Estilo53 Estilo57"><? echo number_format($leches,2) ?></span></td>
            <td align="center" bgcolor="#D9E9CE"><span class="Estilo53 Estilo57"><? echo number_format($generic,2) ?></span></td>
            <td bgcolor="#F0F0F0"><div align="center" class="Estilo53 Estilo57"><? echo number_format($total,2) ?></div>
                <div align="center" class="Estilo53 Estilo57"></div></td>
          </tr>
          <? } ?>
        </table></td>
      </tr>
    </table>
    <p align="right"><span class="Estilo72 Estilo53 Estilo58 Estilo59 Estilo60">(* No incluye Farmacias) </span> </p>
</form>
<script type="text/javascript">
	Calendar.setup(
		{
			inputField : "fechaini", // ID of the input field
			ifFormat : "%Y-%m-%d", // the date format
			button : "cx_FECHA" // ID of the button
		});
</script>
<script type="text/javascript">
	Calendar.setup(
		{
			inputField : "fechafin", // ID of the input field
			ifFormat : "%Y-%m-%d", // the date format
			button : "cx_FECHA2" // ID of the button
		});
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
