<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/includes/functions.php';
$twigParams = array();
secure('calendario');

$twigParams["title"]= 'Clases';

if (isset($_GET["mes"])) {
	$twigParams["mes"]=$_GET["mes"];
}else{
	$twigParams["mes"]='';
}

if (isset($_GET["anio"])) {
	$twigParams["anio"]=$_GET["anio"];
}else{
	$twigParams["anio"]='';
}
$twigParams["idUsuario"]=$_SESSION['idUsuario'];
$twigParams["cantSemanal"]=$_SESSION['cantSemanal'];
init('calendario.twig', $twigParams);