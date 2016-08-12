<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/includes/functions.php';
$twigParams = array();
secure('indexAdmin');

$twigParams["title"]= 'Bienvenido Administrador';
init('welcome.twig', $twigParams);