<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{	cambiar_ventana("index.php");	exit;	}
	$link=conectarse("Apdahum");
//Definición de variables
	$hoy=date('Y-m-d');
	$selec  = "SELECT b.Id_producto, b.Nproducto FROM bodegam as b, proveedores as p WHERE b.Activo='S' 
						AND b.id_proveedor=p.id_proveedor AND p.Activo='S' ORDER BY b.Nproducto";
	$datosm2= mysql_query($selec,$link);
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
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-image: url();
	background-repeat: no-repeat;
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
.Estilo59 {font-size: 12px}
-->
</style>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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
  <p style="font-size: 16px">REPORTE DE VENTAS Y MOVIMIENTO DE MEDICAMENTOS</p>
  <form action="rep_medic4.php" method="post" name="Ventascli" class="Estilo54">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="75%" border="1">
	  <tr>
	    <td><table width="100%" border="0">
	      <tr>
	        <td rowspan="3"><img src="images/iconos/email_038[1].gif" width="89" height="76"></td>
	        <td>Fecha inicio
	          <? if (($Nivel==1) || ($Nivel==2)) { $fecha1=date('Y-m-01'); } else { $fecha1=$hoy; }?></td>
               <td><img src="images/iconos/Calendario.png" alt="Seleccione una fecha" name="cx_FECHA" width="32" height="32" border="0" align="absmiddle" id="cx_FECHA" style="cursor:pointer;cursor:hand;">
	          <input type="text" name="fechaini" id="fechaini" size="10" maxlength="10" value="<?php if(@$fecha1=='')@$fecha1=date('d-m-Y'); echo htmlspecialchars(@$fecha1) ?>"></td>
	        <td align="center" valign="middle"> 
	          <select name="Producto" size="1" id="Producto">
	            <option selected value="TODOS">Todos los Productos
	              <? 
			while($medi=mysql_fetch_array($datosm2))						
			{													
				$nip = $medi['Id_producto'];
				$nom = $medi['Nproducto'];
			?>
	              <option value="<? echo $nip; ?>"> <? echo $nom ?></option>
	            <? } ?>
	            </select></td>
	        </tr>
	      <tr>
	        <td>Fecha final</td>
	        <td><img src="images/iconos/calendario.png" alt="Seleccione una fecha" name="cx_FECHA2" width="32" height="32" border="0" align="middle" id="cx_FECHA2" style="cursor:pointer;cursor:hand;">
	          <input type="text" name="fechafin" id="fechafin" size="10" maxlength="10" value="<?php if(@$fecha=='')@$fecha=date('Y-m-d'); echo htmlspecialchars(@$fecha) ?>"></td>
	        <td align="center" valign="middle">Ventas 
	          <label>
	            <input name="operacion" type="radio" id="radio" value="V" checked>
	          </label></td>
	        </tr>
	      <tr>
	        <td colspan="3" align="center"><input type="submit" name="Submit3" value="Realizar Reporte"></td>
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
