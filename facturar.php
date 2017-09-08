<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI") 	{	cambiar_ventana("index.php");	exit;	}
	$link=conectarse("Apdahum");
	$year=date('Y');
	
	$total_fact="SELECT factura FROM Ventas WHERE ano=2015 and factura >=20500
		GROUP BY factura";
	$buscar=mysql_query($total_fact,$link);
	while($result=mysql_fetch_array($buscar))	
	{
		$dato=$result['factura'];	

		$nfac1= "SELECT sum(total) as Total FROM Ventas WHERE Tipomed='E' AND Factura='$dato' AND ano=$year ";
		$datos4= mysql_query($nfac1,$link);
		while ($subt1 = mysql_fetch_array($datos4))
		{
			$etico=$subt1['Total'];
			$nfac2= "SELECT sum(total) as Total FROM Ventas WHERE Tipomed='P' AND Factura='$dato' AND ano=$year";
			$datos5= mysql_query($nfac2,$link);
			while ($subt2 = mysql_fetch_array($datos5))
			{
				$popul=$subt2['Total'];
				$nfac3= "SELECT sum(total) as Total FROM Ventas WHERE Tipomed='L' AND Factura='$dato' AND ano=$year";
				$datos6= mysql_query($nfac3,$link);
				while ($subt3 = mysql_fetch_array($datos6))
				{
					$lech=$subt3['Total'];
					$nfac4= "SELECT sum(total) as Total FROM Ventas WHERE Tipomed='G' AND Factura='$dato' AND ano=$year";
					$datos7= mysql_query($nfac4,$link);
					while ($subt4 = mysql_fetch_array($datos7))
					{
						$gen=$subt4['Total'];
						$totalf=$etico+$popul+$lech+$gen;
						$nfactura="UPDATE Facturas 
						SET Etico='$etico',Popular='$popul',Leches='$lech',Generico='$gen',Total='$totalf' 
						WHERE Factura='$dato' AND ano='$year'";
						$datos8= mysql_query($nfactura,$link);
					}
				}
			}
		}
	echo "$nfactura </br>";
	}
	
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
.Estilo52 {font-family: Arial, Helvetica, sans-serif; color: #0000FF; font-weight: bold; }
-->
</style>
<style type="text/css">
<!--
.Estilo53 {font-family: Arial, Helvetica, sans-serif}
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
	font-size: 10px;
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

<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
