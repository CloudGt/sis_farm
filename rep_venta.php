<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{	cambiar_ventana("index.php");	exit;	}
	$link=conectarse("Apdahum");
	$cod1=$_POST['Facturaptr'];		$tipr=$_POST['tiporep'];	$cod2=$_GET['dat'];	$year=$_POST['Factyearpt'];
	$tiempo=date('Y-m-d');
	
	if($cod2==2)	{	$cod1=$_GET['cod1'];	$year=date('Y');	}	
	
	$fechaptr="SELECT fecha FROM facturas WHERE factura='$cod1' AND ano='$year'";
	$fecrepor=mysql_query($fechaptr,$link);
	$filtro2="SELECT tipo_cliente 
				FROM cliente c, facturas f 
				WHERE f.cliente=c.nit AND f.factura='$cod1' and f.ano='$year'";
	$buscaclie=mysql_query($filtro2,$link);
	while($rep=mysql_fetch_array($buscaclie))	{	$TipoCliente=$rep['tipo_cliente'];	}
	if($tipr=='F')	{	cambiar_ventana("rep_factura.php?cod1=$cod1&cod2=$year");	exit;	}
	if($tipr=='F2')	{	cambiar_ventana("rep_facturaFT.php?cod1=$cod1&cod2=$year");	exit;	}
	if (($cod2==1) || ($cod2==2))
	{
		$selec="SELECT c.razonsocial, c.nombres, c.apellidos, c.nit2, c.direccion
				FROM Cliente as c, Ventas as v 
				WHERE v.cliente=c.nit AND v.factura='$cod1' AND c.tipo_cliente IN ('A','B','C','D','E','F','G','I') AND v.ano='$year'
				GROUP BY v.cliente";
		$datosm1=mysql_query($selec,$link);
		$selec="SELECT sum(total) as total, sum(descuentos) as totald FROM ventas WHERE factura='$cod1' AND ano='$year'";
		$datosm2=mysql_query($selec,$link);
		$busca="SELECT sum(descuentos) as descuentos FROM Ventas WHERE factura='$cod1' AND ano='$year'";
		$descu= mysql_query($busca,$link);
		while($result=mysql_fetch_array($descu))	{	$totaldesc=$result['descuentos'];	}
		$comenta="SELECT a.comentario FROM ventas_com a, ventas b WHERE b.salida=a.id_venta and b.medicamento=a.id_producto 
						AND b.factura='$cod1' ORDER BY a.comentario";
		$result=mysql_query($comenta,$link);

		if($tipr=='P')
		{
			$selec= "SELECT a.id_producto, a.nproducto, b.presentacion, c.punitario, a.precioVP, c.cantidad, c.descuentos, c.total, a.afecto
    	        FROM bodegam as a, presentacion as b, ventas as c
	            WHERE  a.id_producto=c.medicamento AND a.presentacion=b.id_presenta AND c.factura='$cod1' AND c.operado='S' 
						AND ano='$year'
				ORDER BY a.nproducto";
			$filtro= mysql_query($selec,$link);
		}
		else
		{
			$selec= "SELECT a.id_producto, a.nproducto, b.presentacion, c.punitario, c.cantidad, c.descuentos, c.total, a.afecto
    	        FROM bodegam as a, presentacion as b, ventas as c
	            WHERE  a.id_producto=c.medicamento AND a.presentacion=b.id_presenta AND c.factura='$cod1' AND c.operado='S'
						AND ano='$year'
				ORDER BY a.nproducto";
			$filtro= mysql_query($selec,$link);
		}
	}
	else
	{
		$selec="SELECT c.razonsocial FROM Cliente as c, Cotizacion as v WHERE v.cliente=c.nit AND v.cotizacion='$cod1' 
				GROUP BY v.cliente";
		$datosm1=mysql_query($selec,$link);
		$selec="SELECT sum(total) as total, sum(descuentos) as totald FROM Cotizacion WHERE cotizacion='$cod1'";
		$datosm2=mysql_query($selec,$link);
		$busca="SELECT sum(descuentos) as descuentos FROM Cotizacion WHERE cotizacion='$cod1'";
		$descu= mysql_query($busca,$link);
		while($result=mysql_fetch_array($descu))	{	$totaldesc=$result['descuentos'];	}
		$selec= "SELECT a.id_producto, a.nproducto, b.presentacion, c.punitario, c.cantidad, c.descuentos, c.total
    	        FROM Bodegam as a, Presentacion as b, Cotizacion as c
	            WHERE  a.id_producto=c.medicamento AND a.presentacion=b.id_presenta AND c.cotizacion='$cod1'
				AND c.operado='N'
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
      <td width="97"><img src="images/iconos/printer.bmp" alt="imprimir..." name="Submit" border="0" id="Submit" onClick="PrintPage()"></span></span></td>
      <?php
<?php	if($cod2==1) { $texto="SALIDA DE BODEGA No."; $texto2="TOTAL A PAGAR...";} else {	$texto="COTIZACION No."; $texto2="TOTAL COTIZACION (válida 03 días o mientras duren existencias)";	}	?>
      <td colspan="2"><div align="right" class="Estilo56 Estilo53"><strong><?php
<?php	echo $texto; ?> </strong><span class="Estilo55"><strong><?php
<?php	echo $cod1; ?></strong></span></div></td>
    </tr>
    <tr>
      <?php
	while($clie=mysql_fetch_array($datosm1))
	{
		$nombre1=$clie['razonsocial'];  
		$nombre2=$clie['nombres'];
		$nombre3=$clie['apellidos'];
		$nombre4=$clie['direccion'];
		$nit2=$clie['nit2'];
		$muestra=$nombre2.' '.$nombre3.' ('.$nombre4.')';
		
		?>
      <td class="Estilo60 Estilo53 Estilo126 Estilo125"><strong>CLIENTE:</strong></td>
      <td width="621"><span style="font-size: 12px; font-weight: bold;"><?php
<?php	echo $nombre1 ?></span>, <?php
<?php	echo $muestra; ?></td>
      <td width="189" align="right" class="Estilo60 Estilo53 Estilo132"><span class="Estilo60 Estilo53"><strong>
        FECHA: <?php
<?php	while($dato=mysql_fetch_array($fecrepor))	{	$fecha=$dato['fecha'];	}	echo $tiempo;	?>
      </strong></span></td>
    </tr>
    <?php
<?php	} ?>
  </table>
  <table width="90%" border="1" bordercolor="#000000" frame="hsides" rules="rows">
    <tr>
      <td><div align="center" class="Estilo60 Estilo53"><strong>CANT.</strong></div></td>
      <td><div align="center" class="Estilo60 Estilo53"><strong>DESCRIPCION DE MEDICAMENTOS </strong></div></td>
      <td><div align="center" class="Estilo60 Estilo53"><strong>P.U.</strong></div></td>
      <?php
<?php	if($tipr=='P') {  ?>
	  <td><div align="center" class="Estilo60 Estilo53"><strong>SUGERIDO </strong></div></td>
      <?php
<?php	} ?>
	  <?php
<?php	if($totaldesc<>'0.00') {  ?>
	  <?php
<?php	} ?>	 
      <td><div align="center" class="Estilo60 Estilo53"><strong>TOTAL</strong></div></td>
    </tr>
  </table>
  <table width="90%" border="1" bordercolor="#000000" frame="hsides" rules="rows">
    <tr>
      <td><table width="100%" border="0" align="center">
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
		  <td width="47" height="1" style="font-family: Verdana, Geneva, sans-serif">
            <div align="center" class="Estilo76 Estilo79 Estilo74 Estilo128 Estilo111 Estilo53 Estilo61 Estilo60">
             <div align="center" class="Estilo41 Estilo43">
             <span class="Estilo82 Estilo74 Estilo60"><?php
<?php	echo $cant; ?></span></div>
          </div></td>
          <?php
<?php	if($afecto=='S') { $ivasat=""; } else { $ivasat="*"; } ?>
          <td width="17" height="1" style="font-family: Verdana, Geneva, sans-serif"><?php
<?php	echo $ivasat; ?></td>
          <td width="377" style="font-family: Verdana, Geneva, sans-serif"><?php
<?php	echo $medicamento ?> (<?php
<?php	echo $presenta; ?>)          </td>
          <td width="119" style="font-family: Verdana, Geneva, sans-serif">&nbsp;</td>
          <td width="98" style="font-family: Verdana, Geneva, sans-serif"><div align="right" class="Estilo53 Estilo60">
          <span class="Estilo111 Estilo128 "><span class="Estilo82 Estilo74 Estilo128 Estilo111 ">
         	<?php
<?php	if($TipoCliente=='I') {	$preunit=0;  $total=0; } ?>
          <span class="Estilo41 Estilo43"><?php
<?php	echo $preunit; ?></span></span></span></div></td>
			<?php
<?php	if($tipr=='P') {  $sugerido=$fac['precioVP']; 
			if($TipoCliente=='I') {	$total=$sugerido*$cant;	}	 ?>
		  		<td width="98" height="1" style="font-family: Verdana, Geneva, sans-serif"><div align="right" class="Estilo53 Estilo60">
          		<span class="Estilo111 Estilo128 "><span class="Estilo82 Estilo74 Estilo128 Estilo111 ">
       		<span class="Estilo41 Estilo43" style="font-size: 12px">[<?php
<?php	echo $sugerido ?>]</span></span></span></div></td>
          <?php
<?php	} ?>
          <?php
<?php	if($totaldesc<>'0.00') {  ?>
	  		<?php
<?php	} ?>
		  <td width="125" height="1" style="font-family: Verdana, Geneva, sans-serif"><div align="right" class="Estilo53 Estilo60">
          <span class="Estilo111 Estilo128 "><span class="Estilo43 Estilo41  Estilo128"><?php
<?php	echo number_format($total,2); ?></span></span></div></td>
          <?php
<?php	} ?>
          <?php
	 		while($total=mysql_fetch_array($datosm2))
			{
				$totalg=$total['total'];
				$totaldes=$total['totald'];
			?>
        <tr bordercolor="#000000">
          <td rowspan="2" style="font-family: Verdana, Geneva, sans-serif">
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
           <?php
<?php	if($totaldesc<>'0.00') {  ?>
		  <td height="23" colspan="3" class="Estilo53 Estilo135 Estilo60" style="font-family: Verdana, Geneva, sans-serif"><strong>EN ESTA COMPRA USTED AHORRA...</strong></td>
          <td style="font-family: Verdana, Geneva, sans-serif"><div align="center" class="Estilo128 Estilo61 Estilo53 Estilo60">
            <div align="right" class="Estilo43 Estilo41">***.**</div>
          </div></td>
          <?php
<?php	if($tipr=='P') { ?>
          <td style="font-family: Verdana, Geneva, sans-serif"><div align="center" class="Estilo128 Estilo61 Estilo53 Estilo60">
            <div align="right" class="Estilo43 Estilo41">***.**</div>
          </div></td>
          <?php
<?php	} ?>
          <td style="font-family: Verdana, Geneva, sans-serif"><div align="right" class="Estilo135 Estilo138 Estilo61 Estilo53 Estilo60">
            <div align="right" class="Estilo43 Estilo41 Estilo140">***.**</div>
            <?php
<?php	} ?>
          </div></td>
        <tr bordercolor="#000000">
          <td height="23" colspan="3" class="Estilo53 Estilo136 Estilo128 Estilo60"><strong><?php
<?php	echo $texto2; ?></strong></td>
          <th colspan="2"><div align="center" class="Estilo128 Estilo53 Estilo61 Estilo60">
            <p align="right" class="Estilo82 Estilo67 Estilo74"><strong><span class="Estilo82 Estilo67 Estilo74"><span class="Estilo43 Estilo41 Estilo56 Estilo68">Q. <?php
<?php	echo $totalg; ?></span></span></strong></p>
          </div>            </th>
          <?php
<?php	} ?>
      </table></td>
    </tr>
  </table>

  <table width="90%" border="0">
    <tr>
    <?php
