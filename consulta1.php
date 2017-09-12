<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");

// Recibe los valores que se ingresaron en el formulario
	$cod1=$_GET['cod1'];
	$cod2=$_GET['cod2'];
	$cod3=$_POST['clike'];
	$x=1;			

// Filtros de Busqueda
	$selec = "SELECT Id_proveedor, upper(Nom_provee) Nom_provee FROM Proveedores WHERE Activo='S' ORDER BY 2";
	$datosm1 = mysql_query($selec,$link);
	if($cod1!=0) 
	{
		$selec  = "SELECT Id_producto, upper(Nproducto) Nproducto 
					FROM bodegam WHERE Activo='S' AND Id_proveedor='$cod1' ORDER BY 2";
		$datosm2= mysql_query($selec,$link);
	}
	else
	{
		$selec  = "SELECT b.Id_producto, upper(b.Nproducto) Nproducto FROM bodegam as b, proveedores as p 
					WHERE b.Activo='S' AND b.id_proveedor=p.id_proveedor AND p.Activo='S' ORDER BY 2";
		$datosm2= mysql_query($selec,$link);
	}
	if ($met==1)
	{	
	$selec= "SELECT p.nom_provee, s.presentacion, m.nproducto, m.preciocosto, m.precioc1, m.precioc2, m.precioc3, 
				m.precioc4, m.precioc5, m.precioc6, m.precioc7, m.precioVP, m.existencia
                 FROM bodegam as m, proveedores as p, presentacion as s
                 WHERE p.id_proveedor=m.id_proveedor AND m.Activo='S' AND p.Activo='S' AND s.id_presenta=m.presentacion";
				 if ($cod1) {$selec = $selec." AND m.id_proveedor = '$cod1'";}
				 if ($cod2) {$selec = $selec." AND m.id_producto = '$cod2'";}
				 if ($cod3) {$selec = $selec." AND m.nproducto LIKE ('%$cod3%')";}
	$selec = $selec." ORDER BY p.nom_provee, m.nproducto, s.presentacion";
	$filtro= mysql_query($selec,$link);
	
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Consultas (ldcp 2009)</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language="JavaScript"><!--
	function CambioOpcion(targ,selObj,restore)
	{
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
//--></script>
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
.Estilo54 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
<style type="text/css">
<!--
.Estilo55 {
	font-size: 16;
	font-weight: bold;
}
-->
</style>
<style type="text/css">
<!--
.Estilo56 {font-weight: bold}
#1 form .Estilo6 table tr td {
	text-align: center;
}
-->
</style>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
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

<BODY onLoad="document.Asigna.clike.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<form name="Asigna" method="post" action="consulta1.php?met=1" >
	<div align="right" class="Estilo6">
  <table width="70%" border="0" align="center" class="Estilo6">
    <tr><td><div align="center" class="Estilo57 Estilo60"><span class="Estilo67"><span class="Estilo66"><strong>CONSULTA DE MEDICAMENTOS </strong></span></span></div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF"><span class="Estilo3"><span class="Estilo3 Estilo9">
        <input name="Caja1" type="hidden" id="Caja14" value="<?php
<?php	echo $cod1 ?>">
        <select name="Fiscalia" id="select" onChange="CambioOpcion('self',this,0)">
          <option value="consulta1.php">Seleccione Proveedor</option>
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
				echo "<option ".$selected." value=\"consulta1.php?cod1=".$codigo."&cod3=".$cod3."&met=".$x."\">".$descrip."</option>\n";				
	    }?>
          </select>
        <span class="Estilo9"> <span id="spryselect1"><span class="selectRequiredMsg">Seleccione un elemento.</span></span>
          <input name="Caja2" type="hidden" id="Caja2" value="<?php
<?php	echo $cod2 ?> ";>
          <select name="Usuario" id="Usuario" onChange="CambioOpcion('self',this,0)">
            <option value="consulta1.php?cod2=0&cod1=<?php
