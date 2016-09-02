<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/includes/functions.php';
require_once("config.inc.php");
$twigParams = array();
secure('indexAlumnos');
$seInscribio=$db->query("select count(*) as inscripciones from claseusuario where idUsuario='".$_SESSION["idUsuario"]."'");
$resultado = $seInscribio->fetch_array();
$twigParams["cantSemanal"]= $_SESSION["cantSemanal"];
$twigParams["porcentaje"]= floor(($resultado["inscripciones"]/$_SESSION["cantSemanal"])*100);
$twigParams["title"]= 'Bienvenido Alumno';

$twigParams["cantidad"]= $resultado["inscripciones"];
init('welcome.twig', $twigParams);