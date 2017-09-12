<?php	

  session_start(); 
  $_SESSION['Bandera'] = "NO";
  $_SESSION['Usr'] = "nada";
  $_SESSION['Pwd'] = "nada";
  $_SESSION['Nip'] = 0;
  $_SESSION['Nombre'] = "";
  $_SESSION['Nivel'] = 0;
  $_SESSION['Total'] = 0;
  $_SESSION['PagNow'] = 0;
  $_SESSION['query'] = 0;
  $_SESSION['matriz'] = 0;
  $_SESSION['filas'] = 0;
  $_SESSION['Bfarmacia'] = "xx";
  $_SESSION['facturaA'] = "x";
	/*session_register('Bandera');
	session_register('Usr');
	session_register('Pwd');
	session_register('Nip');
	session_register('Nombre');
	session_register('Nivel');
	session_register('Total');
	session_register('PagNow');
	session_register('query');
	session_register('matriz');
	session_register('filas');
	session_register('Bfarmacia');
	session_register('facturaA');
	$Usr = "nada";
	$Pwd = "nada";
	$Nip = 0;
	$Bandera = "NO";
	$Nombre = "";
	$filas = 0;
	$Nivel=0;
	$Bfarmacia="xx";
	$facturaA="x";*/
?>
<script>

	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>APDAHUM Central (Copy Right 2009)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="Templates/tablas-eec.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #D2E9BC;
	background-image: url(images/layout/wallpaper.jpg);
}
-->
</style>
<link href="tablas-eec.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 14px;
}
.Estilo2 {
	font-size: 9px;
	font-family: Arial, Helvetica, sans-serif;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
-->
</style>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-image: url(images/layout/background.gif);
	background-repeat: repeat;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
.tablas tr td div p {
	color: #00F;
	font-size: 14px;
}
-->
</style><title>Apdahum SICMed (ldcp 2009-2015)</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="javascript: form1.usuario.focus()">
<div align="center">
  <table width="90%" border="0" align="center">
   <tr>
       <td width="24%"><img src="images/layout/farmacia.gif" width="301" height="83"></td>
       <td width="76%" align="center"><p style="font-size: 16px; color: #FFF; font-weight: bold;">&nbsp;</p></td>
     </tr>
   </table>
   <p>&nbsp;</p>
   <table width="40%" border="1" cellpadding="1" cellspacing="1" bgcolor="#F0F0F0" frame="border" rules="groups" class="tablas">
     <tr>
       <td><div align="center">
         <p>!!! BIENVENIDO !!!</p>
         <p>Ingreso al Sistema </p>
       </div>
         <form name="form1" method="post" action="valida.php">
           <table width="100%" border="0" align="center" class="en_tabla">
             <tr>
               <td colspan="2">&nbsp;</td>
             </tr>
             <tr>
               <td align="right">Ingrese Usuario</td>
               <td><span id="sprytextfield1">
                 <label>
                   <input name="usuario" type="text" id="usuario" size="20" maxlength="20">
                 </label>
               <span class="textfieldRequiredMsg">Usuario?</span></span></td>
             </tr>
             <tr>
               <td align="right">Contrase&ntilde;a</td>
               <td><span id="sprypassword1">
                 <label>
                   <input name="password" type="password" id="password" size="20" maxlength="20">
                 </label>
               </span></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td colspan="2"><div align="center">
                   <input type="submit" name="Submit" value="Ingresar">
               </div></td>
             </tr>
             <tr>
	           <td colspan="2">&nbsp;</td>
             </tr>
	         <tr>
               <td colspan="2"><div align="center" class="Estilo2" style="font-size: 9px">Derechos Reservados SIDT, Guatemala Versi&oacute;n 2.03-2015 </div></td>
             </tr>
           </table>
       </form></td>
     </tr>
   </table>
  <p>&nbsp;</p>
   <p style="font-weight: bold; font-size: 16px; color: #FFF;">!!! DIOS DE PACTOS !!!</p>
  <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p><a href="dataprograming.htm"><img src="images/iconos/logo02.PNG" width="75" height="65" border="0" align="left"></a></p>
   <p>&nbsp;</p>
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
//-->
</script>
</body>
</html>
