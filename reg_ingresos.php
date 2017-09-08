<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	$codm=$_GET['codm'];
	$cod1=$_GET['cod1'];
	
	$fecha=date('Y-m-d H:i:s');
	
//Consulta de Medicamentos
	$selec = "SELECT Id_proveedor, upper(Nom_provee) Nom_provee, Activo FROM Proveedores WHERE Activo='S' ORDER BY 2";
	$datosm1 = mysql_query($selec,$link);
	if ($cod1 != 0)
	{
		$selec = "SELECT b.Id_producto, upper(b.Nproducto) Nproducto FROM bodegam as b, proveedores as p 
				WHERE b.Activo='S' AND b.id_proveedor=p.id_proveedor AND p.Activo='S' AND b.id_proveedor='$cod1' 
				ORDER BY 2";
		$datosm2= mysql_query($selec,$link);
	}
	else
	{
		$selec = "SELECT b.Id_producto, upper(b.Nproducto) Nproducto FROM bodegam as b, proveedores as p 
				WHERE b.Activo='S' AND b.id_proveedor=p.id_proveedor AND p.Activo='S' 
				ORDER BY 2";
		$datosm2= mysql_query($selec,$link);
	}
//Actualización de datos
	if ($met==1)
	{
		$subtot=$_POST['Subtot'];
		$sumar=$_POST['Sumar'];
		$produc=$_POST['Caja2'];
		$lote=$_POST['lote'];
		$kduk=$_POST['fechaini'];
		
		if($sumar<=0)	{	error_msg("NO PUEDE INGRESAR (CERO) MEDICAMENTOS");	cambiar_ventana("reg_ingresos.php");	exit;	}
		$total=$subtot+$sumar;
		$selec = "UPDATE Bodegam SET Existencia='$total' WHERE id_producto='$produc'";
		$bodegamud = mysql_query($selec,$link);
		$selec = "INSERT INTO Ingresos (Correlativo, Producto, Ingresa, Fec_reg, Usuario, Lote, Kduk) 
					VALUES('','$produc','$sumar','$fecha','$Usr','$lote','$kduk')";
		$ingresoud = mysql_query($selec,$link);
		if (mysql_errno($link)==0)	{	error_msg("INGRESO A BODEGA SATISFACTORIO");	}
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
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
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
.Estilo3 {font-size: 16px}
-->
</style>
<style type="text/css">
<!--
.Estilo8 {font-size: 14px}
-->
</style>
<style type="text/css">
<!--
.Estilo9 {color: #000000}
-->
</style>
<style type="text/css">
<!--
.Estilo10 {color: #0000FF}
-->
</style>
<style type="text/css">
<!--
.Estilo11 {
	font-weight: bold;
	color: #0000FF;
}
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

<BODY onLoad="document.Actualizacion.Medicamento.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<p>&nbsp;</p>
<form name="Actualizacion" method="post" action="reg_ingresos.php?met=1">
  <table width="60%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr>
      <td><table width="100%" border="0">
        <tr bordercolor="#9CD8A7">
          <td colspan="2"><div align="center"><strong>INGRESO DE MEDICAMENTOS </strong></div></td>
          </tr>
        <tr bordercolor="#9CD8A7">
          <td width="30%">&nbsp;</td>
          <td width="70%">&nbsp;</td>
          </tr>
        <tr bordercolor="#9CD8A7">
          <td><div align="right"></div></td>
          <td><div align="right">
            <input name="Caja1" type="hidden" id="Caja12" value="<? echo $cod1 ?>">
            <select name="Casaf" size="1" id="select" onChange="CambioOpcion('self',this,0)">
              <option value="reg_ingresos.php">Casa Farmaceutica</option>
              <?														
				while($casa=mysql_fetch_array($datosm1))						
				{													
					$idcasa   =	$casa['Id_proveedor'];	
					$descripc = $casa['Nom_provee'];
					if ($idcasa == ($cod1))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"reg_ingresos.php?cod1=".$idcasa."\">".$descripc."</option>\n";				
	         } ?>
              </select>
            </div></td>
          </tr>
        <tr bordercolor="#9CD8A7">
          <td>&nbsp;</td>
          <td><div align="right"><span id="sprytextfield2">
            <input name="Caja2" type="hidden" id="Caja22" value="<? echo $codm ?>">
            <span class="textfieldRequiredMsg">¿?</span></span><span class="Estilo9"> <span class="Estilo3">
              <select name="Medicamento" size="1" id="Medicamento" onChange="CambioOpcion('self',this,0)">
                <option value="reg_ingresos.php?codm=0&cod1=<? echo $cod1; ?>">Medicamentos</option>
                <?														
			while($medi=mysql_fetch_array($datosm2))						
			{													
				$codi=$medi['Id_producto'];
				$medi=$medi['Nproducto'];
				if ($codi == ($codm))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_ingresos.php?codm=".$codi."&cod1=".$cod1."\">".$medi."</option>\n";				              
     	} ?>
                </select>
              </span></span></div></td>
          </tr>
        <tr bordercolor="#ECE9D8">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr bordercolor="#ECE9D8">
          <td><div align="center" class="Estilo76 Estilo1 Estilo8 Estilo9 Estilo10 Estilo11">
            <p align="right" class="Estilo75">
              <?
		  $selec = "SELECT a.nom_provee, b.presentacion, c.existencia FROM Proveedores as a, Presentacion as b, Bodegam as c
		  			WHERE c.id_proveedor=a.id_proveedor AND c.presentacion=b.id_presenta AND c.id_producto='$codm'";
		  $datosm2= mysql_query($selec,$link);
		  while($result=mysql_fetch_array($datosm2))
		  {
		  	$casa=$result['nom_provee'];
			$mpre=$result['presentacion'];
			$total=$result['existencia'];
			
		  ?>
              Casa Farmaceutica:</p>
            </div></td>
          <td><span class="Estilo76"><span class="Estilo1 Estilo92"><strong><? echo $casa; ?></strong></span></span></td>
          </tr>
        <tr bordercolor="#ECE9D8">
          <td><div align="right" class="Estilo8 Estilo1 Estilo10"><strong><span class="Estilo80">Presentaci&oacute;n:</span></strong></div></td>
          <td><span class="Estilo76"><span class="Estilo1 Estilo90"><strong><? echo $mpre; ?></strong></span></span></td>
          </tr>
        <tr bordercolor="#ECE9D8">
          <td><div align="right" class="Estilo8 Estilo1 Estilo10"><strong><span class="Estilo80">Existencia:</span></strong></div></td>
          <td><span class="Estilo76"><span class="Estilo1 Estilo75"><strong><? echo number_format($total) ?>
            <input name="Subtot" type="hidden" id="Subtot2" value="<? echo $total ?>"> 
            </strong></span></span></td>
          </tr>
        <? } ?>
        <tr bordercolor="#9CD8A7">
          <td align="right" bgcolor="#FFFF00">Lote o Factura</td>
          <td><span id="sprytextfield3">
            <label>
              <input name="lote" type="text" id="lote" size="25" maxlength="25">
            </label>
            <span class="textfieldRequiredMsg">?</span></span></td>
        </tr>
        <tr bordercolor="#9CD8A7">
          <td align="right" bgcolor="#FFFF00">Fecha Caducidad</td>
          <td><span class="Estilo60 "><img src="images/iconos/ew_calendar.gif" id="cx_FECHA" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
              <input type="text" name="fechaini" id="fechaini" size="10" maxlength="10" value="<?php $ano=date('Y')+1; 
			  		$mes=date('m-d');	if(@$fecha1=='')@$fecha1="$ano-$mes"; echo htmlspecialchars(@$fecha1) ?>">
          </span></td>
          </tr>
        <tr bordercolor="#9CD8A7">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr bordercolor="#9CD8A7">
          <td><div align="right" class="Estilo8 Estilo1 Estilo10"><strong><span class="Estilo67">&iquest;Cuanto Ingresa? </span></strong></div></td>
          <td><span id="sprytextfield1">
          <input name="Sumar" type="text" id="Sumar" size="8" maxlength="6">
          <span class="textfieldRequiredMsg">?</span><span class="textfieldInvalidFormatMsg">no válido.</span></span></td>
          </tr>
        <tr bordercolor="#9CD8A7">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr bgcolor="#D9E9CC">
          <td height="17" colspan="2">
            <div align="center">
              <input type="submit" name="Submit" value="Actualizar Inventario">
              </div></td>
          </tr>
        </table></td>
      </tr>
    </table>
  <p>&nbsp;</p>
  <table width="70%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr>
      <td><table width="100%" border="1" cellpadding="1" cellspacing="1" frame="box" rules="rows">
        <tr>
          <td colspan="7" align="center"><strong>REGISTRO DE LOTES Y VENCIMIENTOS PARA ESTE MEDICAMENTO</strong></td>
        </tr>
        <tr>
          <td align="center" bgcolor="#FFFF66">Usuario</td>
          <td align="center" bgcolor="#FFFF66">Fecha de Registro</td>
          <td align="center" bgcolor="#FFFF66">Ingreso</td>
          <td align="center" bgcolor="#FFFF66">Lote</td>
          <td align="center" bgcolor="#FFFF66">Vencimiento</td>
          <td colspan="2" align="center" bgcolor="#FFFF66">Acci&oacute;n</td>
        </tr>
        <? 
		$buscalotes="SELECT correlativo, usuario, fec_reg, lote, ingresa, kduk, activo
					FROM Ingresos WHERE Producto='$codm' AND Activo='S' ORDER BY fec_reg desc";
		$proceso=mysql_query($buscalotes,$link);
		while($dato=mysql_fetch_array($proceso))
		{ 
			$usuario=$dato['usuario'];
			$fechare=$dato['fec_reg'];
			$lotereg=$dato['lote'];
			$canting=$dato['ingresa'];
			$fechakd=$dato['kduk'];
			$activo=$dato['activo'];
	?>
        <tr>
          <td bgcolor="#CCCCCC" style="font-size: 10px"><? echo $usuario; ?></td>
          <td align="center" bgcolor="#D9EACA" style="font-size: 10px"><? echo $fechare ?></td>
          <td align="center" bgcolor="#CCCCCC" style="font-size: 10px"><? echo $canting; ?></td>
          <td align="center" bgcolor="#D9EACA" style="font-size: 10px"><? echo $lotereg; ?></td>
          <td align="center" bgcolor="#CCCCCC" style="font-size: 10px"><? echo $fechakd; ?></td>
          <td align="center" bgcolor="#D9EACA"><? if($activo=='S') { ?>
            <a href="reg_ud_ingreso.php?cod1=<? echo $dato['correlativo']; ?>" title="Editar Lote.." target="mainFrame"> <img src="images/iconos/b_edit1.png" alt="Editar" width="16" height="16" border="0"></a>
            <? } ?></td>
          <td align="center" bgcolor="#CCCCCC"><? if($activo=='S') { ?>
            <a href="return_data.php?eli=10&dat=1&id=<? echo $dato['correlativo']; ?>" title="No avisar sobre lote..." target="mainFrame"> <img src="images/iconos/button_drop.png" alt="No avisar mas por este lote" width="16" height="16" border="0"></a>
            <? } else { ?>
            <a href="return_data.php?eli=9&dat=2&id=<? echo $dato['correlativo']; ?>" title="Activar Lote..." target="mainFrame"> <img src="images/iconos/check.gif" alt="Activar Lote" width="16" height="16" border="0"></a>
            <? } ?></td>
          <? } ?>
        </tr>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<script type="text/javascript">
<!--
Calendar.setup(
		{
			inputField : "fechaini", // ID of the input field
			ifFormat : "%Y-%m-%d", // the date format
			button : "cx_FECHA" // ID of the button
		});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
