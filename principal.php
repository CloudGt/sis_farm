<?
	session_start();
	include("barra_inferior.php");
	require('nuevo/conexion/conexion.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>APDAHUM CENTRAL - Sistema de Control de Medicamentos (CopyRigth LDCP 2009)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<frameset rows="130,*" cols="*" frameborder="NO" border="0" framespacing="0">
  <frame src="encabezado.htm" name="topFrame" scrolling="NO" noresize >
  <frameset rows="*" cols="243,*" framespacing="0" frameborder="NO" border="0">
    <frame src="menu.php" name="leftFrame" scrolling="YES" noresize>
    <frame src="contenido.php" name="mainFrame">
  </frameset>
</frameset>
<noframes><body>
</body></noframes>
</html>
