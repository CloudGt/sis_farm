<?php
	session_start();
	include("sysconect.php");
	// Verifica si hubo inicio de sesión
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	$selec="SELECT count(*) as total FROM empleado";	$datosm1=mysql_query($selec,$link);

	if (isset($_POST['ins'])) { $ins = $_POST['ins']; } else {$ins=0;}
	if ($ins == 1)
	{
	   $nip=$_POST['nip'];
	   $pass=md5($_POST['clave']);
   	   $pass_r=md5($_POST['clave_r']);
   	   $nombre=$_POST['nombre'];
	   $usuario=$_POST['usuario'];	   
	   $activo=$_POST['estatus'];	  
   	   $rol_emp=$_POST['rol_emp'];	   	   
	   $id_puesto=$_POST['puesto'];
       $querysel_nip = "select nip, usuario from empleado where nip = '$nip'";
 	   $resultsel = @mysql_query($querysel_nip,$link);
   	   if (@mysql_affected_rows() == 0) // verifica si el nip existe 
	    {
	     $querysel_us = "select usuario from empleado where usuario = '$usuario'";
 		 $resultsel = @mysql_query($querysel_us,$link);	   
         if (@mysql_affected_rows() == 0) // verifica si el usuario existe 
	      {
    	   if ($pass == $pass_r) //verifica que el password y la confirmacion sean iguales
	        {
 		     $query = "insert into empleado (nip,usuario,nombre,password,activo,id_puesto)
		 							 values ('$nip','$usuario','$nombre','$pass',$estatus,$rol_emp)";										 			 $result = @mysql_query($query,$link);
			 $queryin = "insert into rolxempleado (idrolxempleado, nip, id_rol, fecharegistro) values (null,'$nip',$rol_emp,now())";

   	         if (@mysql_affected_rows() == 1)
	          {
				 $result_in = @mysql_query ($queryin,$link);
					envia_msg("Empleado registrado exitosamente");
		      } 
	         else
	          {   
		       envia_msg("El empleado no se pudo registrar");
   		      }  
		    }
	       else
	        {
	         error_msg("Verifique el password... La confirmaci&oacute;n no fue exitosa!");
	        }   
	 	  }
		 else
		  {
  		   error_msg("El usuario que intento agregar ya existe");		  
		  }
	    }
	   else
	    {
		 error_msg("El nip que intento agregar ya existe");
		}
		cambiar_ventana("reg_nusuario.php");
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


<style type="text/css">
<!--
#tabla {	text-align: center;
}
-->
</style>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
#1 form table tr td .en_tabla {
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

<BODY onLoad="document.form1.usuario.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
  <form name="form1" action="reg_nusuario.php" method="post" onSubmit="return Verifica()">
  <table width="85%" border="0">
    <tr id="tabla">
    <td width="8%" rowspan="2" bgcolor="#6699FF" style="font-weight: bold">C&oacute;digo</td>
    <td colspan="3" bgcolor="#6699FF" style="font-weight: bold">USUARIOS REGISTRADOS EN EL SISTEMA</td>
    <td colspan="2" rowspan="2" bgcolor="#6699FF" style="font-weight: bold">Acci&oacute;n</td>
    </tr>
   <tr>
     <td align="center" bgcolor="#6699FF" style="font-weight: bold">NOMBRE COMPLETO</td>
    <td align="center" bgcolor="#6699FF" style="font-weight: bold">USUARIO</td>
    <td align="center" bgcolor="#6699FF" style="font-weight: bold">ROL</td>
    </tr>
   <?php
	$busca="SELECT nip, usuario, nombre, rol FROM empleado,rol WHERE activo='1' and id_rol=id_puesto and id_puesto<>'1'
			ORDER BY id_rol, nombre";
	$filtro=mysql_query($busca,$link);
	while($dato=mysql_fetch_array($filtro))
	{
  		$nip=$dato['nip'];
		$usu=$dato['usuario'];
		$nom=$dato['nombre'];
		$rol=$dato['rol'];
  ?>
  <tr>
    <td align="center" bgcolor="#999999"><?php
<?php	echo $nip; ?></td>
    <td bgcolor="#CCCCCC"><?php
<?php	echo $nom; ?></td>
    <td align="center" bgcolor="#999999">[<?php
<?php	echo $usu; ?>] </td>
    <td align="center" bgcolor="#CCCCCC">[<?php
<?php	echo $rol; ?>]</td>
    <td width="7%" align="center">
    <a href="return_data.php?eli=7&id=<?php
<?php	echo $dato['nip'];?>&dato=1" title="Reiniciar Contraseña de Usuario" target="mainFrame">
    <img src="images/iconos/Question.png" width="26" height="27" border="0" align="absmiddle"></a></td>
    <td width="7%" align="center">
      <a href="return_data.php?eli=7&id=<?php
<?php	echo $dato['nip']; ?>&dato=2" title="Desactivar Usuario" target="mainFrame">
        <img src="images/iconos/button_drop.png" alt="" width="16" height="16" border="0"></a></td>
  </tr>
  <?php
<?php	} ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</form>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
