<?phpsession_start();
require('fpdf.php');
include("sysconect.php");

	$cod1=$_GET['cod1'];
	$fecini=$_POST['fechaini'];		$fecfin=$_POST['fechafin'];
	$produc=$_POST['Producto'];		$report=$_POST['operacion'];
	if($report=='M')	
	{	cambiar_ventana("rep_medic5.php?cod1=$fecini&cod2=$fecfin&cod3=$produc");	exit;	}

// Conexion DB
	$link=conectarse("Apdahum");
	if($produc=='TODOS')	{	$med=0;	} else 	{	$med=1;	}	

	$selec="SELECT p.nom_provee, b.nproducto, s.presentacion, v.cantidad,  v.punitario, 
					v.total, v.factura, 
			date(v.fecha) as fecha
			FROM bodegam as b, proveedores as p, presentacion as s, ventas as v
			WHERE p.id_proveedor=b.id_proveedor AND s.id_presenta=b.presentacion AND b.Activo='S' AND p.Activo='S'
			AND v.medicamento=b.id_producto AND v.tipomed=b.eticopopular AND v.operado='S'";
	if ($fecini) 	{$selec = $selec." AND date(v.fecha)>='$fecini'";}
	if ($fecfin) 	{$selec = $selec." AND date(v.fecha)<='$fecfin'";}
	if ($med == 1)	{$selec = $selec." AND b.id_producto='$produc'";}
	$selec = $selec." ORDER BY v.factura desc, b.nproducto ";
	$row=mysql_query($selec,$link); 
	
	$selec2="SELECT b.nproducto, s.presentacion, sum(v.cantidad) as cantidad,  sum(v.total) as total
			FROM bodegam as b, proveedores as p, presentacion as s, ventas as v
			WHERE p.id_proveedor=b.id_proveedor AND s.id_presenta=b.presentacion AND b.Activo='S' AND p.Activo='S'
			AND v.medicamento=b.id_producto AND v.tipomed=b.eticopopular AND v.operado='S'";
	if ($fecini) 	{$selec2 = $selec2." AND date(v.fecha)>='$fecini'";}
	if ($fecfin) 	{$selec2 = $selec2." AND date(v.fecha)<='$fecfin'";}
	if ($med == 1)	{$selec2 = $selec2." AND b.id_producto='$produc'";}
	$selec2 = $selec2." GROUP BY b.nproducto, s.presentacion ORDER BY v.factura desc, b.nproducto";
	$row2=mysql_query($selec2,$link); 
	
class PDF extends FPDF
{
	function Header()
	{
    	$Bfarmacia=$_SESSION['Bfarmacia'];
		$this->SetFont('Arial','B',12);
		$this->Cell(0,10,$Bfarmacia,0,1,'C');
		$xx=date('Y-m-d'); conversion_fecha($xx);
		$yy=date('h:i:s');
		$this->SetFont('Arial','B',8);
		$this->Cell(0,6,'DETALLE DE VENTA DE MEDICAMENTOS',0,1,'C');
		$this->Cell(0,6,"Impresión: $xx $yy",0,1,'C');
		$this->SetFont('Arial','B',8);	
		$this->Cell(40,8,'PROVEEDOR',1,0,'C');	
		$this->Cell(70,8,'NOMBRE DEL MEDICAMENTO',1,0,'C');
		$this->Cell(20,8,'CANTIDAD',1,0,'C');
		$this->Cell(15,8,'PRECIO',1,0,'C');
		$this->Cell(15,8,'TOTAL',1,0,'C');
		$this->Cell(10,8,'ENVIO',1,0,'C');
		$this->Cell(18,8,'FECHA',1,1,'C');
	}
//Pie de página
	function Footer()
	{
    //Posición: a 1,5 cm del final
    	$this->SetY(-15);
    //Arial italic 8
    	$this->SetFont('Arial','I',8);
    //Número de página
    	$this->Cell(0,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
	}
}

//Creación del objeto de la clase heredada
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',7);
	while($ray=mysql_fetch_array($row))
	{
		$prov=$ray['nom_provee'];
		$prod=$ray['nproducto'];
		$cant=$ray['cantidad'];
		$puni=$ray['punitario'];
		$can2=$ray['cantidad2'];
		$pun2=$ray['punitario2'];
		$tota=$ray['total'];
		$fact=$ray['factura'];
		$fech=$ray['fecha'];
		if($cant==0)	{	$vcant=$can2; $vpuni=$pun2;	}	else	{	$vcant=$cant; $vpuni=$puni;	}
		$pdf->Cell(40,5,$prov,1,0);	
		$pdf->Cell(70,5,$prod,1,0);
		$pdf->Cell(20,5,$vcant,1,0,'C');
		$pdf->Cell(15,5,$vpuni,1,0,'R');
		$pdf->Cell(15,5,$tota,1,0,'R');
		$pdf->Cell(10,5,$fact,1,0,'C');
		$pdf->Cell(18,5,$fech,1,1,'C');

	}
	while($ray=mysql_fetch_array($row2))
	{
		$prod=$ray['nproducto'];
		$pres=$ray['presentacion'];
		$cant=number_format($ray['cantidad'],0);
		$tota=number_format($ray['total'],2);
		$pdf->Cell(10,5,"Total General...",0,1);
		$pdf->Cell(70,5,$prod,1,0);	
		$pdf->Cell(25,5,$pres,1,0);
		$pdf->Cell(15,5,$cant,1,0,'C');
		$pdf->Cell(15,5,$tota,1,1,'R');

	}
	
$pdf->Output();
?>  
