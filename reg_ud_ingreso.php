<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI") 	{	cambiar_ventana("index.php");	exit;	}
	$link=conectarse("apdahum");
	$cod1=$_GET['cod1'];
	$cod2=$_GET['cod2'];
	$buscar="SELECT i.correlativo, b.nproducto, i.lote, i.kduk
				FROM bodegam b, Ingresos i 
				WHERE b.id_producto=i.producto AND i.correlativo='$cod1'";
	$filtro=mysql_query($buscar,$link);
	if($met==1)
	{
		$registro=$_POST['ingreso'];		$lote=$_POST['text1'];		$cadu=$_POST['text2'];
		$cambio="UPDATE Ingresos SET lote='$lote', kduk='$cadu' WHERE correlativo='$registro'";
		$ahora=mysql_query($cambio,$link);
		$prove="SELECT b.id_proveedor, b.id_producto FROM bodegam b, Ingresos i 
				WHERE b.id_producto=i.producto AND i.correlativo='$registro'";
		$result=mysql_query($prove,$link);
		while($datos=mysql_fetch_array($result))	{	$p1=$datos['id_provee'];	$p2=$datos['id_produc'];	}
		header("Location: reg_ingresos.php");
		exit;
		
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
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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
<p>ACTUALIZACI&Oacute;N DE FECHAS DE VENCIMIENTO EN LOTES</p>
<form name="form1" method="post" action="reg_ud_ingreso.php?met=1">
<table width="70%" border="1">
  <tr>
    <td>
  
    <table width="100%" border="0">
      <tr>
        <td align="center" bgcolor="#FFFF33">Registro</td>
        <td align="center" bgcolor="#FFFF33">Descripci&oacute;n del Producto</td>
        <td align="center" bgcolor="#FFFF33">No. Lote</td>
        <td align="center" bgcolor="#FFFF33">Fecha Caducidad</td>
      </tr>
      <? 
	  	while($dato=mysql_fetch_array($filtro))
		{
			$regp=$dato['correlativo'];
			$npro=$dato['nproducto'];
			$lote=$dato['lote'];
			$cadu=$dato['kduk'];
	  ?>
      <tr>
        <td height="41" align="center"><? echo $regp ?></td>
        <td align="left"><label>
          <input name="ingreso" type="hidden" id="ingreso" value="<? echo $regp ?>">
        </label>          
          <? echo $npro ?></td>
        <td align="center"><span id="sprytextfield1">
          <label>
            <input name="text1" type="text" id="text1" value="<? echo $lote ?>" size="20" maxlength="20">
          </label>
          <span class="textfieldRequiredMsg">¿?</span></span></td>
        <td align="center"><span id="sprytextfield2">
          <label>
            <input name="text2" type="text" id="text2" value="<? echo $cadu ?>" size="10" maxlength="10">
          </label>
          <span class="textfieldRequiredMsg">¿?</span></span></td>
      </tr>
      <? } ?>
      <tr>
        <td colspan="4" align="center" bgcolor="#D9E9CC">
          <label>
            <input type="submit" name="button" id="button" value="Registrar Cambios">
          </label>
        </td>
        </tr>
    </table></td>
  </tr>
</table>
</form>

<p>&nbsp;</p>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
