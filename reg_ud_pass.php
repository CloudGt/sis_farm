<?
	session_start();
	require('nuevo/conexion/conexion.php');


if (isset($_POST['ins'])) { $ins = $_POST['ins']; } else {$ins=0;}
 if ($ins == 1)
	{
	   $nip=$_POST['nip'];
	   $pass_a=md5($_POST['clave_anterior']);
   	   $pass_n=md5($_POST['clave_nueva']);
   	   $conf_pass_n=md5($_POST['conf_clave_nueva']);
       $querysel = "select password from empleado where password='$pass_a' and nip = '$nip'";
 	   $resultsel = @mysql_query($querysel,$conexion);
   	   if (@mysql_affected_rows() == 1) // verifica si el password anterior es correcto
	    {
		 if ($pass_n == $conf_pass_n) //verifica que el password nuevo se reconfirmo correctamente.
		  {
	       if ($pass_a != $pass_n) //verifica que el password nuevo sea diferente del anterior
	        {
 		     $query = "update empleado set password='$pass_n' where nip = '$nip'";
		     $result = @mysql_query($query,$link);
   	         if (@mysql_affected_rows() > 0)
	          {
		       envia_msg("Su clave ha sido actualizada");
			   cambiar_ventana("contenido.php");
			   exit;
		      } 
	         else
	          {   
		       envia_msg("Su clave no se pudo actualizar");
   		      }  
		    }
	      else // el password nuevo es igual al anterior
	       {
	        envia_msg("No es valido el cambio de contraseña... Debe ser diferente a la anterior... No se actualizo!");
	       }
		 }
		else //el password confirmado no es igual al password nuevo
		 {
  	      envia_msg("La confirmacion del password no es correcta... No se pudo actualizar!");
		 }
		}
	   else // no es correcto el password anterior
	    {
		 envia_msg("Los datos no son correctos. No se pudo actualizar");
		}
	cambiar_ventana("reg_ud_pass.php");
   exit;
	}
?>

<script language="JavaScript"><!--
// Esta funcion verifica que se hayan ingresado todos los datos obligatorios
	function Verifica()
	{
	    if(form1.nip.value == "" || form1.clave_anterior.value == "" || form1.clave_nueva.value == "" || form1.conf_clave_nueva.value == "")
		{alert('Todos los campos son requeridos');
		return false}
	}
//--></script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>&nbsp;</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<link href="Templates/tablas-eec.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
<style type="text/css">
<!--
.Estilo2 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
.Estilo3 {font-size: 14px}
-->
</style>
<style type="text/css">
<!--
.Estilo4 {font-size: 14}
-->
</style>
<style type="text/css">
<!--
.Estilo5 {
	color: #0000FF;
	font-style: italic;
}
-->
</style>
<!-- InstanceEndEditable -->
<link href="tablas-eec.css" rel="stylesheet" type="text/css">
</HEAD>

<BODY  onLoad="document.form1.clave_anterior.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<form name="form1" action="reg_ud_pass.php" method="post" onSubmit="return Verifica()">
  <p>&nbsp;</p>
  <table width="397" border="0">
    <tr>
      <td colspan="2"><div align="center"><strong>CAMBIO DE CONTRASE&Ntilde;A</strong></div></td>
    </tr>
    <tr>
      <td width="167">&nbsp;</td>
      <td width="220">&nbsp;</td>
    </tr>
    <tr>
      <td><div align="left" class="Estilo3"><span class="Estilo2  Estilo1">C&oacute;digo interno</span></div></td>
      <td><span class="Estilo4 Estilo3 Estilo2 Estilo1"><? echo $Nip;?>
            <input type="hidden" name="nip" value="<? echo $Nip; ?>">
      </span></td>
    </tr>
    <tr>
      <td><div align="left" class="Estilo3"><span class="Estilo2  Estilo1">Nombre de Usuario</span></div></td>
      <td><span class="Estilo4 Estilo1"><strong><span class="Estilo5"><? echo $Nombre;?></span></strong></span></td>
    </tr>
    <tr>
      <td><div align="left" class="Estilo3"><span class="Estilo2  Estilo1">Contrase&ntilde;a Actual</span></div></td>
      <td><input type="password"  name="clave_anterior" maxlength="32" width="32"></td>
    </tr>
    <tr>
      <td><div align="left" class="Estilo3"><span class="Estilo2  Estilo1">Contrase&ntilde;a Nueva</span></div></td>
      <td><input type="password"  name="clave_nueva" maxlength="32" width="32"></td>
    </tr>
    <tr>
      <td><div align="left" class="Estilo3"><span class="Estilo2  Estilo1">Confirmar Contrase&ntilde;a Nueva</span></div></td>
      <td><input type="password"  name="conf_clave_nueva" maxlength="32" width="32"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#D9EACA">
      <td colspan="2"><div align="center">
	  <input type="hidden" name="ins" value="1">
          <input type="submit" name="agregar" value="Actualizar">
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
