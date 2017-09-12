<?
	session_start();
	include('nuevo/conexion/conexion.php');	
	// if ($_SESSION['Bandera'] != "SI")	{	cambiar_ventana("index.php");		exit;	}
	
//Variables de esta aplicaci�n
	$met=$_GET['met'];
	$nit=$_POST['Nit'];
	$clie=$_POST['Tipocli'];
	$nomb=$_POST['Nombres'];
	$apel=$_POST['Apellidos'];
	$dire=$_POST['Direccion'];
	$tele=$_POST['Telefono'];
	$nit2=$_POST['txtNIT'];
	$razon=$_POST['RazonSocial'];

	$selec = "SELECT Nit, upper(Nombres) as Nombres, upper(Apellidos) as Apellidos FROM Cliente WHERE Activo='S' ORDER BY nombres";
	$datosm2 = mysql_query($selec,$link);
	$selec = "SELECT nit, upper(nombres) as nombres, upper(apellidos) as apellidos FROM Cliente WHERE Activo='N' ORDER BY nombres";
	$datosm3 = mysql_query($selec,$link);
	$selec="SELECT * FROM Cliente WHERE Nombres='$nomb' AND Apellidos='$apel'";		
	$rs_cons=mysql_query($selec,$link);
	while(mysql_fetch_array($rs_cons))
	{
		envia_msg("CLIENTE YA REGISTRADO, SE ACTUALIZA REGISTRO");
		$cambio="UPDATE Cliente SET tipo_cliente='', nombres='', apellidos='', nit2='', direccion='', razonsocial='', telefono='' 
					WHERE nombres='$nomb' AND apellidos='$apel'";
		$ejecuta=mysql_query($cambio,$link);		
	}
	$selec="SELECT count(*) as total FROM CLIENTE";
	$datosm1=mysql_query($selec,$link);

	if ($met==1)
	{
		$insert="INSERT INTO Cliente (Nit, Tipo_cliente, Nombres, Apellidos, Nit2, Direccion, RazonSocial, Telefono, Activo) 
					VALUES('$nit','$clie','$nomb','$apel','$nit2','$dire','$razon','$tele','S')";
		$r_insert=mysql_query($insert,$link);
		if (mysql_errno($link)==0)	{ 		error_msg("SE ASIGNA NUEVO CLIENTE AL SISTEMA");		}
	}
?>
<script language="JavaScript"><!--
	function CambioOpcion(targ,selObj,restore)
	{
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selected;
	}	
