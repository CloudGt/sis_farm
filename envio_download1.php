<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("apdahum");
	$cod1=$_GET['cod1'];
	$selec="SELECT count_venta FROM Parameters";
	$busca=mysql_query($selec,$link);
	while($dat=mysql_fetch_array($busca))	{	$ultimo=$dat['count_venta'];	$anterior=$ultimo-1;	}
	
	$select="SELECT * FROM Bodegas ORDER BY descripcion";
	$datosm1=mysql_query($select,$link);
	
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
.Estilo60 {font-size: 16}
.Estilo62 {	color: #0000FF;
	font-weight: bold;
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
<script language="JavaScript"><!--
	function CambioOpcion(targ,selObj,restore)
	{
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
//--></script>
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
<p>M&Oacute;DULO DE DESGARGA DE ARCHIVO ELECTR&Oacute;NICO</p>
<p>GENERACI&Oacute;N DE ENVIO PARA FARMACIA</p>
<form name="envios" method="post" action="envio_download2.php">
<table width="50%" border="0" bgcolor="#DBEACD">
  <tr>
    <td><div align="center"><span class="Estilo1">Pedido para descargar... <span id="sprytextfield1">
          <input name="pedi1" type="text" id="Pedito" value="<? echo $ultimo; ?>" size="9" maxlength="9">
          <span class="textfieldRequiredMsg">?.</span><span class="textfieldInvalidFormatMsg">no válido.</span><span class="textfieldMinValueMsg">?.</span></span><span id="sprytextfield2"><span class="textfieldRequiredMsg">?</span><span class="textfieldInvalidFormatMsg">no válido.</span><span class="textfieldMinValueMsg">?</span></span>
<input name="Submit4" type="submit" id="Submit4" value="Descargar...">
      </span></div></td>
    </tr>
</table>
</form>
<form name="pedidogeneral" id="pedidogeneral" method="post" action="envio_download3.php">
<p>&nbsp;</p>
<p>SELECCIONE SUCURSAL, ENVIO INICIAL Y ENVIO FINAL PARA GENERAR UN SOLO ARCHIVO</p>
<form name="pedidogeneral" method="post" action="envio_download3.php" id="pedidogeneral">
<table width="60%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
  <tr>
    <td align="center">ENVIOS DE SUCURSAL</td>
    <td align="center">Pedido Inicial</td>
    <td align="center">Pedido Final</td>
  </tr>
  <tr>
    <td align="center"><span id="sprytextfield5">
      <label>
        <input name="sucur" type="hidden" id="sucur" value="<?= $cod1; ?>" size="10" maxlength="10">
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
      <select name="Clasifica" size="1" id="Clasifica" onChange="CambioOpcion('self',this,0)">
      <option value="envio_download1.php?cod1=<? echo $cod1 ?>">Sucursal...</option>
      <?														
				while($prese=mysql_fetch_array($datosm1))						
				{													
					$idbodega   = $prese['id_bodega'];			
					$descripcion= $prese['descripcion'];
					if ($idbodega == ($cod1))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"envio_download1.php?cod1=".$idbodega."\">".$descripcion."</option>\n";				
	         } 
			 @mysql_free_result($sqlsel_opme);
			 ?>
    </select></td>
    <td align="center"><span id="sprytextfield3">
      <label>
        <input name="pini" type="text" id="pini" size="10" maxlength="10">
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    <td align="center"><span id="sprytextfield4">
      <label>
        <input name="pfin" type="text" id="pfin" size="10" maxlength="10">
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><label>
      <input type="submit" name="button" id="button" value="Generar Envio">
    </label></td>
    </tr>
</table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur"], minValue:1});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["blur"], minValue:1});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
