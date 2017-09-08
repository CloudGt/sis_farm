<?
// muestra un mensaje de error y corta la acci�n
function error_msg($msg)
{
	echo("<script language='JavaScript'>");
	echo("alert('$msg');");
	echo("history.back();");
	echo("</script>");
	exit(-1);
}

// muestra un mensaje cualquiera
function envia_msg($msg)
{
	echo("<script language='JavaScript'>");
	echo("alert('$msg');");
	echo("</script>");
}

// Funcion para abrir una nueva direccion
function cambiar_ventana($window)
{
	print "<script language=\"JavaScript\">";
	print "window.location = '$window' ";
	print "</script>";
}

// Muestra la fecha actual
function muestra_fecha()
{
	$dia=date("l");
	if ($dia=="Monday") $dia="LUNES";
	if ($dia=="Tuesday") $dia="MARTES";
	if ($dia=="Wednesday") $dia="MI�RCOLES";
	if ($dia=="Thursday") $dia="JUEVES";
	if ($dia=="Friday") $dia="VIERNES";
	if ($dia=="Saturday") $dia="SABADO";
	if ($dia=="Sunday") $dia="DOMINGO";
	
	$dia2=date("d");
	
	$mes=date("F");
	if ($mes=="January") $mes="ENERO";
	if ($mes=="February") $mes="FEBRERO";
	if ($mes=="March") $mes="MARZO";
	if ($mes=="April") $mes="ABRIL";
	if ($mes=="May") $mes="MAYO";
	if ($mes=="June") $mes="JUNIO";
	if ($mes=="July") $mes="JULIO";
	if ($mes=="August") $mes="AGOSTO";
	if ($mes=="September") $mes="SEPTIEMBRE";
	if ($mes=="October") $mes="OCTUBRE";
	if ($mes=="November") $mes="NOVIEMBRE";
	if ($mes=="December") $mes="DICIEMBRE";

	$ano=date("Y");

	echo "$dia $dia2 DE $mes DEL $ano";
}
// Conexion a la base de datos
function Conectarse($base)
{
	if (!($link=@mysql_connect('127.0.0.1','root','VronikILY')))
	{
		echo "Error conectando a la base de datos.";
		exit();
	}

	if (!@mysql_select_db($base,$link))
	{
		echo "Error seleccionando la base de datos.";
		exit();
	}
	return $link;
}
function muestra_fecha2(&$fe)
{
	$dia=date("l");
	if ($dia=="Monday") $dia="LUNES";
	if ($dia=="Tuesday") $dia="MARTES";
	if ($dia=="Wednesday") $dia="MI�RCOLES";
	if ($dia=="Thursday") $dia="JUEVES";
	if ($dia=="Friday") $dia="VIERNES";
	if ($dia=="Saturday") $dia="SABADO";
	if ($dia=="Sunday") $dia="DOMINGO";
		
	$dia2=date("d");
	
	$mes=date("F");
	if ($mes=="January") $mes="ENERO";
	if ($mes=="February") $mes="FEBRERO";
	if ($mes=="March") $mes="MARZO";
	if ($mes=="April") $mes="ABRIL";
	if ($mes=="May") $mes="MAYO";
	if ($mes=="June") $mes="JUNIO";
	if ($mes=="July") $mes="JULIO";
	if ($mes=="August") $mes="AGOSTO";
	if ($mes=="September") $mes="SEPTIEMBRE";
	if ($mes=="October") $mes="OCTUBRE";
	if ($mes=="November") $mes="NOVIEMBRE";
	if ($mes=="December") $mes="DICIEMBRE";


	$ano=date("Y");

	$fe = "$dia $dia2 DE $mes DEL $ano";
}

// Conversion de Fechas
function conversion_fecha(&$fe)
{
	$patterns = array ("/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/","/^\s*{(\w+)}\s*=/");
	$replace = array ("\\4/\\3/\\1\\2", "$\\1 =");
	$s_fec = preg_replace($patterns, $replace, $fe); 
	$fe = ereg_replace( "00:00:00", " ", $s_fec );
}

function conversion_fecha_inv(&$fe)
{
	$patterns = array ("/(\d{1,2})\/(\d{1,2})\/(19|20)(\d{2})/","/^\s*{(\w+)}\s*=/");
	$replace = array ("\\3\\4-\\2-\\1", "$\\1 =");
	$s_fec = preg_replace($patterns, $replace, $fe); 
	$fe = ereg_replace( "00:00:00", " ", $s_fec );
}


function num2letras($num, $fem = true, $dec = true) { 
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   
   if ($dec and $fra and ! $zeros) { 
      $fin = ' con'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero '; 
         elseif ($s == '1') 
            $fin .= $fem ? ' uno' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'uno'; 
         $subcent = 'os'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   return ucfirst($tex); 
} 

?>