<?php	echo $cod1 ?>">Seleccione Producto</option>
            <?														
			while($produc=mysql_fetch_array($datosm2))						
			{													
				$nip =$produc['Id_producto'];
				$nom =$produc['Nproducto'];
				if ($nip == ($cod2))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"consulta1.php?cod2=".$nip."&cod3=".$cod3."&cod1=".$cod1."&met=".$x."\">".$nom."</option>\n";				              
     	} ?>
            </select>
          </span></span></span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><span class="Estilo3"><span class="Estilo3 Estilo9"><span class="Estilo9"><span class="Estilo9 Estilo67 Estilo111"><span id="sprytextfield1">
        <label>
          <input type="text" name="clike" id="clike">
          <span class="Estilo53 Estilo54"><img src="images/iconos/lupa.gif" width="25" height="21"></span>          </label>
        <span class="textfieldRequiredMsg">Falta...</span></span><span class="Estilo53 Estilo54">Nombre del Medicamento</span></span></span></span></span></td>
    </tr>
    <tr>
      <td height="21" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
	</table>
    <table width="100%" border="1" align="center" cellpadding="1" cellspacing="1" frame="border" rules="rows">
      <tr bgcolor="#FFFFCC">
        <td width="10%" rowspan="2" bgcolor="#FFFFCC"><div align="center" class="Estilo99 Estilo98 Estilo67 Estilo107 Estilo53 Estilo54 Estilo56">
            <div align="center"><span class="Estilo57 Estilo60 ">PROVEEDOR</span></div>
        </div></td>
        <td width="20%" rowspan="2"><div align="center" class="Estilo107 Estilo53 Estilo54 Estilo56">
          <div align="center"><span class="Estilo57 Estilo60 Estilo98 Estilo79 Estilo109">PRODUCTO</span></div>
        </div></td>
        <td width="10%" rowspan="2"><div align="center" class="Estilo108 Estilo53 Estilo54 Estilo56">
          <div align="center"><span class="Estilo57 Estilo60">PRESENTACION</span></div>
        </div></td>
        <td width="10%" rowspan="2"><div align="center" class="Estilo108 Estilo53 Estilo54 Estilo56">
            <div align="center">EXISTENCIAS</div>
        </div></td>
       <?php
<?php		if($Nivel==1 || $Nivel==2) 	{ 	?>
		  <td width="10%" rowspan="2"><div align="center" class="Estilo108 Estilo53 Estilo54 Estilo56">
		    <div align="center"><span class="Estilo57 Estilo60 Estilo79 Estilo109 Estilo98">PRECIO COSTO<?php
<?php	} ?>
		    </span></div>
		  </div></td>
        <td colspan="8"><div align="center" class="Estilo54 Estilo53 Estilo110"><span class="Estilo54 Estilo53 Estilo108"><strong>PRECIOS DE VENTA </strong></span></div>          
          <div align="center" class="Estilo54 Estilo53 Estilo108"></div></td>
        </tr>
      <tr bgcolor="#CCCCCC">
		<?php
<?php		if($Nivel==1 || $Nivel==2 || $Nivel==3) {  ?>
		<td width="5%" align="center" bgcolor="#FFFFCC"><div align="center" class="Estilo54 Estilo53"><strong><a href="consulta2.php?cod1=A" title="Ver Asociados Tipo A" target="_self">A</a></strong></div></td>
        <?php
<?php	} ?>
		<?php
<?php		if($Nivel==1 || $Nivel==2 || $Nivel==3 || $Nivel==4) {  ?>
		<td width="5%" align="center" bgcolor="#FFFFCC"><div align="center" class="Estilo54 Estilo53"><strong><a href="consulta2.php?cod1=B" title="Ver Asociados Tipo B" target="_self"  >B</a></strong></div></td>
		 <?php
<?php	} ?>
		<?php
<?php		if($Nivel==1 || $Nivel==2 || $Nivel==3) {  ?>
        <td width="5%" align="center" bgcolor="#FFFFCC"><div align="center" class="Estilo54 Estilo53"><strong><a href="consulta2.php?cod1=C" title="Ver Asociados Tipo C" target="_self">C</a></strong></div></td>
        <td width="5%" align="center" bgcolor="#FFFFCC"><div align="center" class="Estilo54 Estilo53"><strong><a href="consulta2.php?cod1=D" title="Ver Asociados Tipo D" target="_self">D</a></strong></div></td>
        <td width="5%" align="center" bgcolor="#FFFFCC"><span class="Estilo54 Estilo53"><strong><a href="consulta2.php?cod1=E" title="Ver Asociados Tipo E" target="_self">E</a></strong></span></td>
        <td width="5%" align="center" bgcolor="#FFFFCC"><strong><a href="consulta2.php?cod1=G" title="Ver Asociados Tipo V" target="_self" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">V</a></strong></td>
        <td width="5%" align="center" bgcolor="#FFFFCC"><strong><a href="consulta2.php?cod1=H" title="Ver Asociados Tipo M" target="_self" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">M</a></strong></td>
        <?php
<?php	} ?>
		<td width="5%" align="center" bgcolor="#FFFFCC"><div align="center" class="Estilo54 Estilo53"><strong><a href="consulta2.php?cod1=F" title="Ver Asociados Tipo F" target="_self">PUBLICO</a></strong></div></td>
      </tr>
      <?php
