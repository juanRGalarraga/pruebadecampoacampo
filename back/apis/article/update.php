<?php
$id = trim($ws->params['id'] ?? '');
$name = trim($ws->params['name'] ?? '');
$price = trim($ws->params['price'] ?? '');

if(!is_numeric($id)){
    return $ws->sendResponse(406, "Faltan parámetros requeridos.");
}

if(!$article->getById($id)){
    return $ws->sendResponse(404, "El artículo no pudo ser hallado.");
}

$record = [
    'name' => $name,
    'price' => $price
];

if(!$article->edit($record, "id = $id")){
    return $ws->sendResponse(500, "No se pudo editar el artículo.");
}

$ws->sendResponse(200, ["message" => "Artículo actualizado", "data" => $article->getById($id)]);