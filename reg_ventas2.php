<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{	cambiar_ventana("index.php");	exit;	}
	$link=conectarse("Apdahum");
	
	$facturaA=$_SESSION['facturaA'];
	
//Definicion de Variables
	$cod1=$_GET['cod1'];
	$cod2=$_GET['cod2'];
	$met=$_GET['met'];
	$hoy=date('Y-m-d');
	$year=date('Y');
// Filtros de Busqueda
	$selec = "SELECT Nit, upper(Nombres) as Nombres, upper(Apellidos) as Apellidos FROM Cliente WHERE Activo='S' ORDER BY Nombres";
	$datosm1 = mysql_query($selec,$link);
	$selec  = "SELECT b.Id_producto, upper(b.Nproducto) as Nproducto FROM bodegam as b, proveedores as p WHERE b.Activo='S' 
				AND b.id_proveedor=p.id_proveedor AND p.Activo='S' ORDER BY b.Nproducto";
	$datosm2= mysql_query($selec,$link);
	$selec="SELECT count_venta as max FROM Parameters";
	$datosm=mysql_query($selec,$link);
	$buscacliente="SELECT Cliente FROM Ventas WHERE factura=$facturaA AND ano=$year AND operado='S'";
	$recibir=mysql_query($buscacliente,$link);	while($client=mysql_fetch_array($recibir))	{	$estecliente=$client['Cliente'];	}
	
