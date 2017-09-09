<?phpsession_start();
require('fpdf.php');
include("sysconect.php");

	$cod1=$_GET['cod1'];
	$cod2=$_GET['cod2'];	
	
// Conexion DB
	$link=conectarse("Apdahum");
	$selec="SELECT upper(p.nom_provee) nom_provee, upper(b.nproducto) nproducto, s.presentacion, 
					b.eticopopular, b.preciocosto, b.precioc1, b.precioc2, b.precioc3, b.precioc4, b.precioc5, b.precioVP
			FROM bodegam as b, proveedores as p, presentacion as s
			WHERE p.id_proveedor=b.id_proveedor AND s.id_presenta=b.presentacion AND b.Activo='S' AND p.Activo='S'";
			if ($cod1) {$selec = $selec." AND p.id_proveedor='$cod1'";}
			$selec = $selec." ORDER BY 1,2";
	$row=mysql_query($selec,$link);

class PDF extends FPDF
{
	function Header()
	{
    	$this->SetFont('Arial','B',12);
		$this->Cell(0,10,'A P D A H U M',0,0,'C');
    	$this->Ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(70);
		$this->Cell(50,4,'ASOCIACION PRO-DESARROLLO Y AYUDA HUMANITARIA',0,0,'C');
		$this->Ln(8);
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
	$pdf->SetFont('Arial','B',8);
	$xx=date('Y-m-d'); conversion_fecha($xx);
	$pdf->Cell(0,6,'LISTADO GENERAL DE MEDICAMENTOS',0,1,'C');
	$pdf->Cell(0,6,"Actualización: $xx",0,1,'C');
	$pdf->SetFont('Arial','',6);	
	$pdf->Cell(40,8,'PROVEEDOR',1,0,'C');	
	$pdf->Cell(55,8,'NOMBRE DEL MEDICAMENTO',1,0,'C');
	$pdf->Cell(30,8,'PRESENTACION',1,0,'C');
	$pdf->Cell(10,8,'TIPO',1,0,'C');
	$pdf->Cell(25,8,'PRECIO VENTA',1,0,'C');
	$pdf->Cell(10,8,$cod2,1,1,'C');
	while($ray=mysql_fetch_array($row))
	{
		$prov=$ray['nom_provee'];
		$prod=$ray['nproducto'];
		$pres=$ray['presentacion'];
		$etpo=$ray['eticopopular'];
		$pc=$ray['preciocosto'];
		$pv1=$ray['precioc1'];
		$pv2=$ray['precioc2'];
		$pv3=$ray['precioc3'];
		$pv4=$ray['precioc4'];
		$pv5=$ray['precioc5'];
		$pvp=$ray['precioVP'];
		$pdf->Cell(40,5,$prov,1,0);	
		$pdf->Cell(55,5,$prod,1,0);
		$pdf->Cell(30,5,$pres,1,0,'C');
		$pdf->Cell(10,5,$etpo,1,0,'C');
		if($cod2=='A') { $pdf->Cell(25,5,$pv1,1,0,'C'); }
		if($cod2=='B') { $pdf->Cell(25,5,$pv2,1,0,'C'); }
		if($cod2=='C') { $pdf->Cell(25,5,$pv3,1,0,'C'); }
		if($cod2=='D') { $pdf->Cell(25,5,$pv4,1,0,'C'); }
		if($cod2=='E') { $pdf->Cell(25,5,$pv5,1,0,'C'); }
		if($cod2=='F') { $pdf->Cell(25,5,$pvp,1,0,'C'); }
		$pdf->Cell(10,5,'',1,1,'C');
	}
$pdf->Output();
?>  
