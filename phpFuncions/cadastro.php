<?php
// Iniciar a sessão e exibir os dados recebidos via POST 
session_start();

include'../php.config/config.php';

// Dados recebidos via POST
$nome = $_POST['nome'];
$telefone =preg_replace('/\D/','', $_POST['telefone']);
$email = $_POST['email'];
$senha = $_POST['senha'];

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);


if(!is_numeric($telefone)){
   header('Location: ../telas/cadastro.html');
      exit();
}


if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
echo json_encode(["message" => "Email invalido"]);
header("Location: ../telas/cadastro.html");
exit();
}

$sql = " SELECT nome,telefone, email FROM usuarios WHERE nome = ? AND telefone = ?  AND  email = ?  ";
$stmt = $conn->prepare($sql);

$stmt->bind_param("sss", $nome, $telefone, $email );
$stmt->execute();
$result = $stmt->get_result();

if( $result->num_rows > 0 ){
    header('Location: ../telas/cadastro.html');
 exit();
}
else{
// SQL para inserir os dados na tabela
$sql = "INSERT INTO usuarios (nome, telefone,email, senha) VALUES
(?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if(!$stmt){
  die("ERRO" . $stmt->error);
}

$stmt->bind_param("ssss", $nome, $telefone, $email, $senha_hash);
$sucesso = $stmt->execute();

if($sucesso) {
    header('Location: ../telas/login.html');
    exit();

} else {
  header('Location: ../telas/cadastro.html');
  exit();
  }
}

// Fechar conexões
$stmt->close();
$conn->close();
?>