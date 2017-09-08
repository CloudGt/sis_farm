<?php
session_start();
include("sysconect.php");
if ($_SESSION['Bandera'] != "SI") {    cambiar_ventana("index.php");    exit;	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title></title>
    <style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	text-align: center;
	font-weight: bold;
}
-->
    </style></head>
    <body>
        <form name="formulario" action="pedido_upload2.php" method="post" enctype="multipart/form-data">
          <p>MÓDULO DE CARGA DE PEDIDOS ELECTRÓNICOS DE FARMACIAS</p>
          <table width="75%" border="0" align="center">
          <tr>
            <td height="25" align="center" bgcolor="#0033FF">Seleccione Archivo Electrónico Recibido Vía Correo..</td>
          </tr>
          <tr>
                <td height="51" align="center"><input type="file" name="archivo" size="40"/></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#0033FF"><input type="submit" name="subir" value="Ingresar Pedido a Bodega"/></td>
              </tr>
            </table>
        </form>
    </body>
</html>
