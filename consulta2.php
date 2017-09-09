<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	$cod1=$_GET['cod1'];
	
// Filtros de Busqueda
		$selec= "SELECT upper(nombres) as nombres, upper(apellidos) as apellidos FROM Cliente
                 WHERE tipo_cliente='$cod1' AND activo='S'
				ORDER BY apellidos, nombres";
			$filtro= mysql_query($selec,$link);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Consultas TipoCliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo6 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
}
.Estilo67 {font-family: Arial, Helvetica, sans-serif}
.Estilo74 {font-size: 12px}
.Estilo76 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo79 {font-family: Geneva, Arial, Helvetica, sans-serif}
.Estilo98 {font-size: 14px}
.Estilo99 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FF0000;
	font-weight: bold;
}
.Estilo107 {
	color: #0000CC;
	text-align: center;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
	text-align: center;
}
.Estilo109 {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo1 {	font-size: 36px;
	font-weight: bold;
}
.Estilo26 {color: #6600CC}
.Estilo40 {color: #000000}
.Estilo47 {font-family: Geneva, Arial, Helvetica, sans-serif; color: #0000CC; font-weight: bold;}
.Estilo48 {	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo59 {color: #0000CC; font-family: Arial, Helvetica, sans-serif;}
-->
</style>
</head>
<body background="">
<div align="right" class="Estilo6">
  <div align="left"></div>
    <div align="left"><span class="Estilo1"><span class="Estilo47"><span class="Estilo26"><strong><strong><span class="Estilo40"><strong><span class="Estilo48"><strong><strong><strong><strong><strong></strong></strong></strong></strong></strong></span></strong></span></strong></strong></span></span></span>
    </div>
    <table width="50%" border="1" align="center" cellpadding="1" cellspacing="1" frame="border" rules="all">
      <tr>
        <td width="32" height="35" align="center" valign="middle"><div align="center" class="Estilo99 Estilo98 Estilo67 Estilo107">
            <div align="center"><a href="consulta1.php"><img src="images/iconos/cerrar.jpg" width="29" height="26" border="0" align="middle"></a></div>
        </div></td>
        <td colspan="2" align="center" valign="middle" bgcolor="#FFFFCC"><span class="Estilo57 Estilo60 ">CLIENTES CLASIFICACI&Oacute;N&quot;<? echo $cod1 ?>&quot; </span></td>
      </tr>
      <?
		// Llena de fichas existentes
		while($row=mysql_fetch_array($filtro)){
			$nombre=$row['nombres'];
			$apelli=$row['apellidos'];
		?>
      <tr>
        <td colspan="3">
          <div align="center" class="Estilo76 Estilo79 Estilo74">
            <div align="left"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43 Estilo67 Estilo109"> <?php echo $apelli ?>, <?php echo $nombre ?></span></span></div>
        </div></td>
        <? } ?>
      <tr>
        <td colspan="3" bgcolor="#DBEACD"><a href="consulta1.php"></a><a href="consulta1.php"></a><a href="consulta1.php"><img src="images/iconos/cerrar.jpg" width="29" height="26" border="1" align="right"></a></td>
  </table>
</div>
  </div>
  <span class="Estilo1"><span class="Estilo47"><span class="Estilo26"><strong><strong><span class="Estilo40"><strong><span class="Estilo48"><strong><strong><strong><strong><strong></strong></strong></strong></strong></strong></span></strong></span></strong></strong></span></span></span>
</body>
</html>