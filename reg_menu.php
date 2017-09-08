<?
session_start();
include("sysconect.php");
if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("test.php");		exit;	}

$link = conectarse("apdahum");


if ( (isset($_POST['ins'])) && ($_POST['ins']==1) )
 {
  $saves=0;
  $id_padre=$_POST['id_padre'];
  $descri=$_POST['descri'];

  $nom_arch=$_POST['nom_arch'];

	$querysel = "select descr, pagina from menu where descr = '$descri' or pagina = '$nom_arch'";

	$result_sel=@mysql_query($querysel);

	if (mysql_affected_rows() >= 1 )
	 {
	  error_msg("La opcion del Menu $descri o la pagina $nom_arch ya existen. Verifique sus datos");
	 }
	else
	 {
      $query="insert into menu (id_menu,descr,padre,pagina,fecharegistro) values (null,'$descri',$id_padre,'$nom_arch',now())";
      $result = @mysql_query($query);
	  if ( @mysql_affected_rows()== 1)
	   {
	    error_msg("La opcion del menu fue creada exitosamente");
	   }
	  else
	   {
	    error_msg("No se pudo crear la opcion solicitada");
	   }
   } 
  exit;
 }
 ?>
<script language="JavaScript"><!--
	
	function Verifica()
	{ 
  	   if(form1.nom_arch.value == "" || form1.descri.value == "")
		{alert('Debe ingresar obligatoriamente todos los valores');
		return false}
	} 

//--></script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Farmacia del Pueblo</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->


<link href="Templates/tablas-eec.css" rel="stylesheet" type="text/css">
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

<BODY onLoad="document.form1.id_padre.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<form name="form1" action="reg_menu.php" method="post" onSubmit="return Verifica()">
<table border="0"  width="550" align="center" class="en_tabla"> 
 <TR align="center">
   <TD colspan="3"><strong>CONFIGURACI&Oacute;N DE MEN&Uacute; PRINCIPAL </strong></TD>
 </TR>
 <tr><TD width="150">&nbsp;</TD></TR>
 <TR>
  <TD VALIGN="top"> Cat&aacute;logo Principal </TD>
   <TD><select name="id_padre">
		<?
			$sqlsel = @mysql_query("select id_menu, descr from menu where padre = 0");
			while($row = @mysql_fetch_array($sqlsel)) 
			{
				printf("<option value= \"%d\">%s </option>",$row["id_menu"],$row["descr"]);
			}
			@mysql_free_result($sqlsel);
		?>
		 </select>
  </td> 
 </TR>
 <!--/table>
<table border="0"  width="700" align="center" class="en_tabla"--> 

 <TR>
  <TD width="250" >Nombre del Men&uacute; en el Cat&aacute;logo</td>
  <td><input type="text" name="descri" size="45" width="30" maxlength="30" value=""></TD>
 </TR>
 <TR>
  <TD width="150" >Nombre de Archivo </td>
  <td><input type="text" name="nom_arch" size="45" width="30" maxlength="30" onKeyUp="javascript:this.value=this.value.toLowerCase();" value=""></TD>
 </TR>		
  <tr bgcolor="#D9E9CE"><TD align="center" colspan="2">
  	    <input type="hidden" name="ins" value="1">
	    <input type="submit" name="agregar" value="Agregar" onClick="return Verifica()">  </TD>

</TABLE>
</form> 
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
