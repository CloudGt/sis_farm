<?php
	session_start();
	require('nuevo/conexion/conexion.php');

	// Verifica si hubo inicio de sesión
	//if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	//$link=conectarse("apdahum");

// Valores iniciales para la paginacion
	$rangoini = (30 * $PagNow) - 30;
	$rangofin = 30;
	$sqlsel = @mysql_query("select idmenuxrol from menuxrol");
	$Total = @mysql_num_rows($sqlsel);
	$maxpag = ceil($Total / 30);	
	if ($maxpag == 0) {$maxpag = 1;}


//valida si las variables existen para declararlas
if (isset($_POST['ins'])) {	$ins=$_POST['ins']; /*echo $ins."<br>";*/ } else { $ins=0; }
if (isset($_GET['eli'])) { $eli=$_GET['eli']; /*echo $eli."<br>";*/ } else { $eli=0; }
if (isset($_GET['id'])) { $id=$_GET['id']; /*echo $id."<br>"; */} else { $id=0; }

//echo $_POST['nip'];

if (isset($_POST['id_opme']))
{
if (empty($_POST['id_opme']))
 {
    envia_msg("Debe seleccionar las opciones de menu a asignar. Verifique sus datos");
//    header("Location: tipo_archivo.php");
	cambiar_ventana("reg_ud_menu.php");
	exit;
 }
}

if (isset($_POST['id_rol']))
{
if (empty($_POST['id_rol']))
 {
    envia_msg("Debe seleccionar el rol a asignar. Verifique sus datos");
//    header("Location: tipo_archivo.php");
	cambiar_ventana("reg_ud_menu.php");
	exit;
 }
}


// Elimina el registro
	if ($eli == 1)
	{
			$query = "delete from menuxrol where idmenuxrol = '$id'";
			$result = @mysql_query($query,$link);
			cambiar_ventana("reg_ud_menu.php");
		   exit;
	}

	// Graba el nuevo valor en la tabla
	if ($ins == 1)
	 {
	  $personas = 0;
//       echo "personas ".$personas."<br>";
  	  $idrol = $_POST['idr'];
  	  $idrs = $_POST['idrs'];
	  for ($personas=1; $personas <= $_POST['cuenta_op']; $personas++)
		 {
            if (isset($_POST['opm'.$personas]))
			 {
			  $idmenu = $_POST['opm'.$personas];
				$sel_cant_op = @mysql_query("select idmenuxrol from menuxrol where id_menu = $idmenu and id_rol=$idrs");
			  if (@mysql_num_rows($sel_cant_op) == 0)
			   {
				  $query = "insert into menuxrol values (null,$idmenu,$idrs,now())";
				  $result = @mysql_query($query,$link);
			   }
			  else
			   {
			   echo " ";
			   }
			 } // termina if
	     } // termina el for
       cambiar_ventana("reg_ud_menu.php");
	  exit;

	 } // termina el ins
	
	$sqlsel_opme = "select a.id_menu, a.descr from menu a where padre = 0";
	$result_opme = @mysql_query($sqlsel_opme);
	if (isset($_GET['idom'])) { $idom=$_GET['idom']; } else { $idom=0; }

	$sqlsel_r = "select id_rol, rol from rol";
	$result_r = @mysql_query($sqlsel_r);
?>
<script language="JavaScript"><!--

