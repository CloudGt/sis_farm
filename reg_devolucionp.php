<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI") 	{	cambiar_ventana("index.php");	exit;	}
	$conn=conectarse("apdahum");
	
	$id=$_GET['id'];
	
	$select="SELECT c.salida, a.nproducto, b.presentacion, c.punitario, c.cantidad, c.total, c.factura
             FROM bodegam as a, presentacion as b, ventas as c
		     WHERE  a.id_producto=c.medicamento AND a.presentacion=b.id_presenta and c.operado='S' AND c.salida='$id'";
	$filtro=mysql_query($select,$conn);
	
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
<styhnb <style type="text/css">
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
	font-size: 12px;
}
-->
</style>
<style type="text/css">
<!--
.Estilo53 {font-family: Arial, Helvetica, sans-serif}
.Estilo54 {	font-size: 14px;
	font-weight: normal;
}
.Estilo60 {font-size: 16}
.Estilo79 {font-size: 12px}
.Estilo80 {font-weight: bold}
-->
</style>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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

<BODY onBeforePrint="document.body.style.display = 'none';" onAfterPrint="document.body.style.display = '';">

<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
  <p>&nbsp;</p>
  <p>DEVOLUCI&Oacute;N DE MEDICAMENTOS  </p>
<form name="form1" method="post" action="return_data.php?eli=2&id2=2">
  <table width="100%" border="0" align="center">
    <tr bgcolor="#FFFFCC">
      <td width="12%" height="25" bgcolor="#0000CC" style="color: #FF0; font-weight: bold; font-family: Verdana, Geneva, sans-serif;">
<div align="center" class="Estilo99 Estilo98 Estilo112 Estilo111 Estilo113 Estilo57 Estilo53 Estilo73 Estilo63  Estilo79 Estilo80">
        <div align="center"><span class="Estilo63 ">REG</span>ISTRO</div>
      </div></td>
      <td width="37%" bgcolor="#0000CC" style="color: #FF0"><div align="center" class="Estilo114 Estilo57 Estilo53 Estilo73 Estilo63 Estilo79 Estilo80">
        <div align="center"><span class="Estilo109 Estilo98 Estilo63">DESCRIPCI&Oacute;N DEL MEDICAMENTO</span></div>
      </div>
        <div align="center" class="Estilo115 Estilo57 Estilo53 Estilo73 Estilo63 Estilo79 Estilo80">
          <div align="center"></div>
        </div></td>
      <td width="20%" bgcolor="#0000CC" style="color: #FF0"><div align="center" class="Estilo115 Estilo57 Estilo53 Estilo73 Estilo63 Estilo79 Estilo80">
        <div align="center" class="Estilo63 ">PRECIO UNITARIO</div>
      </div></td>
      <td width="12%" bgcolor="#0000CC" style="color: #FF0"><div align="center" class="Estilo57 Estilo53 Estilo65 Estilo63 Estilo79 Estilo80">
        <div align="center">CANTIDAD</div>
      </div></td>
      <td colspan="2" bgcolor="#0000CC" style="color: #FF0"><div align="center" class="Estilo79 Estilo63 Estilo73 Estilo53 Estilo115"><span class="Estilo63 ">TOTAL</span></div>
        <div align="center" class="Estilo116 Estilo3 Estilo57 Estilo53 Estilo73 Estilo63 Estilo79 Estilo80">
          <div align="center" class="Estilo63 "></div>
        </div></td>
    </tr>
    <?   while($salio=mysql_fetch_array($filtro))	{	?>
    	<tr>
      	<td height="28" bgcolor="#F0F0F0"><div align="center"><span class="Estilo53 Estilo55">
		<? echo $salio['factura'] ?>-<? echo $salio['salida'] ?></span></div></td>
      	<td bgcolor="#DBEACD"><span class="Estilo53 Estilo55"><? echo $salio['nproducto'] ?> (<? echo $salio['presentacion'] ?>)</span>
        <input name="return" type="hidden" id="return" value="<? echo $id ?>"><div align="center"></div></td>
	    <td align="center" bgcolor="#DBEACD"><div align="right"><span class="Estilo53 Estilo55">
		<? echo number_format($salio['punitario'],2) ?></span></div></td>
      <td align="center" bgcolor="#F0F0F0">
      <span id="sprytextfield1">
      <input name="retornar" type="text" id="retornar" value="<? echo $salio['cantidad'] ?>" size="6" maxlength="6">
      <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">¿?</span>
      <span class="textfieldMinValueMsg">-</span><span class="textfieldMaxValueMsg">+</span></span><span id="sprytextfield2">
      <label>
        <input name="pedido" type="hidden" id="pedido" value="<? echo $salio['cantidad'] ?>">
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td width="12%" bgcolor="#F0F0F0"><div align="left"><span class="Estilo53 Estilo54"><strong>Q.
      </strong></span><span class="Estilo53 Estilo54"><strong><? echo number_format($salio['total'],2) ?>
      </strong></span></div>        <div align="right"></div></td>
      <td width="7%" align="center">
       <input type="submit" name="button" id="button" value="Actualizar">
      </td>
    	<tr>
      <td height="1" colspan="6" bgcolor="#0000CC"><div align="center" class="Estilo54 Estilo116  Estilo69" style="font-size: 18px; font-weight: bold; color: #FF0;"></div>
        <div align="center" class="Estilo53 Estilo54">
          <div align="left" class="Estilo60"><strong><span class="Estilo43 Estilo41 Estilo56"> </span></strong></div>
        </div></td>
  	<? } ?>
  </table>
</form>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {minValue:1, maxValue:"<? echo $dato; ?>", validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
  </script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>