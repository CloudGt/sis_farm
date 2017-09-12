<?php
	session_start();
	require('fpdf.php');
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	$pedido=$_POST['Pedidoptr'];
	
	$selec="SELECT d.nom_provee, a.nproducto, c.presentacion, b.solicita
                 FROM bodegam as a, pedidos as b, presentacion as c, proveedores as d
                 WHERE  a.presentacion=c.id_presenta AND a.id_producto=b.id_producto AND d.id_proveedor=a.id_proveedor
				 		AND b.npedido='$pedido' AND operado='N'
				 ORDER BY a.nproducto";
	$row=mysql_query($selec,$link);

class PDF extends FPDF
{
	function Header()
	{
    	$this->SetFont('Arial','B',24);
		$this->Cell(0,10,'A P D A H U M',0,0,'C');
    	$this->Ln();
		$this->SetFont('Arial','B',15);
		$this->Cell(70);
		$this->Cell(50,4,'ASOCIACION PRO-DESARROLLO Y AYUDA HUMANITARIA',0,0,'C');
		$this->Ln(14);
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
	$pdf->SetFont('Arial','B',10);
	$xx=date('Y-m-d'); conversion_fecha($xx);
	$pdf->Cell(0,6,'SOLICITUD DE ABASTECIMIENTO DE MEDICAMENTOS',0,1,'C');
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',8);	
	$pdf->Cell(35,8,'PROVEEDOR',1,0,'C');	
	$pdf->Cell(50,8,'NOMBRE DEL MEDICAMENTO',1,0,'C');
	$pdf->Cell(25,8,'PRESENTACION',1,0,'C');
	$pdf->Cell(30,8,'REQUERIMIENTO',1,0,'C');
	$pdf->Cell(30,8,'ENTREGADO',1,1,'C');
	while($ray=mysql_fetch_array($row))
	{
		$prov=$ray['nom_provee'];
		$prod=$ray['nproducto'];
		$pres=$ray['presentacion'];
		$soli=$ray['solicita'];
		$pdf->Cell(35,5,$prov,1,0);	
		$pdf->Cell(50,5,$prod,1,0);
		$pdf->Cell(25,5,$pres,1,0,'C');
		$pdf->Cell(30,5,$soli,1,0,'C');
		$pdf->Cell(30,5,' ',1,1,'C');		
	}
$pdf->Output();
?>  
