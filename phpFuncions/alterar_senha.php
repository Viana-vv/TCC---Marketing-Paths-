<?php
require_once "../php.config/config.php";
session_start();

// ID do usuário logado
$id_usuario = $_SESSION["id_usuario"] ?? null;

if (!$id_usuario) {
    die("Usuário não autenticado.");
}

$senha_atual     = $_POST["senha_atual"] ?? "";
$nova_senha      = $_POST["nova_senha"] ?? "";
$confirmar_senha = $_POST["confirmar_senha"] ?? "";

// =====================
// Validações básicas
// =====================
if ($nova_senha !== $confirmar_senha) {
    die("As senhas não coincidem.");
}

if (strlen($nova_senha) < 6) {
    die("A senha deve ter no mínimo 6 caracteres.");
}

// =====================
// Busca senha atual
// =====================
$sql = "SELECT senha FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuário não encontrado.");
}

$dados = $result->fetch_assoc();

// =====================
// Verifica senha atual
// =====================
if (!password_verify($senha_atual, $dados["senha"])) {
    die("Senha atual incorreta.");
}

// =====================
// Atualiza senha
// =====================
$nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

$update = "UPDATE usuarios SET senha = ? WHERE id_usuario = ?";
$stmt2 = $conn->prepare($update);
$stmt2->bind_param("si", $nova_senha_hash, $id_usuario);

if ($stmt2->execute()) {
    echo "✅ Senha alterada com sucesso!";
} else {
    echo "Erro ao alterar senha.";
}

$stmt->close();
$stmt2->close();
$conn->close();
?>
