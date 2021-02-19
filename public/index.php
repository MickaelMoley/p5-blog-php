<?php

require '../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Core\Application;



$request = Request::createFromGlobals();
$app = new Application($request);
$response = $app->process(); // Gérer les redirections vers les controlleurs
$response->send();
//$app->send(); // Renvoie à l'utilisateur le traitement
//$response->send();
