<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/includes/functions.php';
$twigParams = array();
secure('indexProfesores');

$twigParams["title"]= 'Bienvenido Alumno';
init('welcome.twig', $twigParams);