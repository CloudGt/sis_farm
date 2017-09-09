<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	$met=$_GET['met'];
	$cod1=$_GET['cod1'];
	$cod2=$_GET['cod2'];
	$cod3=$_GET['cod3'];
	$cod4=$_GET['cod4'];
	$casa=$_POST['Caja1'];
	$nomb=$_POST['Caja2'];
	$tpre=$_POST['Caja3'];
	$medi=$_POST['Caja4'];
	$pep=$_POST['Caja5'];	
	$asn=$_POST['Activo'];
	$osn=$_POST['Oferta'];
	$a=$_SESSION['Nom'];
	$p=$_SESSION['Ape'];
		
//Consultas y Popup's
	$selec = "SELECT Id_proveedor, upper(Nom_provee) as Nom_provee, Activo FROM Proveedores WHERE Activo='S' ORDER BY nom_provee";
	$datosm1 = mysql_query($selec,$link);
	if ($cod1 != 0)
	{
		$selec = "SELECT Id_producto, upper(NProducto) as NProducto 
					FROM bodegam WHERE Id_proveedor='$cod1' AND Activo='S' ORDER BY Nproducto";
		$datosm2 = mysql_query($selec,$link);
	}
	else
	{
		$selec = "SELECT Id_producto, upper(NProducto) as NProducto FROM bodegam WHERE Activo='S' ORDER BY 2";
		$datosm2 = mysql_query($selec,$link);
	}
	$selec = "SELECT Id_presenta, upper(Presentacion) Presentacion FROM Presentacion ORDER BY Id_presenta";
	$datosm3 = mysql_query($selec,$link);	
	$selec = "SELECT Id_producto, upper(NProducto) NProducto FROM bodegam WHERE Id_proveedor='$cod1' And Activo='N' ORDER BY 2";
	$datosm4 = mysql_query($selec,$link);
	$selec = "SELECT tipo_medic, descripcion FROM tipo_medic ORDER BY descripcion";
	$datosm5 = mysql_query($selec,$link);
	
//Actualiza Precios
	if ($met==1)
	{
		if($asn=='N')
		{
			$selec="SELECT Existencia FROM Bodegam WHERE  id_producto='$nomb'";
			$busca=mysql_query($selec,$link);
			while($exist=mysql_fetch_array($busca))
			{
				$existe=$exist['Existencia'];
				if($existe!=0)
				{
					error_msg("NO ES POSIBLE DESACTIVAR MEDICAMENTO, HAY EXISTENCIA EN BODEGA");
					header("Location: reg_ud_bodega.php");
					exit;
				}
			}
		}
		$buscamed="SELECT eticopopular FROM Bodegam WHERE id_producto='$nomb'";
		//echo $buscamed;
		$buscar=mysql_query($buscamed,$link);
		while($result=mysql_fetch_array($buscar))	{	$tipomed=$result['eticopopular'];	}
		if($tipomed!=$pep)
		{
			$cambioventa="UPDATE ventas SET tipomed='$pep' WHERE medicamento='$nomb'";
			//echo "$tipomed **** $pep **** $cambioventa" ;
			$ejecutar=mysql_query($cambioventa,$link);
		}
		$insert="UPDATE Bodegam SET NProducto='$medi', Presentacion='$tpre', EticoPopular='$pep', Activo='$asn', Oferta='$osn'
					WHERE id_producto='$nomb'";
		$r_insert=mysql_query($insert,$link);
		
		error_msg("ACTUALIZACION DE DATOS SATISFACTORIA");
		header("Location: reg_ud_bodega.php");
		exit;
	}

?>
<script language="JavaScript"><!--
	function CambioOpcion(targ,selObj,restore)
	{
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selected;
	}	
