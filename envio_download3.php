<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("apdahum");

$pedi1=$_POST['pini'];
$pedi2=$_POST['pfin'];
$sucur=$_POST['sucur'];

$year=date('Y');
$return = '';

$selec="SELECT cliente FROM facturas WHERE factura='$pedi1'";
$busca=mysql_query($selec,$link);
while($x=mysql_fetch_array($busca))	{	$codclie=$x['cliente'];		}
$selec="SELECT id_bodega, descripcion, cliente FROM Bodegas WHERE id_bodega='$sucur'";
$busca=mysql_query($selec,$link);
while($y=mysql_fetch_array($busca))	{	$descrip=$y['descripcion'];		$idbodega=$y['id_bodega'];	$cliente=$y['cliente'];	}
if($descrip=="")	{	$FarmaciaD="BODEGA"; 	}	else	{	$FarmaciaD=$descrip;	}
//Cambiando el content-type m�s las table se pueden exportar formatos como csv
header("Cache-Control: public");
header('Content-Type: text/csv; charset=utf-8');
 // definimos el tipo MIME y la codificación
header('Content-Disposition: attachment; filename='.$FarmaciaD.'_E'.$pedi1.'-'.$pedi2.'_'.$year.'.csv');
// Forzamos que el archivo se descargue con un nombre definido

$sql="SELECT c.factura, a.id_producto, c.cantidad, a.precioc4, a.preciovp 
      	FROM bodegam AS a, ventas AS c
		WHERE  a.id_producto=c.medicamento  
		AND c.operado='S' AND factura>='$pedi1' AND factura<='$pedi2' AND c.cliente='$cliente' 
		ORDER BY c.factura, a.id_producto";
$result=mysql_query($sql,$link);


//primera fila del CSV
$busca="SELECT npedido FROM Pedidos WHERE factura='$pedi1' GROUP BY npedido";
$busca3=mysql_query($busca,$link);	while($r3=mysql_fetch_array($busca3))	{	$npedidoB=$r3['npedido'];	}
if($npedidoB=="")	{	$npedidoB=0;	}	
while($r=mysql_fetch_array($result)){
$idmedica=$r['id_producto'];
$busca="SELECT min(correlativo) as ID FROM ingresos WHERE producto='$idmedica' AND Activo='S'";
$busca1=mysql_query($busca,$link);	while($r1=mysql_fetch_array($busca1))	{	$idfec=$r1['ID'];	}
$busca="SELECT kduk FROM ingresos WHERE correlativo='$idfec'";
$busca2=mysql_query($busca,$link);	while($r2=mysql_fetch_array($busca2))	{	$kduk=$r2['kduk'];	}

if($idbodega=="")	{	$idbodega=0;	}
echo $idbodega.",".$npedidoB.",".$r['factura'].",".$r['id_producto'].",".$r['cantidad'].",".$r['precioc4'].",".$r['preciovp'].",".$kduk."\n";
    //mysql_free_result($r);
}
mysql_close($link);

//Cambiando el content-type m�s las table se pueden exportar formatos como csv
// header("Content-type: application/vnd-ms-excel; charset=iso-8859-1");
// header("Content-Disposition: attachment; filename=Reporte_Ventas_" . date('d-m-Y') . ".xls");
//echo $return;
?>