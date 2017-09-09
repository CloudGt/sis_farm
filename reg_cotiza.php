<?
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
//Definicion de Variables
	$cod1=$_GET['cod1'];
	$cod2=$_GET['cod2'];
	$cliente=$_POST['Caja1'];
	$tipocli=$_POST['Caja2'];
	$medicam=$_POST['Caja3'];
	$existen=$_POST['Caja5'];
	$tipopro=$_POST['Caja4'];
	$preciov=$_POST['Caja6'];
	$solicit=$_POST['Caja7'];
	$descuento=$_POST['Descu'];
	$hoy=date('Y-m-d');
	

// Filtros de Busqueda
	$selec = "SELECT Nit, Nombres, Apellidos FROM Cliente WHERE Activo='S' ORDER BY Nombres";
	$datosm1 = mysql_query($selec,$link);
	$selec  = "SELECT b.Id_producto, b.Nproducto FROM bodegam as b, proveedores as p WHERE b.Activo='S' AND b.id_proveedor=p.id_proveedor AND p.Activo='S' ORDER BY b.Nproducto";
	$datosm2= mysql_query($selec,$link);
	$selec="SELECT max(cotizacion) as max FROM cotizacion";
	$datosm=mysql_query($selec,$link);
				
// Registro de Cotizacines
	if($met==1)
	{
		if($solicit<=0)
		{
			error_msg("NO PUEDE SOLICITAR (CERO) MEDICAMENTOS");
			cambiar_ventana("reg_ventas.php");
			exit;
		}
		if(($existen>=$solicit))
		{
			$total=(($preciov*$solicit)-$descuento);
			$ahora=$existen-$solicit;
			$selec="INSERT INTO Cotizacion (Salida, Cliente, Medicamento, Tipomed, Cantidad, Punitario, Descuentos, Total, Fecha, Usuario, Cotizacion) 
					VALUES ('', '$cliente','$medicam','$tipopro','$solicit','$preciov','$descuento','$total','$hoy','$Usr',0)";
			$registro1=mysql_query($selec,$link);
			
			//Conteo de medicamentos para facturar
			$selec= "SELECT COUNT(cotizacion) as Salidas FROM Cotizacion WHERE Cotizacion=0 AND Usuario='$Usr'";
			$boleta= mysql_query($selec,$link);
			while($sal=mysql_fetch_array($boleta))
			{
				$llena=$sal['Salidas'];
				if($llena>=25)
				{
					envia_msg("*****  ULTIMOS REGISTROS, SE FINALIZARA COTIZACION AUTOMÁTICAMENTE  *****");
					if($llena>=30)
					{
						$selec="SELECT cliente FROM Cotizacion WHERE cotizacion=0 AND Usuario='$Usr' GROUP BY cliente";
						$busca1=mysql_query($selec,$link);
						while($cli=mysql_fetch_array($busca1))
						{	
							$client=$cli['cliente'];
							$selec="SELECT SUM(total) as total FROM Cotizacion WHERE cotizacion=0 AND tipomed='E' AND Cliente='$client' AND Usuario='$Usr'";
							$buscaetico=mysql_query($selec,$link);
							while($te=mysql_fetch_array($buscaetico))
							{
								$etico=$te['total'];
								$selec="SELECT SUM(total) as total FROM Cotizacion WHERE cotizacion=0 AND tipomed='P' AND Cliente='$client' AND Usuario='$Usr'";
								$buscapopul=mysql_query($selec,$link);
								while($tp=mysql_fetch_array($buscapopul))
								{
									$popular=$tp['total'];
									$selec="SELECT max(cotizacion) as max FROM Cotizacion";
									$consulta=mysql_query($selec,$link);
									while($uf=mysql_fetch_array($consulta))
									{
										$ultima=$uf['max'];
										$sigue=$ultima+1; 
										$tabvent="UPDATE Cotizacion SET cotizacion='$sigue' WHERE cotizacion=0 AND Usuario='$Usr'";
										$registro3=mysql_query($tabvent,$link);
										if (mysql_errno($link)==0)
										{ 
											error_msg("SE REGISTRA COTIZACION No. $sigue");
										}
									}
								}
							}
						}
					}
				}
				if($ahora<=5)
				{
					error_msg("SOLO QUEDAN $ahora PRESENTACIONES DE ESTE PRODUCTO, TOME EN CUENTA PARA PROXIMO PEDIDO");
				}
			}
			error_msg("Procesado...");
			cambiar_ventana("reg_cotiza.php");
			exit;
		}
		else
		{
			error_msg("No hay suficiente en EXISTENCIA para cubrir SOLICITUD");
			cambiar_ventana("reg_cotiza.php");
			exit;
		}
	}		
	if($met==2)
	{
		$selec="SELECT cliente FROM Cotizacion WHERE cotizacion=0 AND Usuario='$Usr' GROUP BY cliente";
		$busca1=mysql_query($selec,$link);
		while($cli=mysql_fetch_array($busca1))
		{	
			$client=$cli['cliente'];
			$selec="SELECT SUM(total) as total FROM Cotizacion WHERE cotizacion=0 AND tipomed='E' AND Cliente='$client' AND Usuario='$Usr'";
			$buscaetico=mysql_query($selec,$link);
			while($te=mysql_fetch_array($buscaetico))
			{
				$etico=$te['total'];
				$selec="SELECT SUM(total) as total FROM Cotizacion WHERE cotizacion=0 AND tipomed='P' AND Cliente='$client' AND Usuario='$Usr'";
				$buscapopul=mysql_query($selec,$link);
				while($tp=mysql_fetch_array($buscapopul))
				{
					$popular=$tp['total'];
					$selec="SELECT max(cotizacion) as max FROM Cotizacion";
					$consulta=mysql_query($selec,$link);
					while($uf=mysql_fetch_array($consulta))
					{
						$ultima=$uf['max'];
						$sigue=$ultima+1; 
						$totalfac=$etico+$popular;
						$tabvent="UPDATE Cotizacion SET cotizacion='$sigue' WHERE cotizacion=0 AND Usuario='$Usr'";
						$registro3=mysql_query($tabvent,$link);
						if (mysql_errno($link)==0)
						{ 
						error_msg("SE REGISTRA COTIZACION No. $sigue");
						}
					}
				}
			}
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
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
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
}
-->
</style>
<style type="text/css">
<!--
.Estilo63 {color: #0000FF}
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
-->
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
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
<form name="Venta" id="Venta" method="post" action="reg_cotiza.php?met=1">
    <table width="90%" border="1" cellpadding="1" cellspacing="1" frame="border" rules="all">
        <tr>
          <td><table width="100%" border="0" align="center">
            <tr>
              <td width="50%"><div align="right">
              <p align="right" class="Estilo3"><span class="Estilo3 Estilo9"> <span class="Estilo111"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74  Estilo79"> </span></span></span></span><span id="sprytextfield3">
                <input name="Caja1" type="hidden" id="Caja1" value="<? echo $cod1 ?>">
                <span class="textfieldRequiredMsg">?</span></span><span id="spryselect1">
                <select name="Clientes" size="1" id="Clientes" onChange="CambioOpcion('self',this,0)">
                  <option value="reg_cotiza.php">Cliente</option>
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
				echo "<option ".$selected." value=\"reg_cotiza.php?cod1=".$nit."&cod2=".$cod2."\">".$nom." ".$ape."</option>\n";				
	    	}?>
                </select>
                <span class="selectRequiredMsg">Seleccione un elemento.</span></span><span class="Estilo111"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74  Estilo79">                        </span></span></span></span>                  </span></p>
              </div></td>
              <td width="50%"><div align="right"><span class="Estilo3"><span class="Estilo9">
                  <span class="Estilo3 Estilo9"><span class="Estilo111"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74  Estilo79">
                  <?
			$selec= "SELECT tipo_cliente FROM cliente WHERE nit='$cod1'";
			$datosm3=mysql_query($selec,$link);
			while($tc=mysql_fetch_array($datosm3))
			{
				$tipoc=$tc['tipo_cliente'];
			?>
                  <input name="Caja2" type="hidden" id="Caja2" value="<? echo $tipoc ?>">
                  <? } ?>
                  </span></span></span></span></span><span id="sprytextfield4">
                  <input name="Caja3" type="hidden" id="Caja33" value="<? echo $cod2 ?>">
                  <span class="textfieldRequiredMsg">?</span></span><span id="spryselect2">
                  <select name="Medicamento" size="1" id="select3" onChange="CambioOpcion('self',this,0)">
                    <option value="reg_cotiza.php?cod1=<? echo $cod1; ?>">Todos los Productos</option>
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
				echo "<option ".$selected." value=\"reg_cotiza.php?cod2=".$nip."&cod1=".$cod1."\">".$nom."</option>\n";				              
     	} ?>
                  </select>
              <span class="selectRequiredMsg">Seleccione un elemento.</span></span></span></span> </div></td>
            </tr>
            <tr>
              <td colspan="2"><div align="center" class="Estilo67 Estilo55"><span class="Estilo53 Estilo65 Estilo57"><span class="Estilo3"><span class="Estilo3 Estilo9"><span class="Estilo82 Estilo74 Estilo79 Estilo111 ">
                <?
			$selec= "SELECT a.Nproducto, b.presentacion, c.nom_provee, a.eticopopular, a.existencia, a.precioc1, 
							a.precioc2, a.precioc3, a.precioc4, a.precioc5, a.precioc6, a.precioVP, a.oferta
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
				$pv7=$sale['precioc6'];
				$pv6=$sale['precioVP'];
				$ofe=$sale['oferta'];
			?>
              </span></span></span><span class="Estilo118">
              <input name="Caja4" type="hidden" id="Caja4" value="<? echo $tipoprod ?>">
              <? echo $producto ?> <span class="Estilo53  Estilo55 Estilo63">[<? echo $presenta ?>]</span></span><span class="Estilo120">(<?php echo $casafarm ?>)</span></span></div>
                  <div align="left" class="Estilo111 Estilo67 Estilo55">
                    <div align="center" class="Estilo53 Estilo65 Estilo57"></div>
                </div>                <div align="right" class="Estilo111 Estilo67 Estilo55">                      </div></td>
              <? } ?>
            </tr>
            <tr>
              <td colspan="2"><div align="center" class="Estilo65 Estilo66"><span class="Estilo111"><span class="Estilo125 Estilo54  Estilo53"><strong>
                  <?
		  	if($tipoc=='A')
			{
				$pventa=$pv1; ?>
                  [ Q. <? echo $pventa ?> ]</strong></span> <span class="Estilo125 Estilo54  Estilo53">
                <? } ?>
                <?
		  	if($tipoc=='B')
			{
				$pventa=$pv2; ?>                
                <strong>[Q. <? echo $pventa ?> ]</strong></span> <span class="Estilo125 Estilo54  Estilo53">
                <? } ?>
                <?
		  	if($tipoc=='C')
			{
				$pventa=$pv3; ?>
                <strong>[Q. <? echo $pventa ?> ]</strong>
                <? } ?>
                <?
		  	if($tipoc=='D')
			{
				$pventa=$pv4; ?>
                <strong>[Q. <? echo $pventa ?> ]
                <? } ?>
                </strong></span> <span class="Estilo122 Estilo54  Estilo53">
                <?
		  	if($tipoc=='E')
			{
				$pventa=$pv5; ?>
                <strong>[ Q. <? echo $pventa ?> ]</strong>
                <? } ?>
                <?
		  	if($tipoc=='G')
			{
				$pventa=$pv7; ?>
                <strong>[ Q. <? echo $pventa ?> ]</strong>
                <? } ?>
                <?
		  	if($tipoc=='F')
			{
				$pventa=$pv6; ?>
                <strong>[ Q. <? echo $pventa ?> ]</strong>
                <? } ?>
                <input name="Caja5" type="hidden" id="Caja5" value="<? echo $cnt ?>">
				<input name="Caja6" type="hidden" id="Caja6" value="<? echo $pventa ?>">
			  Existencia</span><span class="Estilo116 Estilo54  Estilo53"> [ <? echo $cnt ?> ]</span></span></div></td>
            </tr>
            <tr>
            <?
		  	if($ofe=='S')
		  	{ ?>
            	<td><div align="center" class="Estilo53 Estilo63 Estilo60"><strong><span class="Estilo130">Descuento por Oferta</span><span id="sprytextfield1">
                <input name="Descu" type="text" id="Descu2" size="6" maxlength="6">
                <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">Dato incorrecto</span></span>
            	  <? } ?>
			    </strong></div></td>
              <td><span class="Estilo53 Estilo3 Estilo63 Estilo60"><strong>Solicita:</strong></span><span id="sprytextfield2">
              <input name="Caja7" type="text" id="Caja7" size="6" maxlength="6">
              <span class="textfieldRequiredMsg">¿?</span><span class="textfieldInvalidFormatMsg">Dato Incorrecto</span></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr bgcolor="#D9E9CC">
              <td colspan="2"><div align="center">
                <input type="submit" name="Submit" value="Operar">
              </div></td>
            </tr>
          </table></td>
        </tr>
    </table>
