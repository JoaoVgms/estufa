<?php
function getAllLogs() {
    global $db;
    try {
        $stmt = $db->query("SELECT * FROM sensors_log");
        $manual = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($manual);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao buscar Controle Manual: " . $e->getMessage()]);
    }
}

function getLogs($date) {
    global $db;
    try {
        $stmt = $db->prepare("SELECT * FROM sensors_log WHERE data_log = ?");
        $stmt->execute([$date]);
        $manual = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($manual) {
            echo json_encode($manual);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Controle Manual não encontrado"]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao buscar Controle Manual: " . $e->getMessage()]);
    }
}

?>