//--></script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>APDAHUM</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->


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
.Estilo54 {color: #0000FF}
-->
</style>
<style type="text/css">
<!--
.Estilo55 {color: #FF0000}
-->
</style>
<style type="text/css">
<!--
.Estilo56 {color: #99CC00}
-->
</style>
<style type="text/css">
<!--
.Estilo57 {
	font-size: 9px;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<style type="text/css">
<!--
.Estilo58 {font-size: 10px}
-->
</style>
<style type="text/css">
<!--
.Estilo60 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
.Estilo61 {
	font-size: 12;
	text-align: left;
}
-->
</style>
<style type="text/css">
<!--
.Estilo62 {
	color: #000000;
	font-weight: bold;
	font-family: "Times New Roman", Times, serif;
	font-size: 14;
}
-->
</style>
<style type="text/css">
<!--
.Estilo63 {
	font-size: 9px;
	color: #FF0000;
}
-->
</style>
<style type="text/css">
<!--
.Estilo65 {font-size: 14}
-->
</style>
<style type="text/css">
<!--
.Estilo66 {font-size: 14px}
-->
</style>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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

<BODY onLoad="document.Medicamento.select.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
<p>&nbsp;</p>
<form name="Medicamento" method="post" action="reg_ud_bodega.php?met=1">
  <table width="60%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="2"><div align="center"><strong>ACTUALIZACI&Oacute;N DE MEDICAMENTOS
            </strong></div>            <div align="right" class="Estilo53 Estilo61 Estilo54">
              <div align="center" class="Estilo62"></div>
              </div></td>
          </tr>
        <tr>
          <td colspan="2"><div align="right"><span class="Estilo53"><span class="Estilo58"><span class="Estilo60"><span class="Estilo61"><span class="Estilo61"><span class="Estilo54"><span class="Estilo54">.</span></span></span></span></span></span></span></div></td>
          </tr>
        <tr>
          <td colspan="2">            <div align="right" class="Estilo53 Estilo61 Estilo54">
            <div align="right"><span class="Estilo88 Estilo83 Estilo53 Estilo63"><strong>Productos Inactivos </strong></span><span class="Estilo83 Estilo88 Estilo53 Estilo57"><span class="Estilo76 Estilo53">
              <select name="select2" size="1" id="select15" onChange="CambioOpcion('self',this,0)">
                <option value="reg_ud_bodega.php?cod1=<? echo $cod1 ?>">Nombre del Medicamento</option>
                <?														
				while($medi=mysql_fetch_array($datosm4))						
				{													
					$idprod = $medi['Id_producto'];
					$nprodu = $medi['NProducto'];	
					if ($idprod == ($cod2))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"reg_ud_bodega.php?cod2=".$idprod."&cod1=".$cod1."\">".$nprodu."</option>\n";				
	         } ?>
                </select>
              </span></span></div>
            </div></td>
          </tr>
        <tr>
          <td colspan="2"><div align="right"><span class="Estilo53"><span class="Estilo58"><span class="Estilo60"><span class="Estilo61"><span class="Estilo61"><span class="Estilo54"><span class="Estilo54"></span></span></span></span></span></span></span>
            .</div></td>
          </tr>
        <tr>
          <td width="46%"><div align="center" class="Estilo83 Estilo88 Estilo57 Estilo53 Estilo61 Estilo54">
            <div align="right"><span class="Estilo53"><span id="sprytextfield2"><span class="textfieldRequiredMsg">¿?</span></span>
                <select name="Casaf" size="1" id="select3" onChange="CambioOpcion('self',this,0)">
                  <option value="reg_ud_bodega.php">Casa Farmaceutica</option>
                  <?														
				while($casa=mysql_fetch_array($datosm1))						
				{													
					$idcasa   =	$casa['Id_proveedor'];	
					$descripc = $casa['Nom_provee'];
					if ($idcasa == ($cod1))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"reg_ud_bodega.php?cod1=".$idcasa."\">".$descripc."</option>\n";				
	         } ?>
                </select>
            </span></div>
            </div>            <div align="right" class="Estilo53 Estilo61 Estilo54">
              <div align="right"></div>
              </div>
            <div align="right"></div>            <div align="left" class="Estilo53"></div></td>
          <td width="54%"><span class="Estilo53"> <span id="sprytextfield3">
            <input name="Caja2" type="hidden" id="Caja24" value="<? echo $cod2 ?>">
            <span class="textfieldRequiredMsg">¿?</span></span>
              <select name="select" size="1" id="select14" onChange="CambioOpcion('self',this,0)">
                <option value="reg_ud_bodega.php?cod2=0&cod1=<? echo $cod1 ?>">Nombre del Medicamento</option>
                <?														
				while($medi=mysql_fetch_array($datosm2))						
				{													
					$idprod =$medi['Id_producto'];			
					$nprodu =$medi['NProducto'];	
					if ($idprod == ($cod2))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"reg_ud_bodega.php?cod2=".$idprod."&cod1=".$cod1."\">".$nprodu."</option>\n";				
	         } ?>
              </select>
          </span></td>
          </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="2" align="left"><div align="right" class="Estilo53 Estilo61 Estilo54"><span class="Estilo81 Estilo82 "><span class="Estilo83">
            <? 
	  	$selec= "SELECT EticoPopular, Presentacion, upper(NProducto) NProducto, Activo, Oferta  FROM Bodegam 
					WHERE id_producto='$cod2'";
		$datosm4=mysql_query($selec,$link);
		while ($busca=mysql_fetch_array($datosm4))
	  	{
			$pep=$busca['EticoPopular'];	  		$cnt=$busca['Presentacion'];	
			$npr=$busca['NProducto'];				$act=$busca['Activo'];	
			$ofe=$busca['Oferta'];
		?>
            Descripci&oacute;n</span></span><span id="sprytextfield1">
              <input name="Caja4" type="text" id="Caja43" value="<? echo $npr ?>" size="55" maxlength="60" onKeyUp="javascript:this.value=this.value.toUpperCase();">
             <span class="textfieldRequiredMsg">¿?.</span></span></div>
            <div align="right" class="Estilo53 Estilo61 Estilo54"><div align="right"></div>
            </div></td>
          </tr>
        <tr>
          <td colspan="2" align="center"><strong><span class="Estilo74"><strong>
            <?
		  if ($cod3==0) { $cod3=$cnt; }
		?>
            <input name="Caja3" type="hidden" id="Caja36" value="<? echo $cod3 ?>">
            <select name="Presentacion" size="1" id="select12" onChange="CambioOpcion('self',this,0)">
              <option value="reg_ud_bodega.php?cod2=<? echo $cod2 ?>&cod1=<? echo $cod1 ?>"></option>
              <?														
				while($busca=mysql_fetch_array($datosm3))						
				{													
					$idpre = $busca['Id_presenta'];	
					$descripc = $busca['Presentacion'];	
					if ($idpre == ($cod3))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"reg_ud_bodega.php?cod3=".$idpre."&cod2=".$cod2."&cod1=".$cod1."\">".$descripc."</option>\n";				
	         } ?>
              </select>
            <strong>
              <?	if ($cod4=="") { $cod4=$pep; }	?>
              <input name="Caja5" type="hidden" id="Caja" value="<? echo $cod4 ?>">
              <select name="Clasificacion" size="1" id="Presentacion" onChange="CambioOpcion('self',this,0)">
                <option value="reg_ud_bodega.php?cod2=<? echo $cod2 ?>&cod1=<? echo $cod1 ?>&cod3=<? echo $cod3 ?>"></option>
                <?														
				while($busca=mysql_fetch_array($datosm5))						
				{													
					$idmedic = $busca['tipo_medic'];	
					$descripc = $busca['descripcion'];	
					if ($idmedic == ($cod4))
					{
						$selected = 'selected="selected"';
					}
					else
					{
						$selected = "";
					}
					echo "<option ".$selected." value=\"reg_ud_bodega.php?cod4=".$idmedic."&cod3=".$cod3."&cod2=".$cod2."&cod1=".$cod1."\">".$descripc."</option>\n";				
	         } ?>
                </select>
              </strong></strong></span></strong></td>
        </tr>
        <tr>
          <td><div align="center" class="Estilo77 Estilo53 Estilo54 Estilo66">
            <div align="right"><span class="Estilo74 "><span class="Estilo74"><span class="Estilo87 ">Activo</span></span></span></div>
            </div></td>
          <td class="Estilo53"><span class="Estilo74"><span class="Estilo54"><strong>
            <?
			if($act=='S')
			{ ?>
            <input name="Activo" type="radio" value="S" checked>
            </strong></span>
            <input name="Activo" type="radio" value="N">
            <? } ?>
            <?
			if($act=='N')
			{ ?>
            <input name="Activo" type="radio" value="S">
            <span class="Estilo54 Estilo87"></span> <span class="Estilo54"><strong>
              <input name="Activo" type="radio" value="N" checked>
              <? } ?>
              </strong><span class="Estilo66"><span class="Estilo74  Estilo53"><span class="Estilo87  Estilo54">Inactivo</span></span></span></span></span></td>
        </tr>
        <tr>
          <td><div align="right" class="Estilo81 Estilo82 Estilo53 Estilo54 Estilo66">
            <div align="right"><span class="Estilo87 ">Ofertado</span></div>
            </div> 
            </td>
          <td class="Estilo74"><strong><span class="Estilo55"><strong>
            <?
			if($ofe=='S')
			{ ?>
            <input name="Oferta" type="radio" value="S" checked>
            </strong></span>
            <input name="Oferta" type="radio" value="N">
            <? } ?>
            <span class="Estilo53">
              <?
			if($ofe=='N')
			{ ?>
              <input name="Oferta" type="radio" value="S">
              <span class="Estilo56"><strong>
                <input name="Oferta" type="radio" value="N" checked>
                <span class="Estilo74 Estilo54">
                <? } ?>
              </span></strong></span></span></strong><span class="Estilo53"><span class="Estilo56"><span class="Estilo74  Estilo54"><span class="Estilo74 Estilo54  Estilo66"> No Ofertado </span></span></span></span></td>
          </tr>
        <tr>
          <td colspan="2"><div align="right" class="Estilo84 Estilo53 Estilo61 Estilo54"></div>            <div align="left" class="Estilo53 Estilo61 Estilo54"></div>            </td>
          </tr>
        <tr bgcolor="#D9EACA">
          <td colspan="2">
            <div align="right" class="Estilo53 Estilo61 Estilo54">
              <div align="center">
                <input name="Registrar" type="submit" id="Registrar3" value="Actualizar Datos">
                </div>
              </div></td>
          </tr>
        <? } ?>
        </table></td>
      </tr>
    </table>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
