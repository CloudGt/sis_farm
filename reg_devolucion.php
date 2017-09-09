<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	
	$fact=$_POST['factura'];	$cod1=$_GET['cod1'];	$year=$_POST['anio'];	$met=$_GET['met'];
	
	$selec="SELECT factura, count(*) as conteo FROM  Ventas WHERE ano='$year' ";
	if($fact)	{	$selec=$selec." AND factura='$fact' ";	}
	if($cod1)	{	$selec=$selec." AND factura='$cod1' ";	}
	$selec=$selec." AND Operado='S' GROUP BY factura";
	$buscatotal=mysql_query($selec,$link);
	while($result=mysql_fetch_array($buscatotal))	{	$activos=$result['conteo'];	}
	if($met==1)
	{
		if (!$fact)
		{
			$selec= "SELECT c.salida, upper(a.nproducto) as nproducto, upper(b.presentacion) as presentacion, c.punitario, 
							c.cantidad, c.descuentos, c.total, c.factura
               		FROM bodegam as a, presentacion as b, ventas as c
		            WHERE  a.id_producto=c.medicamento AND a.presentacion=b.id_presenta AND c.operado='S' AND c.ano in (2013,2014)";
			 //if ($fact) {$selec = $selec." AND c.factura='$fact'";}
			 if ($cod1) {$selec = $selec." AND c.factura='$cod1'";} 
			$selec = $selec." ORDER BY a.nproducto";
			$filtro= mysql_query($selec,$link);
		}
		else
		{
			$selec= "SELECT c.salida, upper(a.nproducto) as nproducto, upper(b.presentacion) as presentacion, c.punitario, 
							c.cantidad, c.descuentos, c.total, c.factura
               		 FROM bodegam as a, presentacion as b, ventas as c
	                 WHERE  a.id_producto=c.medicamento AND a.presentacion=b.id_presenta  AND c.operado='S' AND c.ano>2013";
			 if ($fact) {$selec = $selec." AND c.factura='$fact'";}
			 if ($cod1) {$selec = $selec." AND c.factura='$cod1'";} 
			$selec = $selec." ORDER BY a.nproducto";
			$filtro= mysql_query($selec,$link);
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Dise&ntilde;o y Programaci&oacute;n LDCP</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
.Estilo60 {font-size: 16}
-->
</style>
<style type="text/css">
<!--
.Estilo79 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
.Estilo80 {font-weight: bold}
-->
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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

<BODY onLoad="document.form1.factura.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<form name="form1" method="post" action="reg_devolucion.php?met=1">
  <div align="left"><span class="Estilo53 Estilo54"><em>Modificar Documento:</em></span>      
    <span id="sprytextfield1">
    <input name="factura" type="text" id="factura" value="<? echo $cod1 ?>" size="5" maxlength="5">
    <span class="textfieldRequiredMsg">Falta Salida</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span> .<span id="sprytextfield2">
    <label>
      <input name="anio" type="text" id="anio" value="2015" size="4" maxlength="4">
    </label>
    <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>.
<input type="submit" name="Submit" value="Verificar">
  </div>
</form>
<table width="90%" border="0" align="center">
  <tr bgcolor="#FFFFCC">
    <td bgcolor="#3366FF"><div align="center" class="Estilo99 Estilo98 Estilo112 Estilo111 Estilo113 Estilo57 Estilo53 Estilo73 Estilo63  Estilo79 Estilo80">
        <div align="center"><span class="Estilo63 ">REG</span>.</div>
    </div></td>
    <td bgcolor="#3366FF"><div align="center" class="Estilo114 Estilo57 Estilo53 Estilo73 Estilo63 Estilo79 Estilo80">
        <div align="center"><span class="Estilo109 Estilo98 Estilo63">MEDICAMENTO</span></div>
    </div></td>
    <td bgcolor="#3366FF"><div align="center" class="Estilo115 Estilo57 Estilo53 Estilo73 Estilo63 Estilo79 Estilo80">
        <div align="center">PRESENTA</div>
    </div></td>
    <td bgcolor="#3366FF"><div align="center" class="Estilo115 Estilo57 Estilo53 Estilo73 Estilo63 Estilo79 Estilo80">
        <div align="center" class="Estilo63 ">PRECIO U. </div>
    </div></td>
    <td bgcolor="#3366FF"><div align="center" class="Estilo57 Estilo53 Estilo65 Estilo63 Estilo79 Estilo80">
        <div align="center" class="Estilo128 Estilo109 Estilo98 Estilo111 Estilo54 Estilo63  Estilo53">SOLICITA</div>
    </div></td>
    <td bgcolor="#3366FF"><div align="center" class="Estilo115 Estilo57 Estilo53 Estilo73 Estilo63 Estilo79 Estilo80">
        <div align="center"><span class="Estilo98 Estilo109 ">DESC.</span></div>
    </div></td>
    <td colspan="3" bgcolor="#3366FF"><div align="center" class="Estilo79 Estilo63 Estilo73 Estilo53 Estilo110"><span class="Estilo63 " style="font-weight: bold; font-size: 14px;">TOTAL</span></div>
        <div align="center" class="Estilo79 Estilo63 Estilo73 Estilo53 Estilo115"></div>
        <div align="center" class="Estilo116 Estilo3 Estilo57 Estilo53 Estilo73 Estilo63 Estilo79 Estilo80">
          <div align="center" class="Estilo63 "></div>
      </div></td>
  </tr>
  <?  while($salio=mysql_fetch_array($filtro))	{	?>
  <tr>
  <? $thisfact=$salio['factura']; ?>
    <td height="32" bgcolor="#CCCCCC" style="font-size: 12px"><div align="center"><span class="Estilo53 Estilo55"><? echo $thisfact; ?>-<? echo $salio['salida'] ?></span></div></td>
    <td bgcolor="#FFFFCC" style="font-size: 12px"><span class="Estilo53 Estilo55"><? echo $salio['nproducto'] ?></span></td>
    <td bgcolor="#CCCCCC" style="font-size: 12px"><div align="center"><span class="Estilo53 Estilo55"><? echo $salio['presentacion'] ?></span></div></td>
    <td bgcolor="#FFFFCC" style="font-size: 12px"><div align="right"><span class="Estilo53 Estilo55"><? echo number_format($salio['punitario'],2) ?></span></div></td>
    <td bgcolor="#CCCCCC" style="font-size: 12px"><div align="center"><a href="reg_devolucionp.php?id=<? echo $salio['salida']; ?>&id2=1" title="Actualiza Pedido..." target="mainFrame"><? echo $salio['cantidad'] ?></a></div></td>
    <td bgcolor="#FFFFCC" style="font-size: 12px"><div align="right"><span class="Estilo53 Estilo55"><? echo number_format($salio['descuentos'],2) ?></span></div></td>
    <td width="4%" bgcolor="#CCCCCC"><div align="left"><span class="Estilo53 Estilo54"><strong>Q.</strong></span></div></td>
    <td bgcolor="#FFFFCC"><div align="right"><span class="Estilo53 Estilo54"><strong><? echo number_format($salio['total'],2) ?></strong></span></div></td>
    <td width="4%" align="center" bgcolor="#CCCCCC"><a href="return_data.php?eli=2&id=<? echo $salio['salida']; ?>&id2=1" title="Retornar Pedido completo..." target="mainFrame"><img src="images/iconos/button_drop.png" width="13" height="16" border="0"></a></td>
    <? 	}	mysql_free_result($filtro);		?>
  <tr>
    <?
			$selec="SELECT sum(total) as total FROM ventas WHERE factura='$thisfact' and ano >2013";
			$cantidad=mysql_query($selec,$link);
			while($tf=mysql_fetch_array($cantidad))
			{
				$totalg=$tf['total'];
			?>
    <td height="20" colspan="9" bgcolor="#3366FF">
      <div align="center" class="Estilo54 Estilo116  Estilo69" style="font-family: Verdana, Geneva, sans-serif; font-size: 14px; font-weight: bold;">Total a Pagar... <span class="Estilo82 Estilo74"><span class="Estilo60"><span class="Estilo43 Estilo41 Estilo69  Estilo70"><span class="Estilo43 Estilo41 Estilo69  Estilo71">Q. <? echo number_format($totalg,2) ?></span></span></span></span></div>
      <div align="center" class="Estilo53 Estilo54">
        <div align="left" class="Estilo60"><strong><span class="Estilo43 Estilo41 Estilo56"> </span></strong></div>
    </div></td>
    <? } ?>
  <tr>
    <td height="20" colspan="9">
    <? if($activos < 26)	{	$facturaA=$thisfact;	?>
    
    <a href="reg_ventas2.php?factura=<? echo $thisfact; ?>" title="Agregar Pedido..." target="mainFrame">
    <img src="images/iconos/Abrir.png" width="33" height="33" border="0">
	</a><? } ?></td>
  </table>
<p>&nbsp;</p>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
