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
  <title> Fornecedores - Marketing paths </title>
      <link rel="stylesheet" href="../CSS/home.css">
    <link rel="icon" href="../img/icone.png">
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<style>
  .grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
  padding: 20px 40px;
}

.card {
  
     background: linear-gradient(to right, #000000, #423353ff);
  border-radius: 10px;
  padding: 20px;
  color: white;
  border: 1px solid #333;
  transition: 0.2s;
}

.card:hover {
  transform: translateY(-4px);
  border-color: #ffffffff;
}

.card h3 {
  margin: 0 0 10px 0;
  color: white;
  font-weight: 600;
}

.card a {
  color: #4da3ff;
  text-decoration: none;
  font-size: 15px;
}

.card a:hover {
  text-decoration: underline;
}

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
                <p style="   font-size: medium; color: #dce2b3;" >'.$row['nome'] .'</p>
                
              </li>';
            } else{
              echo '<li><img src="../img/usuario.jfif" alt="" style="width: 50px; height: 50px; border-radius: 50%;"></li>';
            }

          }else{
                   echo '<li><img src="../img/usuario.jfif" alt="" style="width: 50px; height: 50px; border-radius: 50%;"></li>';
       
          }
          ?>
            <p style="   font-size: medium; color: #c4b3e2ff;" ></p>
                
            <li><a href="perfil.php"><i class="bi bi-person-circle"></i> Meu Perfil</a></li>
                <li><a href="../telas/duvidas.html"> <i class="bi bi-person-raised-hand"></i> Duvidas??</a></li>
                <li><a href="apresentação.html"> <i class="bi bi-people-fill"></i> Sobre nós</a></li>
                <li><a href="Suporte.html"> <i class="bi bi-chat-left-dots"></i> Suporte</a></li>
            <li><a href="" style="font-size: x-small;"> <i class="bi bi-book-half"></i> Termos de politica de privacidade</a></li>
         </ul>
        </div>
    </label>
    </div>

   
  </div><div style="display:flex;">
  <div class="left-guide">

    <a href="telapaga.php" class="left-guide-container"
    style="background-size:cover; filter:grayscale(100%); transition:filter 0.3s ease;"
         onmouseover="this.style.filter='grayscale(0%)'"
         onmouseout="this.style.filter='grayscale(100%)'"
    >
      📚
        </a>

         <a href="pdf.php" class="left-guide-container">
      <i class="bi bi-file-earmark-pdf" style="color:red; font-size:30px;"
         ></i>
    </a>
        

    <div href="fornecedores.html" class="left-guide-container"
         >🏢
        </div>

    <a href="chat.php" class="left-guide-container" style="background-size:cover; filter:grayscale(100%); transition:filter 0.3s ease;"
         onmouseover="this.style.filter='grayscale(0%)'"
         onmouseout="this.style.filter='grayscale(100%)'">
      ❤️
    </a>

  </div>
</div>


  <div style=" width:200vh; height:auto; margin-left: 70px;">
    <header> Fornecedores</header>
   <!-- parte dos fornecedores, substituindo os links falsos por reais -->
<h2 style="margin-left:20px;margin-top:40px;color:white; transform: translateX(20px);">Eletrônicos</h2>
<div class="grid-container">
  <div class="card">
    <h3>1 — DL Eletrônicos</h3>
    <p><a href="https://www.dl.com.br/" target="_blank">DL Eletrônicos (site oficial)</a></p>
  </div>
  <div class="card">
    <h3>2 — Pauta Distribuidora</h3>
    <p><a href="https://www.pautadistribuidora.com.br/" target="_blank">Pauta Distribuidora — TI e informática</a></p>
  </div>
  <div class="card">
    <h3>3 — Kalunga Distribuição</h3>
    <p><a href="https://www.kalunga.com.br/" target="_blank">Kalunga — papelaria e eletrônicos</a></p>
  </div>
</div>

<h2 style="margin-left:20px;margin-top:40px;color:white;transform: translateX(20px);">Moda</h2>
<div class="grid-container">
  <div class="card">
    <h3>4 — Atacadão do Brás</h3>
    <p><a href="https://www.atacadaodobras.com/" target="_blank">Atacadão do Brás (marketplace atacado)</a></p>
  </div>
  <div class="card">
    <h3>5 — Luz da Moda Atacado</h3>
    <p><a href="https://atacado.luzdamoda.com.br/" target="_blank">Luz da Moda Brás</a></p>
  </div>
  <div class="card">
    <h3>6 — Allice Tricot</h3>
    <p><a href="https://allicetricot.com.br/" target="_blank">Allice Tricot — fabricante de tricô no atacado</a></p>
  </div>
  <div class="card">
    <h3>7 — O Rei do Brás</h3>
    <p><a href="https://www.oreidobras.com.br/" target="_blank">O Rei do Brás – roupas e acessórios atacado</a></p>
  </div>
</div>

<h2 style="margin-left:20px;margin-top:40px;color:white;transform: translateX(20px);">Acessórios / Variedades</h2>
<div class="grid-container">
  <div class="card">
    <h3>8 — Fornecedores Brás (listagem)</h3>
    <p><a href="https://bras.app/lista-de-fornecedores-de-roupas-brasapp/" target="_blank">Lista de fornecedores – Bras.App</a></p>
  </div>
  <div class="card">
    <h3>9 — Fábricas.Moda</h3>
    <p><a href="https://fabricas.moda/" target="_blank">Fábricas.Moda – fabricantes atacado de roupa</a></p>
  </div>
  <div class="card">
    <h3>10 — Bras.App</h3>
    <p><a href="https://bras.app/" target="_blank">Bras.App – catálogo digital do Brás</a></p>
  </div>
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
