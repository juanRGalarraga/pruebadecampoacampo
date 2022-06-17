<?php

/**
 * Archivo inicial que atiende la api de artículos
 */

require_once(DIR_BASE."system".DS."class.article.php");

try {
    
    $article = new Article;
    
    switch ($ws->method) {
        case 'GET':
    
            $path = DIR_BASE."apis".DS.$ws->url.DS."get.php";
    
            if(!file_exists($path)){
                throw new Exception(" Servicio no encontrado. ");
            }
    
            require_once($path);
    
        break;
    
        case 'POST':
    
            $path = DIR_BASE."apis".DS.$ws->url.DS."create.php";
    
            if(!file_exists($path)){
                throw new Exception(" Servicio no encontrado. ");
            }
    
            require_once($path);
            
        break;

        case 'PUT':
    
            $path = DIR_BASE."apis".DS.$ws->url.DS."update.php";
    
            if(!file_exists($path)){
                throw new Exception(" Servicio no encontrado. ");
            }
    
            require_once($path);
            
        break;
        
        default:
            throw new Exception("Método no reconocido");
            break;
    }

} catch (Exception $e) {
    $ws->sendResponse(404, $e->getMessage());
}