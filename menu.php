<?
	session_start(); 

	$PagNow = 1;

	include("sysconect.php");

	// Verifica si hubo inicio de sesión
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("test.php");		exit;	}

	$link = conectarse("apdahum");
		
	function TieneHijos($padre,$unidad,$fil)
	{
		$cuantos = 0;
		for ($i = 0; $i < $fil; $i++)
		{
			if ($unidad[$i][3] == $padre)
			{
				$cuantos++;
			}
		}
		if ($cuantos > 0) {return true;}
		else {return false;}
	}
	
	function PadreAbierto($padre,$unidad,$fil)
	{
		$abierto = 0;	
		for ($i = 0; $i < $fil; $i++)
		{
			if (($unidad[$i][0] == $padre) && ($unidad[$i][4] == "1"))
			{
				$abierto = 1;
			}
		}
		if ($padre == 0) { $abierto = 0;}
		if ($abierto == 1) { return true;}
		else { return false;}
	}
	
	function AbrirPadre($padre,&$unidad,$fil)
	{
		for ($i = 0; $i < $fil; $i++)
		{
			if ($unidad[$i][0] == $padre)
			{
				$unidad[$i][4] = 1;
			}
		}
	}
	
	function CerrarPadre($padre,&$unidad,$fil)
	{
		$inicio = intval($unidad[$padre][2]) + 1;	
		for ($i = 0; $i < $fil; $i++)
		{
			if ($unidad[$i][0] == $padre)
			{
				$unidad[$i][4] = 0;
			}	
			if ($unidad[$i][5] != "")
			{
				if (substr($unidad[$i][5],$padre - 1,1) == $padre)
				{
					$unidad[$i][4] = 0;
				}	
			}
		}
	}
	
	if (isset($_GET['cod']))
	 {
		$cod=$_GET['cod'];
	 }
 	if (isset($_GET['cod']))
  	 {
	  $pad=$_GET['pad'];
	 }
	
	
	if (!isset($cod))
	{
		$cod = 0;
		$sele = "SELECT m.padre, m.descr, m.pagina, m.imagen 
				FROM menu m, menuxrol n, rol r, rolxempleado s, empleado e
				WHERE m.id_menu = n.id_menu and r.id_rol = n.id_rol and s.nip = e.nip and s.id_rol = r.id_rol and e.usuario = '$Usr' and m.padre <> 0
				GROUP BY m.padre, m.descr, m.pagina, m.imagen";
		$datos = @mysql_query($sele,$link);
		
		$datopadre = "";
		$k = 0;
		$filas = 0;
		$p = 0;
		while ($row = @mysql_fetch_array($datos))
		{
			if ($row['padre'] != $datopadre)
			{
				$p = $k + 1;
				$datopadre = $row['padre'];
				$sele2 = "SELECT descr FROM menu WHERE id_menu = $datopadre";
				$datos2 = @mysql_query($sele2,$link);
				if ($row2 = @mysql_fetch_array($datos2))
				{
					$datopadre2 = $row2['descr'];
				}
				$datohijo = $row['descr'];
				$manda = $row['pagina'];
				$matriz[$k][0] = $k + 1;
				$matriz[$k][1] = $datopadre2;
				$matriz[$k][2] = "0";
				$matriz[$k][3] = "0";
				$matriz[$k][4] = "0";
				$matriz[$k][5] = "";
				$k = $k + 1;
				$filas = $filas + 1;
				$matriz[$k][0] = $k + 1;
				$matriz[$k][1] = "<a href=".$manda." target=\"mainFrame\">".$datohijo."</a>";
				$matriz[$k][2] = "1";
				$matriz[$k][3] = $p;
				$matriz[$k][4] = "0";
				$matriz[$k][5] = $p;
				$k = $k + 1;
				$filas = $filas + 1;
			}
			else
			{
				$datohijo = $row['descr'];
				$manda = $row['pagina'];
				$matriz[$k][0] = $k + 1;
				$matriz[$k][1] = "<a href=".$manda." target=\"mainFrame\">".$datohijo."</a>";
				$matriz[$k][2] = "1";
				$matriz[$k][3] = $p;
				$matriz[$k][4] = "0";
				$matriz[$k][5] = $p;
				$k = $k + 1;
				$filas = $filas + 1;
			}
		}
	}
	if ($cod == 1) { AbrirPadre($pad,$matriz,$filas);}
	if ($cod == 2) { CerrarPadre($pad,$matriz,$filas);}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Farmacia</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="Templates/tablas-eec.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-top: 0px;
}
a:link {
	color: #0000FF;
	text-decoration: none;
}
a:visited {
	color: #0000FF;
	text-decoration: none;
}
.Estilo1 {font-family: Arial, Helvetica, sans-serif}
.Estilo2 {font-size: 10px}
.Estilo3 {font-size: 12px}
.Estilo5 {
	font-size: 10px;
	color: #0000FF;
	font-weight: bold;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style></head>

<body>

<div align="left"></div>
<table width="180" border="0" align="center" cellpadding="0" cellspacing="0" class="en_menu">
  <!--DWLayoutTable-->
  <tr>
    <td width="180" height="80" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablamenu">
        <!--DWLayoutTable-->
        <tr>
          <td bgcolor="#D9E9CC" class="en_menu Estilo1 Estilo3"><div align="center"><span class="Estilo1"><span class="Estilo5"><a href="consulta1.php" target="_blank">...<? echo $Nombre ?></a></span></span></div></td>
        </tr>
        <tr>
          <td width="178" class="en_menu Estilo1 Estilo3"><table border="0">
              <?
		$cont = 0;
		for ($cont = 0; $cont < $filas; $cont++)
		{
				// Muestra los padres del directorio raiz
			if ($matriz[$cont][2] == "0")
			{
				echo "<tr>";			
					// Verifica si tiene hijos
				if (TieneHijos($matriz[$cont][0],$matriz,$filas))
				{
						// Verifica si esta abierto
					if ($matriz[$cont][4] == 0)
					{
						echo "<td><a href=\"menu.php?cod=1&pad=".$matriz[$cont][0]."\"><img src=\"images/iconos/datos1.ico\" border=\"0\"></a></td>";
					}
					else
					{
						echo "<td><a href=\"menu.php?cod=2&pad=".$matriz[$cont][0]."\"><img src=\"images/iconos/datos2.ico\" border=\"0\"></a></td>";
					}
				}
				else
				{
					echo "<td><img src=\"images/iconos/datos3.gif\" border=\"0\"></a></td>";
				}						
					// Despliega el nombre de la carpeta
				$tot = 10 - $matriz[$cont][2];
				echo "<td colspan=".$tot.">".$matriz[$cont][1]."</td>";
				echo "</tr>";
			}			
			else
			{
					// Muestra los hijos
				if (PadreAbierto($matriz[$cont][3],$matriz,$filas))			
				{
					echo "<tr>";
					for ($j = 1; $j <= $matriz[$cont][2]; $j++)
					{
						echo "<td>&nbsp;</td>";
					}
						// Verifica si tiene hijos
					if (TieneHijos($matriz[$cont][0],$matriz,$filas))
					{
							// Verifica si esta abierto
						if ($matriz[$cont][4] == 0)
						{
							echo "<td><a href=\"menu.php?cod=1&pad=".$matriz[$cont][0]."\"><img src=\"images/iconos/datos1.ico\" border=\"0\"></a></td>";
						}
						else
						{
							echo "<td><a href=\"menu.php?cod=2&pad=".$matriz[$cont][0]."\"><img src=\"images/iconos/datos2.ico\" border=\"0\"></a></td>";
						}
					}
					else
					{
						echo "<td><img src=\"images/iconos/datos3.gif\" border=\"0\"></a></td>";
					}
						// Despliega el nombre de la carpeta
					$tot = 10 - $matriz[$cont][2];
					echo "<td colspan=".$tot.">".$matriz[$cont][1]."</td>";
					echo "</tr>";
				}
			}	
		}
	?>
            </table>
            <span class="Estilo1"><span class="Estilo5"><a href="consulta1.php" target="_blank"><a href="consulta1.php" target="_blank"><img src="images/iconos/datos3.gif" width="25" height="21" border="0"></a></span></span>Consulta r&aacute;pida
          <blockquote>&nbsp;</blockquote></td>
        </tr>
        <tr>
          <td class="en_menu"><div align="center">
            <p><span class="Estilo1"></span></p>
          </div></td>
        </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