</form>

<form name="Factura" id="Factura" method="post" action="reg_cotiza.php?met=2">
  <table width="90%" border="0">
    <tr>
      <td><table width="100%" border="1" align="center" cellpadding="1" cellspacing="1" frame="border" rules="rows">
          <tr bgcolor="#FFFFCC">
            <td><div align="center" class="Estilo99 Estilo98 Estilo112 Estilo111 Estilo113 Estilo57 Estilo53  Estilo73 Estilo63">
                <div align="center"><span class="Estilo63 Estilo54">REG</span>.</div>
            </div></td>
            <td><div align="center" class="Estilo114 Estilo57 Estilo53  Estilo73 Estilo63">
                <div align="center"><span class="Estilo109 Estilo79 Estilo98 Estilo63 Estilo54">DESCRIPCION</span></div>
            </div></td>
            <td><div align="center" class="Estilo115 Estilo57 Estilo53  Estilo73 Estilo63">
                <div align="center" class="Estilo76">PRESENTACION</div>
            </div></td>
            <td><div align="center" class="Estilo115 Estilo57 Estilo53  Estilo73 Estilo63">
                <div align="center" class="Estilo63 Estilo54">UNITARIO</div>
            </div></td>
            <td><div align="center" class="Estilo57 Estilo53 Estilo65 Estilo63">
                <div align="center" class="Estilo128 Estilo79 Estilo109 Estilo98 Estilo111 Estilo53 Estilo54 Estilo63">SOLICITUD</div>
            </div></td>
            <td><div align="center" class="Estilo115 Estilo57 Estilo53  Estilo73 Estilo63">
                <div align="center">DESCUENTO</div>
            </div></td>
            <td colspan="3"><div align="center" class="Estilo110 Estilo53  Estilo73 Estilo63">TOTAL</div>
                <div align="center" class="Estilo115 Estilo53  Estilo73 Estilo63"></div>
                <div align="center" class="Estilo116 Estilo3 Estilo57 Estilo53  Estilo73 Estilo63">
                  <div align="center" class="Estilo63 Estilo54"></div>
              </div></td>
          </tr>
          <?  
			$selec= "SELECT c.salida, a.nproducto, b.presentacion, c.punitario, c.cantidad, c.descuentos, c.total, c.cotizacion
                 FROM bodegam as a, presentacion as b, Cotizacion as c
                 WHERE  a.id_producto=c.medicamento AND a.presentacion=b.id_presenta AND c.cotizacion=0 AND c.usuario='$Usr' AND operado='N'
				 ORDER BY c.salida";
			$filtro= mysql_query($selec,$link);
			while($salio=mysql_fetch_array($filtro))
			{
			?>
          <tr>
            <td bgcolor="#F0F0F0"><div align="center"><span class="Estilo53 Estilo55"><? echo $salio['cotizacion'] ?>-<? echo $salio['salida'] ?></span></div></td>
            <td bgcolor="#DBEACD"><span class="Estilo53 Estilo55"><? echo $salio['nproducto'] ?></span></td>
            <td bgcolor="#F0F0F0"><div align="center"><span class="Estilo53 Estilo55"><? echo $salio['presentacion'] ?></span></div></td>
            <td bgcolor="#DBEACD"><div align="right"><span class="Estilo53 Estilo55"><? echo number_format($salio['punitario'],2) ?></span></div></td>
            <td bgcolor="#F0F0F0"><div align="center"><span class="Estilo55 Estilo53"><strong><? echo $salio['cantidad'] ?></strong></span></div></td>
            <td bgcolor="#DBEACD"><div align="right"><span class="Estilo53 Estilo55"><? echo number_format($salio['descuentos'],2) ?></span></div></td>
            <td bgcolor="#F0F0F0"><div align="left"><span class="Estilo53 Estilo54"><strong>Q.</strong></span></div></td>
            <td bgcolor="#F0F0F0"><div align="right"><span class="Estilo53 Estilo54"><strong><? echo number_format($salio['total'],2) ?></strong></span></div></td>
            <td><a href="return_data.php?eli=6&id=<? echo $salio['salida']; ?>" title="Cancelar Medicamento.." target="mainFrame"><img src="images/iconos/button_drop.png" width="11" height="13" border="0"></a></td>
            <? 
			}
				mysql_free_result($filtro);
			?>
          <tr>
            <?
		  	$selec="SELECT sum(total) as total FROM Cotizacion WHERE cotizacion =0 AND Usuario='$Usr'";
			$cantidad=mysql_query($selec,$link);
			while($tf=mysql_fetch_array($cantidad))
			{
				$totalg=$tf['total'];
			?>
            <td height="1" colspan="9" align="left">
              <div align="center" class="Estilo54 Estilo116  Estilo69">Total Cotizaci&oacute;n.... <span class="Estilo82 Estilo74"><span class="Estilo60"><span class="Estilo43 Estilo41 Estilo69  Estilo70"><span class="Estilo43 Estilo41 Estilo69  Estilo71">Q. <? echo number_format($totalg,2) ?></span></span></span></span></div>
              <div align="center" class="Estilo53 Estilo54">
                <div align="left" class="Estilo60"><strong><span class="Estilo43 Estilo41 Estilo56"> </span></strong></div>
            </div></td>
            <? } ?>
          </table>
          <div align="right">
            <input type="submit" name="Submit2" value="**  Cerrar Cotizacion  **">
        </div></td>
    </tr>
  </table>
</form>

<form name="Cancela" id="Cancela" method="post" action="rep_cotiza.php?dat=1">
  <p align="center" class="Estilo1"> <span class="Estilo120">
    <?
	  	while($fac=mysql_fetch_array($datosm)) 
		{ 
			$ultima=$fac['max']; ?>
    <span class="Estilo60 Estilo53 Estilo62"><em>&Uacute;ltima Cotizaci&oacute;n:</em></span> </span> <span class="Estilo120">
  <? } ?>
  </span>
    <input name="Facturaptr" type="text" id="Facturaptr" value="<? echo $ultima ?>" size="4" maxlength="4">
    <label>
      <input name="radio" type="radio" id="radio" value="I" checked>
      Imprimir 
      <input name="radio" type="radio" id="radio2" value="V">
      Autorizado Facturar
    </label>
    <input name="Submit4" type="submit" id="Submit4" value="Generar...">
  </p>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "currency");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
//-->
</script>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
