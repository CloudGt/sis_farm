<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
//Variables de esta aplicación
	$met=$_GET['met'];
	$cod1=$_GET['cod1'];
	$codi=$_POST['Caja1'];
	$clie=$_POST['Tipocli'];
	$nomb=$_POST['Nombres'];
	$apel=$_POST['Apellidos'];
	$dire=$_POST['Direccion'];
	$tele=$_POST['Telefono'];
	$acti=$_POST['Activo'];			
	$nit2=$_POST['txtNIT'];
	$razon=$_POST['RazonSocial'];
	
//Buscando Cliente
	$selec= "SELECT * FROM Cliente WHERE Nit='$cod1'";
	$consul=mysql_query($selec,$link);
	
//Registra Equipo de Cómputo Nuevo
	if ($met==1)
	{
		$selec= "UPDATE Cliente SET Tipo_Cliente='$clie', Nombres='$nomb', Apellidos='$apel', Direccion='$dire', Telefono='$tele', Activo='$acti', Nit2='$nit2', RazonSocial='$razon' WHERE Nit='$codi'";
		$modifica = mysql_query ($selec,$link);
		envia_msg ("ACTUALIZACION DE DATOS SATISFACTORIA");
		cambiar_ventana("reg_cliente.php");
		exit;
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>&nbsp;</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript">
<!-- Hide

function test2(form) {
  if (form.txtNIT.value == "" || form.txtNIT.value.indexOf('-', 0) == -1) 
      alert("NIT no valido!");
	  
  else 
		return;
}
// -->
</script>

<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {color: #0000FF}
-->
</style>
<style type="text/css">
<!--
.Estilo2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
-->
</style>
<style type="text/css">
<!--
.Estilo3 {font-weight: bold}
-->
</style>
<style type="text/css">
<!--
.Estilo4 {color: #FF0000}
-->
</style>
<style type="text/css">
<!--
.Estilo5 {color: #FF0000; font-weight: bold; }
-->
</style>
<style type="text/css">
<!--
.Estilo6 {font-family: Arial, Helvetica, sans-serif}
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
#1 #Clientes table tr td table tr td .Estilo62.Estilo2 p strong {
}
-->
</style>
<style type="text/css">
<!--
.Estilo11 {font-family: Arial, Helvetica, sans-serif}
.Estilo31 {font-size: 10px}
.Estilo41 {font-size: 12px}
.Estilo51 {font-size: 12}
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

<BODY onLoad="document.Clientes.Nombres.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<p>&nbsp;</p>
<form name="Clientes" id="Clientes" method="post" action="reg_ud_cliente.php?met=1">
  <table width="70%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr>
      <td><table width="100%" border="0" align="center">
        <tr>
          <td height="31" colspan="2"><div align="center"><strong>ACTUALIZACION DE CLIENTES </strong></div></td>
        </tr>
        <tr>
          <?php
	while ($perso=mysql_fetch_array($consul))
	{
		$nitc =$perso['NIT'];
		$tclc =$perso['Tipo_Cliente'];
		$nomc =$perso['Nombres'];
		$apec =$perso['Apellidos'];
		$dirc =$perso['Direccion'];
		$telc =$perso['Telefono'];
		$act  =$perso['Activo'];
		$nit2 =$perso['Nit2'];
		$razon=$perso['RazonSocial'];
	?>
          <td width="24%"><span class="Estilo58">C&oacute;digo</span></td>
          <td><div align="left"><?php
<?php	echo $nitc ?>
            <input name="Caja1" type="hidden" id="Caja1" value="<?php
<?php	echo $nitc ?>">
            </div></td>
        </tr>
        <tr>
          <td>Nombres</td>
          <td><div align="left"><span id="sprytextfield1">
            <input name="Nombres" type="text" id="Nombres" value="<?php
<?php	echo $nomc ?>" size="40" maxlength="30" onKeyUp="javascript:this.value=this.value.toUpperCase();">
            <span class="textfieldRequiredMsg">¿?</span></span></div></td>
          </tr>
        <tr>
          <td><span class="Estilo58">Apellidos</span></td>
          <td><div align="left"><span id="sprytextfield2">
            <input name="Apellidos" type="text" id="Apellidos" value="<?php
<?php	echo $apec ?>" size="40" maxlength="30" onKeyUp="javascript:this.value=this.value.toUpperCase();">
            <span class="textfieldRequiredMsg">¿?</span></span></div></td>
          </tr>
        <tr>
          <td><span class="Estilo58">NIT</span></td>
          <td><span id="sprytextfield5">
            <input name="txtNIT" type="text" id="txtNIT" onBlur="test2(this.form)" value="<?php
<?php	echo $nit2 ?>">
            <span class="textfieldRequiredMsg">Identificaci&oacute;n Tributaria...</span></span>Tel&eacute;fono <span id="sprytextfield4">
            <input name="Telefono" type="text" id="Telefono" value="<?php
<?php	echo $telc ?>" size="10" maxlength="10">
            <span class="textfieldRequiredMsg">&iquest;?</span><span class="textfieldInvalidFormatMsg">0000-0000</span></span></td>
        </tr>
        <tr>
          <td>Raz&oacute;n Social</td>
          <td><span id="sprytextfield6">
            <input name="RazonSocial" type="text" id="RazonSocial" value="<?php
<?php	echo $razon ?>" size="70" maxlength="60" onKeyUp="javascript:this.value=this.value.toUpperCase();">
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
        </tr>
        <tr>
          <td><span class="Estilo58">Direcci&oacute;n Fiscal</span></td>
          <td><div align="left"><span id="sprytextfield3">
            <input name="Direccion" type="text" id="Direccion" value="<?php
<?php	echo $dirc ?>" size="70" maxlength="60" onKeyUp="javascript:this.value=this.value.toUpperCase();">
            <span class="textfieldRequiredMsg">¿?</span></span></div></td>
        </tr>
        <tr>
          <td colspan="2"><div align="center" class="Estilo62  Estilo2"> 
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td width="67%" align="center"><table width="70%" border="1" cellpadding="1" cellspacing="1" frame="box" rules="rows">
                  <tr>
                    <td width="62%" bgcolor="#CCCCCC">Clasificacion A</td>
                    <td width="38%" align="center" bgcolor="#FFFFCC"><?php
			if($tclc=='A')
			{ ?>
                      <span class="Estilo1"><strong>
                        <input name="Tipocli" type="radio" value="A" checked>
                        </strong></span>
                      <?php
<?php	} else { ?>
                      <strong>
                        <input name="Tipocli" type="radio" value="A">
                        </strong></td>
                    <?php
<?php	} ?>
                    </tr>
                  <tr>
                    <td bgcolor="#CCCCCC">Promotores</td>
                    <td align="center" bgcolor="#FFFFCC"><?php
			if($tclc=='B')
			{ ?>
                      <span class="Estilo1"><strong>
                        <input name="Tipocli" type="radio" value="B" checked>
                        </strong></span>
                      <?php
<?php	} else { ?>
                      <strong>
                        <input name="Tipocli" type="radio" value="B">
                        </strong></td>
                    <?php
<?php	} ?>
                    </tr>
                  <tr>
                    <td bgcolor="#CCCCCC">Clasificacion C</td>
                    <td align="center" bgcolor="#FFFFCC"><?php
			if($tclc=='C')
			{ ?>
                      <span class="Estilo1"><strong>
                        <input name="Tipocli" type="radio" value="C" checked>
                        </strong></span>
                      <?php
<?php	} else { ?>
                      <strong>
                        <input name="Tipocli" type="radio" value="C">
                        </strong></td>
                    <?php
<?php	} ?>
                    </tr>
                  <tr>
                    <td bgcolor="#CCCCCC">Clasificacion D</td>
                    <td align="center" bgcolor="#FFFFCC"><?php
			if($tclc=='D')
			{ ?>
                      <span class="Estilo1"><strong>
                        <input name="Tipocli" type="radio" value="D" checked>
                        </strong></span>
                      <?php
<?php	} else { ?>
                      <strong>
                        <input name="Tipocli" type="radio" value="D">
                        </strong></td>
                    <?php
<?php	} ?>
                    </tr>
                  <tr>
                    <td bgcolor="#CCCCCC">Clasificacion E</td>
                    <td align="center" bgcolor="#FFFFCC"><?php
			if($tclc=='E')
			{ ?>
                      <span class="Estilo1"><strong>
                        <input name="Tipocli" type="radio" value="E" checked>
                        </strong></span>
                      <?php
<?php	} else { ?>
                      <strong>
                        <input name="Tipocli" type="radio" value="E">
                        </strong></td>
                    <?php
<?php	} ?>
                    </tr>
                  <tr>
                    <td bgcolor="#CCCCCC">Mayoristas</td>
                    <td align="center" bgcolor="#FFFFCC"><?php
			if($tclc=='H')
			{ ?>
                      <span class="Estilo1"><strong>
                        <input name="Tipocli" type="radio" value="H" checked>
                        </strong></span>
                      <?php
<?php	} else { ?>
                      <strong>
                        <input name="Tipocli" type="radio" value="H">
                        </strong></td>
                    <?php
<?php	} ?>
                    </tr>
                  <tr>
                    <td bgcolor="#CCCCCC">Ruta</td>
                    <td align="center" bgcolor="#FFFFCC"><?php
			if($tclc=='G')
			{ ?>
                      <span class="Estilo1"><strong>
                        <input name="Tipocli" type="radio" value="G" checked>
                        </strong></span>
                      <?php
<?php	} else { ?>
                      <strong>
                        <input name="Tipocli" type="radio" value="G">
                        </strong></td>
                    <?php
<?php	} ?>
                    </tr>
                  <tr>
                    <td bgcolor="#CCCCCC">Farmacia Interna</td>
                    <td align="center" bgcolor="#FFFFCC"><?php
			if($tclc=='I')
			{ ?>
                      <span class="Estilo1"><strong>
                        <input name="Tipocli" type="radio" value="I" checked>
                        </strong></span>
                      <?php
<?php	} else { ?>
                      <strong>
                        <input name="Tipocli" type="radio" value="I">
                        </strong></td>
                    <?php
<?php	} ?>
                    </tr>
                  <tr>
                    <td bgcolor="#CCCCCC">Publico</td>
                    <td align="center" bgcolor="#FFFFCC"><?php
			if($tclc=='F')
			{ ?>
                      <span class="Estilo1"><strong>
                        <input name="Tipocli" type="radio" value="F" checked>
                        </strong></span>
                      <?php
<?php	} else { ?>
                      <strong>
                        <input name="Tipocli" type="radio" value="F">
                        </strong></td>
                    <?php
<?php	} ?>
                    </tr>
                  </table></td>
                <td width="33%" align="center"><table width="50%" border="1" cellpadding="1" cellspacing="1" frame="box" rules="all">
                  <tr>
                    <td align="center">ACTIVO</td>
                    </tr>
                  <tr>
                    <td align="center"><span class="Estilo74 Estilo6">
                      <?php
			if($act=='S')
			{ ?>
                      <span class="Estilo1"><strong>SI
                        <input name="Activo" type="radio" value="S" checked>
                        NO</strong></span>
                      <input name="Activo" type="radio" value="N">
                      <?php
<?php	} ?>
                      <?php
				if($act=='N')
			{ ?>
                      SI
  <input name="Activo" type="radio" value="S">
  <span class="Estilo4"><strong> NO
  <input name="Activo" type="radio" value="N" checked>
  </strong></span>
  <?php
<?php	} ?>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
            </div></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
          </tr>
        <tr bgcolor="#D9EACA">
          <td colspan="2"><div align="center">
            <input name="Guardar" type="submit" id="Guardar2" value="Registrar Cambios">
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "phone_number", {format:"phone_custom", pattern:"0000-0000"});
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
