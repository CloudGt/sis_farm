<?
	session_start();
	
	$pag = $_GET['pag'];
	$maxpag = $_GET['maxpag'];
	$linkant = $_GET['linkant'];

	if ($pag == -1) { $PagNow = $PagNow - 1;}
	if ($pag == 0) { $PagNow = $PagNow + 1;}
	if ($pag > 0) { $PagNow = $pag;}
	if ($PagNow < 1) { $PagNow = 1;}
	if ($PagNow > $maxpag) { $PagNow = $maxpag;}

	header("Location: $linkant");
	exit;
?>