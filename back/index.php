<?php
define("DS", DIRECTORY_SEPARATOR);
define("DIR_BASE", __DIR__.DS);
define("BASE_VPATH","__rute__");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(DIR_BASE."system".DS."class.database.php");
require_once(DIR_BASE."system".DS."class.ws.php");

$db = new DB;
$ws = new WS;

try {

    //La url indica en qué carpeta ir a buscar el servicio
    $path = DIR_BASE."apis".DS.$ws->url.DS."init.php";

    if(!file_exists($path)){
        throw new Exception(" Servicio no encontrado. ");
    }

    require_once($path);

} catch (Exception $e) {
    $ws->sendResponse(500, $e->getMessage());
} finally {
    $db->disconnect();
}