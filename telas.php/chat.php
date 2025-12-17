<?php
session_start();
include '../php.config/config.php';
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$id_usuario = $_SESSION['id_usuario'] ?? null;

$sql = "SELECT imagens FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$pego = $stmt->get_result();

$sql = "SELECT imagens, nome FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$uso = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CHAT - Marketing paths</title>
  <link rel="stylesheet" href="../CSS/estiloChat.css">
  <link rel="icon" href="../img/icone.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
 
</head>
<body>
 <div class="navBar">
   <div class="pesquisar">
     <form action="" method="get">
       <input type="search" name="pesquisar" class="pesq" placeholder="Pesquisar...">
       <button type="submit"><i class="bi bi-search"></i></button>
     </form>
   </div>

   <div class="nav1">
     <input type="checkbox" id="toggle">
     <label for="toggle" class="toggle">
       <?php
       if ($pego->num_rows > 0) {
         $row = $pego->fetch_assoc();
         if(!empty($row['imagens'])) {
           $ImagemBase64 = base64_encode($row['imagens']);
           echo '<img src="data:image/jpeg;base64,' . $ImagemBase64 . '" alt="foto do usuario">';
         } else {
           echo '<img src="../img/usuario.jfif" alt="foto do usuario">';
         }
       } else {
         echo '<img src="../img/usuario.jfif" alt="foto do usuario">';
       }
       ?>
       <span class="top_line common"></span>
       <span class="middle_line common"></span>
       <span class="bottom_line common"></span>
     </label>

     <div class="slide">
       <ul>
         <?php
         if ($uso->num_rows > 0) {
           $row = $uso->fetch_assoc();
           if(!empty($row['imagens'])) {
             $ImagemBase64 = base64_encode($row['imagens']);
             echo '<li><img src="data:image/jpeg;base64,' . $ImagemBase64 . '" style="width:50px;height:50px;border-radius:50%;">
                   <p style="font-size:medium;color:#dce2b3;">'.$row['nome'].'</p></li>';
           } else {
             echo '<li><img src="../img/usuario.jfif" style="width:50px;height:50px;border-radius:50%;"></li>';
           }
         } else {
           echo '<li><img src="../img/usuario.jfif" style="width:50px;height:50px;border-radius:50%;"></li>';
         }
         ?>
         <li><a href="perfil.php"><i class="bi bi-person-circle"></i> Meu Perfil</a></li>
         <li><a href="../telas/duvidas.html"><i class="bi bi-person-raised-hand"></i> Duvidas??</a></li>
         <li><a href="../telas/apresentacao.html"> <i class="bi bi-people-fill"></i> Sobre nós</a></li>
        
         <li><a href="https://wa.me/5511945931935"><i class="bi bi-chat-left-dots"></i> Suporte</a></li>
        
       </ul>
     </div>
   </div>
 </div>

 <div style="display:flex;">
   <div class="left-guide">
     <a href="telapaga.php" class="left-guide-container">📚</a>
     <a href="pdf.php" class="left-guide-container"><i class="bi bi-file-earmark-pdf" style="color:red;font-size:30px;"></i></a>
     <a href="fornecedores.php" class="left-guide-container">🏢</a>
     <div class="left-guide-container">❤️</div>
   </div>
 </div>

<div class="box">
   <header>Chat</header>
   <div class="chat-container">
     <div class="mensagens">
       <?php
       $sql = "SELECT c.id, c.id_usuario, c.mensagem, u.nome, u.imagens
               FROM chat_mensagens c
               JOIN usuarios u ON c.id_usuario = u.id_usuario
               WHERE c.comentario_id IS NULL
               ORDER BY c.data_envio ASC";
       $comentarios = $conn->query($sql);

       if ($comentarios && $comentarios->num_rows > 0) {
         while ($msg = $comentarios->fetch_assoc()) {
           $isUser = ($msg['id_usuario'] == $id_usuario);
           $classe = $isUser ? "mensagem direita" : "mensagem esquerda";

           if (!empty($msg['imagens'])) {
             $ImagemBase64 = base64_encode($msg['imagens']);
             $foto = '<img src="data:image/jpeg;base64,' . $ImagemBase64 . '" class="foto">';
           } else {
             $foto = '<img src="../img/usuario.jfif" class="foto">';
           }

           echo '<div class="'.$classe.'">
                   '.$foto.'<div class="conteudo">
                     <span class="nome">'.$msg['nome'].'</span>
                     <p>'.$msg['mensagem'].'</p>';

           // Respostas
           $sqlResp = "SELECT r.id, r.id_usuario, r.mensagem, u.nome, u.imagens
                       FROM chat_mensagens r
                       JOIN usuarios u ON r.id_usuario = u.id_usuario
                       WHERE r.comentario_id = ".$msg['id']." 
                       ORDER BY r.data_envio ASC";
           $respostas = $conn->query($sqlResp);

           while ($resp = $respostas->fetch_assoc()) {
             $fotoResp = !empty($resp['imagens'])
               ? '<img src="data:image/jpeg;base64,'.base64_encode($resp['imagens']).'" class="foto">'
               : '<img src="../img/usuario.jfif" class="foto">';

             echo '<div class="resposta">
                     '.$fotoResp.'
                     <span class="nome">'.$resp['nome'].'</span>
                     <p>'.$resp['mensagem'].'</p>
                   </div>';
           }

           // Formulário para resposta
           echo '<form class="resposta-form" method="post" action="../phpFuncions/responder.php">
                   <input type="hidden" name="comentario_id" value="'.$msg['id'].'">
                   <textarea name="mensagem" placeholder="Responder este comentário..." required></textarea>
                   <button type="submit">Enviar</button>
                 </form>';

           echo '</div></div>';
         }
       } else {
         echo "<p style='color:white;'>Nenhuma mensagem encontrada.</p>";
       }
       ?>
     </div>
   </div>

   <!-- Formulário de envio de mensagens -->
   <form class="chat-input" method="post" action="../phpFuncions/enviar.php">
     <input type="text" name="mensagem" placeholder="Digite sua mensagem..." required>
     <button type="submit">Enviar</button>
   </form>
</div>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