// Esta funcion verifica que se hayan ingresado todos los datos obligatorios
	function CambioOpcion(targ,selObj,restore)
	{
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
	function Verifica()
	{
	    if ( (form1.id_rol.value == "" ) || (form1.id_opme.value == "" ))
		{alert('Debe ingresar los datos solicitados');
		return false}
	}

//--></script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>&nbsp;</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->


<link href="Templates/tablas-eec.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
<link href="tablas-eec.css" rel="stylesheet" type="text/css">
</HEAD>

<BODY onLoad="document.form1.id_opme.focus()">
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
  <form  name="form1" action="reg_ud_menu.php" method="POST" onSubmit="return Verifica()">
    <TR align="center"><TD colspan="2"><p class="en_tabla"><strong>ASIGNACI&Oacute;N DE PRIVILEGIOS (MEN&Uacute; PRINCIPAL) </strong></p></TD><TR>
	<span class="en_tabla">
	<TR>
	</span>
	 <TR><TD colspan="2">&nbsp;</TD></TR>
	  <TD class="en_tabla">Cat&aacute;logo Principal	    
	    <select name="id_opme" onChange="CambioOpcion('self',this,0)"> 
	          <option selected value="reg_ud_menu.php">-- Seleccione Opcion de Menu -</option>
	          <?php
	  $total_opme = mysql_num_rows($result_opme);
	  if ($total_opme==0)
	  { ?>
	          <tr>
	          <td colspan="2">
	          <font color="#FF0000"><strong><br>
	    No hay opciones de menu en el catalogo</strong></font>
	          </td>
	          </tr>
	          <?php
	  }
	  else
	  {
	  while($rowopme = @mysql_fetch_array($result_opme))
	 	{
	 	 $id_menu = $rowopme['id_menu'];
 		 $descr = $rowopme['descr'];
 		 if ($id_menu == ($idom))
 		  {
			$selected = 'selected="selected"';
 		  }
		 else
		  {
			$selected = "";
		  }
		 echo "<option ".$selected." value=\"reg_ud_menu.php?idom=".$id_menu."\">".$descr."</option>\n";
 		}	
	  }
 	  @mysql_free_result($sqlsel_opme);
	  ?>
        </select>
	        
        <input type="hidden" name="idom" value="<?php
<?php	echo $id_menu; ?>">
    
<p>
      </TD>
      </tr>
	        
	        
    </p>
<TD class="en_tabla">Nivel del Usuario <span class="en_tabla"><TD>
	        <select name="id_rol" onChange="CambioOpcion('self',this,0)"> 
	    <option selected value="reg_ud_menu.php?idr=0&idom=<?php
<?php	echo $idom ?>">-- Seleccione rol -</option>
 	    <?php
	  $total = mysql_num_rows($result_r);
	  if ($total==0)
	  { ?>
	  <tr>
	    <td colspan="2">
	    <font color="#FF0000"><strong><br>
	    No hay roles disponibles en el catalogo</strong></font>
	    </td>
	  </tr>
	    <?php
	  }
	  else
	  {
	  echo "valor idr".$_POST['idr'];
	  while($row = @mysql_fetch_array($result_r))
	 	{
	 	 $id_rol = $row['id_rol'];
 		 $rol = $row['rol'];
		 if ($id_rol == ($idr))
 		  {
			$selected = 'selected="selected"';
 		  }
		 else
		  {
			$selected = "";
		  }		 
		 echo "<option ".$selected." value=\"reg_ud_menu.php?idom=$idom&idr=".$id_rol."\">".$rol."</option>\n";
 		}	
 	  @mysql_free_result($sqlsel_r);
	  ?>
       </select>
	  <strong>
	  <input type="hidden" name="idrs" value="<?php
<?php	echo $idr;//$id_rol; ?>">
	  </strong>
      </select>
      </tr>

 	  <?
    $sqlsel_op = "select a.id_menu, a.descr from menu a where padre = $idom and id_menu not in (select id_menu from menuxrol where id_rol = $idr) order by 2";
	$result_op = @mysql_query($sqlsel_op);
    ?>
</span></TD>
	  <TR>
	    <TD class="en_tabla"><p><strong>Opciones Disponibles </strong></p></TD>
	    <TD align="center" class="en_tabla"><strong>Asignar </strong></TD>
	  </TR>
	<TR>
	<?php
<?php	
	if (@mysql_num_rows($result_op) == 0)
	 {
	?> <tr>
	    <td colspan="2" align="center">
	    <font color="#FF0000"><strong><br>
	    Todas las opciones del menu estan asignadas</strong></font>
	    </td>
	    </tr>
	<?
     }

	$cuenta_op =0;
	 while ($row = @mysql_fetch_array($result_op))
	  { 
  	  $opm = ("opm".($cuenta_op+1));
  	  $valarray = $row['id_menu'];
	  ?><TD class="en_tabla"><?php
<?php	echo $row['descr']; ?></TD><TD align="center">
      <span class="en_tabla">
      <input name="<?php
<?php	echo $opm; ?>" type="checkbox" value="<?php
<?php	echo $valarray; ?>">
<?	//  echo $opm." ".$valarray;?>
	  </span></TD></tr>
	<span class="en_tabla">
 	<?php
	  $cuenta_op = $cuenta_op +1;
	 } 
	?></span>
	
	<TR>
	   <TD align="center" colspan="2">
	     <p class="en_tabla">
 	     <input type="hidden" name="cuenta_op" value="<?php
<?php	echo $cuenta_op;?>">
	     <input type="hidden" name="ins" value="1">
	     </p>
	     <table width="400" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="400" bgcolor="#D9E9CC"><div align="center"><span class="en_tabla">
                 <input type="submit" name="agregar" value="Asignar">
             </span></div></td>
           </tr>
         </table>	     
	     </TD>
	</form> 
    <span class="en_tabla">
	  </TR>
	  <?php
<?php	} ?>
	  </table>
    </span>
    <tr><td>&nbsp;</td></tr>
    <span class="en_tabla">
</table>
<!--Termina tabla de altas-->

<?
$sql_sel="select * from menuxrol";
$result=@mysql_query($sql_sel,$link);
$cant_reg = @mysql_affected_rows();
//echo $cant_reg;
if ($cant_reg == 0)
 {
  echo "<p align=\"center\"><font color=\"#FF0000\"><strong>No hay registros en la base</strong></font></p>";
  exit;
 }
else
 {
  ?>
	</span>
    <TABLE  BORDER=0 CELLSPACING=2 CELLPADDING=2 align="center">
		<TR align="center">
		<TD bgcolor="#DBEACD" class="en_tabla" ><strong>Control</strong></strong></TD>
		<TD bgcolor="#F0F0F0" class="en_tabla" ><strong>Opcion de Menu</strong></TD>
		<TD bgcolor="#DBEACD" class="en_tabla"><strong>Rol</strong></TD>
	    <td  bgcolor="#F0F0F0">&nbsp;</td>
		</TR>
		<?php
		$sql_sel="select a.idmenuxrol, b.descr, c.rol from menuxrol a, menu b, rol c where a.id_menu = b.id_menu and a.id_rol = c.id_rol and a.id_rol<>1 order by 3,2 limit $rangoini,$rangofin";
		$result=@mysql_query($sql_sel,$link);
		$correlativo = 0;
		while($row = @mysql_fetch_array($result)) 
		 {?>
			<tr>
			<td bgcolor="#DBEACD" class="en_tabla">
			  <?php
<?php	echo $row["idmenuxrol"]; ?>
			</td>
			<td bgcolor="#F0F0F0" class="en_tabla"><?php
<?php	echo $row["descr"]; ?></td>
			<td bgcolor="#DBEACD" class="en_tabla"><?php
<?php	echo $row["rol"]; ?></td>			
			<td bgcolor="#F0F0F0" class="en_tabla"><a href="reg_ud_menu.php?eli=1&id=<?php
<?php	echo $row["idmenuxrol"]; ?>" title="Elimina Opcion de Menu para el Rol" target="mainFrame"><img src="images/iconos/button_drop.png" width="11" height="13" border="0"></a></td>
			</tr>
		<?php
		 }
		@mysql_free_result($result);
	 } 
	?>
  </table>
	
	
	<!--Paginagion de consulta -->
	<form name="form3" method="post" action="">
	<table border="0" align="center" class="en_tabla">
     <tr>
		<?php
			if ($PagNow != 1)
			{
				echo "<td><a href=\"validapag.php?linkant=reg_ud_menu.php&pag=-1&maxpag=".$maxpag."\">Anterior</a></td>";
			}
			if ($maxpag > 10)
			{
				for ($contpag = $PagNow;($contpag <= $maxpag) && ($contpag <= ($PagNow + 9));$contpag++)
				{ 
					echo "<td><a href=\"validapag.php?linkant=reg_ud_menu.php&pag=".$contpag."&maxpag=".$maxpag."\">".$contpag."</a></td>";
				}
			}
			else
			{
			 if ($maxpag > 1 ) { 
				for ($contpag = 1;($contpag <= $maxpag) && ($contpag <= ($PagNow + 9));$contpag++)
				{ 
					echo "<td><a href=\"validapag.php?linkant=reg_ud_menu.php&pag=".$contpag."&maxpag=".$maxpag."\">".$contpag."</a></td>";
				}
			  }
			}
			
			if ($PagNow != $maxpag)
			{
				echo "<td><a href=\"validapag.php?linkant=reg_ud_menu.php&pag=0&maxpag=".$maxpag."\">Siguiente</a></td>";
			}
		?>  
    </tr>
  </table>
</form>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