<?php	 
		// Llena de fichas existentes
		while($lista=mysql_fetch_array($filtro)){
			$provee=$lista['nom_provee'];
			$medicamento=$lista['nproducto'];
			$presentacion=$lista['presentacion'];
			$pcosto=$lista['preciocosto'];
			$pv1=$lista['precioc1'];
			$pv2=$lista['precioc2'];
			$pv3=$lista['precioc3'];
			$pv4=$lista['precioc4'];
			$pv5=$lista['precioc5'];
			$pv7=$lista['precioc6'];
			$pv8=$lista['precioc7'];
			$pv6=$lista['precioVP'];
			$existencia=$lista['existencia'];
	?>
	  <tr>
        <td height="53" bgcolor="#F0F0F0">
          <div align="center" class="Estilo76 Estilo67 Estilo74 Estilo53 Estilo54">
            <div align="left" class="Estilo82 Estilo67 Estilo74"><?php
<?php	echo $provee; ?></div>
          </div></td>
        <td height="53" bgcolor="#D9E9CC"><div align="left" class="Estilo57 Estilo60 Estilo53 Estilo54"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74 Estilo67"><span class="Estilo82 Estilo79 Estilo98"><?php echo $medicamento; ?></span></span></span></div></td>
        <td height="53" bgcolor="#F0F0F0"><div align="center" class="Estilo41 Estilo43 Estilo53 Estilo54"><span class="Estilo82 Estilo67 Estilo111"><span class="Estilo67 Estilo111"><?php
<?php	echo $presentacion; ?></span></span></div></td>
        <td height="53" bgcolor="#D9E9CC"><div align="center" class="Estilo82 Estilo67 Estilo74 Estilo53 Estilo54"> <span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><?php echo $existencia; ?></span></span></div></td>
		<?php
<?php	 if($Nivel==1 || $Nivel==2)	{  ?>
        <td height="53" bgcolor="#F0F0F0"><div align="center" class="Estilo82 Estilo67 Estilo74 Estilo53 Estilo54"> <span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><?php echo $pcosto; ?></span></span></div></td>
        <?php
<?php	} ?>
<?php
<?php	 if(($Nivel==1) || ($Nivel==2) || ($Nivel==3))	{  ?>
		<td height="53" bgcolor="#D9E9CC">
        <div align="center" class="Estilo76 Estilo53 Estilo54">
		<div align="right"><span class="Estilo82 Estilo74  Estilo67">
        <span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><?php echo $pv1; ?><span class="Estilo82 Estilo74  Estilo79">
        </span></span></span></span></div>
		<?php
<?php	} ?>
		<td height="53" bgcolor="#F0F0F0">
        
		<?php
<?php		if($Nivel==1 || $Nivel==2 || $Nivel==3 || $Nivel==4) {  ?>
        <div align="center" class="Estilo76 Estilo67 Estilo74 Estilo53 Estilo54">
        <div align="right"><span class="Estilo82 Estilo74  Estilo79">
        <span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43">
        <?php
<?php	echo $pv2; ?>
        </span></span></span></div>        
        <td height="53" bgcolor="#D9E9CC"><div align="center" class="Estilo82 Estilo67 Estilo74 Estilo53 Estilo54"> 
        <?php
<?php	} ?>
         <?php
<?php	 if(($Nivel==1) || ($Nivel==2) || ($Nivel==3))	{  ?>
        <div align="right"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74  Estilo79">
        </span><?php echo $pv3; ?></span></span></div>
		</div></td>
        <td bgcolor="#F0F0F0"><div align="center" class="Estilo53 Estilo54">
          <div align="right"><span class="Estilo76"><span class="Estilo82 Estilo74  Estilo67">
          <span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><?php echo $pv4; ?></span></span></span></span></div>
        </div></td>
        <td align="right" bgcolor="#D9E9CC" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><span class="Estilo82 Estilo74  Estilo67"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><?php echo $pv5; ?></span></span></span></td>
        <td align="right" bgcolor="#F0F0F0" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><?php echo $pv7; ?></td>        
        <td height="53" bgcolor="#D9E9CC"><div align="center" class="Estilo76 Estilo53 Estilo54">
          <div align="right"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><?php echo $pv8; ?></span></div>
        </div></td>
        <?php
<?php	} ?>
		<td height="53" bgcolor="#F0F0F0">
        <div align="center" class="Estilo53 Estilo54" style="text-align: right; font-weight: bold; font-size: 14px;"><?php
<?php	echo $pv6; ?></div>
        <div align="center" class="Estilo82 Estilo79 Estilo98 Estilo53 Estilo54 Estilo55">
        <div align="right"></div>
        </div>            
        <div align="right"></div></td>
        <?php
<?php	} ?>
      </table>
    </div>
</form>

<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