<?php	
	  		$subtotal1="SELECT sum(total) as sub1 FROM Ventas v, Bodegam b
						WHERE b.id_producto=v.medicamento AND v.factura='$cod1' AND v.ano='$year'
						AND b.afecto='N'";
			$result1=mysql_query($subtotal1,$link);
			while($dat1=mysql_fetch_array($result1))	{	$subtotalA=$dat1['sub1'];	}
			$subtotal2="SELECT sum(total) as sub2 FROM Ventas v, Bodegam b
						WHERE b.id_producto=v.medicamento AND v.factura='$cod1' AND v.ano='$year'
						AND b.afecto='S'";
			$result2=mysql_query($subtotal2,$link);		
			while($dat2=mysql_fetch_array($result2))	{	$subtotalE=$dat2['sub2'];	}
						
	  ?>
      <td><span style="text-align: left; font-weight: bold;">(*) Producto Gen&eacute;rico exento;  SUBTOTAL EXENTO:   Q.<span style="font-size: 9px"><?php
<?php	echo number_format($subtotalA,2); ?></span> SUBTOTAL AFECTO: Q. <span style="font-size: 9px"><?php
<?php	echo number_format($subtotalE,2); ?></span></span></td>
    </tr>
  </table>
  <table width="50%" border="0">
    <tr>
      <td>&nbsp;</td>
       <?php