//--></script>
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>&nbsp;</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->


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
.Estilo2 {color: #0000FF}
-->
</style>
<style type="text/css">
<!--
.Estilo3 {font-size: 10px}
-->
</style>
<style type="text/css">
<!--
.Estilo4 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
.Estilo5 {font-size: 12}
-->
</style>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--

-->
</style><!-- InstanceEndEditable -->
<link href="tablas-eec.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--

-->
</style></HEAD>

<BODY  onLoad="document.Clientes.RazonSocial.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<p>&nbsp;</p>
<form name="Clientes" id="Clientes" method="post" action="reg_cliente.php?met=1">
  <table width="60%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td height="32" colspan="2"><div align="center"><strong>REGISTRO DE CLIENTES </strong></div></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <? 
    	while($ultim=mysql_fetch_array($datosm1))
		{
		$ultimo=$ultim['total'];
		$siguiente=$ultimo+1;
	?>
          <td width="100"><span class="Estilo58"><strong>Codigo</strong></span></td>
          <td width="240"><div align="left">
              <input name="Nit" type="text" id="Nit" value="<? echo $siguiente ?>" size="5" maxlength="10" readonly="true">
          </div></td>
          <? } ?>
        </tr>
        <tr>
          <td><strong>Raz&oacute;n Social</strong></td>
          <td><span id="sprytextfield6">
          <input name="RazonSocial" type="text" id="RazonSocial" size="70" maxlength="60" onKeyUp="javascript:this.value=this.value.toUpperCase();">
          <span class="textfieldRequiredMsg">&iquest;?</span></span></td>
        </tr>
        <tr>
          <td><strong>Contacto</strong></td>
          <td><div align="left"><span id="sprytextfield2">
            <input name="Nombres" type="text" id="Nombres" size="30" maxlength="30" onKeyUp="javascript:this.value=this.value.toUpperCase();">
            <span class="textfieldRequiredMsg">Nombres</span></span><span id="sprytextfield3">
              <input name="Apellidos" type="text" id="Apellidos" size="30" maxlength="30" onKeyUp="javascript:this.value=this.value.toUpperCase();">
              <span class="textfieldRequiredMsg">Apellidos</span></span></div></td>
        </tr>
        <tr>
          <td><strong>NIT</strong></td>
          <td><span id="sprytextfield5">
            <input type="text" name="txtNIT" id="txtNIT" onBlur="test2(this.form)">
            <span class="textfieldRequiredMsg">Identificaci�n Tributaria...</span></span> Tel&eacute;fono <span id="sprytextfield1">
            <input name="Telefono" type="text" id="Telefono" size="10" maxlength="10">
            <span class="textfieldRequiredMsg">&iquest;?</span><span class="textfieldInvalidFormatMsg">0000-0000.</span></span></td>
        </tr>
        <tr>
          <td><span class="Estilo58"><strong>Direcci&oacute;n Fiscal</strong></span></td>
          <td><div align="left"><span id="sprytextfield4">
            <input name="Direccion" type="text" id="Direccion" size="60" maxlength="60" onKeyUp="javascript:this.value=this.value.toUpperCase();">
            <span class="textfieldRequiredMsg">�?</span></span></div></td>
        </tr>
        <tr>
          <td colspan="2"><div align="center" class="Estilo62"> <strong> </strong>
            <table width="40%" border="1" cellpadding="1" cellspacing="1" frame="box" rules="rows">
              <tr>
                <td bgcolor="#CCCCCC">Clasificacion A</td>
                <td align="center" bgcolor="#FFFFCC"><strong><span class="Estilo1 Estilo3 Estilo4 Estilo5">
                  <input name="Tipocli" type="radio" value="A" checked>
                  </span></strong></td>
                </tr>
              <tr>
                <td bgcolor="#CCCCCC">Promotores</td>
                <td align="center" bgcolor="#FFFFCC"><strong><span class="Estilo1 Estilo3 Estilo4 Estilo5">
                  <input name="Tipocli" type="radio" value="B">
                  </span></strong></td>
                </tr>
              <tr>
                <td bgcolor="#CCCCCC">Clasificacion C</td>
                <td align="center" bgcolor="#FFFFCC"><strong><span class="Estilo1 Estilo3 Estilo4 Estilo5">
                  <input name="Tipocli" type="radio" value="C">
                  </span></strong></td>
                </tr>
              <tr>
                <td bgcolor="#CCCCCC">Clasificacion D</td>
                <td align="center" bgcolor="#FFFFCC"><strong><span class="Estilo1 Estilo3 Estilo4 Estilo5">
                  <input name="Tipocli" type="radio" value="D">
                  </span></strong></td>
                </tr>
              <tr>
                <td bgcolor="#CCCCCC">Clasificacion E</td>
                <td align="center" bgcolor="#FFFFCC"><strong><span class="Estilo1 Estilo3 Estilo4 Estilo5">
                  <input name="Tipocli" type="radio" value="E">
                  </span></strong></td>
                </tr>
              <tr>
                <td bgcolor="#CCCCCC">Mayoristas</td>
                <td align="center" bgcolor="#FFFFCC"><strong><span class="Estilo1 Estilo3 Estilo4 Estilo5">
                  <input name="Tipocli" type="radio" value="H">
                  </span></strong></td>
                </tr>
              <tr>
                <td bgcolor="#CCCCCC">Ruta</td>
                <td align="center" bgcolor="#FFFFCC"><strong><span class="Estilo1 Estilo3 Estilo4 Estilo5">
                  <input name="Tipocli" type="radio" value="G">
                  </span></strong></td>
                </tr>
              <tr>
                <td bgcolor="#CCCCCC">Farmacia Interna</td>
                <td align="center" bgcolor="#FFFFCC"><strong><span class="Estilo1 Estilo3 Estilo4 Estilo5">
                  <input name="Tipocli" type="radio" value="I">
                  </span></strong></td>
                </tr>
              <tr>
                <td bgcolor="#CCCCCC">Publico</td>
                <td align="center" bgcolor="#FFFFCC"><strong><span class="Estilo1 Estilo3 Estilo4 Estilo5">
                  <input name="Tipocli" type="radio" value="F">
                  </span></strong></td>
                </tr>
              </table>
            </div></td>
        </tr>
        <tr bgcolor="#D9EACA">
          <td colspan="2"><div align="center">
            <input name="Guardar" type="submit" id="Guardar2" value="Registrar Cliente">
            </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
	</form>
	<table border="0">
      <tr>
        <td><div align="left" class="Estilo63">
          <div align="right"><span class="Estilo2 Estilo1 Estilo64"><strong>Modificaciones</strong></span></div>
        </div></td>
        <td><div align="right">
          <select name="Cliente" size="1" id="Cliente" onChange="CambioOpcion('self',this,0)">
            <option value="">Todos los Clientes</option>
            <?														
			while($client=mysql_fetch_array($datosm2))						
			{													
				$codigo  = $client['Nit'];
				$nombres = $client['Nombres'];
				$apellid = $client['Apellidos'];
				if ($codigo == ($cod1))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_ud_cliente.php?cod1=".$codigo."\">".$nombres." ".$apellid."</option>\n";				
	    }?>
          </select>
        </div></td>
      </tr>
      <tr>
        <td><div align="left" class="Estilo63">
          <div align="right"><span class="Estilo2 Estilo1 Estilo64"><strong>Activaciones</strong></span></div>
        </div></td>
        <td><div align="right">
          <select name="select" size="1" id="select3" onChange="CambioOpcion('self',this,0)">
            <option value="">Todos los Clientes</option>
            <?														
			while($clientes=mysql_fetch_array($datosm3))						
			{													
				$codigo  = $clientes['nit'];
				$nombres = $clientes['nombres'];
				$apellid = $clientes['apellidos'];
				if ($codigo == ($cod1))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_ud_cliente.php?cod1=".$codigo."\">".$nombres." ".$apellid."</option>\n";				
	    }?>
          </select>
        </div></td>
      </tr>
    </table>
  <script type="text/javascript">
<!--
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {format:"phone_custom", pattern:"0000-0000", validateOn:["blur"]});
//-->
  </script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
