<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{	cambiar_ventana("index.php");	exit;	}
	$link=conectarse("Apdahum");
	$cod1=$_POST['Facturaptr'];
	$year=date('Y');
	$radio=$_POST['radio'];
	if($radio=='V')
	{
		$select="SELECT cliente, medicamento, cantidad, punitario, descuentos, total, usuario 
					FROM cotizacion WHERE cotizacion='$cod1'";
		$busca=mysql_query($select,$link);
		while($x=mysql_fetch_array($busca))
		{
			$fcliente=$x['cliente'];
			$fmedicam=$x['medicamento'];
			$fcantida=$x['cantidad'];
			$fpunitar=$x['punitario'];
			$fdescuen=$x['descuentos'];
			$ftotal=$x['total'];
			$fuser=$x['usuario'];
		}
	}
	else
	{
	$fechaptr="SELECT fecha FROM Cotizacion WHERE Cotizacion='$cod1' AND year(fecha)='$year'";
	$fecrepor=mysql_query($fechaptr,$link);
	$selec="SELECT c.razonsocial 
			FROM Cliente as c, Cotizacion as v 
			WHERE v.cliente=c.nit AND v.cotizacion='$cod1' AND year(v.fecha)='$year'
			GROUP BY v.cliente";
	$datosm1=mysql_query($selec,$link);
	$selec="SELECT sum(total) as total FROM Cotizacion WHERE cotizacion='$cod1' AND year(fecha)='$year'";
	$datosm2=mysql_query($selec,$link);
	$selec= "SELECT a.nproducto, b.presentacion, c.punitario, c.cantidad, c.total
    	        FROM bodegam as a, presentacion as b, cotizacion as c
	            WHERE  a.id_producto=c.medicamento AND a.presentacion=b.id_presenta AND c.cotizacion='$cod1' AND c.operado='N' 
						AND year(fecha)='$year'
				ORDER BY a.nproducto";
	$filtro= mysql_query($selec,$link);
	}


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
	font-size: 10px;
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
  <table width="90%" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td colspan="3"><div align="center" class="Estilo55 Estilo54 Estilo53 Estilo133"><strong><span class="Estilo120">A P D A H U M </span></strong></div></td>
    </tr>
    <tr>
      <td width="111"><img src="images/iconos/printer.bmp" alt="imprimir..." name="Submit" border="0" id="Submit" onClick="PrintPage()"></span></span></td>
      <td colspan="2"><div align="right" class="Estilo56 Estilo53"><span style="font-size: 24px"><strong>C</strong></span><strong>OTIZACI&Oacute;N No. </strong><span class="Estilo55"><strong><? echo $cod1; ?></strong></span></div></td>
    </tr>
    <tr>
      <?
	while($clie=mysql_fetch_array($datosm1))
	{
		$nombres=$clie['razonsocial'];  
		?>
      <td class="Estilo60 Estilo53 Estilo126 Estilo125"><strong>CLIENTE:</strong></td>
      <td width="579" class="Estilo60 Estilo53 Estilo132"><strong><? echo $nombres ?></strong></td>
      <td width="217" class="Estilo60 Estilo53 Estilo132"><span class="Estilo60 Estilo53"><strong>
        FECHA: <?	while($dato=mysql_fetch_array($fecrepor))	{	$fecha=$dato['fecha'];	}	echo $fecha;	?>
      </strong></span></td>
    </tr>
    <? } ?>
  </table>
  <table width="90%" border="1" bordercolor="#000000" frame="hsides" rules="rows">
    <tr>
      <td><div align="center" class="Estilo60 Estilo53"><strong>CANT.</strong></div></td>
      <td><div align="center" class="Estilo60 Estilo53"><strong>DESCRIPCION DE MEDICAMENTOS </strong></div></td>
      <td><div align="center" class="Estilo60 Estilo53"><strong>P.U.</strong></div></td> 
      <td><div align="center" class="Estilo60 Estilo53"><strong>TOTAL</strong></div></td>
    </tr>
  </table>
  <table width="90%" border="1" bordercolor="#000000" frame="hsides" rules="rows">
    <tr>
      <td><table width="100%" border="0" align="center">
	<? 
		while($fac=mysql_fetch_array($filtro))
		{
			$medicamento=$fac['nproducto'];
			$presenta=$fac['presentacion'];
			$preunit=$fac['punitario'];
			$cant=$fac['cantidad'];
			$total=$fac['total'];
		?>
        <tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
		  <td width="105" height="1">
            <div align="center" class="Estilo76 Estilo79 Estilo74 Estilo128 Estilo111 Estilo53 Estilo61 Estilo60">
             <div align="center" class="Estilo41 Estilo43">
             <span class="Estilo82 Estilo74 Estilo60"><? echo $cant; ?></span></div>
          </div></td>
          <td width="584"><? echo $medicamento ?> (<? echo $presenta; ?>)</td>
          <td width="83"><div align="right" class="Estilo53 Estilo60">
          <span class="Estilo111 Estilo128 "><span class="Estilo82 Estilo74 Estilo128 Estilo111 ">
          <span class="Estilo41 Estilo43"><? echo $preunit; ?></span></span></span></div></td>
		  <td width="121" height="1"><div align="right" class="Estilo53 Estilo60">
          <span class="Estilo111 Estilo128 "><span class="Estilo43 Estilo41  Estilo128"><? echo $total; ?></span></span></div></td>
          <? } ?>
          <?
	 		while($total=mysql_fetch_array($datosm2))
			{
				$totalg=$total['total'];
				$totaldes=$total['totald'];
			?>
        <tr bordercolor="#000000">
          <td>
            <div align="center" class="Estilo76 Estilo79 Estilo74 Estilo53 Estilo61 Estilo60">
              <div align="center"></div>
              </div>
            <div align="left" class="Estilo111 Estilo53 Estilo61 Estilo60">
              <div align="center"></div>
              </div>
            <div align="center" class="Estilo116 Estilo53 Estilo61 Estilo60">
              <div align="center"></div>
              </div>
            <div align="center" class="Estilo82 Estilo67 Estilo74 Estilo3 Estilo113 Estilo53 Estilo61 Estilo60">
              <div align="center" class="Estilo128 Estilo136"></div>
              </div>
            <div align="center" class="Estilo82 Estilo67 Estilo74 Estilo111 Estilo53 Estilo61 Estilo60">
              <div align="center" class="Estilo116 Estilo128">
                <div align="center"></div>
                </div>
            </div></td>
          <td height="23" class="Estilo53 Estilo136 Estilo128 Estilo60"><strong>TOTAL COTIZACI&Oacute;N...</strong></td>
          <th><div align="center" class="Estilo128 Estilo53 Estilo61 Estilo60">
            <p align="right" class="Estilo82 Estilo67 Estilo74"><strong><span class="Estilo82 Estilo67 Estilo74"><span class="Estilo43 Estilo41 Estilo56 Estilo68">Q. <? echo $totalg; ?></span></span></strong></p>
          </div>            </th>
          <? } ?>
      </table></td>
    </tr>
  </table>
  <table width="495" border="0" align="center">
    <tr>
    <td width="243" height="26"><div align="left" class="Estilo131 Estilo53 Estilo60">
      <p>f.________________________________</p>
</div></td>
    <td width="242" rowspan="3"><div align="left" class="Estilo131 Estilo53 Estilo60">
      <p>&nbsp;</p>
</div>
      <div align="center" class="Estilo131 Estilo53 Estilo60"></div>
      <div align="center" class="Estilo131 Estilo53 Estilo60"></div>
    <div align="center" class="Estilo131 Estilo53 Estilo60"></div>    <div align="center" class="Estilo131 Estilo53 Estilo60"></div></td>
  </tr>
  <tr>
    <td><div align="center" class="Estilo131"><? echo $Usr ?></div></td>
    </tr>
  <tr>
    <td><div align="center" class="Estilo135 Estilo53 Estilo60">Elabora Cotizaci&oacute;n</div></td>
    </tr>
</table>
<span class="Estilo120"><span class="Estilo119">
</span></span><!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
