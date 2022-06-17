<?php
/**
 * Obtiene un articulo dado un id
 */

$id = $ws->params['id'] ?? 'all';

if(is_numeric($id)){
    
    if(!$article->getById($id)){
        return $ws->sendResponse(500, "No se hallaron datos.");
    }
    
} else {

    if(!$article->getAll()){
        return $ws->sendResponse(500, "No se hallaron datos.");
    }

}

$ws->sendResponse(200, $article->raw);