// Registro de Ventas y Actualización de Bodega
	if($met==1)
	{
		$cliente=$_POST['Caja1'];		$tipocli=$_POST['Caja2'];
		$medicam=$_POST['Caja3'];		
		$tipopro=$_POST['Caja4'];		$preciov=$_POST['Caja6'];
		$solicit=$_POST['Caja7'];		$comenta=$_POST['Caja8'];
		$descuento=$_POST['Descu'];
		
		if($solicit<=0)		{	error_msg("NO PUEDE SOLICITAR (CERO) MEDICAMENTOS");	cambiar_ventana("reg_ventas.php");	exit;	}
		
		$total=(($preciov*$solicit)-$descuento);
			$buscar="SELECT existencia FROM Bodegam WHERE id_producto='$medicam'";
			$busca2=mysql_query($buscar,$link);
			while($x=mysql_fetch_array($busca2))	{	$existen=$x['existencia'];	}
			
		if(($existen>=$solicit))
		{
			$ahora=$existen-$solicit;
			$selec="INSERT INTO 				
					Ventas(Salida,Cliente,Medicamento,Tipomed,Cantidad,Punitario,Descuentos,Total,Fecha,Usuario,Factura,Ano) 
	VALUES ('','$cliente','$medicam','$tipopro','$solicit','$preciov','$descuento','$total','$hoy','$Usr',$facturaA,'$year')";
			$registro1=mysql_query($selec,$link);
			$selec="UPDATE Bodegam SET Existencia='$ahora' WHERE id_producto='$medicam'";
			$registro2=mysql_query($selec,$link) or die('Error actualizando existencias'. mysql_error());
			//Buscando comentarios
			if($comenta!="")	
			{	
				$buscar="SELECT salida FROM ventas WHERE cliente='$cliente' AND medicamento='$medicam' AND usuario='$Usr'
								AND factura=$facturaA AND ano='$year'";
				$busca=mysql_query($buscar,$link);
				while($dato=mysql_fetch_array($busca))
				{
					$idventa=$dato['salida'];
				}
				$addcomment="INSERT INTO ventas_com (id_venta,id_producto,comentario) VALUES('$idventa','$medicam','$comenta')";	
				$registra=mysql_query($addcomment,$link) or die('Error registrando comentario a ventas '. mysql_error());
				
			}
			//Conteo de medicamentos para facturar
			$selec= "SELECT COUNT(factura) as Salidas FROM Ventas 
						WHERE Factura=$facturaA AND ano='$year' AND Operado='S' AND Cliente='$cliente' ";
			$boleta= mysql_query($selec,$link);
			while($sal=mysql_fetch_array($boleta))	{	$llena=$sal['Salidas'];				}
			
			if($llena>=26)
			{
				$selec="SELECT SUM(total) as total1 FROM Ventas WHERE factura='$facturaA' AND tipomed='E' 
						AND Cliente='$cliente'  AND Ano='$year' AND operado='S'";
				$buscaetico=mysql_query($selec,$link);
				while($te=mysql_fetch_array($buscaetico))	{	$etico=$te['total1'];		}
				
				$selec="SELECT SUM(total) as total2 FROM Ventas WHERE factura=$facturaA AND tipomed='P' 
						AND Cliente='$cliente'  AND Ano='$year' AND operado='S'";
				$buscapopul=mysql_query($selec,$link);
				while($tp=mysql_fetch_array($buscapopul))	{	$popular=$tp['total2'];		}
				
				$selec="SELECT SUM(total) as total3 FROM Ventas WHERE factura=$facturaA AND tipomed='L' 
						AND Cliente='$cliente'  AND Ano='$year' AND operado='S'";
				$buscalech=mysql_query($selec,$link);
				while($tl=mysql_fetch_array($buscalech))	{	$leches=$tl['total3'];		}
				
				$selec="SELECT SUM(total) as total4 FROM Ventas WHERE factura=$facturaA AND tipomed='G' 
						AND Cliente='$cliente'  AND Ano='$year' AND operado='S'";
				$buscagen=mysql_query($selec,$link);
				while($tg=mysql_fetch_array($buscagen))		{	$generico=$tg['total4'];		}
				
				$totalfac=$etico+$popular+$leches+$generico;
				$tabfact="UPDATE Facturas 
						SET Etico='$etico', Popular='$popular', Generico='$generico', Leches='$leches', Total='$totalfac'
						WHERE Factura='$facturaA' AND Ano='$year'";
				$guardar=mysql_query($tabfact,$link) or die('Error registrando factura... '. mysql_error());
				if (mysql_errno($link)==0)		{ 		error_msg("SE ACTUALIZA FACTURA No. $facturaA");	}
			}
			if($llena>=23)	{	envia_msg("*****  ULTIMOS REGISTROS, SE FACTURARA AUTOMÁTICAMENTE  *****");		}
			if($ahora<=5)	{	error_msg("QUEDAN $ahora PRESENTACIONES, CONSIDERAR EN PRÓXIMO PEDIDO");	}
			error_msg("Procesado...");	cambiar_ventana("reg_ventas.php");	exit;
		}
		else
		{
			error_msg("No hay suficiente en EXISTENCIA para cubrir SOLICITUD");
			cambiar_ventana("reg_ventas.php");
			exit;
		}
	}		
	if($met==2)
	{
		$selec="SELECT cliente FROM Ventas WHERE factura='$facturaA' AND ano='$year'  GROUP BY cliente";
		$busca1=mysql_query($selec,$link);
		while($cli=mysql_fetch_array($busca1))	{		$cliente=$cli['cliente'];	}
		if($cliente==0)	{	error_msg("No hay nada que facturar...");	exit;	}
		else 
		{
			$selec="SELECT SUM(total) as total1 FROM Ventas WHERE factura=$facturaA AND tipomed='E' AND ano='$year'
				AND Cliente='$cliente'  AND operado='S'";
			$buscaetico=mysql_query($selec,$link);
			while($te=mysql_fetch_array($buscaetico))	{		$etico=$te['total1'];		}
		
			$selec="SELECT SUM(total) as total2 FROM Ventas WHERE factura=$facturaA AND tipomed='P' AND ano='$year' 
				AND Cliente='$cliente'  AND Operado='S'";
			$buscapopul=mysql_query($selec,$link);
			while($tp=mysql_fetch_array($buscapopul))	{		$popular=$tp['total2'];		}
		
			$selec="SELECT SUM(total) as total3 FROM Ventas WHERE factura=$facturaA AND tipomed='L' AND Ano='$year'
				AND Cliente='$cliente'  AND Operado='S'";
			$buscalech=mysql_query($selec,$link);
			while($tl=mysql_fetch_array($buscalech))	{		$leches=$tl['total3'];		}
		
			$selec="SELECT SUM(total) as total4 FROM Ventas WHERE factura=$facturaA AND tipomed='G' AND Ano='$year'
				AND Cliente='$cliente' AND Operado='S'";
			$buscagen=mysql_query($selec,$link);
			while($tg=mysql_fetch_array($buscagen))		{		$generico=$tg['total4'];	}
			
			$totalfac=$etico+$popular+$leches+$generico;
			$tabfact="UPDATE Facturas 
					SET Etico='$etico', Popular='$popular', Generico='$generico', Leches='$leches', Total='$totalfac'
					WHERE Factura='$facturaA' AND Ano='$year'";	
			$guardar=mysql_query($tabfact,$link) or die('Error registrando factura '. mysql_error());
			if (mysql_errno($link)==0)		{ 		error_msg("SE ACTUALIZA FACTURA No. $facturaA");	}
		
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Dise&ntilde;o y Programaci&oacute;n LDCP</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language="JavaScript"><!--
	function CambioOpcion(targ,selObj,restore)
	{
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selected;
	}	
//--></script>
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
.Estilo54 {font-size: 14px}
-->
</style>
<style type="text/css">
<!--
.Estilo55 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
.Estilo56 {
	font-size: 18px;
	color: #0000FF;
}
-->
</style>
<style type="text/css">
<!--
.Estilo57 {font-weight: bold}
-->
</style>
<style type="text/css">
<!--
.Estilo60 {font-size: 16}
-->
</style>
<style type="text/css">
<!--
.Estilo62 {
	color: #0000FF;
	font-weight: bold;
	font-size: 10px;
}
-->
</style>
<style type="text/css">
<!--
.Estilo63 {
	color: #0000FF;
	font-size: 12px;
}
-->
</style>
<style type="text/css">
<!--
.Estilo65 {font-size: 16px}
-->
</style>
<style type="text/css">
<!--
.Estilo66 {
	font-family: "Courier New", Courier, mono;
	font-size: 12px;
}
-->
</style>
<style type="text/css">
<!--
.Estilo67 {font-family: Georgia, "Times New Roman", Times, serif}
-->
</style>
<style type="text/css">
<!--
.Estilo69 {
	font-family: "Lucida Calligraphy", "Monotype Corsiva", Papyrus;
	color: #0000FF;
	font-size: 18px;
	text-align: left;
}
-->
</style>
<style type="text/css">
<!--
.Estilo70 {
	font-size: 24px;
	font-weight: bold;
}
-->
</style>
<style type="text/css">
<!--
.Estilo71 {font-size: 24px}
-->
</style>
<style type="text/css">
<!--
.Estilo73 {font-size: 14}
-->
</style>
<style type="text/css">
<!--
.Estilo74 {font-size: 10px}
-->
</style>
<style type="text/css">
<!--
.Estilo76 {color: #0000FF; font-size: 14px; }
#a {
	text-align: left;
}
-->
</style>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 18px;
}
#1 #Factura table tr td table tr td .Estilo110.Estilo53.Estilo73.Estilo63 .Estilo63.Estilo54 {
	font-weight: bold;
}
#1 #Factura table tr td table tr td .Estilo110.Estilo53.Estilo73.Estilo63 .Estilo63.Estilo54 {
	font-weight: bold;
}
#1 #Venta table tr td table {
	font-size: 10px;
}
#1 #Venta table tr .Estilo111 .Estilo125.Estilo54.Estilo53 strong span span {
	font-size: 12px;
}
#1 #Venta table tr .Estilo111 .Estilo125.Estilo54.Estilo53 strong span span {
	font-family: Verdana, Geneva, sans-serif;
}
#1 #Venta table tr .Estilo111 .Estilo125.Estilo54.Estilo53 strong span span {
	font-size: 10px;
}
#1 #Venta table tr .Estilo111 .Estilo125.Estilo54.Estilo53 strong span span {
	font-size: 10px;
}
#1 #Venta table tr .Estilo111 .Estilo125.Estilo54.Estilo53 strong span span {
	font-family: Verdana, Geneva, sans-serif;
}
#1 #Venta table {
	font-size: 10px;
}
#1 #Venta table tr td table tr td {
	font-size: 12px;
}
#1 #Cancela table tr td table {
	font-size: 9px;
}
#1 #Cancela table tr td table tr td #radio {
	font-size: 9px;
}
#1 #Cancela table tr td table tr td {
	font-size: 9px;
}
#1 #Cancela table tr td table tr td .Estilo1 #sprytextfield6 .Estilo120 .Estilo60.Estilo53.Estilo62 em {
	font-size: 12px;
}
#1 #Cancela table tr td table tr td {
	font-size: 10px;
}
-->
</style>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
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

