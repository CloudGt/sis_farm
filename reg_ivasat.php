<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	$cod1=$_GET['cod1'];	$cod2=$_GET['cod2'];
	
	$selec1= "SELECT Id_proveedor, upper(Nom_provee) as Nom_provee FROM Proveedores WHERE Activo='S' ORDER BY Nom_provee";
	$datosm1 = mysql_query($selec1,$link);
	if($cod1)	{
		$selec2= "SELECT id_producto, upper(nproducto) as nproducto 
					FROM Bodegam WHERE Activo='S' AND id_proveedor='$cod1' ORDER BY Nproducto";
		$datosm2 = mysql_query($selec2,$link);
	} else {
		$selec2= "SELECT id_producto, upper(nproducto) as nproducto FROM Bodegam WHERE Activo='S' ORDER BY Nproducto";
		$datosm2 = mysql_query($selec2,$link);
	}
	if(($cod1) || ($cod2)) {
	$listado="SELECT b.id_producto, upper(b.nproducto) as nproducto, upper(p.nom_provee) as nom_provee, 
					upper(x.presentacion) as presentacion, b.id_proveedor, b.afecto, b.existencia
				FROM Bodegam b, Proveedores p, Presentacion x
				WHERE p.id_proveedor=b.id_proveedor AND x.id_presenta=b.presentacion
				AND b.activo='S'";
	if ($cod1)	{	$listado = $listado." AND b.id_proveedor = '$cod1'"; }
	if ($cod2)	{	$listado = $listado." AND b.id_producto = '$cod2'";  }
	$listado=$listado." ORDER BY p.nom_provee, b.nproducto";
	$filtro=mysql_query($listado,$link);
	}
?>  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Dise&ntilde;o y Programaci&oacute;n LDCP</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript"><!--
	function CambioOpcion(targ,selObj,restore)
	{
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
//--></script>

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
	font-size: 10px;
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
  <p style="font-weight: bold"><span class="Estilo3 Estilo9">
    <select name="Proveedor" id="select" onChange="CambioOpcion('self',this,0)">
      <option value="reg_ivasat.php">Seleccione Proveedor</option>
      <?														
			while($provee=mysql_fetch_array($datosm1))						
			{													
				$codigo =$provee['Id_proveedor'];
				$descrip=$provee['Nom_provee'];
				if ($codigo == ($cod1))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_ivasat.php?cod1=".$codigo."\">".$descrip."</option>\n";				
	    }?>
    </select>
    <input name="Caja1" type="hidden" id="Caja14" value="<?php
<?php	echo $cod1 ?>">
    <select name="Medicamento" size="1" id="Medicamento" onChange="CambioOpcion('self',this,0)">
      <option value="reg_ivasat.php?cod1=<?php
<?php	echo $cod1 ?>">Todos los Medicamentos</option>
      <?														
			while($medi=mysql_fetch_array($datosm2))						
			{													
				$codi=$medi['id_producto'];
				$medi=$medi['nproducto'];
				if ($codi == ($cod2))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_ivasat.php?cod2=".$codi."&cod1=".$cod1."\">".$medi."</option>\n";				              
     	} ?>
    </select>
  </span></p>
  <p style="font-weight: bold">&nbsp; </p>
  <table width="95%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr>
      <td height="11" align="center" bgcolor="#FFFF66" style="font-weight: bold">PROVEEDOR</td>
      <td align="center" bgcolor="#FFFF66" style="font-weight: bold">MEDICAMENTO</td>
      <td align="center" bgcolor="#FFFF66" style="font-weight: bold">PRESENTACI&Oacute;N</td>
      <td align="center" bgcolor="#FFFF66" style="font-weight: bold">AFECTO a  Impuesto al Valor Agregado [IVA]</td>
      <td align="center" bgcolor="#FFFF66" style="font-weight: bold">DESACTIVAR</td>
    </tr>
    <?	while ($result=mysql_fetch_array($filtro))	{	$afecto=$result['afecto']; ?>
    <tr>
      <td height="44" bgcolor="#999999"><?php
<?php	echo $proveedor=$result['nom_provee']; ?></td>
      <td bgcolor="#CCCCCC"><?php
<?php	echo $medicamento=$result['nproducto']; ?></td>
      <td align="center" bgcolor="#999999"><?php
<?php	echo $presentacion=$result['presentacion']; ?></td>
      <td align="center" valign="middle" bgcolor="#CCCCCC">
<form name="form1" method="post" action="return_data.php?eli=8">
          <table width="100%" border="0">
            <tr>
              <td width="85%" align="center">
			  <?	if($afecto=='S')	{	?>	
                SI  
			      <label>	<input name="radio" type="radio" id="radio" value="S" checked>  </label>
												NO	<label>	<input type="radio" name="radio" id="radio" value="N">	</label>
				<?php
<?php	}	else	{	?>			SI	<label> <input type="radio" name="radio" id="radio" value="S">	</label>
                								NO	<label> <input name="radio" type="radio" id="radio" value="N" checked></label>
			<?php
<?php	} ?></td>
              <td width="15%" align="center"><input type="submit" name="button" id="button" value="Corregir">
                <span id="sprytextfield5">
                <label>
              <input name="codmed" type="hidden" id="codmed" value="<?php
<?php	echo $codmed=$result['id_producto']; ?>">
                </label>
              <span class="textfieldRequiredMsg">?</span></span><span id="sprytextfield3">
              <label>
             <input name="codpro" type="hidden" id="codpro" value="<?php
<?php	echo $codpro=$result['id_proveedor']; ?>">
              </label>
              <span class="textfieldRequiredMsg">?</span></span></td>
            </tr>
           
          </table>
          <label><span id="sprytextfield1"><span class="textfieldRequiredMsg">?</span></span></label>
      </form></td>
      <td align="center" bgcolor="#999999">
      <a href="return_data.php?eli=9&id=<?php
<?php	echo $codmed=$result['id_producto']; ?>&id2=<?php
<?php	echo $codpro=$result['id_proveedor']; ?> title="Desactivar Producto" target="mainFrame">
      <img src="images/iconos/button_drop.png" alt="Desactivar..." width="16" height="16" border="0"></a></td>
    </tr>
    <?php
<?php	} ?>
  </table>
  <script type="text/javascript">
<!--

var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
//-->
  </script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
