<?
session_start();
require('fpdf.php');
include("sysconect.php");

	$cod1=$_GET['cod1'];
	
// Conexion DB
	$link=conectarse("Apdahum");
	$selec="SELECT upper(p.nom_provee) nom_provee, upper(b.nproducto) nproducto, upper(s.presentacion) presentacion,
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
	$pdf->Cell(35,8,'PROVEEDOR',1,0,'C');	
	$pdf->Cell(50,8,'NOMBRE DEL MEDICAMENTO',1,0,'C');
	$pdf->Cell(25,8,'PRESENTACION',1,0,'C');
	$pdf->Cell(4,8,'T',1,0,'C');
	$pdf->Cell(11,8,'PC',1,0,'C');
	$pdf->Cell(11,8,'A',1,0,'C');
	$pdf->Cell(11,8,'B',1,0,'C');	
	$pdf->Cell(11,8,'C',1,0,'C');	
	$pdf->Cell(11,8,'D',1,0,'C');	
	$pdf->Cell(11,8,'E',1,0,'C');
	$pdf->Cell(11,8,'PV',1,1,'C');		
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
		$pdf->Cell(35,5,$prov,1,0);	
		$pdf->Cell(50,5,$prod,1,0);
		$pdf->Cell(25,5,$pres,1,0,'C');
		$pdf->Cell(4,5,$etpo,1,0,'C');
		$pdf->Cell(11,5,$pc,1,0,'R');
		$pdf->Cell(11,5,$pv1,1,0,'R');
		$pdf->Cell(11,5,$pv2,1,0,'R');
		$pdf->Cell(11,5,$pv3,1,0,'R');	
		$pdf->Cell(11,5,$pv4,1,0,'R');	
		$pdf->Cell(11,5,$pv5,1,0,'R');	
		$pdf->Cell(11,5,$pvp,1,1,'R');		
	}
$pdf->Output();
?>  