<BODY onLoad="document.Venta.select2.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<form name="Venta" id="Venta" method="post" action="reg_ventas2.php?met=1">
      <table width="90%" border="1" cellpadding="1" cellspacing="1" bgcolor="#F0F0F0" frame="border" rules="all">
        <tr>
          <td width="50%" valign="top"><table width="100%" border="0">
            <tr>
              <td width="105%"><span class="Estilo3"><span class="Estilo3 Estilo9"><span id="spryselect2">
                <? if(!$cod1)	{	$cod1=$estecliente;	}	?>
                <select name="Clientes" class="Estilo110" id="Clientes" onChange="CambioOpcion('self',this,0)">
                  <option value="reg_ventas2.php?cod2=<? echo $cod2; ?>">Todos los Clientes</option>
                  <?														
			while($perso=mysql_fetch_array($datosm1))						
			{													
				$nit =$perso['Nit'];
				$nom =$perso['Nombres'];
				$ape =$perso['Apellidos'];
				if ($nit == ($cod1))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_ventas2.php?cod1=".$nit."&cod2=".$cod2."\">".$nom." ".$ape."</option>\n";				
	    	}?>
                </select>
                <span class="selectRequiredMsg">.</span></span>
                <span id="sprytextfield3">
                <label>
                  <input name="Caja1" type="hidden" id="Caja1" value="<? echo $cod1; ?>">
                </label>
                <span class="textfieldRequiredMsg">¿?</span></span><span class="Estilo9"><span class="Estilo111">
                <span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74  Estilo79">
                <?
			$selec= "SELECT tipo_cliente FROM cliente WHERE nit='$cod1'";
			$datosm3=mysql_query($selec,$link);
			while($tc=mysql_fetch_array($datosm3))
			{
				$tipoc=$tc['tipo_cliente'];
			?>
                <input name="Caja2" type="hidden" id="Caja2" value="<? echo $tipoc ?>">
                <? } ?>
                </span></span></span></span></span></span></span></td>
            </tr>
            <tr>
              <td>
                <span id="spryselect1">
                <select name="select2" id="select2" onChange="CambioOpcion('self',this,0)">
                  <option value="reg_ventas2.php?cod1=<? echo $cod1; ?>">Todos los Productos</option>
                  <?														
			while($medi=mysql_fetch_array($datosm2))						
			{													
				$nip = $medi['Id_producto'];
				$nom = $medi['Nproducto'];
				if ($nip == ($cod2))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_ventas2.php?cod2=".$nip."&cod1=".$cod1."\">".$nom."</option>\n";				              
     	} ?>
                </select>
                <span class="textfieldRequiredMsg">.</span></span><span id="sprytextfield4">
                <input name="Caja3" type="hidden" id="Caja33" value="<? echo $cod2 ?>">
                <span class="textfieldRequiredMsg">¿?</span></span></td>
            </tr>
            <tr>
              <td height="25" align="center">&nbsp;</td>
            </tr>
            <tr>
              <td align="center"><span id="sprytextfield2">
              <label><strong><span class="Estilo53 Estilo63 Estilo60"><strong><span class="Estilo130"><span class="Estilo3"><span class="Estilo3 Estilo9"><span class="Estilo9"><span class="Estilo111"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74  Estilo79"><span class="Estilo67 Estilo55"><span class="Estilo53 Estilo65 Estilo57"><span class="Estilo118">
                <?
			$selec= "SELECT a.Nproducto, b.presentacion, c.nom_provee, a.eticopopular, a.existencia, a.precioc1, a.precioc2,
							a.precioc3, a.precioc4, a.precioc5, a.precioc6, a.precioc7, a.precioVP, a.oferta
						FROM bodegam as a, presentacion as b, proveedores as c 
						WHERE a.id_proveedor=c.id_proveedor AND a.presentacion=b.id_presenta AND a.id_producto='$cod2'";
			$datosm4=mysql_query($selec,$link);
			while($sale=mysql_fetch_array($datosm4))
			{
				$producto=$sale['Nproducto'];
				$presenta=$sale['presentacion'];
				$casafarm=$sale['nom_provee'];
				$tipoprod=$sale['eticopopular'];
				$cnt=$sale['existencia'];
				$pv1=$sale['precioc1'];
				$pv2=$sale['precioc2'];
				$pv3=$sale['precioc3'];
				$pv4=$sale['precioc4'];
				$pv5=$sale['precioc5'];
				$pv6=$sale['precioVP'];
				$pv7=$sale['precioc6'];
				$pv8=$sale['precioc7'];
				$ofe=$sale['oferta'];
			?>
                </span></span></span></span></span></span></span></span></span></span></span></strong></span></strong>
                <input name="Caja7" type="text" id="Caja7" size="6" maxlength="6">
              </label>
              <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">No válido</span></span>
                <label>
                  <input type="submit" name="Operar" id="Operar" value="Operar">
                  <strong><span class="Estilo53 Estilo63 Estilo60"><strong><strong><span class="Estilo130"><span class="Estilo3"><span class="Estilo3 Estilo9"><span class="Estilo9"><span class="Estilo111"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74  Estilo79"><span class="Estilo67 Estilo55"><span class="Estilo53 Estilo65 Estilo57"><span class="Estilo118"><strong>
                  <? 	if($ofe=='S')	{ ?>
                  <span id="sprytextfield5">
                  <input name="Descu" type="text" id="Descu" size="6" maxlength="6">
                  <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">No válido.</span></span>
                  </strong></span></span></span></span></span></span></span></span></span></span></span></strong><span class="Estilo130"><span class="Estilo3"><span class="Estilo3 Estilo9"><span class="Estilo9"><span class="Estilo111"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74  Estilo79"><span class="Estilo67 Estilo55"><span class="Estilo53 Estilo65 Estilo57"><span class="Estilo118"> </span></span></span></span></span></span></span></span></span></span></span></strong></span></strong><strong><span class="Estilo53 Estilo63 Estilo60"><strong><span class="Estilo130"><strong><strong><span id="sprytextfield1"><span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">Valor</span></span><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                   </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>% Descuento </strong></strong></span><span class="Estilo130"> </span>
                  <? } ?>
              </strong></span></strong></label></td>
            </tr>
          </table></td>
          <td colspan="2"><table width="100%" border="0">
            <tr>
              <td width="24%">Nombre</td>
              <td colspan="2"><span class="Estilo67 Estilo55"><span class="Estilo53 Estilo65 Estilo57"><span class="Estilo118">
                <input name="Caja4" type="hidden" id="Caja4" value="<? echo $tipoprod ?>">
              <? echo $producto ?> (<? echo $presenta ?>)</span></span></span></td>
            </tr>
            <tr>
              <td>Proveedor</td>
              <td colspan="2"><span class="Estilo67 Estilo55"><span class="Estilo53 Estilo65 Estilo57"><span class="Estilo120"><?php echo $casafarm ?></span></span></span></td>
            </tr>
            <tr>
              <td colspan="2" align="center" bgcolor="#00FF00"><strong><span style="font-size: 18px"><span style="font-family: Verdana, Geneva, sans-serif">
                <span class="Estilo110" style="font-size: 16px">
                <span class="Estilo125">
<?		  	if($tipoc=='A')		{		$pventa=$pv1;	}
			if($tipoc=='B')		{		$pventa=$pv2;	}
			if($tipoc=='C')		{		$pventa=$pv3;	}
			if($tipoc=='D')		{		$pventa=$pv4;	}
			if($tipoc=='E')		{		$pventa=$pv5;	}
			if($tipoc=='F')		{		$pventa=$pv6;	}
			if($tipoc=='G')		{		$pventa=$pv7;	}
			if($tipoc=='H')		{		$pventa=$pv8;	}
			if($tipoc=='I')		{		$pventa=$pv1;	}	?>

Q. <? echo $pventa ?></span></span></span></span></strong> <span class="Estilo125" style="font-size: 16px"><span class="Estilo110">

<input name="Caja6" type="hidden" id="Caja6" value="<? echo $pventa ?>">
</span><span class="Estilo110"></span></span></td>
              <td width="33%" align="center" bgcolor="#7E9DE5" style="font-weight: bold; font-size: 16px;"><input name="Caja5" type="hidden" id="Caja5" value="<? echo $cnt ?>">
              <? echo number_format($cnt,0); ?></td>
            </tr>
            <tr>
              <td colspan="3" align="right"><span class="Estilo53 Estilo63 Estilo60">Observaciones
                  <input name="Caja8" type="text" id="Caja3" size="45" maxlength="100" onKeyUp="javascript:this.value=this.value.toUpperCase();">
                  <span style="font-weight: bold; font-size: 16px;">
                  <? } ?>
              </span>              </span></td>
            </tr>
          </table></td>
        </tr>
    </table>
