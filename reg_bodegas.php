<?php	
session_start();
	include("sysconect.php");
	// Verifica si hubo inicio de sesión
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
//Variables de esta aplicación
	$met=$_GET['met'];
	$cod1=$_GET['cod1'];	$cod2=$_GET['cod2'];	$cod3=$_GET['cod3'];
	$casa=$_POST['Caja1'];
	$pres=$_POST['Caja2'];
	$pep=$_POST['Caja3'];
	$nombre=$_POST['Producto']; 
	$pc=$_POST['Pcosto'];	$cant=$_POST['Cantidad'];
	$precio1=$_POST['PventaA'];		$precio2=$_POST['PventaB'];	
	$precio3=$_POST['PventaC'];		$precio4=$_POST['PventaD'];	
	$precio5=$_POST['PventaE'];		$precio6=$_POST['PventaP'];
	$precio7=$_POST['PventaG'];		$precio8=$_POST['PventaH'];
	$fecha=date('Y-m-d H:i:s');
	
//Consultas y Popup's
	$selec = "SELECT id_proveedor, upper(nom_provee) nom_provee FROM Proveedores WHERE Activo='S' ORDER BY nom_provee";
	$datosm1 = mysql_query($selec,$link);
	if ($cod1 != 0)
	{
		$selec = "SELECT id_presenta, upper(presentacion) presentacion FROM Presentacion ORDER BY Presentacion";
		$datosm2 = mysql_query($selec,$link);
		$select= "SELECT * FROM tipo_medic";
		$datosm3 = mysql_query($select,$link);
	}
	else
	{
		$selec = "SELECT * FROM presentacion WHERE id_presenta = 0 ORDER BY Presentacion";
		$datosm2 = mysql_query($selec,$link);
	}

//Registra Producto Nuevo
	if ($met==1)
	{
		// Verifica que Producto no exista 
		$selec="SELECT * FROM Bodegam WHERE NProducto='$nombre' AND Presentacion=$pres AND Id_proveedor='$casa'";		
		$rs_cons = mysql_query($selec,$link);
		while(mysql_fetch_array($rs_cons))
		{
			error_msg("YA ESTA REGISTRADO: << $nombre >> NO PUEDO PROCESARLO");
		}
		$pv1=$precio1;
		$pv2=$precio2;
		$pv3=$precio3;
		$pv4=$precio4;
		$pv5=$precio5;
		$pv6=$precio6;
		$pv7=$precio7;
		$pv8=$precio8;
		$insert="INSERT INTO Bodegam (Id_producto, Id_proveedor, NProducto, Presentacion, Eticopopular, PrecioCosto, PrecioC1, 
									  PrecioC2, PrecioC3, PrecioC4, PrecioC5, PrecioC6, PrecioC7, PrecioVP, Existencia, Activo, Oferta) 
				VALUES('','$casa','$nombre','$pres','$pep','$pc','$pv1','$pv2','$pv3','$pv4','$pv5','$pv7','$pv8','$pv6','$cant', 'S', 'N')";
		$r_insert=mysql_query($insert,$link);
		$producto="SELECT COUNT(id_producto) as Producto FROM Bodegam";
		$ingreso=mysql_query($producto,$link);
		while($ingre=mysql_fetch_array($ingreso))
		{
			$Id_med=$ingre['Producto'];
			$selec = "INSERT INTO Ingresos (Correlativo, Producto, Ingresa, Fec_reg, Usuario) 
						VALUES('','$Id_med','$cant','$fecha','$Usr')";
			$ingresoud = mysql_query($selec,$link);
		}
		envia_msg("SE REGISTRO: $nombre CON EXITO");
	}

