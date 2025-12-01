<?php
session_start();
include '../php.config/config.php';

// id do usuário logado
$id_usuario = $_SESSION['id_usuario'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['mensagem'])) {
    $mensagem = trim($_POST['mensagem']);

    $sql = "INSERT INTO chat_mensagens (id_usuario, mensagem, comentario_id, data_envio) 
            VALUES (?, ?, NULL, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_usuario, $mensagem);
    $stmt->execute();
}

header("Location: ../telas.php/chat.php");
exit;
?>
