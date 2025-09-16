<?php

require_once __DIR__ . '/database.php';
$db = getConnection(); // mudar para nome do meu arquivo de root password .php DONE

header('Content-Type: application/json');

// Lê os dados enviados no corpo da requisição HTTP (espera um JSON) e converte em array associativo
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se os dois campos obrigatórios foram enviados no JSON
if (isset($data['TemperaturaInterna']) && isset($data['TemperaturaExterna']) && isset($data['UmidadeSolo']) && isset($data['Luminosidade']) && (isset($data['NiveldeAgua']))) { // fazer a esp mandar todos os dados que estão aqui. TODO

    // criar mais variaveis DONE



    // pensar na logica para registrar os sensores num loop só. TODO

    $stmt = $db->prepare("UPDATE sensors SET tipo_sensor = 'Temperatura Interna', valor = ?, data_atualizada = NOW() WHERE id = 1"); // aqui tbm adicionar tudo. mudar para o sensors la

    if ($stmt)
    {
        if ($stmt->execute([$data['TemperaturaInterna']])) {
            echo json_encode(["status" => "sucesso", "mensagem" => "Leitura de sensores recebida com sucesso."]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Erro ao executar o INSERT: " . $stmt->error]);
        }
        
    }
    else
    {
        echo json_encode(["status" => "erro", "mensagem" => "Erro na preparação da consulta: " . $db->error]);
    }

    $stmt = $db->prepare("UPDATE sensors SET tipo_sensor = 'Temperatura Externa', valor = ?, data_atualizada = NOW() WHERE id = 2"); // aqui tbm adicionar tudo. mudar para o sensors la

    if ($stmt)
    {
        if ($stmt->execute([$data['TemperaturaExterna']])) {
            echo json_encode(["status" => "sucesso", "mensagem" => "Leitura de sensores recebida com sucesso."]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Erro ao executar o INSERT: " . $stmt->error]);
        }
    }
    else
    {
        echo json_encode(["status" => "erro", "mensagem" => "Erro na preparação da consulta: " . $db->error]);
    }

    $stmt = $db->prepare("UPDATE sensors SET tipo_sensor = 'Umidade do Solo', valor = ?, data_atualizada = NOW() WHERE id = 3"); // aqui tbm adicionar tudo. mudar para o sensors la

    if ($stmt)
    {
        if ($stmt->execute([$data['UmidadeSolo']])) {
            echo json_encode(["status" => "sucesso", "mensagem" => "Leitura de sensores recebida com sucesso."]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Erro ao executar o INSERT: " . $stmt->error]);
        }
    }
    else
    {
        echo json_encode(["status" => "erro", "mensagem" => "Erro na preparação da consulta: " . $db->error]);
    }

    $stmt = $db->prepare("UPDATE sensors SET tipo_sensor = 'Luminosidade', valor = ?, data_atualizada = NOW() WHERE id = 4"); // aqui tbm adicionar tudo. mudar para o sensors la

    if ($stmt)
    {
        if ($stmt->execute([$data['Luminosidade']])) {
            echo json_encode(["status" => "sucesso", "mensagem" => "Leitura de sensores recebida com sucesso."]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Erro ao executar o INSERT: " . $stmt->error]);
        }
    }
    else
    {
        echo json_encode(["status" => "erro", "mensagem" => "Erro na preparação da consulta: " . $db->error]);
    }

    $stmt = $db->prepare("UPDATE sensors SET tipo_sensor = 'Nivel de água', valor = ?, data_atualizada = NOW() WHERE id = 5"); // aqui tbm adicionar tudo. mudar para o sensors la

    if ($stmt)
    {
        if ($stmt->execute([$data['NiveldeAgua']])) {
            echo json_encode(["status" => "sucesso", "mensagem" => "Leitura de sensores recebida com sucesso."]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Erro ao executar o INSERT: " . $stmt->error]);
        }
    }
    else
    {
        echo json_encode(["status" => "erro", "mensagem" => "Erro na preparação da consulta: " . $db->error]);
    }


} else {

    echo json_encode(["status" => "erro", "mensagem" => "Leitura de sensores ausentes no JSON recebido."]); // se não houver dados o suficiente.
}

$db->close();
?>
