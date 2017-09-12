<?php
	session_start();
	include("sysconect.php");
	include("conversor.php");
	if ($_SESSION['Bandera'] != "SI")	{	cambiar_ventana("index.php");	exit;	}
	$link=conectarse("Apdahum");
	$cod1=$_GET['cod1'];	$cod2=$_GET['cod2'];

	$fechaptr="SELECT year(fecha) as ano, month(fecha) as mes, day(fecha) as dia FROM facturas WHERE factura='$cod1' AND ano='$cod2'";
	$fecrepor=mysql_query($fechaptr,$link);
	
	$selec="SELECT c.razonsocial, c.direccion, nit2 FROM Cliente as c, Ventas as v 
			WHERE v.cliente=c.nit AND v.factura='$cod1' AND v.ano='$cod2' GROUP BY v.cliente";
	$datosm1=mysql_query($selec,$link);
	$selec="SELECT sum(total) as total FROM ventas WHERE factura='$cod1' AND ano='$cod2'";
	$datosm2=mysql_query($selec,$link);
	$selec= "SELECT a.id_producto, upper(a.nproducto) as nproducto, b.presentacion, c.punitario, c.cantidad, c.total, a.afecto
    	       FROM bodegam as a, presentacion as b, ventas as c
	           WHERE  a.id_producto=c.medicamento AND a.presentacion=b.id_presenta AND c.factura='$cod1' AND c.operado='S'
				AND ano='$cod2'	ORDER BY a.nproducto";
	$filtro= mysql_query($selec,$link);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<script language="JavaScript"><!--
	function PrintPage()
	{
    document.getElementById('Submit').style.visibility = 'hidden';
    
	// Imprimir la pagina
    if (typeof(window.print) != 'undefined') {
        window.print();
    }
    document.getElementById('Submit').style.visibility = '';
}	
//--></script>
<TITLE>Dise&ntilde;o y Programaci&oacute;n LDCP</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
.Estilo53 {
	font-family: Verdana, Geneva, sans-serif
}
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
.Estilo54 {font-size: 18px}
-->
</style>
<style type="text/css">
<!--
.Estilo55 {font-size: 24px}
-->
</style>
<style type="text/css">
<!--
.Estilo56 {font-size: 14px}
-->
</style>
<style type="text/css">
<!--
.Estilo60 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
.Estilo61 {font-weight: bold}
-->
</style>
<style type="text/css">
<!--
.Estilo66 {font-family: "Times New Roman", Times, serif}
-->
</style>
<style type="text/css">
<!--
.Estilo67 {font-size: 9px}
-->
</style>
<style type="text/css">
<!--
.Estilo68 {font-size: 16px}
-->
</style>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
#1 table tr td table tr td .Estilo76 div .Estilo41.Estilo43 .Estilo82.Estilo74.Estilo60 {
	text-align: left;
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
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
 	<tr><td height="129" colspan="5"><div align="center"></div></td></tr>
    <tr><td width="142" rowspan="2" align="center"></span><img src="images/iconos/printer.bmp" alt="imprimir..." name="Submit" border="0" id="Submit" onClick="PrintPage()"></span></td>
   <td colspan="2" align="right" style="font-size: 12px">SB-<?php
<?php	echo $cod1; ?>-<?php
<?php	echo $cod2; ?>/<?php
<?php	echo $Usr; ?></td>
   <td colspan="2">&nbsp;</td>
   </tr>
   <tr>
   <td width="251" height="31">&nbsp;</td>
   <?	while($dato=mysql_fetch_array($fecrepor))	{	/*$ano=$dato['ano'];	$mes=$dato['mes']; $dia=$dato['dia'];*/ 
   														$ano=date('Y');	$mes=date('m'); $dia=date('d');	?>
   <td width="224" valign="bottom"><?php
<?php	echo $dia; ?></td>
  	
   <td width="212" align="center" valign="bottom"><?php
<?php	echo $mes; ?></td>
   <td width="155" align="right" valign="bottom"><?php
<?php	echo $ano; ?></td>
   </tr>
   <?php
<?php	} ?>
   <tr>
    <?	while($clie=mysql_fetch_array($datosm1))	
	{	$nombres=$clie['razonsocial']; 	$direccion=$clie['direccion'];	$nit=$clie['nit2']; ?>
    <td height="39">&nbsp;</td>
    <td colspan="4" valign="bottom"><span class="Estilo60 Estilo53 Estilo132"><strong><?php
<?php	echo $nombres ?></strong></span></td>
    </tr>
    <?php
<?php	} ?>
    <tr>
      <td height="30">&nbsp;</td>
      <td colspan="3" valign="bottom"><strong class="Estilo53"><?php
