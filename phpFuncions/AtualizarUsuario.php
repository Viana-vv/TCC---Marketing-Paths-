<?php
session_start();
include '../php.config/config.php';

$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $telefone = $_POST['telefone'] ?? null;
    $rua      = $_POST['rua'] ?? null;
    $bairro   = $_POST['bairro'] ?? null;
    $estado   = $_POST['estado'] ?? null;

    // Verifica se foi enviada uma nova imagem
    $imagem = null;
    if (isset($_FILES['imagens']) && $_FILES['imagens']['error'] === UPLOAD_ERR_OK) {
        $imagem = file_get_contents($_FILES['imagens']['tmp_name']);
    }

    if ($imagem) {
        $sql = "UPDATE usuarios 
                   SET telefone = ?, rua = ?, bairro = ?, estado = ?, imagens = ? 
                 WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssbi", $telefone, $rua, $bairro, $estado, $imagem, $id_usuario);
        // Para o campo blob, usamos send_long_data
        $stmt->send_long_data(4, $imagem);
    } else {
        $sql = "UPDATE usuarios 
                   SET telefone = ?, rua = ?, bairro = ?, estado = ? 
                 WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $telefone, $rua, $bairro, $estado, $id_usuario);
    }

    if ($stmt->execute()) {
        // Redireciona de volta para o perfil
        header("Location: ../telas.php/perfil.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