<?php	
  	while($cdato=mysql_fetch_array($result))
	{
		$dato=$cdato['comentario'];
	?>
    </tr>
    <tr>
      <td><?php
<?php	if($dato=="") { $dato="***********"; echo $dato; } else { $msg="* "; echo "$msg $dato"; } ?></td>
    </tr>
    <?php
<?php	} ?>
  </table>
  <table width="495" border="0" align="center">
    <tr>
    <td><div align="left" class="Estilo131 Estilo53 Estilo60">
      <p>f.________________________________</p>
</div></td>
    <td><div align="left" class="Estilo131 Estilo53 Estilo60">
      <p>f.________________________________</p>
</div></td>
  </tr>
  <tr>
    <td><div align="center" class="Estilo131"><?php
<?php	echo $Usr ?></div></td>
    <td><div align="center" class="Estilo131 Estilo53 Estilo60"><?php
<?php	echo $nombres ?> <?php
<?php	echo $apellid ?></div>
      <div align="center" class="Estilo131 Estilo53 Estilo60"></div>
    <div align="center" class="Estilo131 Estilo53 Estilo60"></div></td>
  </tr>
  <tr>
    <td><div align="center" class="Estilo135 Estilo53 Estilo60">Responsable de Venta </div></td>
    <td><div align="center" class="Estilo131 Estilo53 Estilo60">
      <p class="Estilo111">Recib&iacute; Conforme </p>
      </div></td>
  </tr>
</table>
<span class="Estilo120"><span class="Estilo119">
</span></span><!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
