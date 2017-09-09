<?php	
session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");

	$hoy=date('Y-m-d');
	$met=$_GET['met'];
	$inicio=$_POST['fechaini'];
	$final=$_POST['fechafin'];
	$client=$_POST['cliente'];
	
	
	$selec="SELECT nit, nombres, apellidos FROM cliente WHERE activo='S' ORDER BY nombres";
	$datos = mysql_query($selec,$link);

	$selec="SELECT c.nombres, c.apellidos, upper(f.usuario) as usuario, f.factura, f.fecha, f.etico, f.popular, f.leches, f.generico, f.total 
			FROM facturas as f, cliente as c 
			WHERE c.nit=f.cliente AND date(f.fecha)>='$inicio' AND date(f.fecha)<='$final' AND f.cliente='$client'
			GROUP BY f.factura ORDER BY f.factura";
	$filtro=mysql_query($selec,$link);


	if($met==1)
	{
		$totales="SELECT count(factura) as factura, sum(etico) as etico, sum(popular) as popular, sum(leches) as leches,
						sum(generico) as generico 
					FROM facturas WHERE cliente='$client' AND date(fecha)>='$inicio' AND date(fecha)<='$final'";
		$Totserch=mysql_query($totales,$link);
		while($results=mysql_fetch_array($Totserch))
		{
			$Tfactura=$results['factura'];
			$Tetico=$results['etico'];
			$Tmilk=$results['leches'];
			$Tgener=$results['generico'];
			$Tpopul=$results['popular'];
		}
		$Ttotal=$Tetico+$Tpopul+$Tmilk+$Tgener;
		
	}