?>
<script language="JavaScript"><!--
	function CambioOpcion(targ,selObj,restore)
	{
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
//--></script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Farmacia del Pueblo</TITLE>
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
	background-image: url();
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

<BODY onLoad="document.Medicamento.Casaf.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<p>&nbsp;</p>
<form name="Medicamento" method="post" action="reg_bodegas.php?met=1">
  <table width="75%" border="1" align="center" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr>
      <td><table width="100%" border="0" align="center">
        <tr>
          <td colspan="9"><div align="center"><strong>REGISTRO DE MEDICAMENTOS NUEVOS </strong></div></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="9"><div align="right">
            <span id="sprytextfield6"><span id="sprytextfield5"><span id="sprytextfield12">
            <input name="Caja1" type="hidden" id="Caja12" value="<? echo $cod1 ?>">
            <span class="textfieldRequiredMsg">¿?</span></span><span class="textfieldRequiredMsg">¿?</span></span>
              <select name="Casaf" size="1" id="Casaf" onChange="CambioOpcion('self',this,0)">
                <option selected value="reg_bodegas.php">- Casa Farmaceutica -</option>
                <?														
				while($casa= mysql_fetch_array($datosm1))						
				{													
					$idcasa = $casa['id_proveedor'];			
					$descripc = $casa['nom_provee'];
					if ($idcasa == ($cod1))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"reg_bodegas.php?cod1=".$idcasa."&cod2=".$cod2."&cod3=".$cod3."\">".$descripc."</option>\n";				
	         } ?>
                </select>
              <span id="sprytextfield13">
              <input name="Caja2" type="hidden" id="Caja2" value="<? echo $cod2 ?>">
              <span class="textfieldRequiredMsg">¿?</span></span><span class="textfieldRequiredMsg">¿?</span></span>
            <select name="Presenta" size="1" id="Presenta" onChange="CambioOpcion('self',this,0)">
              <option value="reg_bodegas.php?cod1=<? echo $cod1 ?>&cod3=<? echo $cod3 ?>">Presentaciones</option>
              <?														
				while($prese=mysql_fetch_array($datosm2))						
				{													
					$idpre   = $prese['id_presenta'];			
					$presenta= $prese['presentacion'];
					if ($idpre == ($cod2))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"reg_bodegas.php?cod2=".$idpre."&cod1=".$cod1."&cod3=".$cod3."\">".$presenta."</option>\n";				
	         } 
			 @mysql_free_result($sqlsel_opme);
			 ?>
              </select>
            <span id="sprytextfield14">
            <input name="Caja3" type="hidden" id="Caja" value="<? echo $cod3 ?>">
            <span class="textfieldRequiredMsg">¿?</span></span>
            <select name="Clasifica" size="1" id="Clasifica" onChange="CambioOpcion('self',this,0)">
              <option value="reg_bodegas.php?cod2=<? echo $cod2 ?>&cod1=<? echo $cod1 ?>">Clasificaci&oacute;n</option>
              <?														
				while($prese=mysql_fetch_array($datosm3))						
				{													
					$idtipmed   = $prese['tipo_medic'];			
					$presenta= $prese['descripcion'];
					if ($idtipmed == ($cod3))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"reg_bodegas.php?cod3=".$idtipmed."&cod2=".$cod2."&cod1=".$cod1."\">".$presenta."</option>\n";				
	         } 
			 @mysql_free_result($sqlsel_opme);
			 ?>
              </select>
            </div>
            <div align="right"></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="4">&nbsp;</td>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="right"><span class="Estilo54 Estilo53 Estilo67"><strong>Medicamento</strong></span></div></td>
          <td colspan="8">
            <div align="left"><span id="sprytextfield4">
              <input name="Producto" type="text" id="Producto4" size="40" maxlength="40" onKeyUp="javascript:this.value=this.value.toUpperCase();">
              <span class="textfieldRequiredMsg">¿?</span></span><span class="Estilo59"> </span></div>            <div align="center"></div></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="7">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><span class="Estilo52">Precio Costo</span> </div></td>
          <td><div align="center" class="Estilo54 Estilo55 Estilo53"><em><span class="Estilo68"><span class="Estilo69"> &quot;A&quot; </span></span> </em></div></td>
          <td><div align="center" class="Estilo54 Estilo55 Estilo53"><em><span class="Estilo68"><span class="Estilo69"> &quot;B&quot; </span></span></em></div></td>
          <td><div align="center" class="Estilo54 Estilo55 Estilo53"><em><span class="Estilo68"><span class="Estilo69"> &quot;C&quot; </span></span></em></div></td>
          <td><div align="center" class="Estilo54 Estilo55 Estilo53"><em><span class="Estilo68"><span class="Estilo69"> &quot;D&quot; </span></span></em></div></td>
          <td align="center"><span class="Estilo54 Estilo55 Estilo53"><em><span class="Estilo68"><span class="Estilo69"> &quot;E&quot; </span></span></em></span></td>
          <td align="center"><em><span class="Estilo69"> &quot;M&quot; </span></em></td>
          <td align="center"><span class="Estilo54 Estilo55 Estilo53"><em><span class="Estilo68"><span class="Estilo69"> &quot;V&quot; </span></span></em></span>            <div align="center" class="Estilo54 Estilo55 Estilo53"></div></td>
          <td align="center" valign="middle">
            <div align="center"><span class="Estilo52">Precio P&uacute;blico</span> </div></td>
          </tr>
        <tr>
          <td>
            <div align="center"><span id="sprytextfield1">
            <input name="Pcosto" type="text" id="Pcosto2" size="6" maxlength="8">
            <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">No válido.</span></span>
            </div></td>
          <td>
            <div align="center"><span id="sprytextfield2">
            <input name="PventaA" type="text" id="PventaA2" size="6" maxlength="8">
            <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">No válido</span></span></div></td>
          <td><div align="center"><span id="sprytextfield7">
          <input name="PventaB" type="text" id="PventaB2" size="6" maxlength="8">
<span class="textfieldInvalidFormatMsg">¿?</span></span></div></td>
          <td><div align="center"><span id="sprytextfield8">
            <input name="PventaC" type="text" id="PventaC2" size="6" maxlength="8">
            <span class="textfieldInvalidFormatMsg">¿?</span></span></div></td>
          <td><div align="center"><span id="sprytextfield9">
            <input name="PventaD" type="text" id="PventaD3" size="6" maxlength="8">
            <span class="textfieldInvalidFormatMsg">¿?</span></span></div></td>
          <td align="center"><span id="sprytextfield10">
          <input name="PventaE" type="text" id="PventaD4" size="6" maxlength="8">
          <span class="textfieldInvalidFormatMsg">&iquest;?</span></span></td>
          <td align="center"><span id="sprytextfield16">
          <label>
            <input name="PventaH" type="text" id="PventaH" size="6" maxlength="8">
          </label>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span></span></td>
          <td><div align="center"><span id="sprytextfield15">
          <label> <strong>
            <input name="PventaG" type="text" id="PventaG" size="6" maxlength="8">
          </strong></label>
          <span class="textfieldRequiredMsg">?</span><span class="textfieldInvalidFormatMsg">no válido.</span></span></div></td>
          <td align="center" valign="middle"><span id="sprytextfield3">
          <input name="PventaP" type="text" id="PventaP2" size="6" maxlength="8">
          <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">No Válido.</span></span></td>
          </tr>
        <tr>
          <td><div align="right" class="Estilo68"></div></td>
          <td colspan="7">
            <div align="left"> </div></td>
          <td><p align="center" class="Estilo60 ">&nbsp; </p></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="7" bgcolor="#D9EACA"><div align="center"><strong><span class="Estilo53 Estilo56 Estilo57 Estilo60">Cantidad a ingresar
            </span><span id="sprytextfield11">
            <input name="Cantidad" type="text" id="Cantidad2" size="6" maxlength="8">
<span class="textfieldInvalidFormatMsg">¿?</span></span></strong></div></td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="7">&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr bgcolor="#D9EACA">
          <td colspan="9" align="center"><div align="right">
            <input name="Registrar2" type="submit" id="Registrar22" value="Registrar Producto">
          </div>
            <div align="center"></div></td>
          </tr>
        </table></td>
      </tr>
    </table>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "currency");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "currency");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "currency", {isRequired:false});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "currency", {isRequired:false});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "currency", {isRequired:false});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "integer", {isRequired:false});
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");
var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13");
var sprytextfield14 = new Spry.Widget.ValidationTextField("sprytextfield14");
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "currency", {isRequired:false});
var sprytextfield15 = new Spry.Widget.ValidationTextField("sprytextfield15", "currency");
var sprytextfield16 = new Spry.Widget.ValidationTextField("sprytextfield16", "currency", {validateOn:["blur"], minValue:0});
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
