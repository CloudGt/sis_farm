<?
	session_start();
	include("sysconect.php");
	include("conversor.php");
	if ($_SESSION['Bandera'] != "SI")	{	cambiar_ventana("index.php");	exit;	}
	$link=conectarse("Apdahum");
	$cod1=$_GET['cod1'];
	$cod2=$_GET['cod2'];

	$fechaptr="SELECT year(fecha) as ano, month(fecha) as mes, day(fecha) as dia FROM facturas WHERE factura='$cod1' AND ano='$cod2'";
	$fecrepor=mysql_query($fechaptr,$link);
	
	$selec="SELECT c.razonsocial, c.direccion, nit2 FROM Cliente as c, Ventas as v 
			WHERE v.cliente=c.nit AND v.factura='$cod1' AND v.ano='$cod2' GROUP BY v.cliente";
	$datosm1=mysql_query($selec,$link);
	$selec="SELECT sum(total) as total FROM ventas WHERE factura='$cod1' AND ano='$cod2'";
	$datosm2=mysql_query($selec,$link);
	$selec= "SELECT upper(a.nproducto) as nproducto, b.presentacion, c.punitario, c.cantidad, c.total, a.afecto
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
<table width="65%" border="0" align="center" rules="none">
 	<tr><td height="55" colspan="6"><div align="center"></div></td></tr>
    <tr><td width="64" rowspan="2" align="center"></span>
    <img src="images/iconos/printer.bmp" alt="imprimir..." name="Submit" border="0" id="Submit" onClick="PrintPage()"></span></td>
   <?	while($dato=mysql_fetch_array($fecrepor))	{	$ano=date('y');	$mes=date('m'); $dia=date('d');	?>
   <td width="126" align="center" style="font-size: 12px"><? echo $dia; ?></td>
   <td width="100" align="left" style="font-size: 12px"><? echo $mes; ?></td>
   <td width="148" align="left" style="font-size: 12px"><? echo $ano; ?></td>
   <td colspan="2" align="right"><span style="font-size: 10px">SB-<? echo $cod1; ?>-<? echo $cod2; ?>/<? echo $Usr; ?></span></td>
    </tr><tr>
   <? } ?>
    <?	while($clie=mysql_fetch_array($datosm1))	
	{	$nombres=$clie['razonsocial']; 	$direccion=$clie['direccion'];	$nit=$clie['nit2']; ?>
    <td height="36" colspan="5" align="left"><span class="Estilo60 Estilo53 Estilo132"><strong><? echo $nombres ?></strong></span></td>
   </tr>
   <tr>
    <td height="24">&nbsp;</td>
    <td colspan="3" valign="bottom"><strong class="Estilo53" style="font-size: 10px"><? echo $direccion ?></strong></td>
    <td width="15" align="right" valign="bottom">&nbsp;</td>
    <td width="132" align="right" valign="bottom"><strong class="Estilo53" style="font-size: 10px"><? echo $nit ?></strong></td>
    </tr>
    <? } ?>
    <tr>
      <td height="29" colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td height="30" colspan="6" align="left" valign="top"><table width="100%" height="502" border="0" align="left" bordercolor="#000000" rules="none">
        <tr>
          <td height="454" colspan="6" valign="top"><table width="100%" border="0" align="left" rules="none">
            <? 
		while($fac=mysql_fetch_array($filtro))
		{
			$medicamento=$fac['nproducto'];
			$afecto=$fac['afecto'];
			$presenta=$fac['presentacion'];
			$preunit=$fac['punitario'];
			$cant=$fac['cantidad'];
			$descu=$fac['descuentos'];
			$total=$fac['total'];
	?>
            <tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
              <? if($afecto=='S') { $ivasat=""; } else { $ivasat="*"; } ?>
              <td width="6%" height="23" align="left" valign="bottom" style="font-size: 9px"><? echo $cant; ?></td>
              <td width="3%" align="left" valign="bottom" style="font-size: 9px"><? echo $ivasat; ?></td>
              <td colspan="2" align="left" valign="bottom" style="font-size: 9px"><? echo $medicamento ?> (<? echo $presenta; ?>)</td>
              <td width="9%" align="right" valign="bottom"><? echo $preunit; ?></td>
              <td width="16%" align="right" valign="bottom"><? echo number_format($total,2); ?></td>
              <? } ?>
            <tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
              <? 
		$totaltuplas="SELECT COUNT(*) as Total FROM Ventas WHERE Factura='$cod1' AND Ano='$cod2' AND Operado='S'";
		$total=mysql_query($totaltuplas,$link);
		while($result=mysql_fetch_array($total))	{	$tiene=$result['Total'];	}
		if($tiene<=15)	{	?>
              <td height="21" align="left" valign="bottom">--</td>
              <?
	 		while($total=mysql_fetch_array($datosm2))
			{
				$totalg=$total['total'];
				$totaldes=$total['totald'];
				$dato0=floor($totalg);
				$dato1=round(($totalg-$dato0)*100);
				$dato2=convertir($dato0);
				$print="$dato2, con $dato1/100";	 } ?>
              <td align="center" valign="bottom" style="font-size: 9px">&nbsp;</td>
              <td colspan="2" align="left" valign="bottom" style="font-size: 9px">- <? echo $print; ?> -</td>
              <td align="right" valign="bottom">---</td>
              <td align="right" valign="bottom">---</td>
            <tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
              <td height="27" align="left">&nbsp;</td>
              <? 
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
              <td align="left" style="font-size: 9px">&nbsp;</td>
              <td width="29%" align="left" style="font-size: 8px">Total Exento Q.<? echo number_format($subtotalA,2); ?></td>
              <td align="left" style="font-size: 8px">Total Afecto Q.<? echo number_format($subtotalE,2); ?></td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
            <tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
              <td align="right" style="font-size: 8px">(*)</td>
              <td align="left" style="font-size: 8px">&nbsp;</td>
              <td colspan="2" align="left" style="font-size: 8px"> Producto Gen&eacute;rico Exento de IVA Segun Decreto 16-2003 CONGRESO DE LA REPUBLICA</td>
              <td align="left" style="font-size: 8px">&nbsp;</td>
              <td align="left" style="font-size: 8px">&nbsp;</td>
            </table></td>
        </tr>
        <tr>
          <? } ?>
          
          <td colspan="3">&nbsp;</td>
          <td align="right" style="font-size: 12px; font-weight: bold;">&nbsp;</td>
          <td align="right" style="font-size: 12px; font-weight: bold;"><? echo number_format($totalg,2); ?></td>
          </tr>
        <tr>
          <td width="31%">&nbsp;</td>
          <td colspan="4" valign="top">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p><!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
