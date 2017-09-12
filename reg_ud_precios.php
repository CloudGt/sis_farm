<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
//Variables de esta aplicación
	$a=$_SESSION['Nom'];
	$p=$_SESSION['Ape'];
	$c=$_SESSION['Usr'];
	$met=$_GET['met'];
	$cod1=$_GET['cod1'];
	$cod2=$_GET['cod2'];
			
//Consultas y Popup's
	$selec = "SELECT Id_proveedor, upper(Nom_provee) as Nom_provee FROM Proveedores WHERE Activo='S' ORDER BY nom_provee";
	$datosm1 = mysql_query($selec,$link);
	if ($cod1 != 0)
	{
		$selec = "SELECT Id_producto, upper(NProducto) as NProducto 
					FROM bodegam WHERE Id_proveedor='$cod1' AND Activo='S' ORDER BY Nproducto";
		$datosm2 = mysql_query($selec,$link);
	}
	else
	{
		$selec = "SELECT Id_producto, upper(NProducto) as NProducto FROM bodegam WHERE Activo='S' ORDER BY nproducto";
		$datosm2 = mysql_query($selec,$link);
	}
		
//Actualiza Precios
	if ($met==1)
	{
		$casa=$_POST['Caja1'];
		$nomb=$_POST['Caja2'];
		$pc1=$_POST['Pcosto'];		$pc2=$_POST['Pcosto2'];
		$pv1=$_POST['PventaA'];		$pv2=$_POST['PventaB'];	
		$pv3=$_POST['PventaC'];		$pv4=$_POST['PventaD'];	
		$pv5=$_POST['PventaE'];		$pv7=$_POST['PventaG'];	
		$pv6=$_POST['PventaP'];		$pv8=$_POST['PventaH'];
		$pv12=$_POST['PventaA2'];	$pv22=$_POST['PventaB2'];	
		$pv32=$_POST['PventaC2'];	$pv42=$_POST['PventaD2'];	
		$pv52=$_POST['PventaE2'];	$pv72=$_POST['PventaG2'];
		$pv62=$_POST['PventaP2'];	$pv82=$_POST['PventaH2'];
		$fecha=date('Y-m-d H:i:s');

		$selec="UPDATE Bodegam 
		SET PrecioCosto='$pc2', PrecioC1='$pv12', PrecioC2='$pv22', PrecioC3='$pv32', PrecioC4='$pv42', 
			PrecioC5='$pv52', PrecioC6='$pv72', PrecioC7='$pv82', PrecioVP='$pv62' 
		WHERE id_producto='$nomb'";
		$modifica=mysql_query($selec,$link);
		$insert="INSERT INTO 
		Precios (Correlativo,Producto,Opc,Npc,Opv1,Npv1,Opv2,Npv2,Opv3,Npv3,Opv4,Npv4,Opv5,Npv5,Opv6,Npv6,Fecha,Usuario) 
VALUES('','$nomb','$pc1','$pc2','$pv1','$pv12','$pv2','$pv22','$pv3','$pv32','$pv4','$pv42','$pv5','$pv52','$pv7','$pv72','$pv6','$pv62','$fecha','$Usr')";
		$historial=mysql_query($insert,$link);
		error_msg("Actualizacion de precios satisfactoria...");
		cambiar_ventana("reg_ud_precios.php");
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
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language="JavaScript"><!--
	function CambioOpcion(targ,selObj,restore)
	{
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selected;
	}	
//--></script>
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
<style type="text/css">
<!--
.Estilo2 {font-size: 14px}
-->
</style>
<style type="text/css">
<!--
.Estilo3 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
.Estilo4 {color: #0000FF}
-->
</style>
<style type="text/css">
<!--
.Estilo5 {color: #FF0000}
-->
</style>
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

<BODY onLoad="document.Medicamento.select.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
  <form name="Medicamento" method="post" action="reg_ud_precios.php?met=1">
    <table width="75%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr>
      <td><table width="100%" border="0">
        <tr bordercolor="#ECE9D8">
          <td height="36" colspan="9" bgcolor="#D9E9CC"><div align="center"><strong>ACTUALIZACI&Oacute;N DE PRECIOS </strong></div></td>
          </tr>
        <tr bordercolor="#ECE9D8">
          <td colspan="9">&nbsp;</td>
          </tr>
        <tr bordercolor="#ECE9D8">
          <td colspan="9"><div align="right">
            <input name="Caja1" type="hidden" id="Caja1" value="<?php
<?php	echo $cod1 ?>">
            <select name="Casaf" size="1" id="Casaf" onChange="CambioOpcion('self',this,0)">
              <option value="reg_ud_precios.php">Casa Farmaceutica</option>
              <?														
				while($casa=mysql_fetch_array($datosm1))						
				{													
					$idcasa  =$casa['Id_proveedor'];
					$descripc=$casa['Nom_provee'];
					if ($idcasa == ($cod1))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"reg_ud_precios.php?cod1=".$idcasa."\">".$descripc."</option>\n";				
	         } ?>
              </select>
            </div></td>
          </tr>
        <tr bordercolor="#ECE9D8">
          <td colspan="9"><div align="right">
            <input name="Caja2" type="hidden" id="Caja2" value="<?php
<?php	echo $cod2 ?>">
            <select name="select" size="1" id="select" onChange="CambioOpcion('self',this,0)">
              <option value="reg_ud_precios.php?cod2=0&cod1=<?php
<?php	echo $cod1 ?>">Nombre del Medicamento</option>
              <?														
				while($medi=mysql_fetch_array($datosm2))						
				{													
					$idprod =$medi['Id_producto'];
					$nprodu =$medi['NProducto'];
					if ($idprod == ($cod2))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"reg_ud_precios.php?cod2=".$idprod."&cod1=".$cod1."\">".$nprodu."</option>\n";				
	         } ?>
              </select>
            </div></td>
          </tr>
        <tr bordercolor="#CCCCCC">
          <td bordercolor="#ECE9D8"><span class="Estilo1"><span class="Estilo2 Estilo59"><strong>
            <?php
	  	$selec= "SELECT Id_producto, PrecioCosto, PrecioC1, PrecioC2, PrecioC3, PrecioC4, PrecioC5, PrecioC6, PrecioC7, PrecioVP 
					FROM Bodegam WHERE id_producto='$cod2'";
		$datosm3=mysql_query($selec,$link);
		while ($pr=mysql_fetch_array($datosm3))
	  	{
	  		$pcosto=$pr['PrecioCosto'];
			$p1=$pr['PrecioC1'];
			$p2=$pr['PrecioC2'];
			$p3=$pr['PrecioC3'];
			$p4=$pr['PrecioC4'];
			$p5=$pr['PrecioC5'];
			$p7=$pr['PrecioC6'];
			$p8=$pr['PrecioC7'];
			$p6=$pr['PrecioVP'];
		?>
            </strong></span></span></td>
          <td colspan="7" bordercolor="#ECE9D8"><div align="center"><strong>***</strong></div></td>
          <td bordercolor="#ECE9D8"><span class="Estilo1"><span class="Estilo2 Estilo59"><strong>
            </strong></span></span></td>
          </tr>
        <tr bordercolor="#CCCCCC">
          <td bordercolor="#ECE9D8" bgcolor="#D9E9CC"><div align="center" class="Estilo1"><strong>Costo</strong></div></td>
          <td bordercolor="#ECE9D8" bgcolor="#D9E9CC"><div align="center" class="Estilo1 Estilo2">A</div></td>
          <td bordercolor="#ECE9D8" bgcolor="#D9E9CC"><div align="center" class="Estilo1 Estilo2">Promotor</div></td>
          <td bordercolor="#ECE9D8" bgcolor="#D9E9CC"><div align="center" class="Estilo1 Estilo2"><span class="Estilo68"><span class="Estilo69">C </span></span></div></td>
          <td bordercolor="#ECE9D8" bgcolor="#D9E9CC"><div align="center" class="Estilo1 Estilo2"><span class="Estilo68"><span class="Estilo69">D </span></span></div></td>
          <td align="center" bordercolor="#ECE9D8" bgcolor="#D9E9CC"><span class="Estilo1 Estilo2"><span class="Estilo68"><span class="Estilo69">E </span></span></span></td>
          <td bordercolor="#ECE9D8" bgcolor="#D9E9CC"><div align="center" class="Estilo1 Estilo2">Visita</div></td>
          <td align="center" bordercolor="#ECE9D8" bgcolor="#D9E9CC"><span class="Estilo1 Estilo2">Mayorista</span></td>
          <td bordercolor="#ECE9D8" bgcolor="#D9E9CC">
            <div align="center" class="Estilo2 Estilo1"><strong>P&uacute;blico</strong></div></td>
          </tr>
        <tr bordercolor="#CCCCCC">
          <td height="32" bordercolor="#ECE9D8"><div align="center" class="Estilo3 Estilo1 Estilo4">
            <div align="center"><strong><span class="Estilo77">Q. <?php
<?php	echo $pcosto ?></span>
              <input name="Pcosto" type="hidden" id="Pcosto3" value="<?php
<?php	echo $pcosto ?>">
              </strong></div>
            </div></td>
          <td bordercolor="#ECE9D8"><div align="center" class="Estilo3 Estilo1 Estilo4">
            <div align="center"><strong><span class="Estilo77">Q. <?php
<?php	echo $p1 ?></span>                  <input name="PventaA" type="hidden" id="PventaA" value="<?php
<?php	echo $p1 ?>">
              </strong></div>
            </div></td>
          <td bordercolor="#ECE9D8">
            <div align="center" class="Estilo3 Estilo1 Estilo4">
              <div align="center"><strong><span class="Estilo77">Q. <?php
<?php	echo $p2 ?></span>                    <input name="PventaB" type="hidden" id="PventaB" value="<?php
<?php	echo $p2 ?>">
                </strong></div>
              </div></td>
          <td bordercolor="#ECE9D8"><div align="center" class="Estilo3 Estilo1 Estilo4">
            <div align="center"><strong><span class="Estilo77">Q. <?php
<?php	echo $p3 ?></span>                  <input name="PventaC" type="hidden" id="PventaC" value="<?php
<?php	echo $p3 ?>">
              </strong></div>
            </div></td>
          <td bordercolor="#ECE9D8">
            <div align="center" class="Estilo3 Estilo1 Estilo4">
              <div align="center"><strong><span class="Estilo77">Q. <?php
<?php	echo $p4 ?></span>                    <input name="PventaD" type="hidden" id="PventaD" value="<?php
<?php	echo $p4 ?>">
                </strong></div>
              </div></td>
          <td align="center" bordercolor="#ECE9D8"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #00F;"><strong>Q.<?php
<?php	echo $p5 ?>
                <input name="PventaE" type="hidden" id="PventaE" value="<?php
<?php	echo $p5 ?>">
          </strong></span></td>
          <td bordercolor="#ECE9D8">
            <div align="center" class="Estilo3 Estilo1 Estilo4">
              <div align="center"><strong><span class="Estilo77">Q. <?php
<?php	echo $p7 ?></span>
                  <input name="PventaG" type="hidden" id="PventaG" value="<?php
<?php	echo $p7 ?>">
              </strong></div>
            </div></td>
          <td align="center" bordercolor="#ECE9D8" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #00F;"><strong><span class="Estilo77">Q. <?php
<?php	echo $p8 ?></span>
              <input name="PventaH" type="hidden" id="PventaH" value="<?php
<?php	echo $p8 ?>">
          </strong></td>
          <td bordercolor="#ECE9D8"><div align="center" class="Estilo3 Estilo1 Estilo4">
            <div align="center"><strong><span class="Estilo77">Q. <?php
<?php	echo $p6 ?></span>                  <input name="PventaP" type="hidden" id="PventaP" value="<?php
<?php	echo $p6 ?>">
              </strong></div>
          </div></td>
          </tr>
        <tr bordercolor="#CCCCCC">
          <td height="40" bordercolor="#ECE9D8"><div align="right" class="Estilo68">
            <div align="center"><span id="sprytextfield1">
            <input name="Pcosto2" type="text" id="Pcosto2" value="<?php
<?php	echo $pcosto ?>" size="6" maxlength="8">
            <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div>
            </div></td>
          <td bordercolor="#ECE9D8"><div align="center"><span id="sprytextfield2">
          <input name="PventaA2" type="text" id="PventaA2" value="<?php
<?php	echo $p1 ?>" size="6" maxlength="8">
          <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div></td>
          <td bordercolor="#ECE9D8">
            <div align="center"><span id="sprytextfield3">
            <input name="PventaB2" type="text" id="PventaB2" value="<?php
<?php	echo $p2 ?>" size="6" maxlength="8">
            <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div></td>
          <td bordercolor="#ECE9D8"><div align="center"><span id="sprytextfield4">
          <input name="PventaC2" type="text" id="PventaC2" value="<?php
<?php	echo $p3 ?>" size="6" maxlength="8">
          <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div></td>
          <td bordercolor="#ECE9D8"><div align="center"><span id="sprytextfield5">
          <input name="PventaD2" type="text" id="PventaD2" value="<?php
<?php	echo $p4 ?>" size="6" maxlength="8">
          <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div></td>
          <td align="center" bordercolor="#ECE9D8"><span id="sprytextfield8">
            <label>
              <input name="PventaE2" type="text" id="PventaE2" value="<?php
<?php	echo $p5 ?>" size="6" maxlength="8">
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          <td bordercolor="#ECE9D8"><div align="center"><span id="sprytextfield6"><span class="textfieldRequiredMsg">¿?</span>
            <input name="PventaG2" type="text" id="PventaG2" value="<?php
<?php	echo $p7 ?>" size="6" maxlength="8">
            <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div></td>
          <td align="center" bordercolor="#ECE9D8"><span id="sprytextfield9">
            <label>
              <input name="PventaH2" type="text" id="PventaH2" value="<?php
<?php	echo $p8 ?>" size="6" maxlength="8">
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          <td bordercolor="#ECE9D8"><p align="center" class="Estilo60 "><span id="sprytextfield7">
            <input name="PventaP2" type="text" id="PventaP2" value="<?php
<?php	echo $p6 ?>" size="6" maxlength="8">
            <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></p></td>
          </tr>
        <tr bordercolor="#CCCCCC">
          <td colspan="9" bordercolor="#ECE9D8">&nbsp;</td>
          </tr>
        <tr bordercolor="#CCCCCC" bgcolor="#D9E9CC">
          <td colspan="9" bordercolor="#ECE9D8"><div align="center">
            <input name="Registrar" type="submit" id="Registrar2" value="Actualizar Precios">
            </div></td>
          </tr>
        <?php
<?php	} ?>
        </table></td>
      </tr>
    </table>
    <p>&nbsp;    </p>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "currency");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "currency");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "currency");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "currency");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "currency");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "currency");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "currency");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
