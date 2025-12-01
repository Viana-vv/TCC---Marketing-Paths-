<?php
// Dados da conexão
$servidor = "localhost";       // servidor MySQL
$usuario  = "root";            // usuário do banco
$senha    = "1194viana@";      // senha do usuário
$banco    = "markzen";         // nome do banco de dados

// Criar conexão entre PHP e MySQL
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verificar se houve erro
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Configurações adicionais
date_default_timezone_set('America/Sao_Paulo'); // fuso horário
mysqli_set_charset($conn, "utf8mb4");           // charset para acentos
error_reporting(0);                             // desliga mensagens de erro
ini_set('display_errors', 0);

?>
