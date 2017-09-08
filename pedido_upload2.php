<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI") {	cambiar_ventana("index.php");	exit;	}	
	$link=conectarse("apdahum");

function filesize_format($bytes, $format = '', $force = ''){
	$bytes=(float)$bytes;
	if ($bytes <1024){
		$numero=number_format($bytes, 0, '.', ',');
		return array($numero,"B");
	}
	if ($bytes <1048576){
		$numero=number_format($bytes/1024, 2, '.', ',');
		return array($numero,"KBs");
	}
	if ($bytes>= 1048576){
		$numero=number_format($bytes/1048576, 2, '.', ',');
		return array($numero,"MB");
	}
}
//VERIFICAMOS QUE SE SELECCIONO ALGUN ARCHIVO
if(sizeof($_FILES)==0){
	echo "No se puede subir el archivo";
	exit();
}
// EN ESTA VARIABLE ALMACENAMOS EL NOMBRE TEMPORAL QUE SE LE ASIGNO ESTE NOMBRE ES GENERADO POR EL SERVIDOR
$archivo = $_FILES["archivo"]["tmp_name"];
//Definimos un array para almacenar el tama�o del archivo
$tamanio=array();
//OBTENEMOS EL TAMA�O DEL ARCHIVO
$tamanio = $_FILES["archivo"]["size"];
//OBTENEMOS EL TIPO MIME DEL ARCHIVO
$tipo = $_FILES["archivo"]["type"];
//OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
$nombre_archivo = $_FILES["archivo"]["name"];
//PARA HACERNOS LA VIDA MAS FACIL EXTRAEMOS LOS DATOS DEL REQUEST
extract($_REQUEST);

if ( $archivo != "none" ){
	//ABRIMOS EL ARCHIVO EN MODO SOLO LECTURA
	// VERIFICAMOS EL TA�ANO DEL ARCHIVO
	$fp = fopen($archivo, "rb");
	//LEEMOS EL CONTENIDO DEL ARCHIVO
	$contenido = fread($fp, $tamanio);
	//CON LA FUNCION addslashes AGREGAMOS UN \ A CADA COMILLA SIMPLE ' PORQUE DE OTRA MANERA
	//NOS MARCARIA ERROR A LA HORA DE REALIZAR EL INSERT EN NUESTRA TABLA
	$contenido = addslashes($contenido);
	//CERRAMOS EL ARCHIVO
	fclose($fp);
	// VERIFICAMOS EL TA�ANO DEL ARCHIVO
	if ($tamanio <1048576){
		//HACEMOS LA CONVERSION PARA PODER GUARDAR SI EL TAMA�O ESTA EN b � MB
		$tamanio=filesize_format($tamanio);
	}

////insertada
$row = 1;
$handle = fopen($archivo, "r"); //contiene los datos
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //Lee toda una linea completa, e ingresa los datos en el array 'data'
    $num = count($data); //Cuenta cuantos campos contiene la linea (el array 'data')
    $row++;
	//$nupedido=$data[0];
	$nupedido=$data[0];
	$idbodega=$data[1];
	$medicame=$data[2];
	$cantida1=$data[3];
	$usuariop=$data[4];
	$fechaped=$data[5];	
	$busca="SELECT count(*) as tiene
				FROM PEDIDOS WHERE id_bodega='$idbodega' AND npedido='$nupedido' AND id_producto='$medicame'";
	$exist=mysql_query($busca,$link);
	while($x=mysql_fetch_array($exist))	{	$tiene=$x['tiene'];		}
	$newdate=date('Y-m-d');
	if($fechaped=='0000-00-00')	{	$fechaped=$newdate;		}
	if($tiene==0)
	{
		$selec = "INSERT INTO Pedidos 
					(pedido,id_bodega,id_producto,solicita,solicita2,usuario,fecha,npedido,operado,surtido,factura) 
			VALUES('','$idbodega','$medicame','$cantida1','$cantida2','$usuariop','$fechaped','$nupedido','N','N',0)";
		$ingresoud = mysql_query($selec,$link)or die('Error en actualizacion '. mysql_error());
	}

}

$select="SELECT id_bodega, npedido FROM pedidos WHERE operado='N' GROUP BY id_bodega, npedido";
$buscar=mysql_query($select,$link);
while($res=mysql_fetch_array($buscar))	
{	
	$bodega=$res['id_bodega'];	$pedido=$res['npedido'];	
	header("Location: pedido_upload3.php?dat1=$bodega&dat2=$pedido");
	exit;
}
// mysql_close($enlace);

fclose($handle);   
} 
?>
