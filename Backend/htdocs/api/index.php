<?php
// Arquivo: index.php

// Habilita erros para debug
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// CORS headers (in your PHP file handling the requests)
header("Access-Control-Allow-Origin: *"); // or specify domains like 'http://localhost:3000'
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Access-Control-Max-Age: 86400');
    http_response_code(200);
    exit;
}
    

// Inclui config de banco
require_once __DIR__ . '/database.php';
$db = getConnection();

// Função para ler o corpo JSON
function getJsonInput() {
    return json_decode(file_get_contents("php://input"), true);
}

// Roteador
$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$resource = $uri[1] ?? null; // Ex: "sensors"
$id = $uri[2] ?? null;

// === FUNÇÕES ===//

switch ($resource)
{
    case 'sensors':
        require_once __DIR__ . '/sensor_functions.php';
        // Rotas
        switch ($method) {
            case 'GET':
                if ($id) {
                    getSensor($id);
                } else {
                    getSensors();
                }
                break;

            case 'POST':
                createSensor();
                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["error" => "ID é obrigatório para PUT"]);
                    exit;
                }
                updateSensor($id);
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["error" => "ID é obrigatório para DELETE"]);
                    exit;
                }
                deleteSensor($id);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método não permitido"]);
        }
        break;
    case 'controlemanual':
        require_once __DIR__ . '/manual_functions.php';
        switch ($method) {
            case 'GET':
                if ($id) {
                    getManualControl($id);
                } else {
                    getManualControls();
                }
                break;

            case 'POST':
                postControl();
                break;

            case 'PUT':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["error" => "ID é obrigatório para PUT"]);
                    exit;
                }
                updateControls($id);
                break;

            case 'DELETE':
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["error" => "ID é obrigatório para DELETE"]);
                    exit;
                }
                deleteControl($id);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método não permitido"]);
        }
        break;
        case 'logs':
            require_once __DIR__ . '/logs_functions.php';
            switch ($method) {
                case 'GET':
                    if ($id) {
                        getLogs($id);
                    } else {
                        getAllLogs();
                    }
                    break;
    
                default:
                    http_response_code(405);
                    echo json_encode(["error" => "Método não permitido"]);
            }
            break;
    default:
        http_response_code(404);
        echo json_encode(["error" => "Endpoint não encontrado"]);
        exit;
}

