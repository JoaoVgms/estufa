<?php

function getSensors() {
    global $db;
    try {
        $stmt = $db->query("SELECT * FROM sensors");
        $sensors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($sensors);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao buscar sensores: " . $e->getMessage()]);
    }
}

function getSensor($id) {
    global $db;
    try {
        $stmt = $db->prepare("SELECT * FROM sensors WHERE id = ?");
        $stmt->execute([$id]);
        $sensor = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($sensor) {
            echo json_encode($sensor);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Sensor não encontrado"]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao buscar sensor: " . $e->getMessage()]);
    }
}

function createSensor() {
    global $db;
    $data = getJsonInput();
    if (!isset($data['tipo_sensor']) || !isset($data['valor'])) {
        http_response_code(400);
        echo json_encode(["error" => "Campos obrigatórios: tipo_sensor, valor"]);
        return;
    }
    try {
        $stmt = $db->prepare("INSERT INTO sensors (tipo_sensor, valor, data_atualizada) VALUES (?, ?, NOW())");
        $stmt->execute([$data['tipo_sensor'], $data['valor']]);
        echo json_encode(["message" => "Sensor criado com sucesso", "id" => $db->lastInsertId()]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao criar sensor: " . $e->getMessage()]);
    }
}

function updateSensor($id) {
    global $db;
    $data = getJsonInput();
    if (!isset($data['valor'])) {
        http_response_code(400);
        echo json_encode(["error" => "Campos obrigatórios: valor"]);
        return;
    }
    try {
        $stmt = $db->prepare("UPDATE sensors SET valor = ?,  data_atualizada = NOW() WHERE id = ?");
        $stmt->execute([ $data['valor'], $id]);
        echo json_encode(["message" => "Sensor atualizado com sucesso"]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao atualizar sensor: " . $e->getMessage()]);
    }
}

function deleteSensor($id) {
    global $db;
    try {
        $stmt = $db->prepare("DELETE FROM sensors WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(["message" => "Sensor deletado com sucesso"]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao deletar sensor: " . $e->getMessage()]);
    }
}

?>