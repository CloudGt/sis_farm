<?php	
session_start();
	include("sysconect.php");
	// Verifica si hubo inicio de sesión
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}

	$link=conectarse("Apdahum");
//Variables de esta aplicación
	$met=$_GET['met'];
	
//Registra Presentacion Nueva
	if ($met==1)
	{
		$presenta=$_POST['Presentacion']; 		
		$cambio=$_POST['cambio'];
		if($cambio==0)
		{
			// Verifica que Presentacion no exista 
			$selec="SELECT * FROM Presentacion WHERE Presentacion LIKE('%$presenta%') AND activo='S'";		
			$rs_cons = mysql_query($selec,$link);
			while(mysql_fetch_array($rs_cons))
			{
				error_msg("YA EXISTE ESTA PRESENTACION");
			}
			$insert="INSERT INTO Presentacion (Id_presenta, Presentacion) VALUES('','$presenta')";
			$r_insert=mysql_query($insert,$link);
			if (mysql_errno($link)==0)
			{ 
				error_msg("NUEVA PRESENTACION REGISTRADA SATISFACTORIAMENTE...");
				cambiar_ventana("reg_presenta.php");
				exit;
			}
		}
		else
		{
			$actual="UPDATE Presentacion SET Presentacion='$presenta' WHERE id_presenta='$cambio'";
			$daleud=mysql_query($actual,$link);
			envia_msg("Edición de Presentación a: $presenta");
			$met=0;		$cod1=0;	$cod2="";
			cambiar_ventana("reg_presenta.php?cod2=$cod2");
			exit;
		}
	}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Farmacia</TITLE>
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
.Estilo54 {color: #0000FF}
-->
</style>
<style type="text/css">
<!--
.Estilo55 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
.Estilo56 {font-size: 10px}
-->
</style>
<style type="text/css">
<!--
.Estilo57 {
	color: #FF0000;
	font-size: 12px;
}
-->
</style>
<style type="text/css">
<!--
.Estilo58 {color: #00A653}
-->
</style>
<style type="text/css">
<!--
body {
	background-image: url(images/iconos/Medicamento.png);
	background-repeat: no-repeat;
}
-->
</style>
<style type="text/css">
<!--
.Estilo59 {font-weight: bold}
-->
</style>
<style type="text/css">
<!--
.Estilo60 {font-size: 14px}
-->
</style>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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

<BODY onLoad="document.Presentacion.Presentacion.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
  <form name="Presentacion" method="post" action="reg_presenta.php?met=1">
    <table border="0">
      <tr>
        <td><table border="0">
          <tr>
            <td><div align="center"><strong>REGISTRO DE PRESENTACIONES DE PRODUCTOS </strong></div></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td><div align="center"><span class="Estilo52">
              <label>
                <input name="cambio" type="hidden" id="cambio" value="<? echo $cod2 ?>">
                </label>
              Descripci&oacute;n</span><span id="sprytextfield1">
                <input name="Presentacion" type="text" id="Presentacion" onKeyUp="javascript:this.value=this.value.toUpperCase();" value="<? echo $cod1; ?>" size="25" maxlength="25">
                <span class="textfieldRequiredMsg">¿?</span></span></div></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td bgcolor="#6699FF"><div align="center"><span class="en_tabla">
              <input type="submit" name="agregar" value="<? if ($cod1) { ?> Actualizar <? } else { ?> Registrar <? } ?> ">
            </span></div></td>
            </tr>
          </table></td>
      </tr>
    </table>
</form>
<table width="40%" border="0" frame="box" rules="rows">
  <tr>
    <td width="10%" align="center" bgcolor="#FFFF99">C&oacute;digo</td>
    <td width="77%" align="center" bgcolor="#FFFF99">Descripci&oacute;n de la Presentaci&oacute;n</td>
    <td colspan="2" align="center" bgcolor="#FFFF99">Acci&oacute;n</td>
    </tr>
  <?php  	$busca="SELECT id_presenta, upper(presentacion) presentacion FROM Presentacion WHERE activo='S' ORDER BY 2";
	$buscar=mysql_query($busca,$link);
	while($result=mysql_fetch_array($buscar))
	{
		$idpresent=$result['id_presenta'];
		$presentac=$result['presentacion'];
	?>
  <tr>
    <td height="33" align="center" bgcolor="#D9EAC8"><? echo $idpresent; ?></td>
    <td bgcolor="#CCCCCC"><? echo $presentac; ?></td>
    <td width="9%" align="center" bgcolor="#D9EAC8">
    <a href="reg_presenta.php?cod1=<? echo $result['presentacion']; ?>&cod2=<? echo $result['id_presenta'];?>" 
    		title="Editar presentación" target="mainFrame">
    <img src="images/iconos/b_edit1.png" alt="Editar presentaci&oacute;n" width="16" height="16" border="0"></a></td>
    <td width="4%" align="center" bgcolor="#CCCCCC">
     <a href="return_data.php?eli=8&id=<? echo $result['id_presenta'];?>" title="Eliminar presentación" target="mainFrame">
    <img src="images/iconos/button_drop.png" alt="Eliminar presentaci&oacute;n" width="16" height="16" border="0"></a></td>
  </tr>
  <? } ?>
</table>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
