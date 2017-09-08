<?
	session_start();
	include("sysconect.php");
	require('fpdf.php');
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");

	$selec="SELECT upper(p.nom_provee) nom_provee, upper(b.nproducto) nproducto, upper(s.presentacion) presentacion,
				b.eticopopular, b.existencia
			FROM bodegam as b, proveedores as p, presentacion as s
			WHERE p.id_proveedor=b.id_proveedor AND s.id_presenta=b.presentacion AND b.Activo='S' AND p.Activo='S' 
					AND b.existencia<=5
			ORDER BY 1,2";
	$row=mysql_query($selec,$link);

class PDF extends FPDF
{
	function Header()
	{
    	$this->SetFont('Arial','B',14);
		$this->Cell(0,8,'A P D A H U M',0,0,'C');
    	$this->Ln();
		$this->SetFont('Arial','B',8);
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
	$pdf->Cell(0,6,'LISTADO DE MEDICAMENTOS PRÓXIMOS A AGOTARSE',0,1,'C');
	$pdf->Cell(0,6,"Actualización: $xx",0,1,'C');
	
	$pdf->SetFont('Arial','',8);	
	$pdf->Cell(40,8,'PROVEEDOR',1,0,'C');	
	$pdf->Cell(65,8,'NOMBRE DEL MEDICAMENTO',1,0,'C');
	$pdf->Cell(30,8,'PRESENTACION',1,0,'C');
	$pdf->Cell(6,8,'T',1,0,'C');
	$pdf->Cell(25,8,'BODEGA',1,0,'C');
	$pdf->Cell(15,8,'PEDIDO',1,1,'C');
	while($ray=mysql_fetch_array($row))
	{
		$prov=$ray['nom_provee'];
		$prod=$ray['nproducto'];
		$pres=$ray['presentacion'];
		$etpo=$ray['eticopopular'];
		$exis=$ray['existencia'];
		$pdf->Cell(40,5,$prov,1,0);	
		$pdf->Cell(65,5,$prod,1,0);
		$pdf->Cell(30,5,$pres,1,0,'C');
		$pdf->Cell(6,5,$etpo,1,0,'C');
		$pdf->Cell(25,5,$exis,1,0,'C');
		$pdf->Cell(15,5,' ',1,1);
	}
$pdf->Output();
?>  