</form>
<? if($cod1)	{ ?>
<form name="Factura" id="Factura" method="post" action="reg_ventas2.php?met=2">
  <table width="90%" border="0">
    <tr>
      <td><table width="100%" border="1" align="center" cellpadding="1" cellspacing="1" frame="box" rules="rows">
          <tr bgcolor="#FFFFCC">
            <td width="10%" height="30" align="center" bgcolor="#7E9DE5"><span class="Estilo128 Estilo79 Estilo109 Estilo98 Estilo111 Estilo53 Estilo54 Estilo63">Registro</span></td>
            <td align="center" bgcolor="#7E9DE5"><span class="Estilo128 Estilo79 Estilo109 Estilo98 Estilo111 Estilo53 Estilo54 Estilo63">Descripcion del Medicamento</span></td>
            <td align="center" bgcolor="#7E9DE5"><span class="Estilo128 Estilo79 Estilo109 Estilo98 Estilo111 Estilo53 Estilo54 Estilo63">Presentaci&oacute;n</span></td>
            <td align="center" bgcolor="#7E9DE5"><span class="Estilo128 Estilo79 Estilo109 Estilo98 Estilo111 Estilo53 Estilo54 Estilo63">Unitario</span></td>
            <td align="center" bgcolor="#7E9DE5"><span class="Estilo128 Estilo79 Estilo109 Estilo98 Estilo111 Estilo53 Estilo54 Estilo63">Solicitud</span></td>
            <td align="center" bgcolor="#7E9DE5"><span class="Estilo128 Estilo79 Estilo109 Estilo98 Estilo111 Estilo53 Estilo54 Estilo63">Descuento</span></td>
            <td colspan="3" bgcolor="#7E9DE5"><div align="center" class="Estilo110 Estilo53  Estilo73 Estilo63"><span class="Estilo63 Estilo54">TOTAL</span></div>
                <div align="center" class="Estilo115 Estilo53  Estilo73 Estilo63"></div>
                <div align="center" class="Estilo116 Estilo3 Estilo57 Estilo53  Estilo73 Estilo63">
                  <div align="center" class="Estilo63 Estilo54"></div>
              </div></td>
          </tr>
          <?  
			$selec= "SELECT c.salida, a.nproducto, b.presentacion, c.punitario, c.cantidad, c.descuentos, c.total, c.factura
                 FROM bodegam as a, presentacion as b, ventas as c
                 WHERE  a.id_producto=c.medicamento AND a.presentacion=b.id_presenta AND c.factura=$facturaA AND ano='$year' 
				 		AND c.operado='S'
				 ORDER BY c.salida";
			$filtro= mysql_query($selec,$link);
			while($salio=mysql_fetch_array($filtro))
			{
			?>
          <tr>
            <td height="27" bgcolor="#F0F0F0"><div align="center"><span class="Estilo53 Estilo55"><? echo $salio['factura'] ?>-<? echo $salio['salida'] ?></span></div></td>
            <td width="35%" bgcolor="#DBEACD"><span class="Estilo53 Estilo55"><? echo $salio['nproducto'] ?></span></td>
            <td width="15%" bgcolor="#F0F0F0"><div align="center"><span class="Estilo53 Estilo55"><? echo $salio['presentacion'] ?></span></div></td>
            <td width="10%" bgcolor="#DBEACD"><div align="right"><span class="Estilo53 Estilo55"><? echo number_format($salio['punitario'],2) ?></span></div></td>
            <td width="10%" bgcolor="#F0F0F0"><div align="center"><span class="Estilo55 Estilo53"><strong><? echo $salio['cantidad'] ?></strong></span></div></td>
            <td width="10%" bgcolor="#DBEACD"><div align="right"><span class="Estilo53 Estilo55"><? echo number_format($salio['descuentos'],2) ?></span></div></td>
            <td width="1%" bgcolor="#F0F0F0"><div align="left"><span class="Estilo53 Estilo54"><strong>Q.</strong></span></div></td>
            <td bgcolor="#F0F0F0"><div align="right"><span class="Estilo53 Estilo54"><strong><? echo number_format($salio['total'],2) ?></strong></span></div></td>
            <td width="1%"><a href="return_data.php?eli=1&id=<? echo $salio['salida']; ?>" title="Retornar Medicamento.." target="mainFrame"><img src="images/iconos/button_drop.png" width="11" height="13" border="0"></a></td>
            <? 
			}
				mysql_free_result($filtro);
			?>
          <tr>
            <?
		  	$selec="SELECT sum(total) as total FROM ventas WHERE factura=$facturaA AND ano='$year' ";
			$cantidad=mysql_query($selec,$link);
			while($tf=mysql_fetch_array($cantidad))
			{
				$totalg=$tf['total'];
			?>
            <td height="34" colspan="6" bgcolor="#7E9DE5">
              <div align="center" class="Estilo54 Estilo116  Estilo69">Total a Pagar.... <span class="Estilo82 Estilo74"><span class="Estilo60"><span class="Estilo43 Estilo41 Estilo69  Estilo70"><span class="Estilo43 Estilo41 Estilo69  Estilo71">Q. <? echo number_format($totalg,2) ?></span></span></span></span></div>
              <div align="center" class="Estilo53 Estilo54">
                <div align="left" class="Estilo60"><strong><span class="Estilo43 Estilo41 Estilo56"> </span></strong></div>
              </div></td>
            <td height="34" colspan="3" align="center" bgcolor="#7E9DE5"><input type="submit" name="Submit2" value="**  Actualizar **"></td>
            <? } ?>
          </table>
        <div align="right"></div></td>
    </tr>
  </table>
</form>
<? } ?>
<form name="Cancela" id="Cancela" method="post" action="rep_venta.php?dat=1">
  <table width="90%" border="1" cellpadding="1" cellspacing="1" bgcolor="#FFFFCC" frame="border" rules="all">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td width="25%" align="center">
            <?
	  	while($fac=mysql_fetch_array($datosm)) 
		{ 
			$ultima=$fac['max']; ?>
            <span id="sprytextfield6">
              <input name="Facturaptr" type="text" id="Facturaptr" value="<? echo $ultima ?>" size="4" maxlength="8">
            </span>  <span id="sprytextfield7">
              <? } ?>
              <label>
                &Uacute;ltima Factura
                <input name="Factyearpt" type="text" id="Factyearpt" value="<? echo $year; ?>" size="4" maxlength="8">
              </label>
              </span>
              </td>
          <td width="36%" align="center" bgcolor="#7E9DE5" style="font-family: Verdana, Geneva, sans-serif; font-size: 10px;"><span style="font-size: 9px">
            <input name="tiporep" type="radio" id="tiporep" value="S" checked>
ENVIO
<input name="tiporep" type="radio" id="tiporep" value="P">
Sugerir Precio
<input name="tiporep" type="radio" id="tiporep2" value="F">
Factura AA
<input name="tiporep" type="radio" id="tiporep3" value="F2">
Factura A</span></td>
          <td width="5%" align="center"><span class="Estilo1">
            <input name="Submit4" type="submit" id="Submit4" value="Imprimir...">
          </span></td>
        </tr>
        </table></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "currency");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "currency");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "integer");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
