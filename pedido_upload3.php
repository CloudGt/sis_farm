<?php	
session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("apdahum");
	$dat1=$_GET['dat1'];
	$dat2=$_GET['dat2'];
	
	$select="SELECT p.pedido, s.descripcion, b.nproducto, p.id_producto, b.existencia,  
					p.solicita, p.solicita2, s.cliente, p.id_bodega, p.npedido
				FROM bodegam b, pedidos p, bodegas s
				WHERE p.id_bodega='$dat1' AND p.npedido='$dat2'
				AND b.id_producto=p.id_producto	AND s.id_bodega=p.id_bodega AND operado='N'";
	$filtro=mysql_query($select,$link);

	
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
.Estilo52 {font-family: Arial, Helvetica, sans-serif; color: #0000FF; font-weight: bold; }
-->
</style>
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
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
-->
</style>
<!-- InstanceEndEditable -->
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
  <p style="font-size: 16px; font-weight: bold;">DESPACHO A FARMACIAS</p>
  <table width="90%" border="1">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td width="25%" height="22" align="center" bgcolor="#FFFF00">SURTIR A FARMACIA</td>
          <td width="36%" align="center" bgcolor="#FFFF00">NOMBRE DEL MEDICAMENTO</td>
          <td colspan="2" align="center" bgcolor="#FFFF00">SOLICITA</td>
          <td width="12%" align="center" bgcolor="#FFFF00">EN BODEGA</td>
          <td width="11%" align="center" bgcolor="#FFFF00">OPERAR</td>
          </tr>
          <? while($res=mysql_fetch_array($filtro))	{	
		  		$medica=$res['id_producto'];	
				$clien=$res['cliente'];	
				$pedido=$res['pedido']; 
				$bodega=$res['id_bodega'];
				$xpedir=$res['npedido']; ?>
        <tr>
          <td height="28" bgcolor="#CCCCCC"><? echo $farma=$res['descripcion']; ?></td>
          <td bgcolor="#CCCCCC"><? echo $medic=$res['nproducto']; ?></td>
          <? 	$pidef1=$res['solicita']; 
		  		$pidef2=$res['solicita2'];
				$enbod1=$res['existencia'];
				$enbod2=$res['existencia2'];
				if($pidef1==0)	{	$pide=$pidef2;	$desplegar="Unidades";	$existe=$enbod2;	}
						else	{	$pide=$pidef1;	$desplegar="";			$existe=$enbod1;	}
		  ?>
          <td width="8%" align="center" bgcolor="#CCCCCC"><? echo $pide; ?></td>
          <td width="8%" align="center" bgcolor="#CCCCCC"><? echo $desplegar; ?></td>
          <td align="center" bgcolor="#CCCCCC"><? echo number_format($existe,0); ?></td>
          <td align="center" bgcolor="#CCCCCC">
		  <? if($existe<$pide) 
		  { 
		  	echo "NO";
			$cambio="UPDATE Pedidos SET operado='S', surtido='N' 
						WHERE npedido='$xpedir' AND id_bodega='$bodega' AND operado='N' AND id_producto='$medica'";
					$registro=mysql_query($cambio,$link);
			}	else	{	echo "SI";	} ?></td>
          </tr>
       <? } ?>   
      </table>
      </td></tr>
    
  </table>
  
  <form name="facturar" method="post" action="return_data.php?eli=11">
    <label>
      <input name="cliente" type="hidden" id="cliente" value="<? echo $clien ?>" size="10" maxlength="10">
      <input name="bodega2" type="hidden" id="bodega2" value="<? echo $bodega ?>" size="10" maxlength="10">
      <input name="pedido2" type="hidden" id="pedido2" value="<? echo $xpedir ?>" size="10" maxlength="10">
      <input type="submit" name="submit" id="button" value="Cerrar Pedido y Generar Envio">
    </label>
  </form>
  
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
