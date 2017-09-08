<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
//Definición de variables
	$hoy=date('Y-m-d');
	$inicio=$_POST['fechaini'];
	$final=$_POST['fechafin'];
	
//Busca información
	$selec="SELECT f.cliente, c.nombres, c.apellidos, SUM(f.etico) as etico, SUM(f.popular) as popular, SUM(f.leches) as leches, 
			SUM(f.generico) as generico, SUM(f.total) as total FROM Facturas as f, Cliente as c
			WHERE f.Fecha >= '$inicio' AND f.Fecha <= '$final' AND f.cliente=c.nit AND c.tipo_cliente IN ('F','I') GROUP BY f.cliente ORDER BY f.total DESC";
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
body {
	background-image: url();
}
-->
</style>
<style type="text/css">
<!--
.Estilo54 {font-size: 9px}
-->
</style>
<style type="text/css">
<!--
.Estilo55 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
<style type="text/css">
<!--
.Estilo57 {font-size: 14px}
-->
</style>
<style type="text/css">
<!--
.Estilo58 {font-size: 14}
-->
</style>
<style type="text/css">
<!--
.Estilo59 {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
#1 .Estilo54 table tr td table {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
#1 .Estilo54 table tr td table tr td .Estilo55.Estilo59 .Estilo78 {
	font-family: Verdana, Geneva, sans-serif;
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
  <form action="rep_ventasxfarm.php" method="post" name="Ventascli" class="Estilo54">
	<table width="65%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
	  <tr>
	    <td><table width="100%" border="0">
	      <tr>
	        <td width="18%">Fecha inicio
	           <? if (($Nivel==1) || ($Nivel==2)) { $fecha1=date('Y-m-01'); } else { $fecha1=$hoy; }?></td>
	        <td width="23%"><img src="images/iconos/ew_calendar.gif" alt="Seleccione una fecha" name="cx_FECHA" id="cx_FECHA" style="cursor:pointer;cursor:hand;">
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
	<p>&nbsp;</p>
	<table width="75%" border="0">
      <tr>
        <td><table width="100%" border="1" cellpadding="1" cellspacing="1" frame="box" rules="rows">
          <tr>
            <td colspan="6" bgcolor="#7E9DE5"><div align="center"><span class="Estilo75 Estilo71 Estilo49"><strong>REPORTE DE VENTAS A FARMACIAS </strong></span></div></td>
          </tr>
          <tr bgcolor="#D9E9CE">
            <td colspan="6"><div align="center" class="Estilo55 Estilo59"><span class="Estilo73">Per&iacute;odo: <? echo $inicio ?> al <? echo $final ?></span></div></td>
          </tr>
          <tr bgcolor="#FFFFCC">
            <td height="29" bgcolor="#7E9DE5"><div align="center" class="Estilo55 Estilo59">
                <div align="center"><span class="Estilo72">DATOS DEL CLIENTE </span></div>
            </div></td>
            <td bgcolor="#7E9DE5"><div align="center" class="Estilo55 Estilo59"><span class="Estilo72">ETICO</span></div></td>
            <td bgcolor="#7E9DE5"><div align="center" class="Estilo55 Estilo59"><span class="Estilo72">POPULAR</span></div></td>
            <td align="center" bgcolor="#7E9DE5"><span class="Estilo55 Estilo59"><span class="Estilo72">LECHES</span></span></td>
            <td align="center" bgcolor="#7E9DE5"><span class="Estilo55 Estilo59"><span class="Estilo72">GENERICO</span></span></td>
            <td bgcolor="#7E9DE5"><div align="center" class="Estilo55 Estilo59"><span class="Estilo72">TOTAL</span></div></td>
          </tr>
          <tr bordercolor="#9CD8A7">
            <? 
		while($venta=mysql_fetch_array($datosm1))
		{
			$codigo=$venta['cliente'];
			$nomb=$venta['nombres'];
			$apel=$venta['apellidos'];
			$totale=$venta['etico'];
			$totalp=$venta['popular'];
			$totalm=$venta['leches'];
			$totalg=$venta['generico'];
			$totalG=$venta['total'];
			$tabfact="SELECT SUM(f.etico) as etico, SUM(f.popular) as popular, SUM(f.leches) as leches, SUM(f.generico) as generico, 		
						SUM(f.total) as total 	
						FROM Facturas as f, Cliente as c 
						WHERE f.fecha >='$inicio' AND f.fecha <='$final' AND f.cliente=c.nit AND c.tipo_cliente IN ('F','I')";
			$dato1=mysql_query($tabfact,$link);
			if ($tf=mysql_fetch_array($dato1))
			{
				$tot_etico=$tf['etico'];
				$tot_popul=$tf['popular'];
				$tot_milk=$tf['leches'];
				$tot_gener=$tf['generico'];
				$subtotal =$tf['total'];
			}
		?>
            <td height="25" bordercolor="#9CD8A7" bgcolor="#D9E9CE"><div align="left" class="Estilo55 Estilo59"><span class="Estilo49"><? echo $nomb ?> <? echo $apel ?></span></div></td>
            <td bgcolor="#F0F0F0"><div align="right" class="Estilo55 Estilo59"><span class="Estilo78"><? echo number_format($totale,2) ?></span></div></td>
            <td height="25" bordercolor="#9CD8A7" bgcolor="#D9E9CE"><div align="right" class="Estilo55 Estilo59"><span class="Estilo78"><? echo number_format($totalp,2) ?></span></div></td>
            <td align="right" bordercolor="#9CD8A7" bgcolor="#D9E9CE"><span class="Estilo78"><? echo number_format($totalm,2) ?></span></td>
            <td align="right" bordercolor="#9CD8A7" bgcolor="#D9E9CE"><span class="Estilo78"><? echo number_format($totalg,2) ?></span></td>
            <td bordercolor="#9CD8A7" bgcolor="#F0F0F0"><div align="right" class="Estilo55 Estilo59"><span class="Estilo78"><? echo number_format($totalG,2) ?></span></div></td>
          </tr>
          <? } ?>
          <tr bgcolor="#FFFFCC">
            <td height="36" bgcolor="#7E9DE5"><span class="Estilo49 Estilo55 Estilo59">TOTAL VENTAS ESTE PERIODO (*) </span></td>
            <td bgcolor="#7E9DE5"><div align="right" class="Estilo57 Estilo55"><strong><span class="Estilo78"><? echo number_format($tot_etico,2) ?></span></strong></div></td>
            <td bgcolor="#7E9DE5"><div align="right" class="Estilo57 Estilo55"><span class="Estilo78" style="font-weight: bold"><? echo number_format($tot_popul,2) ?></span></div></td>
            <td align="right" bgcolor="#7E9DE5"><span class="Estilo78" style="font-weight: bold"><? echo number_format($tot_milk,2) ?></span></td>
            <td align="right" bgcolor="#7E9DE5"><span class="Estilo78" style="font-weight: bold"><? echo number_format($tot_gener,2) ?></span></td>
            <td bgcolor="#7E9DE5"><div align="right" class="Estilo57 Estilo55"><strong><span class="Estilo70"><? echo number_format($subtotal,2) ?></span></strong></div></td>
          </tr>
        </table></td>
      </tr>
    </table>
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