?>  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<TITLE>Dise&ntilde;o y Programaci&oacute;n LDCP</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<style type="text/css">
<!--
.Estilo54 {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
	text-align: center;
}
-->
</style>
<style type="text/css">
<!--
.Estilo55 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
.Estilo56 {font-size: 12}
#1 #clientes table tr td strong {
	font-size: 12px;
}
-->
</style>
<style type="text/css">
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
#1 #clientes table tr td {
	font-family: Verdana, Geneva, sans-serif;
}
#1 #clientes table tr td {
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
<form action="rep_facturas.php?met=1" method="post" name="clientes" class="Estilo54" id="clientes" onSubmit="return Verifica()">
  <table width="80%" border="1" align="center" bgcolor="#CCCCCC" frame="border" rules="all">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td width="18%">Fecha inicio
            <? if (($Nivel==1) || ($Nivel==2)) { $fecha1=date('Y-m-01'); } else { $fecha1=$hoy; }?></td>
          <td width="23%"><img src="images/iconos/ew_calendar.gif" id="cx_FECHA" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
           
            <input type="text" name="fechaini" id="fechaini" size="10" maxlength="10" value="<?php if(@$fecha1=='')@$fecha1=date('d-m-Y'); echo htmlspecialchars(@$fecha1) ?>"></td>
          <td width="59%" align="center" valign="top"><select name="cliente" size="1" id="cliente">
            <option selected value="rep_facturas.php">Seleccione
              <? 
			while($result=mysql_fetch_array($datos))
			{
				$id_cli=$result['nit'];
				$nombre=$result['nombres'];
				$apelli=$result['apellidos'];
			?>
              <option value="<? echo $id_cli; ?>"> <? echo $nombre ?> <? echo $apelli ?></option>
            <? } ?>
          </select></td>
        </tr>
        <tr>
          <td>Fecha final</td>
          <td><img src="images/iconos/ew_calendar.gif" id="cx_FECHA2" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
            <input type="text" name="fechafin" id="fechafin" size="10" maxlength="10" value="<?php if(@$fecha=='')@$fecha=date('Y-m-d'); echo htmlspecialchars(@$fecha) ?>"></td>
          <td align="center" valign="top"><input type="submit" name="Submit" value="Realizar Reporte"></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="90%" border="1" align="center" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr bgcolor="#FFFFCC">
      <td height="35" bgcolor="#7E9DE5"><div align="center">Datos del Cliente</div></td>
      <td align="center" bgcolor="#7E9DE5">Usuario</td>
      <td bgcolor="#7E9DE5"><div align="center">Facturas</div></td>
      <td bgcolor="#7E9DE5"><div align="center">Fecha</div></td>
      <td bgcolor="#7E9DE5"><div align="center">Etico</div></td>
      <td bgcolor="#7E9DE5"><div align="center">Popular</div></td>
      <td align="center" bgcolor="#7E9DE5">Leches</td>
      <td align="center" bgcolor="#7E9DE5">Gen&eacute;rico</td>
      <td bgcolor="#7E9DE5"><div align="center">Total General</div></td>
    </tr>
    <tr>
      <? while($result=mysql_fetch_array($filtro))
	  	{
		$nombres=$result['nombres'];
		$apellidos=$result['apellidos'];
		$factura=$result['factura'];
		$usuario=$result['usuario'];
		$fecha=$result['fecha'];
		$etico=$result['etico'];
		$popul=$result['popular'];
		$milk=$result['leches'];
		$gener=$result['generico'];
		$total=$result['total'];								
		?>
	  <td height="30" bgcolor="#D9E9CE"><span class="Estilo55"><? echo $nombres ?> <? echo $apellidos ?></span></td>
	  <td align="center" bgcolor="#F0F0F0" style="font-size: 9px"><? echo $usuario ?></td>
      <td align="center" bgcolor="#F0F0F0">
      <a href="rep_venta.php?dat=2&cod1=<? echo $factura; ?>" title="Ver detalle" target="mainFrame">      
	  <? echo $factura ?></a></td>
      <td bgcolor="#D9E9CE"><div align="center" class="Estilo55"><? echo $fecha ?></div></td>
      <td bgcolor="#F0F0F0"><div align="right" class="Estilo55"><? echo number_format($etico,2) ?></div></td>
      <td bgcolor="#D9E9CE"><div align="right" class="Estilo55"><? echo number_format($popul,2) ?></div></td>
      <td align="right" bgcolor="#D9E9CE"><span class="Estilo55"><? echo number_format($milk,2) ?></span></td>
      <td align="right" bgcolor="#D9E9CE"><span class="Estilo55"><? echo number_format($gener,2) ?></span></td>
      <td bgcolor="#F0F0F0"><div align="right" class="Estilo55"><? echo number_format($total,2) ?></div></td>
      </tr>
	<? } ?>

    <tr>
      <td align="center" bgcolor="#7E9DE5">TOTALES</td>
      <td align="center" bgcolor="#7E9DE5" style="font-weight: bold">&nbsp;</td>
      <td align="center" bgcolor="#7E9DE5" style="font-weight: bold">
	  <a href="rep_venta2.php?f1=<? echo $inicio ?>&f2=<? echo $final; ?>&nit=<? echo $client; ?>" title="Detalle General" target="mainFrame"> 
	  <? echo $Tfactura ?></a></td>
      <td align="center" bgcolor="#7E9DE5" style="font-weight: bold">&gt;&gt;&gt;&gt;&gt;</td>
      <td align="right" bgcolor="#7E9DE5" style="font-weight: bold"><? echo number_format($Tetico,2) ?></td>
      <td align="right" bgcolor="#7E9DE5" style="font-weight: bold"><? echo number_format($Tpopul,2) ?></td>
      <td align="right" bgcolor="#7E9DE5" style="font-weight: bold"><? echo number_format($Tmilk,2) ?></td>
      <td align="right" bgcolor="#7E9DE5" style="font-weight: bold"><? echo number_format($Tgener,2) ?></td>
      <td align="right" bgcolor="#7E9DE5" style="font-weight: bold; font-size: 18px;"><? echo number_format($Ttotal,2) ?></td>
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
