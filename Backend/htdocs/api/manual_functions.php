<?php

function getManualControls() {
    global $db;
    try {
        $stmt = $db->query("SELECT * FROM controlemanual");
        $manual = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($manual);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao buscar Controle Manual: " . $e->getMessage()]);
    }
}

function getManualControl($id) {
    global $db;
    try {
        $stmt = $db->prepare("SELECT * FROM controlemanual WHERE id = ?");
        $stmt->execute([$id]);
        $manual = $stmt->fetch(PDO::FETCH_ASSOC);
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

function postControl() {
    global $db;
    $data = getJsonInput();
    if (!isset($data['controle']) || !isset($data['atividade'])) {
        http_response_code(400);
        echo json_encode(["error" => "Campos obrigatórios: controle, atividade"]);
        return;
    }
    if($data['atividade'] == 0 || $data['atividade'] == 1){
        try {
            $stmt = $db->prepare("INSERT INTO controlemanual (controle, atividade) VALUES (?, ?)");
            $stmt->execute([$data['controle'], $data['atividade']]);
            echo json_encode(["message" => "Controle criado com sucesso", "id" => $db->lastInsertId()]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao criar Controle Manual: " . $e->getMessage()]);
        }
    }
    else{
        http_response_code(500);
        echo json_encode(["error" => "Dados Inválidos para campo 'Atividade'"]);
        return;
    }
}

function updateControls($id) {
    global $db;
    $data = getJsonInput();
    if (!isset($data['controle']) || !isset($data['atividade'])) {
        http_response_code(400);
        echo json_encode(["error" => "Campos obrigatórios: controle, atividade"]);
        return;
    }
    if ($data['atividade'] == 0 || $data['atividade'] == 1)
    {
        try {
            $stmt = $db->prepare("UPDATE controlemanual SET controle = ?, atividade = ? WHERE id = ?");
            $stmt->execute([$data['controle'], $data['atividade'], $id]);
            echo json_encode(["message" => "Controle Manual atualizado com sucesso"]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao atualizar Controle Manual: " . $e->getMessage()]);
        }
    }
    else{
        http_response_code(500);
        echo json_encode(["error" => "Dados Inválidos para campo 'Atividade'"]);
        return;
    }
}

function deleteControl($id) {
    global $db;
    try {
        $stmt = $db->prepare("DELETE FROM controlemanual WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(["message" => "Controle Manual deletado com sucesso"]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao deletar Controle Manual: " . $e->getMessage()]);
    }
}

?>