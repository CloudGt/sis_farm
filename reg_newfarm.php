<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	
	$selec="SELECT * FROM Bodegas ORDER BY Descripcion";
	$datosm1= mysql_query($selec,$link);
	$selec = "SELECT Nit, upper(Nombres) as Nombres, upper(Apellidos) as Apellidos 
				FROM Cliente WHERE Activo='S' ORDER BY nombres";
	$datosm2 = mysql_query($selec,$link);
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Dise&ntilde;o y Programaci&oacute;n LDCP</TITLE>
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
.Estilo54 {font-size: 9px}
-->
</style>
<style type="text/css">
<!--
.Estilo55 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
<style type="text/css">
<!--
.Estilo57 {font-size: 14px}
-->
</style>
<style type="text/css">
<!--
.Estilo58 {font-size: 14}
-->
</style>
<style type="text/css">
<!--
.Estilo59 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	text-align: left;
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
  <p>Registro de Farmacia Nueva</p>
  <table width="60%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr>
      <td width="27%">Seleccione cliente</td>
      <td width="73%"><select name="Cliente" size="1" id="Cliente" onChange="CambioOpcion('self',this,0)">
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
      </select></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
