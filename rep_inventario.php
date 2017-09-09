<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
//Definición de variables
	$cod1=$_GET['cod1'];
	$cod2=$_GET['cod2'];
	$link=conectarse("Apdahum");
	$selec = "SELECT id_proveedor, nom_provee FROM Proveedores WHERE Activo='S' ORDER BY nom_provee";
	$datosm1 = mysql_query($selec,$link);
	$selec = "SELECT nit, nombres, apellidos FROM Cliente ORDER BY nombres";
	$datosm2 = mysql_query($selec,$link);
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
		if (restore) selObj.selected;
	}	
//--></script>
<style type="text/css">
<!--
.Estilo52 {font-family: Arial, Helvetica, sans-serif; color: #0000FF; font-weight: bold; }
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
<form name="form1" method="post" action="Rmtemp.php">
  <table width="60%" border="2">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td><div align="center"><strong>GENERACION DE ARCHIVOS DE MEDICAMENTOS</strong></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><p align="right">
              <input name="Caja1" type="hidden" id="Caja1" value="<? echo $cod1 ?>">
              <select name="Proveedor" size="1" id="select6" onChange="CambioOpcion('self',this,0)">
                <option value="rep_inventario.php">Todos los Proveedores</option>
                <?														
			while($nomp=mysql_fetch_array($datosm1))						
			{													
				$codigo =$nomp['id_proveedor'];
				$descrip =$nomp['nom_provee'];
				if ($codigo == ($cod1))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"rep_inventario.php?cod1=".$codigo."&cod2=".$cod2."\">".$descrip."</option>\n";				
	    }?>
              </select>
              </td>
        </tr>
        <tr>
          <td><div align="right"><span class="Estilo52"><span class="Estilo3"><span class="Estilo3 Estilo9">
              <input name="Caja2" type="hidden" id="Caja2" value="<? echo $cod2 ?>">
              <select name="Cliente" size="1" id="select2" onChange="CambioOpcion('self',this,0)">
                <option value="rep_inventario.php?cod2=0&cod1=<? $cod1 ?>">Clientes General</option>
                <?														
			while($clientes=mysql_fetch_array($datosm2))						
			{													
				$codigo  = $clientes['nit'];
				$nombres = $clientes['nombres'];
				$apellid = $clientes['apellidos'];
				if ($codigo == ($cod2))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"rep_inventario.php?cod2=".$codigo."&cod1=".$cod1."\">".$nombres." ".$apellid."</option>\n";				
	    }?>
              </select>
          </span></span></span></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><label>
<input name="radio" type="radio" id="radio" value="E" checked>
Generar archivo PDF</label></td>
        </tr>
        <tr>
          <td><label>
            <input type="radio" name="radio" id="radio2" value="X">
          Gererar archivo XLS</label></td>
        </tr>
        <tr>
          <td bgcolor="#D9E9CE"><div align="center">
            <input type="submit" name="Submit2" value="Generar Reporte">
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
  </form>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
