<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
//Definicion de Variables
	$cod1=$_GET['cod1'];
	$medicam=$_POST['Caja1'];
	$solicit=$_POST['Caja2'];
	$hoy=date('Y-m-d');
	

// Filtros de Busqueda
	$selec  = "SELECT b.Id_producto, b.Nproducto FROM bodegam as b, proveedores as p WHERE b.Activo='S' AND b.id_proveedor=p.id_proveedor AND p.Activo='S' ORDER BY b.Nproducto";
	$datosm1= mysql_query($selec,$link);
	
	$selec="SELECT max(npedido) as max FROM pedidos";
	$datosm=mysql_query($selec,$link);
				
// Registro de Pedido
if($met==1)
	{
		if($solicit<=0)
		{
			error_msg("NO PUEDE SOLICITAR (CERO) MEDICAMENTOS");
			cambiar_ventana("reg_pedido.php");
			exit;
		}
		else
		{
			$selec="INSERT INTO Pedidos (Pedido, Id_producto, Solicita, Usuario, Fecha, Npedido, Operado) 
					VALUES('','$medicam','$solicit','$Usr','$hoy',0,'N')";
			$insert=mysql_query($selec,$link);
			if (mysql_errno($link)==0)
			{ 
				error_msg("Confirmar pedido...");
			}
			header("Location: Reg_Pedido.php");
			exit;
		}
	}
	if($met==2)
	{
		$selec="SELECT max(npedido) as max FROM pedidos";
		$datosm=mysql_query($selec,$link);
		while($confi=mysql_fetch_array($datosm)) 
		{ 
			$ultima=$confi['max']; 
			$next=$ultima+1;
		}
		$selec="UPDATE Pedidos SET Npedido='$next' WHERE Npedido=0 and Usuario='$Usr'";
		$confirma=mysql_query($selec,$link);
		if (mysql_errno($link)==0)
			{ 
				error_msg("Pedido Finalizado, No Olvide Confirmar Pedido");
			}
			header("Location: reg_Pedido.php");
			exit;
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
		 if(Pedido.Caja1.value== "" || Pedido.Caja2.value== "")
		{alert('Faltan Datos por Captarse');
		return false}
	}
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
.Estilo77 {
	font-size: 9px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
<style type="text/css">
<!--
.Estilo79 {font-size: 9px}
-->
</style>
<style type="text/css">
<!--
.Estilo80 {
	font-size: 9;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
<style type="text/css">
<!--
.Estilo81 {
	color: #FF0000;
	font-size: 16px;
}
-->
</style>
<style type="text/css">
<!--
.Estilo82 {font-size: 16px}
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
<form name="Pedido" id="Pedido" method="post" action="reg_pedido.php?met=1" onSubmit="return Verifica();">
  <table border="2">
        <tr>
          <td><table border="0" align="center">
            <tr>
              <td><div align="right"><span class="Estilo3"><span class="Estilo9">
                  <span class="Estilo3 Estilo9"><span class="Estilo111"><span class="Estilo57 Estilo60"><span class="Estilo41 Estilo43"><span class="Estilo82 Estilo74  Estilo79">
                  </span></span></span></span></span>
                  <input name="Caja1" type="hidden" id="Caja33" value="<?php
<?php	echo $cod1 ?>">
                  <select name="Medicamento" size="1" id="select3" onChange="CambioOpcion('self',this,0)">
                    <option value="reg_pedido.php">Todos los Productos</option>
                    <?														
			while($medi=mysql_fetch_array($datosm1))						
			{													
				$nip = $medi['Id_producto'];
				$nom = $medi['Nproducto'];
				if ($nip == ($cod1))
				{
					$selected = 'selected="selected"';
				}
				else
				{
					$selected = "";
				}
				echo "<option ".$selected." value=\"reg_pedido.php?cod1=".$nip."\">".$nom."</option>\n";				              
     	} ?>
                  </select>
                  <span class="Estilo3 Estilo9"><span class="Estilo82 Estilo79 Estilo111">
                  </span></span>              </span></span> </div></td>
              <td bgcolor="#F0F0F0"><span class="Estilo3"><span class="Estilo9"><span class="Estilo3 Estilo9"><span class="Estilo82 Estilo79 Estilo111">
                <?php
			$selec= "SELECT a.Nproducto, b.presentacion, c.nom_provee, a.eticopopular, a.existencia
						FROM bodegam as a, presentacion as b, proveedores as c 
						WHERE a.id_proveedor=c.id_proveedor AND a.presentacion=b.id_presenta AND a.id_producto='$cod1'";
			$datosm2=mysql_query($selec,$link);
			while($sale=mysql_fetch_array($datosm2))
			{
				$producto=$sale['Nproducto'];
				$presenta=$sale['presentacion'];
				$casafarm=$sale['nom_provee'];
				$tipoprod=$sale['eticopopular'];
				$cnt=$sale['existencia'];
				
			?>
              </span></span> <span class="Estilo118"> <span class="Estilo53 Estilo79 Estilo80"><span class="Estilo63 Estilo53 Estilo55"><strong>[ <?php
<?php	echo $presenta ?> ]</strong></span></span> </span><span class="Estilo120"><span class="Estilo63 Estilo55 Estilo53"><strong>[ <?php echo $casafarm ?> ] </strong></span><span class="Estilo111 Estilo74 Estilo77"><span class="Estilo54 Estilo111"><strong><strong> Existencia [ <span class="Estilo81 Estilo82"><?php
<?php	echo $cnt ?> </span>]</strong></strong></span></span></span></span></span></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <?php
<?php	} ?>
			<tr>
           	<td colspan="2"><div align="center"><span class="Estilo53 Estilo3 Estilo63 Estilo60"><strong>Solicita:</strong></span>
                      <span class="Estilo53 Estilo63 Estilo60"><strong>
                      <input name="Caja2" type="text" id="Caja2" size="6" maxlength="6">
                    </strong></span></div></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
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

<form name="Cierra" id="Cierra" method="post" action="reg_pedido.php?met=2">
  <table border="0">
    <tr>
      <td><table width="701" border="0" align="center">
          <tr bgcolor="#FFFFCC">
            <td width="89" class="Estilo62"><div align="center" class="Estilo99 Estilo98 Estilo112 Estilo111 Estilo113 Estilo57 Estilo63 Estilo53 Estilo54">
                <div align="center"><span class="Estilo54  Estilo63">REG</span>.</div>
            </div></td>
            <td width="262" class="Estilo62"><div align="center" class="Estilo114 Estilo57 Estilo63 Estilo53 Estilo54">
                <div align="center"><span class="Estilo109 Estilo98 Estilo54  Estilo63">MEDICAMENTO</span></div>
            </div></td>
            <td width="176" class="Estilo62"><div align="center" class="Estilo62 Estilo53 Estilo54">
                <div align="center" class="Estilo63">PRESENTA</div>
            </div></td>
            <td width="124" class="Estilo62"><div align="center" class="Estilo57 Estilo63 Estilo53 Estilo54">
                <div align="center" class="Estilo128 Estilo109 Estilo98 Estilo111 Estilo53 Estilo54  Estilo63">SOLICITA</div>
            </div></td>
            <td width="24"><div align="center" class="Estilo110 Estilo53  Estilo73 Estilo63"></div>
                <div align="center" class="Estilo115 Estilo53  Estilo73 Estilo63"></div>
                <div align="center" class="Estilo116 Estilo3 Estilo57 Estilo53  Estilo73 Estilo63">
                  <div align="center" class="Estilo63 Estilo54"></div>
              </div></td>
          </tr>
          <?php
<?php	 
			$selec= "SELECT p.npedido, p.pedido, a.nproducto, b.presentacion, p.solicita
                 FROM bodegam as a, pedidos as p, presentacion as b
                 WHERE  a.presentacion=b.id_presenta AND a.id_producto=p.id_producto AND p.npedido=0 AND p.usuario='$Usr' 
				 		AND operado='N'
				 ORDER BY a.nproducto";
			$filtro= mysql_query($selec,$link);
			while($salio=mysql_fetch_array($filtro))
			{
			?>
          <tr>
            <td bgcolor="#F0F0F0"><div align="center"><span class="Estilo53 Estilo55"><?php
<?php	echo $salio['npedido'] ?>-<?php
<?php	echo $salio['pedido'] ?></span></div></td>
            <td bgcolor="#DBEACD"><span class="Estilo53 Estilo55"><?php
<?php	echo $salio['nproducto'] ?></span></td>
            <td bgcolor="#F0F0F0"><div align="center"><span class="Estilo53 Estilo55"><?php
<?php	echo $salio['presentacion'] ?></span></div></td>
            <td bgcolor="#DBEACD"><div align="center"><span class="Estilo55 Estilo53"><strong><?php
<?php	echo $salio['solicita'] ?></strong></span></div></td>
            <td bgcolor="#F0F0F0"><a href="return_data.php?eli=3&id=<?php
<?php	echo $salio['pedido']; ?>" title="Cancelar Pedido.." target="mainFrame"><img src="images/iconos/button_drop.png" width="11" height="13" border="0"></a></td>
            <?php
<?php	
			}
				mysql_free_result($filtro);
			?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </table>
          
          <div align="center"></div></td>
    </tr>
    <tr>
      <td bgcolor="#DBEACD"><div align="center">
        <input type="submit" name="Submit2" value="**  Finalizar Pedido  **">
      </div></td>
    </tr>
  </table>
</form>
<form name="Cancela" id="Cancela" method="post" action="rep_pedido.php">
  <table border="0" bgcolor="#DBEACD">
    <tr>
      <td><div align="center"><span class="Estilo1"><span class="Estilo120">
          <?php
	  	while($fac=mysql_fetch_array($datosm)) 
		{ 
			$ultima=$fac['max']; ?>
          <span class="Estilo60 Estilo53 Estilo62"><em>&Uacute;ltimo Pedido:</em></span> </span> <span class="Estilo120">
          <?php
<?php	} ?>
          </span>
          <input name="Pedidoptr" type="text" id="Pedidoptr2" value="<?php
<?php	echo $ultima ?>" size="4" maxlength="4">
          <input name="Submit4" type="submit" id="Submit42" value="Imprimir...">
      </span></div></td>
    </tr>
  </table>
  </form>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
