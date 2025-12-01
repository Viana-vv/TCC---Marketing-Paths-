<?php
session_start();
include '../php.config/config.php';

$id_usuario = $_SESSION['id_usuario'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['mensagem'])) {
    $mensagem = trim($_POST['mensagem']);
    $comentario_id = intval($_POST['comentario_id']);

    $sql = "INSERT INTO chat_mensagens (id_usuario, mensagem, comentario_id, data_envio) 
            VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $id_usuario, $mensagem, $comentario_id);
    $stmt->execute();
}

header("Location: ../telas.php/chat.php");
exit;
?>
