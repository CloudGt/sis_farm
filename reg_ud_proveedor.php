<?php	
session_start();
	include("sysconect.php");
	// Verifica si hubo inicio de sesión
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}

	$link=conectarse("Apdahum");
	$met=$_GET['met']; 	$cod1=$_GET['cod1'];
	$nombre=$_POST['Proveedor']; $nombre=strtoupper($nombre);
	$codigo=$_POST['Caja1'];
	$activa=$_POST['Activo'];
				
	$selec= "SELECT Id_proveedor, Nom_provee, Activo FROM Proveedores WHERE id_proveedor='$cod1'";
	$datosm1=mysql_query($selec,$link);
			
//Actualiza Proveedor
	if ($met==1)
	{
		if($activa=='N')
		{
			$selec="SELECT Sum(existencia) as suma FROM Bodegam WHERE  id_proveedor='$codigo'";
			$busca=mysql_query($selec,$link);
			while($total=mysql_fetch_array($busca))
			{
				$existe=$total['suma'];
				if($existe!=0)
				{
					envia_msg("NO ES POSIBLE DESACTIVAR PROVEEDOR, HAY EXISTENCIA DE PRODUCTOS EN BODEGA");
					cambiar_ventana("reg_proveedor.php");
					exit;
				}
			}
		}
		$insert="UPDATE Proveedores SET Nom_provee='$nombre', Activo='$activa' WHERE id_proveedor='$codigo'";
		$r_insert=mysql_query($insert,$link);
		if (mysql_errno($link)==0)
			{ 
				envia_msg("ACTUALIZACION DE DATOS EXITOSA");
				cambiar_ventana("reg_proveedor.php");
				exit;
			}
	}
?>	

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
<style type="text/css">
<!--
.Estilo54 {color: #0000FF}
-->
</style>
<style type="text/css">
<!--
.Estilo55 {color: #FF0000}
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
<form name="Proveedor" method="post" action="reg_ud_proveedor.php?met=1">
    <div align="center">
      <p>&nbsp;</p>
      <table width="50%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
        <tr>
          <td><table width="100%" border="0" bordercolor="#9CD8A7">
            <tr bordercolor="#F8F8F6">
              <td colspan="2"><div align="center"><strong>ACTUALIZACION DE PROVEEDORES </strong></div></td>
              </tr>
            <tr bordercolor="#F8F8F6">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr bordercolor="#F8F8F6">
              <td><span class="Estilo52">C&oacute;digo del Proveedor: </span></td>
              <td><span class="Estilo53"><? echo $cod1 ?>
                    <input name="Caja1" type="hidden" id="Caja1" value="<? echo $cod1 ?>">
              </span></td>
            </tr>
            <?php			while($lista=mysql_fetch_array($datosm1))
			{
				$codigo=$lista['Id_proveedor'];
				$nombre=$lista['Nom_provee'];
				$act=$lista['Activo'];
			?>
            <tr bordercolor="#F8F8F6">
              <td><span class="Estilo52">Nombre del Proveedor: </span></td>
              <td><span id="sprytextfield1">
                <input name="Proveedor" type="text" id="Proveedor" value="<? echo $nombre ?>" size="40" maxlength="40" onKeyUp="javascript:this.value=this.value.toUpperCase();">
                <span class="textfieldRequiredMsg">¿?</span></span></td>
            </tr>
            <tr bordercolor="#F8F8F6">
              <td colspan="2"><div align="center"><span class="Estilo74 Estilo53">
                  <?php			if($act=='S')
			{ ?>
                   <span class="Estilo54"><strong>Activo
                   <input name="Activo" type="radio" value="S" checked>
                   </strong></span>        Inactivo
        <input name="Activo" type="radio" value="N">
        <? } ?>
        <?php			if($act=='N')
			{ ?>
        Activo
        <input name="Activo" type="radio" value="S">
         <span class="Estilo54"><strong><span class="Estilo55">Inactivo</span>         
         <input name="Activo" type="radio" value="N" checked>
         </strong></span>         <? } ?>
              </span> </div></td>
            </tr>
            <tr bordercolor="#F8F8F6">
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr bordercolor="#F8F8F6" bgcolor="#D9E9CC">
              <td colspan="2"><div align="center">
                <input name="Registrar" type="submit" id="Registrar2" value="Actualizar Proveedor">
              </div></td>
            </tr>
            <? } ?>
          </table></td>
        </tr>
      </table>
      <p>&nbsp;      </p>
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
