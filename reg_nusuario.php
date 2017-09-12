<?php
	session_start();
  require('nuevo/conexion/conexion.php');
	// Verifica si hubo inicio de sesión

	$selec="SELECT count(*) as total FROM empleado";	
  $datosm1=mysqli_query($selec,$conexion);

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
 	   $resultsel = mysqli_query($querysel_nip,$conexion);
   	   if (mysqli_affected_rows() == 0) // verifica si el nip existe 
	    {
	     $querysel_us = "select usuario from empleado where usuario = '$usuario'";
 		 $resultsel = mysqli_query($querysel_us,$conexion);	   
         if (mysqli_affected_rows() == 0) // verifica si el usuario existe 
	      {
    	   if ($pass == $pass_r) //verifica que el password y la confirmacion sean iguales
	        {
 		     $query = "insert into empleado (nip,usuario,nombre,password,activo,id_puesto)
		 							 values ('$nip','$usuario','$nombre','$pass',$estatus,$rol_emp)";										 			 
                   $result = mysqli_query($query,$conexion);
			 $queryin = "insert into rolxempleado (idrolxempleado, nip, id_rol, fecharegistro) values (null,'$nip',$rol_emp,now())";

   	         if (mysqli_affected_rows() == 1)
	          {
				 $result_in = mysqli_query ($queryin,$conexion);
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

<script language="JavaScript"><!--
	function Verifica()
	{
	    if(form1.nip.value == "" || form1.clave.value == "" || form1.clave_r.value == "" || form1.usuario.value == "" || form1.nombre.value == "")
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


<link href="tablas-eec.css" rel="stylesheet" type="text/css">
</HEAD>

<BODY onLoad="document.form1.usuario.focus()">
<pre>
  <?php 
    print_r($_SESSION); 
   ?>
</pre>
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<form name="form1" action="reg_nusuario.php" method="post" onSubmit="return Verifica()">
  <table width="75%" border="0">
    <tr>
    <td><table width="100%" border="0" align="center" cellpadding="1" cellspacing="2" class="en_tabla">
      <tr>
        <td colspan="3" align="center"><p><strong>REGISTRO DE USUARIOS</strong></p></td>
      </tr>
  <tr>
    <td rowspan="8" align="center" valign="top"><img src="images/iconos/Personal.png" width="58" height="51" border="0"></td>
    <td><br></td>
      <td width="300">&nbsp;</td>
  <tr>
   <?php
<?php	
    	while($ultim=mysql_fetch_array($datosm1))
		{
		$ultimo=$ultim['total'];
		$siguiente=$ultimo+1;
	?>
    <td><strong>C&oacute;digo</strong></td>
    <td align="left"><input name="nip" type="text" onKeyUp="javascript:this.value=this.value.toUpperCase();" value="<?php
<?php	echo $siguiente; ?>"  size="10" maxlength="8" readonly="readonly" width="8"></td>
  </tr>
  <?php
<?php	} ?>
  <tr>
    <td><strong>Usuario</strong></td>
    <td align="left"><input type="text" name="usuario" size="20" width="20"  maxlength="20" onKeyUp="javascript:this.value=this.value.toLowerCase();"></td>
  </tr>
  <tr>
    <td><strong>Nombre</strong></td>
    <td align="left"><input type="text" name="nombre"  size="55" width="50" maxlength="50" onKeyUp="javascript:this.value=this.value.toUpperCase();"></td>
  </tr>
  <tr>
    <td><strong>Contrase&ntilde;a</strong></td>
    <td align="left"><input type="password"  name="clave" width="32" maxlength="32" size="15" ></td>
  </tr>
  <tr>
    <td><strong>Repetir Contrase&ntilde;a</strong></td>
    <td align="left"><input type="password"  name="clave_r" width="32" maxlength="32" size="15" ></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><label>
      <input type="radio" name="estatus" value="1" checked>
      Activo</label>      <label>
        <input type="radio" name="estatus" value="0">
        Inactivo</label></td>
    </tr>
  <tr>
    <td><strong>Rol del Usuario</strong></td>
    <td align="left"><select name="rol_emp">
      <?php
<?php	 if ($id_sede_caso == 1)
	     {
		  $sqlsel = "select id_rol, rol from rol";
		 }
		else
		 {
		  $sqlsel = "select id_rol, rol from rol where id_rol not in (1,9)";
		 }
		$result = @mysql_query($sqlsel);
		while ($row = mysql_fetch_array($result))
		 { 
		 $id_rol = $row[id_rol];
		 $rol = $row[rol];
		 ?>
      <option value= "<?php
<?php	echo $id_rol; ?>"><?php
<?php	echo $rol; ?> </option>
      <?php
<?php	}	?>
      </select>
      </td>
  </tr>
  <tr bgcolor="#D9EAC8">
    <input type="hidden" name="ins" value="1">
    <td colspan="3" align="center" bgcolor="#6699FF"><input type="submit" name="agregar" value="Agregar"></td>
    </tr>
    </table></td>
  </tr>
</table>
  <p>&nbsp;</p>
  <table width="20%" border="0">
    <tr>
      <td align="center"><a href="reg_nusuarios.php"><img src="images/iconos/Usuario.png" alt="Ver Usuarios Activos" width="58" height="67" border="0"></a></td>
    </tr>
    <tr>
      <td align="center">Usuarios Activos</td>
    </tr>
  </table>
  <p>&nbsp;</p>
<p>&nbsp;</p>
</form>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
