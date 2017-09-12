<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	
	$fact=$_POST['factura'];
	$cod1=$_GET['cod1'];
	
	$selec= "SELECT p.npedido, p.pedido, b.nproducto, r.presentacion, p.solicita
                 FROM bodegam as b, presentacion as r,  pedidos as p
                 WHERE  b.id_producto=p.id_producto AND b.presentacion=r.id_presenta AND p.npedido='$cod1' AND operado='N'
				 ORDER BY b.nproducto";
	$filtro= mysql_query($selec,$link);			
	if($met==1)
	{
	$verifica="SELECT usuario FROM pedidos WHERE npedido='$fact' group by usuario";
	$consult=mysql_query($verifica,$link);
	while ($dat=mysql_fetch_array($consult))
	{
		$usr=$dat['usuario'];
	}
	if ($usr<>$Usr)
	{
		error_msg("Usted no generó este Pedido, Acceso Negado.");
		cambia_ventana('reg_pedidos.php');
		exit;
	}
	else
	{
		$selec= "SELECT p.npedido, p.pedido, b.nproducto, r.presentacion, p.solicita
                 FROM bodegam as b, presentacion as r,  pedidos as p
                 WHERE  b.id_producto=p.id_producto AND b.presentacion=r.id_presenta AND operado='N'";
				 if ($fact) {$selec = $selec." AND p.npedido='$fact'";}
				 if ($cod1) {$selec = $selec." AND p.npedido='$cod1'";} 
			$selec = $selec." ORDER BY b.nproducto";
			$filtro= mysql_query($selec,$link);
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
<script language="JavaScript"><!--
	function Verifica()
	{
	   	if(form1.factura.value== "" || form1.factura.value==0)
		{alert('Ingrese Número de Factura');
		return false}
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
.Estilo80 {font-weight: bold}
-->
</style>
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

<BODY>
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<form name="form1" method="post" action="reg_pedidos.php?met=1" onSubmit="return Verifica();">
  <div align="left"><span class="Estilo53 Estilo54"><em>Pedido N&uacute;mero:</em></span>      
    <input name="factura" type="text" id="factura" value="<?php
<?php	echo $cod1 ?>" size="5" maxlength="5"> 
      .. 
      <input type="submit" name="Submit" value="Verificar">
  </div>
</form>
<table border="0" align="center">
  <tr bgcolor="#FFFFCC">
    <td width="39"><div align="center" class="Estilo99 Estilo98 Estilo112 Estilo111 Estilo113 Estilo57 Estilo53 Estilo73 Estilo63 Estilo80 Estilo54">
        <div align="center"><span class="Estilo63 ">REG</span>.</div>
    </div></td>
    <td width="243"><div align="center" class="Estilo114 Estilo57 Estilo53 Estilo73 Estilo63 Estilo80 Estilo54">
        <div align="center"><span class="Estilo109 Estilo98 Estilo63">MEDICAMENTO</span></div>
    </div></td>
    <td width="153"><div align="center" class="Estilo115 Estilo57 Estilo53 Estilo73 Estilo63 Estilo80 Estilo54">
        <div align="center">PRESENTA</div>
    </div></td>
    <td colspan="2"><div align="center" class="Estilo115 Estilo57 Estilo53 Estilo73 Estilo63 Estilo80 Estilo54">
        <div align="center" class="Estilo63 "><span class="Estilo128 Estilo109 Estilo98 Estilo111 Estilo63 Estilo54  Estilo53">SOLICITUD</span></div>
    </div>      <div align="center" class="Estilo63 Estilo73 Estilo53 Estilo110 Estilo54"></div>      <div align="center" class="Estilo63 Estilo73 Estilo53 Estilo115 Estilo54"></div>      <div align="center" class="Estilo116 Estilo3 Estilo57 Estilo53 Estilo73 Estilo63 Estilo80 Estilo54">
          <div align="center" class="Estilo63 "></div>
      </div></td>
    </tr>
  <?php
<?php	 while($salio=mysql_fetch_array($filtro))	{	?>
  <tr>
    <td bgcolor="#F0F0F0"><div align="center"><span class="Estilo53 Estilo55"><?php
<?php	echo $salio['npedido'] ?>-<?php
<?php	echo $salio['pedido'] ?></span></div></td>
    <td bgcolor="#DBEACD"><span class="Estilo53 Estilo55"><?php
<?php	echo $salio['nproducto'] ?></span></td>
    <td bgcolor="#F0F0F0"><div align="center"><span class="Estilo53 Estilo55"><?php
<?php	echo $salio['presentacion'] ?></span></div></td>
    <td bgcolor="#DBEACD"><div align="center"><span class="Estilo55 Estilo53"><strong>
</strong></span>
        <form name="form2" method="post" action="return_data.php?eli=4&id=<?php
<?php	echo $salio['pedido']; ?>">
          <span class="Estilo55 Estilo53"><strong><strong>
          <input name="correcto" type="text" id="correcto2" value="<?php
<?php	echo $salio['solicita'] ?>" size="4" maxlength="6">
          </strong></strong></span><input type="submit" name="Submit2" value="Ingresar">        
		</form></div></td>  	
	<td width="23" bgcolor="#DBEACD"><div align="center"><a href="return_data.php?eli=5&id=<?php
<?php	echo $salio['pedido']; ?>" title="Cancelar Pedido..." target="mainFrame"><img src="images/iconos/button_drop.png" width="18" height="18" border="0" align="absmiddle"></a></div></td>
    <?php
<?php	
			}
				mysql_free_result($filtro);
			?>
  </table>
<p>&nbsp;</p>

<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
