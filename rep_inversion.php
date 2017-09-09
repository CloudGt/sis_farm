<?php	
session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	//Busca información
	$selec="SELECT EticoPopular, SUM(preciocosto*existencia) as bodega FROM Bodegam WHERE eticopopular<>'' 
				GROUP BY eticopopular";
	$datosm1=mysql_query($selec,$link);

	$selec="SELECT SUM(preciocosto*existencia) as bodega FROM Bodegam";
	$datosm2=mysql_query($selec,$link);

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
body {
	background-image: url();
}
-->
</style>
<style type="text/css">
<!--
.Estilo50 {font-family: Arial, Helvetica, sans-serif; font-size: 10px;}
.Estilo79 {	font-family: Arial, Helvetica, sans-serif;
	font-size: 12;
}
.Estilo87 {font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 18px; color: #000000; }
.Estilo88 {	font-size: 18px;
	font-weight: bold;
	font-family: "Lucida Calligraphy";
	color: #0000FF;
}
.Estilo90 {font-family: "Monotype Corsiva", "Lucida Calligraphy", "Lucida Fax"; font-size: 24px; color: #0000FF; }
-->
</style>
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

<BODY>
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="50%" border="0" align="center" cellpadding="1" cellspacing="1" frame="border" rules="all">
  <tr>
    <td><table width="100%" border="1" align="center" cellpadding="1" cellspacing="1" frame="box" rules="rows">
      <tr>
        <td height="39" colspan="2"><div align="center"><strong>REPORTE DE INVERSI&Oacute;N EN BODEGA </strong></div></td>
      </tr>
      <tr bgcolor="#FFFFCC">
        <td width="244"><div align="center" class="Estilo79"><strong>TIPO DE MEDICAMENTO </strong></div></td>
        <td width="170"><div align="center" class="Estilo79"><strong>INVERSION</strong></div></td>
      </tr>
      <?php		while($tipomed=mysql_fetch_array($datosm1))
		{
			$tipom=$tipomed['EticoPopular'];
			$total=$tipomed['bodega'];
		?>
      <tr>
	  <? 
	  	if($tipom=='E') { $tipome='ETICO';  } 
		if($tipom=='P') { $tipome='POPULAR'; } 
		if($tipom=='L') { $tipome='LECHES'; } 
		if($tipom=='G') { $tipome='GENERICO'; }
		?>
        <td height="35" bgcolor="#D9E9CE"><div align="left"><span class="Estilo87">Producto &quot;<? echo $tipome ?>&quot;</span></div></td>
        <td bgcolor="#F0F0F0"><div align="right" class="Estilo87"><? echo number_format($total,2) ?></div></td>
        <? } ?>
      </tr>
      <tr bgcolor="#FFFFCC">
        <?php		while($tipomed=mysql_fetch_array($datosm2))
		{
			$totalg=$tipomed['bodega'];
		?>
        <td height="23" bgcolor="#FFFFCC"><div align="left"><span class="Estilo88">Total General</span></div></td>
        <td bgcolor="#FFFFCC"><div align="right"><span class="Estilo90">Q. <? echo number_format($totalg,2) ?></span></div></td>
        <? } ?>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>

<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
