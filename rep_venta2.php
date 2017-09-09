<?php	
session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	
	$f1=$_GET['f1'];
	$f2=$_GET['f2'];
	$f3=$_GET['nit'];
	//echo "*** $f1 *** $f2 *** $f3 ***";
	$selec="SELECT b.id_producto, b.nproducto, sum(v.cantidad) as cantidad, sum(v.total) as total 
			FROM ventas v, bodegam b 
			WHERE v.cliente='$f3' and date(v.fecha)>='$f1' and date(v.fecha)<='$f2' 
					and v.operado='S' and v.medicamento=b.id_producto
			GROUP BY v.medicamento ORDER BY total desc";
	$detalle=mysql_query($selec,$link);
	//echo $selec;
	
	$selec2="SELECT upper(nombres) as nombres, upper(apellidos) as apellidos FROM Cliente WHERE nit='$f3'";
	$cliente=mysql_query($selec2,$link);
	while($result=mysql_fetch_array($cliente))
	{	
		$nombre=$result['nombres'];
		$apelli=$result['apellidos'];
	}
	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
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

  <p>DETALLE DE MEDICAMENTOS VENDIDOS</p>
  <table width="40%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td width="30%">CLIENTE</td>
          <td colspan="2"><? echo $nombre; ?> <? echo $apelli; ?></td>
        </tr>
        <tr>
          <td>PERIODO</td>
          <td width="35%" align="center"><? echo $f1; ?></td>
          <td width="35%" align="center"><? echo $f2; ?></td>
        </tr>
      </table></td>
    </tr>
  </table>

  <p>&nbsp;</p>
  <table width="70%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="rows">
    <tr>
      <td width="39%" height="27" align="center">MEDICAMENTO</td>
      <td width="12%" align="center">CANTIDAD</td>
      <td width="16%" align="center">TOTAL VENTA</td>
      <td width="17%" align="center">DIFERENCIAL</td>
      <td width="16%" align="center">TOTAL (Q)</td>
    </tr>
    <tr>
      <td colspan="5">
      <table width="100%" height="41" border="0">
    	<?   while($res=mysql_fetch_array($detalle))
			{
				$medicamento=$res['nproducto'];
				$cantidad=$res['cantidad'];
				$total=$res['total'];
				$product=$res['id_producto'];
	  	?>
        <tr>
          <td width="38%" height="37" bgcolor="#CCCCCC"><? echo $medicamento; ?></td>
          <td width="13%" align="center"><? echo $cantidad; ?></td>
          <td width="16%" align="right" bgcolor="#CCCCCC"><? echo number_format($total,2); ?></td>
           <? 	$buscat="SELECT preciocosto FROM Bodegam WHERE id_producto='$product'";
		   		$buscar=mysql_query($buscat,$link);
				while($prec=mysql_fetch_array($buscar))	{	$dato=$prec['preciocosto'];	}
		  		$Total=$dato*$cantidad;	
				$diferencia=$total-$Total; 
			?>
         	<td width="17%" align="right"><? echo number_format($Total,2); ?></td>
			<td width="16%" align="right" bgcolor="#CCCCCC"><? echo number_format($diferencia,2); ?></td>
        </tr><? } ?>
      </table></td>
    </tr>
  </table>
  <p> </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
