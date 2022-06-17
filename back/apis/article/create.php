<?php

/**
 * Da de alta un articulo
 */

$name = trim($ws->params['name'] ?? '');
$price = trim($ws->params['price'] ?? '');

if(empty($name)){ return $ws->sendResponse(406, "No se pudo crear el artículo. Debe indicar el nombre");; }

$record = [
    'name' => $name,
    'price' => $price
];

if(!$article->new($record)){
    return $ws->sendResponse(500, "No se pudo crear el artículo.");
}

$articleCreated = $article->getById($article->last_id);

$ws->sendResponse(200, ["message" => "Artículo creado", "data" => $articleCreated]);