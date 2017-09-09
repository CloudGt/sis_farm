<?php	
session_start();
	include("sysconect.php");
	// Verifica si hubo inicio de sesión
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}

	$link=conectarse("Apdahum");

//Variables de esta aplicación
	$met=$_GET['met'];
	$nombre=$_POST['Proveedor']; $nombre=strtoupper($nombre);		
	$selec = "SELECT Id_proveedor, upper(Nom_provee) Nom_provee FROM Proveedores WHERE Activo='S' ORDER BY 2";
	$datosm1 = mysql_query($selec,$link);
	$selec="SELECT count(*) as total FROM Proveedores";
	$datosm2= mysql_query($selec,$link);
	$selec = "SELECT id_proveedor, upper(nom_provee) nom_provee FROM Proveedores WHERE Activo='N' ORDER BY 2";
	$datosm3= mysql_query($selec,$link);
//Registra Nuevo Proveedor
	if ($met==1)
	{
		// Verifica que Proveedor no exista 
		$selec="SELECT * FROM Proveedores WHERE Nom_provee like ('%$nombre%')";		
		$rs_cons = mysql_query($selec,$link);
		while(mysql_fetch_array($rs_cons))
		{
			error_msg("ESTE PROVEEDOR YA EXISTE, VERIFIQUE");
		}
		$insert="INSERT INTO Proveedores (id_proveedor, Nom_provee, Activo) VALUES('','$nombre', 'S')";
		$r_insert=mysql_query($insert,$link);
		if (mysql_errno($link)==0)
			{ 
				error_msg("SE ASIGNA NUEVO PROVEEDOR AL SISTEMA");
			}
	}
?>	

<script language="JavaScript"><!--

	function CambioOpcion(targ,selObj,restore)
	{
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selected;
	}	
//--></script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>&nbsp;</TITLE>
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

<BODY onLoad="document.Proveedor.Proveedor.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<p>&nbsp;</p>
<form name="Proveedor" method="post" action="reg_proveedor.php?met=1">
<div align="center">
  <table width="45%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr>
      <td><table width="100%" border="0" bordercolor="#9CD8A7">
        <tr bordercolor="#F8F8F6">
          <td colspan="2"><div align="center"><strong>REGISTRO DE PROVEEDORES </strong></div></td>
          </tr>
        <tr bordercolor="#F8F8F6">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr bordercolor="#F8F8F6">
          <td><span class="Estilo52">C&oacute;digo del Proveedor: </span></td>
          <? 
    		while($final=mysql_fetch_array($datosm2))
			{
				$ultimo=$final['total'];
				$siguiente=$ultimo+1; ?>
          <td><span class="Estilo53"><? echo $siguiente ?></span></td>
          <? } ?>
          </tr>
        <tr bordercolor="#F8F8F6">
          <td><span class="Estilo52">Nombre del Proveedor: </span></td>
          <td><span id="sprytextfield1">
            <input name="Proveedor" type="text" id="Proveedor" size="40" maxlength="40" onKeyUp="javascript:this.value=this.value.toUpperCase();">
            <span class="textfieldRequiredMsg">¿?</span></span></td>
          </tr>
        <tr bordercolor="#F8F8F6">
          <td colspan="2">&nbsp;</td>
          </tr>
        <tr bordercolor="#F8F8F6" bgcolor="#D9E9CE">
          <td colspan="2"><div align="center">
            <input name="Registrar" type="submit" id="Registrar5" value="Registrar Proveedor">
            </div></td>
          </tr>
        <tr bordercolor="#F8F8F6">
          <td colspan="2">&nbsp;</td>
          </tr>
        <tr bordercolor="#F8F8F6">
          <td colspan="2"><div align="center"><strong>ACTIVACION / DESACTIVACI&Oacute;N </strong></div></td>
          </tr>
        <tr bordercolor="#F8F8F6">
          <td colspan="2">&nbsp;</td>
          </tr>
        <tr bordercolor="#F8F8F6">
          <td colspan="2"><div align="right"><span class="Estilo52">Desactivar Proveedores: <span class="Estilo3"><span class="Estilo3 Estilo9">
            <select name="select2" size="1" id="select5" onChange="CambioOpcion('self',this,0)">
              <option value="">Todos los Proveedores</option>
              <?														
			while($nomp=mysql_fetch_array($datosm1))						
			{													
				$codigo =$nomp['Id_proveedor'];
				$descrip =$nomp['Nom_provee'];
				if ($codigo == ($cod1))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_ud_proveedor.php?cod1=".$codigo."\">".$descrip."</option>\n";				
	    }?>
              </select>
            </span></span></span></div></td>
          </tr>
        <tr bordercolor="#F8F8F6">
          <td colspan="2"><div align="right"><span class="Estilo52">Activar Proveedores : <span class="Estilo3"><span class="Estilo3 Estilo9">
            <select name="select" size="1" id="select6" onChange="CambioOpcion('self',this,0)">
              <option value="">Todos los Proveedores</option>
              <?														
			while($nompr=mysql_fetch_array($datosm3))						
			{													
				$codigo =$nompr['id_proveedor'];
				$descrip=$nompr['nom_provee'];
				if ($codigo == ($cod1))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_ud_proveedor.php?cod1=".$codigo."\">".$descrip."</option>\n";				
	    }?>
              </select>
            </span></span></span></div></td>
          </tr>
        <tr bordercolor="#F8F8F6">
          <td colspan="2">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
