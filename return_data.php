<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{	cambiar_ventana("index.php");	exit;	}
	$link=conectarse("Apdahum");	
	if (isset($_GET['eli'])) { $eli=$_GET['eli']; } else { $eli=0; }
	if (isset($_GET['id'])) { $id=$_GET['id']; } else { $id=0; }
	$year=date('Y');
	if ($eli == 1)
	{
		$tomamed = "SELECT Medicamento, Cantidad, Cliente FROM Ventas WHERE Salida=$id";
			$dato1= mysql_query($tomamed,$link);
			while ($medi = mysql_fetch_array($dato1))
			{
				$codmed= $medi['Medicamento'];
				$cantid= $medi['Cantidad'];
				$client= $medi['Cliente'];
				$bodega= "SELECT Existencia FROM Bodegam WHERE Id_producto=$codmed";
				$datos2= mysql_query($bodega,$link);
				while ($bode = mysql_fetch_array($datos2))
				{
					$actual= $bode['Existencia'];
					$total=$actual+$cantid;
					$actualiza= "UPDATE Bodegam SET Existencia=$total WHERE Id_producto=$codmed";
					$datos3 = mysql_query($actualiza,$link);
				}
			}
			$borra = "UPDATE Ventas SET operado='N', PUnitario=0, Descuentos=0, Total=0 WHERE salida = $id";
			$elimina = mysql_query($borra,$link);
			header("Location: reg_ventas.php?cod1=$client");
			exit;
	}
	
	if($eli == 2)
	{
		//DEVOLUCION DE MEDICAMENTOS YA FACTURADOS reg_devolucion.php
		if (isset($_GET['id2'])) { $id2=$_GET['id2']; } else { $id2=0; }
		if (isset($_GET['id'])) { $id=$_GET['id']; } else { $id=$_POST['return']; }
		//echo $id;
		
		$tomamed = "SELECT Medicamento, Cantidad, Factura, Fecha, Usuario, PUnitario FROM Ventas WHERE Salida=$id";
		$dato1= mysql_query($tomamed,$link);
		while ($medi = mysql_fetch_array($dato1))
		{
			$codmed= $medi['Medicamento'];
			$cantid= $medi['Cantidad'];
			$factu= $medi['Factura'];
			$fechaf= $medi['Fecha'];
			$usr=$medi['Usuario'];
			$preun=$medi['PUnitario'];	
		}
		$bodega= "SELECT Existencia FROM Bodegam WHERE Id_producto=$codmed";
		$datos2= mysql_query($bodega,$link);
		while ($bode = mysql_fetch_array($datos2))	{		$actual= $bode['Existencia'];	}
		
		if($id2==1)
		{
			$subtotal=$actual+$cantid;
			$actualiza= "UPDATE Bodegam SET Existencia=$subtotal WHERE Id_producto=$codmed";
			$datos3 = mysql_query($actualiza,$link);
			$borra = "UPDATE Ventas SET operado='N', PUnitario=0, Total=0 WHERE salida = $id";
			$elimina = mysql_query($borra,$link);
		}
		//Devolucion parcial o agregar sobre registro facturado
		if($id2==2)
		{
			$actualiza=$_POST['retornar'];
			$pedidoini=$_POST['pedido'];
					
			
			if($actualiza < $pedidoini)	{	$updatebodega=$actual+($pedidoini-$actualiza);	$venta=$cantid-($pedidoini-$actualiza);	}
			else						{	$updatebodega=$actual-($actualiza-$pedidoini);	$venta=$cantid+($actualiza-$pedidoini);	}
			
			if($updatebodega < 0)	{	error_msg("No hay en bodega...");	cambiar_ventana("reg_devolucion.php");	exit;	}
			
			$actualiza= "UPDATE Bodegam SET Existencia=$updatebodega WHERE Id_producto=$codmed";
			$datos3 = mysql_query($actualiza,$link);
			
			if($venta==0)
			{
				$borra = "UPDATE Ventas SET operado='N', PUnitario=0, Total=0 WHERE salida = $id";
				$elimina = mysql_query($borra,$link);
			}
			else
			{
				$newtotal=$venta*$preun;
				$borra = "UPDATE Ventas SET Cantidad='$venta', Total='$newtotal' WHERE salida = $id";
				$elimina = mysql_query($borra,$link);
			}
		}
		
		$nfac1= "SELECT sum(total) as Total FROM Ventas WHERE Tipomed='E' AND Factura='$factu' AND ano='$year' AND Operado='S'";
		$datos4= mysql_query($nfac1,$link);
		while ($subt1 = mysql_fetch_array($datos4))	{		$etico=$subt1['Total'];		}
		
		$nfac2= "SELECT sum(total) as Total FROM Ventas WHERE Tipomed='P' AND Factura='$factu' AND ano='$year' AND Operado='S'";
		$datos5= mysql_query($nfac2,$link);
		while ($subt2 = mysql_fetch_array($datos5))	{		$popul=$subt2['Total'];		}
		
		$nfac3= "SELECT sum(total) as Total FROM Ventas WHERE Tipomed='G' AND Factura='$factu' AND ano='$year' AND Operado='S'";
		$datos6= mysql_query($nfac3,$link);
		while ($subt3 = mysql_fetch_array($datos6))	{		$gener=$subt3['Total'];		}
		
		$nfac4= "SELECT sum(total) as Total FROM Ventas WHERE Tipomed='L' AND Factura='$factu' AND ano='$year' AND Operado='S'";
		$datos7= mysql_query($nfac4,$link);
		while ($subt4 = mysql_fetch_array($datos7))	{		$lech=$subt4['Total'];		}
		
		$totalf=$etico+$popul+$gener+$lech;

		if($id2==1)
		{
			$nfactura="UPDATE Facturas SET Etico='$etico', Popular='$popul', Generico='$gener', Leches='$lech', Total='$totalf'
						WHERE Factura='$factu' AND Ano='$year'";
			$datos6= mysql_query($nfactura,$link);
			//echo $nfactura;
			header("Location: reg_devolucion.php?cod1=$factu&met=1");
			exit;
		}
		else
		{
			$nfactura="UPDATE Facturas SET Etico='$etico', Popular='$popul', Generico='$gener', Leches='$lech', Total='$totalf'
						WHERE Factura='$factu' AND Ano='$year'";
			$datos6= mysql_query($nfactura,$link);
			//echo $nfactura;
			header("Location: reg_devolucion.php?cod1=$factu&met=1");
			exit;
		}
	}
	
	if ($eli == 3)
	{
		$borra = "UPDATE Pedidos SET Operado='E' WHERE pedido = $id";
		$elimina = mysql_query($borra,$link);
		header("Location: reg_pedido.php");
		exit;
	}
	if ($eli == 4)
	{
		$fecha=date('Y-m-d H:i:s');
		$ingresa=$_POST['correcto'];
		if(!$ingresa || $ingresa<=0) 
		{ 
			envia_msg("DATO INCORRECTO, NO SE ACTUALIZA BODEGA"); 
			cambiar_ventana("reg_pedidos.php"); 
			exit; 
		}
		else
		{
			//validacion del pedido
			$select="SELECT npedido, id_producto FROM pedidos WHERE pedido='$id'";
			$dato=mysql_query($select,$link);
			while($dats=mysql_fetch_array($dato))
			{
				$pidio= $dats['npedido'];
				$codigo=$dats['id_producto'];
			}
			$selec="SELECT existencia FROM Bodegam WHERE id_producto='$codigo'";
			$rundat= mysql_query($selec,$link);
			while($dato=mysql_fetch_array($rundat))
			{
				$tiene=$dato['existencia'];
			}
			//actualizacion de bodega
			$cambio=$tiene+$ingresa;
			$selec="UPDATE Bodegam SET Existencia='$cambio' WHERE id_producto='$codigo'";
			$rundat= mysql_query($selec,$link);
			//registro de transaccion
			$selec = "INSERT INTO Ingresos (Correlativo, Producto, Ingresa, Fec_reg, Usuario) 
					VALUES('','$codigo','$ingresa','$fecha','$Usr')";
			$ingresoud = mysql_query($selec,$link);
			//borrar pedido 
			$borra = "UPDATE Pedidos SET operado='S' WHERE pedido = $id";
			$elimina = mysql_query($borra,$link);
		}
		header("Location: reg_pedidos.php?cod1=$pidio");
		exit;
	}
	if ($eli == 5)
	{
		$select="SELECT npedido, id_producto FROM pedidos WHERE pedido='$id'";
			$dato=mysql_query($select,$link);
			while($dats=mysql_fetch_array($dato))
			{
				$pidio= $dats['npedido'];
				$codigo=$dats['id_producto'];
			}
			$borra = "UPDATE Pedidos SET operado='E' WHERE pedido = $id";
			$elimina = mysql_query($borra,$link);
			header("Location: reg_pedidos.php?cod1=$pidio");
			exit;
	}
	if ($eli == 6)
	{
			$tomamed = "SELECT Medicamento, Cantidad, Cliente FROM Cotizacion WHERE Salida=$id";
			$dato1= mysql_query($tomamed,$link);
			while ($medi = mysql_fetch_array($dato1))
			{
				$codmed= $medi['Medicamento'];
				$cantid= $medi['Cantidad'];
				$client= $medi['Cliente'];
			}
			$borra = "UPDATE Cotizacion SET Operado='E', Descuentos=0, Total=0 WHERE salida = $id";
			$elimina = mysql_query($borra,$link);
			header("Location: reg_cotiza.php?cod1=$client");
			exit;
	}
	if($eli == 7)
	{
		if (isset($_GET['dato'])) { $dato=$_GET['dato']; } else { $dato=0; }
		if($dato==1)
		{
			$Pwd="123";
			$Pwd = md5($Pwd);
			$cambio="UPDATE Empleado SET password='$Pwd' WHERE nip='$id'";
			$realiza=mysql_query($cambio,$link);
			error_msg("Cambio la Contraseña...");
			header("Location: reg_nusuario.php");
			exit;
		}
		if($dato==2)
		{
			$cambio="UPDATE empleado SET activo='0' WHERE nip='$id'";
			$ahora=mysql_query($cambio,$link);
			error_msg("Usuario Desactivado...");
			header("Location: reg_nusuario.php");
			exit;
		}
		else
		{
			error_msg("Se presentó un error notifique al administrador ERROR ADD USER...");
			header("Location: reg_nusuario.php");
			exit;
		}
	}
	
	if ($eli == 8)
	{
		$codmed=$_POST['codmed'];	$codpro=$_POST['codpro'];	$afecto=$_POST['radio'];
		$cambio="UPDATE Bodegam SET afecto='$afecto' WHERE id_producto='$codmed'";
		$registro=mysql_query($cambio,$link);
		header("Location: reg_ivasat.php?cod1=$codpro");
		exit;
	}
	
	if($eli == 9)
	{
		$id=$_GET['id'];	$id2=$_GET['id2'];
		$buscar="SELECT existencia FROM Bodegam WHERE id_producto='$id'";
		$regist=mysql_query($buscar,$link);
		while($result=mysql_fetch_array($regist))	{	$tiene=$result['existencia'];	}
		if($tiene==0)	{
			$cambio="UPDATE Bodegam SET activo='N'  WHERE id_producto='$id'";
			$registro=mysql_query($cambio,$link);
			header("Location: reg_ivasat.php?cod1=$id2");
			exit;
		} else	{
			error_msg("Medicamento en Bodega no se desactiva...");
			header("Location: reg_ivasat.php?cod1=$id2");
			exit;	
		}
	}
	
	if($eli == 10)
	{
		$hoy=date('Y-m-d h:i:s');
		$dat=$_GET['dat'];
		if($dat==1) 
		{
			$cambio="UPDATE ingresos SET activo='N', Usr_update='$Usr', kupdate='$hoy' WHERE correlativo='$id'";
			$registro=mysql_query($cambio,$link);
			error_msg("Lote Desactivado...");
			header("Location: reg_ud_bodega.php");
			exit;
		}
		else
		{
			$cambio="UPDATE ingresos SET activo='S', Usr_update='$Usr', kupdate='$hoy' WHERE correlativo='$id'";
			$registro=mysql_query($cambio,$link);
			error_msg("Lote Activado...");
			header("Location: reg_ud_bodega.php");
			exit;
		}
	}
	if($eli == 11)
	{
		$nitclie=$_POST['cliente'];		$bodega=$_POST['bodega2'];	$pedido=$_POST['pedido2'];
		$year=date('Y');				$today=date('Y-m-d');
		
		$consulta="SELECT id_producto, solicita, solicita2 FROM Pedidos 
					WHERE id_bodega='$bodega' AND npedido='$pedido' AND Operado='N'";
		$busca=mysql_query($consulta,$link);
		while($res=mysql_fetch_array($busca))
		{
			$idproduc=$res['id_producto'];
			$solicita1=$res['solicita'];
			$solicita2=$res['solicita2'];
			//Busco datos en bodega para generar Venta
			$buscaenbodega="SELECT existencia, preciocosto, eticopopular FROM Bodegam WHERE id_producto='$idproduc'";
			$buscarahora=mysql_query($buscaenbodega,$link);
			while($x=mysql_fetch_array($buscarahora))	
			{	
				$existe1=$x['existencia'];	$precio1=$x['preciocosto'];	$tipomed=$x['eticopopular'];
			}
				
			if($solicita1==0)	{		}	
			else
			{
				if($existe1 < $solicita1)	
				{
					$cambio="UPDATE Pedidos SET operado='S', surtido='N' 
						WHERE npedido='$pedido' AND id_bodega='$bodega' AND operado='N' AND id_producto='$idproduc'";
					$registro=mysql_query($cambio,$link);
				} else	{
					$ndato1=$existe1-$solicita1;
					$precio=$precio1;
					$unidades=$solicita1;
					$precioa=$precio;
					$preciob=0;
					
					$cambio2="UPDATE Bodegam SET existencia='$ndato1' WHERE id_producto='$idproduc'";
					$registra=mysql_query($cambio2,$link);
					$total=$unidades*$precio;
					$regventa="INSERT INTO Ventas 
VALUES('','$nitclie','$idproduc','$tipomed','$solicita1','$precioa',0,'$total','$today','$Usr',0,'$year','S')";
					$registra=mysql_query($regventa,$link);
				}
			}
			
			$cambio="UPDATE Pedidos SET operado='S', surtido='S' 
					WHERE npedido='$pedido' AND id_bodega='$bodega' AND id_producto='$idproduc'";
			$registro=mysql_query($cambio,$link);
		}
		//FACTURAR
		$selec="SELECT count_venta as max FROM Parameters";		$consulta=mysql_query($selec,$link);
		while($uf=mysql_fetch_array($consulta))		{		$ultima=$uf['max'];			}
		$sigue=$ultima+1; 
		$cambio="UPDATE Parameters SET count_venta=$sigue";	
		$registro=mysql_query($cambio,$link);
		//Sumatoria por tipo_medic
		$selec="SELECT SUM(total) as total1 FROM Ventas WHERE factura='$sigue' AND tipomed='E' AND ano='$year'
			AND Cliente='$nitclie' AND Usuario='$Usr' AND operado='S'";
		$buscaetico=mysql_query($selec,$link);
		while($te=mysql_fetch_array($buscaetico))	{		$etico=$te['total1'];		}
	
		$selec="SELECT SUM(total) as total2 FROM Ventas WHERE factura='$sigue' AND tipomed='P' AND ano='$year'
			AND Cliente='$nitclie' AND Usuario='$Usr' AND operado='S'";
		$buscapopul=mysql_query($selec,$link);
		while($tp=mysql_fetch_array($buscapopul))	{		$popular=$tp['total2'];		}
	
		$selec="SELECT SUM(total) as total3 FROM Ventas WHERE factura='$sigue' AND tipomed='L' AND ano='$year'
			AND Cliente='$nitclie' AND Usuario='$Usr' AND operado='S'";
		$buscalech=mysql_query($selec,$link);
		while($tl=mysql_fetch_array($buscalech))	{		$leches=$tl['total3'];		}
	
		$selec="SELECT SUM(total) as total4 FROM Ventas WHERE factura='$sigue' AND tipomed='G' AND ano='$year'
			AND Cliente='$nitclie' AND Usuario='$Usr' AND operado='S'";
		$buscagen=mysql_query($selec,$link);
		while($tg=mysql_fetch_array($buscagen))		{		$generico=$tg['total4'];	}
		//Facturación FINAL
		$totalfac=$etico+$popular+$leches+$generico;
		$tabfact="INSERT INTO Facturas (factura,ano,fecha,cliente,etico,popular,leches,generico,total,usuario) 
					VALUES('$sigue','$year','$today','$nitclie','$etico','$popular','$leches','$generico','$totalfac','$Usr')";					
		$guardar=mysql_query($tabfact,$link);
		
		//Actualizo Cliente y Factura en Ventas y Pedido
		$ventas="UPDATE Ventas SET factura='$sigue' WHERE factura=0 AND cliente='$nitclie' AND ano='$year' AND Usuario='$Usr'";
		$registro=mysql_query($ventas,$link);
		//Actualiza pedido vs. envio
		$pedidos="UPDATE Pedidos SET factura='$sigue' WHERE Factura=0 AND id_bodega='$bodega' AND npedido='$pedido'";
		$registro=mysql_query($pedidos,$link);
				
		cambiar_ventana("reg_ventas.php");
		exit;

	}
	
?>