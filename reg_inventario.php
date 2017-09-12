<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
//Definicion de Variables
	$a=$_SESSION['Nom'];
	$p=$_SESSION['Ape'];
	$c=$_SESSION['Usr'];
	$cod1=$_GET['cod1'];
	$cod2=$_GET['cod2'];
	$met=$_GET['met'];
	$casa=$_POST['Caja1'];
	$producto=$_POST['Caja2'];
	$correcto=$_POST['Caja3'];
	$hoy=date('Y-m-d');
	
// Filtros de Busqueda
	$selec = "SELECT Id_proveedor, upper(Nom_provee) Nom_provee, Activo FROM Proveedores WHERE Activo='S' ORDER BY 2";
	$datosm1 = mysql_query($selec,$link);
	if ($cod1 != 0)
	{
		$selec = "SELECT b.Id_producto, b.Nproducto FROM bodegam as b, proveedores as p 
				WHERE b.Activo='S' AND b.id_proveedor=p.id_proveedor AND p.Activo='S' AND b.id_proveedor='$cod1' 
				ORDER BY b.Nproducto";
		$datosm2= mysql_query($selec,$link);
	}
	else
	{
		$selec = "SELECT b.Id_producto, upper(b.Nproducto) Nproducto FROM bodegam as b, proveedores as p 
				WHERE b.Activo='S' AND b.id_proveedor=p.id_proveedor AND p.Activo='S' 
				ORDER BY 2";
		$datosm2= mysql_query($selec,$link);
	}
	$selec= "SELECT a.Id_producto, upper(a.Nproducto) Nproducto, b.Presentacion, a.Existencia
				FROM bodegam as a, presentacion as b 
				WHERE a.presentacion=b.id_presenta AND a.activo='S' AND a.id_producto='$cod2'";
				if ($cod1) {$selec = $selec." AND a.id_proveedor = '$cod1'";}
	$selec = $selec." ORDER BY 2"; 
	$filtro= mysql_query($selec,$link);

if ($met==1)
{
	if($correcto<0)
	{
		error_msg("NO PUEDE ACTUALIZAR MEDICAMENTOS CON VALORES NEGATIVOS");
		cambiar_ventana("reg_inventario.php");
		exit;
	}
	else
	{
		$cambio="UPDATE Bodegam SET Existencia='$correcto' WHERE id_producto='$producto'";
		$corre=mysql_query($cambio,$link);
		error_msg ("ACTUALIZACION DE DATOS SATISFACTORIA");
		cambiar_ventana("reg_inventario.php");
		exit;
	}
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
	function Verifica()
	{
		 if(Inventario.Caja2.value== "" || Inventario.Caja3.value== "" )
		{alert('Faltan Datos por Captarse');
		return false}
	}
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
.Estilo3 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
.Estilo4 {font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
-->
</style>
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

<BODY>
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<p>&nbsp;</p>
<form name="Inventario" id="Inventario" method="post" action="reg_inventario.php?met=1" onSubmit="return Verifica();">
	<table border="0" align="center">
      <tr>
        <td><div align="center"><strong>ACTUALIZACI&Oacute;N DE INVENTARIO</strong></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
    <td><div align="right"><span class="Estilo3"><span class="Estilo9">
      <input name="Caja1" type="hidden" id="Caja1" value="<?php
<?php	echo $cod1 ?>">
      <select name="Proveedor" size="1" id="Proveedor" onChange="CambioOpcion('self',this,0)">
   	        <option value="reg_inventario.php?cod1=0">Seleccione Proveedor </option>
            <?														
			while($medi=mysql_fetch_array($datosm1))						
			{													
				$prv = $medi['Id_proveedor'];
				$nom = $medi['Nom_provee'];
				if ($prv == ($cod1))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_inventario.php?cod1=".$prv."\">".$nom."</option>\n";				              
     	} ?>
          </select>
      <input name="Caja2" type="hidden" id="Caja2" value="<?php
<?php	echo $cod2 ?>">
      <select name="Medicamento" size="1" id="Medicamento" onChange="CambioOpcion('self',this,0)">
        <option value="reg_inventario.php?cod2=0&cod1=<?php
<?php	echo $cod1 ?>">Seleccione Medicamento</option>
        <?														
			while($medi=mysql_fetch_array($datosm2))						
			{													
				$codi=$medi['Id_producto'];
				$medi=$medi['Nproducto'];
				if ($codi == ($cod2))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_inventario.php?cod2=".$codi."&cod1=".$cod1."\">".$medi."</option>\n";				              
     	} ?>
      </select>
        </span></span> </div></td>
      </tr>
    <tr>
      <td><div align="right">        <span class="Estilo9"><span class="Estilo3">.        </span></span></div></td>
    </tr>
	</table>
  	<table width="60%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
      <tr>
        <td><table width="100%" border="0" align="center">
          <tr bgcolor="#FFFFCC">
            <td bgcolor="#FFFFCC"><div align="center" class="Estilo114 Estilo1 Estilo3">
                <div align="center"><span class="Estilo57 Estilo60 Estilo98 Estilo79 Estilo109 Estilo67">MEDICAMENTO</span></div>
            </div></td>
            <td><div align="center" class="Estilo115 Estilo1 Estilo3">
                <div align="center"><span class="Estilo57 Estilo60">PRESENTACION</span></div>
            </div></td>
            <td><div align="center" class="Estilo115 Estilo1 Estilo3">
                <div align="center">EXISTENCIA</div>
            </div></td>
            <td><div align="center" class="Estilo110 Estilo1 Estilo3">ACTUALIZACION</div></td>
          </tr>
          <?php
<?php	 
		while($list=mysql_fetch_array($filtro))
		{
			$codprod=$list['Id_producto'];
			$medicamento=$list['Nproducto'];
			$presenta=$list['Presentacion'];
			$existe=$list['Existencia'];
		?>
          <tr>
            <td height="37" bgcolor="#F0F0F0"><div align="left" class="Estilo1 Estilo120  Estilo3"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74 Estilo79 Estilo111  Estilo67"><?php
<?php	echo $medicamento ?></span></span></span></div></td>
            <td bgcolor="#D9E9CE"><div align="center" class="Estilo1 Estilo120  Estilo3"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74  Estilo79"><?php
<?php	echo $presenta; ?></span></span></span></div></td>
            <td bgcolor="#F0F0F0"><div align="center" class="Estilo1 Estilo111 Estilo67 Estilo74 Estilo82  Estilo3"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><?php
<?php	echo $existe ?></span></span></div></td>
            <td bgcolor="#D9E9CE">
              <div align="center" class="Estilo4">
                <input name="Caja3" type="text" id="Caja32" size="10" maxlength="10">
                <?php
<?php	} ?>
              </div>
          <tr>
            <td colspan="4">&nbsp;          </td>
            <tr bgcolor="#D9E9CE">
            <td colspan="4"><div align="center"><span class="Estilo1">
                <input name="Submit3" type="submit" id="Submit3" value="Actualizar Inventario">
            </span> </div></td>
        </table></td>
      </tr>
    </table>
  	<div align="center"><span class="Estilo1">
    </span>
  	</div>
</form>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
