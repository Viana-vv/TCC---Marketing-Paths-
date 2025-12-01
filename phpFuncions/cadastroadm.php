<?php
// Iniciar a sessão e exibir os dados recebidos via POST 
session_start();
include'../php.config/config.php';
// Dados recebidos via POST
$email = $_POST['email'];
$senha = $_POST['senha'];

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);


if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
echo json_encode(["message" => "Email invalido"]);
header("Location: ../administracao/cadastroadm.html");
exit();
}

$sql = " SELECT  email FROM adm WHERE email = ?  ";
$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $email );
$stmt->execute();
$result = $stmt->get_result();

if( $result->num_rows > 0 ){
    $_SESSION['erro_cadastro'] = "Erro usuario existente";
    header('Location:../administracao/cadastroadm.html');
 exit();

}
else{
// SQL para inserir os dados na tabela
$sql = "INSERT INTO adm (email, senha) VALUES
(?, ?)";
$stmt = $conn->prepare($sql);

if(!$stmt){
  die("ERRO" . $stmt->error);
}

$stmt->bind_param("ss",  $email, $senha_hash);
$sucesso = $stmt->execute();

if($sucesso) {
    header('Location: ../telas/login.html');
    exit();

} else {
  $_SESSION['erro_cadastro'] = "Erro ao cadastrar usuário!." . $stmt->error;
  header('Location: ../administracao/cadastroadm.html');
  exit();
  }
}

// Fechar conexões
$stmt->close();
$conn->close();
?>