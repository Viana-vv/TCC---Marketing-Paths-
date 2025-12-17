<?php
require_once "php.config.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ==========================
    // Captura dos dados
    // ==========================
    $titulo     = $_POST["titulo"] ?? "";
    $descricao  = $_POST["descricao"] ?? "";
    $categoria  = $_POST["categoria"] ?? "";

    // ==========================
    // Verifica upload do vídeo
    // ==========================
    if (!isset($_FILES["video"]) || $_FILES["video"]["error"] !== 0) {
        echo "Erro ao enviar o vídeo.";
        exit;
    }

    $video      = $_FILES["video"];
    $extensao   = strtolower(pathinfo($video["name"], PATHINFO_EXTENSION));

    // Extensões permitidas
    $permitidos = ["mp4", "mov", "avi", "mkv", "webm"];

    if (!in_array($extensao, $permitidos)) {
        echo "Formato de vídeo não permitido.";
        exit;
    }

    // ==========================
    // Diretório de upload
    // ==========================
    $pasta = "../videos/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    // Nome único
    $novoNome = uniqid("video_") . "." . $extensao;
    $caminho  = $pasta . $novoNome;

    if (!move_uploaded_file($video["tmp_name"], $caminho)) {
        echo "Erro ao salvar o vídeo.";
        exit;
    }

    // ==========================
    // Inserção no banco
    // ==========================
    $sql = "INSERT INTO videos 
            (titulo, descricao, categoria, arquivo, data_envio)
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Erro na query.";
        exit;
    }

    $stmt->bind_param("ssss", $titulo, $descricao, $categoria, $novoNome);

    if ($stmt->execute()) {
        echo "✅ Vídeo enviado com sucesso!";
    } else {
        echo "Erro ao salvar no banco.";
    }

    $stmt->close();
    $conn->close();
}
?>
