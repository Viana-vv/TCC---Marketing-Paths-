<?php

session_start();
include'../php.config/config.php';
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");


$sql = "SELECT imagens FROM usuarios  WHERE id_usuario = ?  ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario );
$stmt->execute(); 
$pego = $stmt->get_result();

$sql = "SELECT imagens, nome FROM usuarios  WHERE id_usuario = ?  ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario );
$stmt->execute(); 
$uso = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> PDF - Marketing paths </title>
  <link rel="stylesheet" href="../CSS/pdf.css">
  <link rel="icon" href="../img/icone.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<style>
  
.btn{
  margin-bottom: 5px;
  width: 350px;
  height: 50px;
  font-size: large;
  border-radius: 20px;
  cursor: pointer;
  background-color: #5a3f91ff;
  color:rgb(255, 255, 255);
}

.btn:hover{
  background-color: #dce2b3;
  color: #2b2341ff;
}

i{
  color: #c3b3e2ff;
  transform: translateX(0px);
}

button{
  background-color: #8d1bffff;
  color: #ffffffff;
width: 80px;
height: 30px;
border-radius: 20px;
}
</style>

<body>
 <div class="navBar">
<div class="pesquisar">
  <form action="" method="get">
<input type="search" name="pesquisar" class="pesq" placeholder="Pesquisar..." 
value="<?php echo isset($_GET['pesquisar']) ? htmlspecialchars($_GET['  $row[titulo] ']) :''; ?>">
<button type="submit"><i class="bi bi-search"></i></button>
</form>
</div>


      <div class="nav1">
     <input type="checkbox" id="toggle">
      <label for="toggle" class="toggle">
         <?php
          if ($pego->num_rows > 0) {
            $row = $pego->fetch_assoc();
            if(!empty($row['imagens'])) 
             {
                 $ImagemBase64 = base64_encode($row['imagens']);
           
         echo '<img src="data:image/jpeg;base64,' . $ImagemBase64 . '" alt="foto do usuario aqui">';
            }else{
        echo '<img src="../img/usuario.jfif" alt="foto do usuario aqui">';
      }
    }else{
          echo '<img src="../img/usuario.jfif" alt="foto do usuario aqui">';
     
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
              echo '<li><img src="data:image/jpeg;base64,' . $ImagemBase64 . '" alt="" style="width: 50px; height: 50px; border-radius: 50%;">
                <p style="font-size: medium; color: #dce2b3;">'.$row['nome'] .'</p>
              </li>';
            } else{
              echo '<li><img src="../img/usuario.jfif" alt="" style="width: 50px; height: 50px; border-radius: 50%;"></li>';
            }

          }else{
            echo '<li><img src="../img/usuario.jfif" alt="" style="width: 50px; height: 50px; border-radius: 50%;"></li>';
          }
          ?>
                
            <li><a href="perfil.php"><i class="bi bi-person-circle"></i> Meu Perfil</a></li>
            <li><a href="../telas/duvidas.html"> <i class="bi bi-person-raised-hand"></i> Duvidas??</a></li>
           <li><a href="../telas/apresentacao.html"> <i class="bi bi-people-fill"></i> Sobre nós</a></li>
        
            <li><a href="https://wa.me/5511945931935"> <i class="bi bi-chat-left-dots"></i> Suporte</a></li>
           </ul>
        </div>
    </label>
    </div>

   
  </div><div style="display:flex;">
  <div class="left-guide">

    <a href="telapaga.php"  class="left-guide-container"
    style="background-size:cover; filter:grayscale(100%); transition:filter 0.3s ease;"
    onmouseover="this.style.filter='grayscale(0%)'"
    onmouseout="this.style.filter='grayscale(100%)'">
      📚
    </a>

    <div href="pdf.html" class="left-guide-container">
      <i class="bi bi-file-earmark-pdf" style="color:red; font-size:30px;"></i>
    </div>
        

    <a href="fornecedores.php" class="left-guide-container"
    style="background-size:cover; filter:grayscale(100%); transition:filter 0.3s ease;"
    onmouseover="this.style.filter='grayscale(0%)'"
    onmouseout="this.style.filter='grayscale(100%)'">🏢
    </a>

    <a href="chat.php" class="left-guide-container"
    style="background-size:cover; filter:grayscale(100%); transition:filter 0.3s ease;"
    onmouseover="this.style.filter='grayscale(0%)'"
    onmouseout="this.style.filter='grayscale(100%)'">
      ❤️
    </a>

  </div>
</div>


  <div style="width:200vh; height:auto; margin-left: 100px;">
    <header> PDFs</header>
   

<!-- ===================== PDFs AQUI ===================== -->
<?php
$pasta = "../pdfs/";
$pdfs = glob($pasta . "*.pdf");

if (empty($pdfs)) {
    echo "<p style='color:white;'>Nenhum PDF encontrado.</p>";
} else {
 echo "<div class='pdf-container'>";

    foreach ($pdfs as $pdf) {
        $nome = basename($pdf);

        echo "
        <div style='width:300px; background:#2b2341; padding:15px; border-radius:15px;'>
            <p style='color:#fff; font-size:16px; margin-bottom:10px;'>$nome</p>

            <iframe 
                src='$pdf'
                style='width:100%; height:200px; border:none; border-radius:10px; background:#fff;overflow:hidden;'>
          
                </iframe>

            <a href='$pdf' download 
               style='margin-top:10px; display:block; text-align:center; background:#5a3f91; padding:10px; border-radius:10px; color:white; text-decoration:none;'>
               Baixar PDF
            </a>
        </div>
        ";
    }

    echo "</div>";
}
?>
<!-- ===================================================== -->


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