<?php	echo $direccion ?></strong></td>
      <td align="center" valign="bottom"><strong class="Estilo53"><?php
<?php	echo $nit ?></strong></td>
    </tr>
    <tr>
      <td height="39">&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
</table>
<table width="100%" height="599" border="0" bordercolor="#000000" rules="none">
<tr>
   <td height="551" colspan="5" valign="top">
	<table width="100%" border="0" align="center">
    <?php
<?php	
		while($fac=mysql_fetch_array($filtro))
		{
			$idmedic=$fac['id_producto'];
			$medicamento=$fac['nproducto'];
			$afecto=$fac['afecto'];
			$presenta=$fac['presentacion'];
			$preunit=$fac['punitario'];
			$cant=$fac['cantidad'];
			$descu=$fac['descuentos'];
			$total=$fac['total'];
	?>
    <tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
    <td width="4%" align="left"><?php
<?php	echo $cant; ?></td>
    <?php
<?php	if($afecto=='S') { $ivasat=""; } else { $ivasat="*"; } ?>
    <td width="2%" align="left"><?php
<?php	echo $ivasat; ?></td>
    <td width="48%" align="left"><?php
<?php	echo $medicamento ?> (<?php
<?php	echo $presenta; ?>)</td>
    <td width="16%" align="right" valign="middle">&nbsp;</td>
     <td width="15%" align="right"><?php
<?php	echo $preunit; ?></td>
     <td width="15%" align="right"><?php
<?php	echo $total; ?></td>
     <?php
<?php	} ?>
    <tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
    <?php
<?php	
		$totaltuplas="SELECT COUNT(*) as Total FROM Ventas WHERE Factura='$cod1' AND Ano='$cod2' AND Operado='S'";
		$total=mysql_query($totaltuplas,$link);
		while($result=mysql_fetch_array($total))	{	$tiene=$result['Total'];	}
		if($tiene<=28)	{	?>
	 
      <td align="left" style="font-size: 9px">&nbsp;</td>
      <?php
<?php	
	  		$subtotal1="SELECT sum(total) as sub1 FROM Ventas v, Bodegam b
						WHERE b.id_producto=v.medicamento AND v.factura='$cod1' AND v.ano='$cod2'
						AND b.afecto='N'";
			$result1=mysql_query($subtotal1,$link);
			while($dat1=mysql_fetch_array($result1))	{	$subtotalA=$dat1['sub1'];	}
			$subtotal2="SELECT sum(total) as sub2 FROM Ventas v, Bodegam b
						WHERE b.id_producto=v.medicamento AND v.factura='$cod1' AND v.ano='$cod2'
						AND b.afecto='S'";
			$result2=mysql_query($subtotal2,$link);		
			while($dat2=mysql_fetch_array($result2))	{	$subtotalE=$dat2['sub2'];	}
						
	  ?>
      <td colspan="3" align="left" style="font-size: 12px">Subtotal Exento: Q.<?php
<?php	echo number_format($subtotalA,2); ?> Subtotal Afecto: Q.<?php
<?php	echo number_format($subtotalE,2); ?></td>
      <td align="right">&nbsp;</td>
    <tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
      <td align="center" style="font-size: 8px"><span style="font-size: 10px">(*) </span></td>
      <td colspan="4" align="left" style="font-size: 10px">Producto Gen&eacute;rico Exento de IVA Segun Decreto 16-2003 CONGRESO DE LA REPUBLICA</td>
      <td align="right">&nbsp;</td>
    </table></td></tr><tr>
    <?php
<?php	} ?>
        <?php
	 		while($total=mysql_fetch_array($datosm2))
			{
				$totalg=$total['total'];
				$totaldes=$total['totald'];
			?>
      <td colspan="3">&nbsp;</td>
      <td width="12%" align="right" style="font-size: 12px; font-weight: bold;"><?php
<?php	echo number_format($totalg,2); ?></td>
      </tr>
    <tr>
      <td width="31%">&nbsp;</td>
      <?php
	  	$dato0=floor($totalg);
		$dato1=round(($totalg-$dato0)*100);
		$dato2=convertir($dato0);
		$print="$dato2, con $dato1/100";
	  ?>
      <td colspan="3" valign="top"><?php
<?php	echo $print; ?></td>
    </tr>
    <?php
<?php	} ?>
  </table>
  <span class="Estilo120"><span class="Estilo119">
</span></span><!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
