<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/frlisandroolmos/includes/functions.php';
$twigParams = array();
secure('indexAdmin');

$twigParams["title"]= 'Bienvenido Administrador';
init('welcome.twig', $twigParams);