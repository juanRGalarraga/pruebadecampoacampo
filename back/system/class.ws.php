<?php

class WS {

    public $method = 'GET';
    public $url = "";
    public $params = [];
    
    function __construct(){
        $this->method = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : $this->method;
        $this->url = !empty($_GET[BASE_VPATH]) ? $_GET[BASE_VPATH] : $_SERVER['REQUEST_URI'];

        //Si es index.php quiere decir que solo se pasó la url base en la petición
        if(empty(trim($this->url)) or $this->url == "index.php"){ throw new Exception("Servicio no encontrado");}
        if(empty(trim($this->method))){ throw new Exception("Método no encontrado");}

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        header('Access-Control-Expose-Headers: Content-Length');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header('Access-Control-Max-Age: 86400');
        header("Content-Type: application/json;charset=UTF-8");
        // header("Content-Type: application/x-www-form-urlencoded");

        switch ($this->method) {
			case 'GET':
				$this->params = $_GET;
				break;
			case 'POST':
				$this->params = $_POST;
				break;
            case 'PUT':
                parse_str(file_get_contents("php://input"), $this->params);
            break;
            case 'OPTION': // Esto es para cumplir con el protocolo CORS.
				header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
				die(); break;
			case 'OPTIONS': // Esto es para cumplir con el protocolo CORS.
				header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
				die(); break;
			default:
				$this->params = $_REQUEST;
		}
    }

    public function sendResponse(int $httpStatus = 200, $data = null){

        header($_SERVER['SERVER_PROTOCOL'].' '.$httpStatus);
        
        echo json_encode($data);

        exit();
    }
}