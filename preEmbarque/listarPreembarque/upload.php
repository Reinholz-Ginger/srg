<?php
include '../../generalPhp/conection.php';

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['id'])) {
    die(header("Location: ../../index.php"));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../../generalPhp/conection.php';

    if (!isset($_SESSION)) session_start();

    if (!isset($_SESSION['id'])) {
        die(header("Location: ../../index.php"));
    }

    $uniqId = $_POST['uniqId'] ?? null;
    if (!$uniqId) {
        echo 'Erro: uniqId não informado.';
        exit;
    }

    $uploadDir = 'uploadedFiles/';
    $respostas = [];

    // SALVAR CAMPOS DE TEXTO
    foreach ($_POST as $campo => $valor) {
        if ($campo === 'uniqId') continue;
        if (substr($campo, -5) === '_nome') continue;
        if (!isset($_FILES[$campo])) {
            $nomeCampo = $_POST[$campo . '_nome'] ?? $campo;
            if (empty($nomeCampo)) continue;
            $resposta = $valor;
            $caminho = '';

            // Verifica se já existe um registro com esse uniqId e nomeCampo
            $stmtVerifica = $conn->prepare("SELECT id FROM pre_embarque_files WHERE uniqId = ? AND nomeCampo = ?");
            $stmtVerifica->bind_param("ss", $uniqId, $nomeCampo);
            $stmtVerifica->execute();
            $stmtVerifica->store_result();

            if ($stmtVerifica->num_rows > 0) {
                // Existe: atualiza
                $stmtVerifica->close();

                $stmtAtualiza = $conn->prepare("UPDATE pre_embarque_files SET caminho = ?, resposta = ? WHERE uniqId = ? AND nomeCampo = ?");
                $stmtAtualiza->bind_param("ssss", $caminho, $resposta, $uniqId, $nomeCampo);

                if ($stmtAtualiza->execute()) {
                    $respostas[] = "Campo '$nomeCampo' atualizado com sucesso.";
                } else {
                    $respostas[] = "Erro ao atualizar '$nomeCampo': " . $stmtAtualiza->error;
                }

                $stmtAtualiza->close();
            } else {
                // Não existe: insere
                $stmtVerifica->close();

                $stmtInsere = $conn->prepare("INSERT INTO pre_embarque_files (uniqId, nomeCampo, caminho, resposta) VALUES (?, ?, ?, ?)");
                $stmtInsere->bind_param("ssss", $uniqId, $nomeCampo, $caminho, $resposta);

                if ($stmtInsere->execute()) {
                    $respostas[] = "Campo '$nomeCampo' inserido com sucesso.";
                } else {
                    $respostas[] = "Erro ao inserir '$nomeCampo': " . $stmtInsere->error;
                }

                $stmtInsere->close();
            }
        }
    }

    // SALVAR ARQUIVOS
    foreach ($_FILES as $campo => $arquivo) {
        $nomeCampo = $_POST[$campo . '_nome'] ?? $campo;
        if (empty($nomeCampo)) continue;
        $resposta = $_POST[$campo] ?? null;

        if ($arquivo['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            $novoNome = $uniqId . '_' . $campo . '.' . $extensao;
            $uploadPath = $uploadDir . $novoNome;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (move_uploaded_file($arquivo['tmp_name'], $uploadPath)) {
                // Verifica se já existe no banco
                $stmtVerifica = $conn->prepare("SELECT id FROM pre_embarque_files WHERE uniqId = ? AND nomeCampo = ?");
                $stmtVerifica->bind_param("ss", $uniqId, $nomeCampo);
                $stmtVerifica->execute();
                $stmtVerifica->store_result();

                if ($stmtVerifica->num_rows > 0) {
                    // Atualiza
                    $stmtVerifica->close();
                    $stmtAtualiza = $conn->prepare("UPDATE pre_embarque_files SET caminho = ?, resposta = ? WHERE uniqId = ? AND nomeCampo = ?");
                    $stmtAtualiza->bind_param("ssss", $uploadPath, $resposta, $uniqId, $nomeCampo);

                    if ($stmtAtualiza->execute()) {
                        $respostas[] = "Arquivo '$nomeCampo' atualizado com sucesso.";
                    } else {
                        $respostas[] = "Erro ao atualizar arquivo '$nomeCampo': " . $stmtAtualiza->error;
                    }

                    $stmtAtualiza->close();
                } else {
                    // Insere
                    $stmtVerifica->close();
                    $stmtInsere = $conn->prepare("INSERT INTO pre_embarque_files (uniqId, nomeCampo, caminho, resposta) VALUES (?, ?, ?, ?)");
                    $stmtInsere->bind_param("ssss", $uniqId, $nomeCampo, $uploadPath, $resposta);

                    if ($stmtInsere->execute()) {
                        $respostas[] = "Arquivo '$nomeCampo' inserido com sucesso.";
                    } else {
                        $respostas[] = "Erro ao inserir arquivo '$nomeCampo': " . $stmtInsere->error;
                    }

                    $stmtInsere->close();
                }
            } else {
                $respostas[] = "Erro ao mover o arquivo '$nomeCampo'.";
            }
        } else {
            $respostas[] = "Erro no upload do campo '$nomeCampo'. Código do erro: " . $arquivo['error'];
        }
    }

    echo implode("<br>", $respostas);
}
