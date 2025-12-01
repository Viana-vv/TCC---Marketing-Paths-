<?php

session_start();
include'../php.config/config.php';
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");



$sql = "SELECT imagens, nome FROM usuarios WHERE id_usuario = ? AND nome = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id_usuario, $nome);
$stmt->execute();
$uso = $stmt->get_result();




?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Home - Marketing paths </title>
      <link rel="stylesheet" href="../CSS/home.css">
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

    <div  class="left-guide-container"
    
    >
      📚
        </div>

         <a href="pdf.php" class="left-guide-container">
      <i class="bi bi-file-earmark-pdf" style="color:red; font-size:30px;"
         ></i>
    </a>
        

    <a href="fornecedores.php" class="left-guide-container"
         style="background-size:cover; filter:grayscale(100%); transition:filter 0.3s ease;"
         onmouseover="this.style.filter='grayscale(0%)'"
         onmouseout="this.style.filter='grayscale(100%)'">🏢
    </a>

    <a href="chat.php" class="left-guide-container" style="background-size:cover; filter:grayscale(100%); transition:filter 0.3s ease;"
         onmouseover="this.style.filter='grayscale(0%)'"
         onmouseout="this.style.filter='grayscale(100%)'">
      ❤️
    </a>

  </div>
</div>


  <div style=" width:200vh; height:auto; margin-left: 70px;">
    <header> Bem-Vindo  
<?php
echo $nome;
?>

    </header>
    <div class="center-container">
<a href="tutorial.php" class="tutorial">
  <div>
    <h1>Tutorial</h1>
    <p>Este bloco serve para orientar o usuário sobre como utilizar os cursos e entender a estrutura do site. 
       Ele pode conter instruções passo a passo, dicas de navegação e exemplos práticos para facilitar o aprendizado.</p>
  </div>
</a>

<a href="estrategia-marketing.html" class="areaCursos">
  <div>
    <h1>Estratégia de marketing</h1>
    <p>Aprenda a planejar e executar ações que posicionam sua marca de forma competitiva no mercado.</p>
  </div>
</a>

<a href="comunicacao-conteudo.html" class="areaCursos">
  <div>
    <h1>Comunicação e conteúdo</h1>
    <p>Entenda como criar mensagens claras e conteúdos relevantes para engajar seu público-alvo.</p>
  </div>
</a>

<a href="empreendedorismo-negocios.html" class="areaCursos">
  <div>
    <h1>Empreendedorismo e negócios</h1>
    <p>Desenvolva habilidades para iniciar e gerir empresas com foco em inovação e sustentabilidade.</p>
  </div>
</a>

<a href="etica-legislacao.html" class="areaCursos">
  <div>
    <h1>Ética e legislação</h1>
    <p>Conheça princípios éticos e normas legais que orientam práticas responsáveis no marketing.</p>
  </div>
</a>

<a href="desenvolvimento-pessoal.html" class="areaCursos">
  <div>
    <h1>Desenvolvimento pessoal</h1>
    <p>Invista em autoconhecimento e competências que fortalecem sua carreira e relações profissionais.</p>
  </div>
</a>

<a href="analise-metricas.html" class="areaCursos">
  <div>
    <h1>Análise de métricas</h1>
    <p>Aprenda a interpretar dados e indicadores para medir resultados e otimizar estratégias.</p>
  </div>
</a>

<a href="tendencias-inovacao.html" class="areaCursos">
  <div>
    <h1>Tendências e inovação</h1>
    <p>Descubra novidades e tecnologias que estão transformando o cenário do marketing moderno.</p>
  </div>
</a>

<a href="experiencia-compra.html" class="areaCursos">
  <div>
    <h1>Experiência de compra</h1>
    <p>Entenda como oferecer jornadas de consumo mais agradáveis e memoráveis para seus clientes.</p>
  </div>
</a>

<a href="posicionamento-diferenciacao.html" class="areaCursos">
  <div>
    <h1>Posicionamento e diferenciação</h1>
    <p>Aprenda a destacar sua marca no mercado com propostas únicas e relevantes.</p>
  </div>
</a>

<a href="produto-oferta.html" class="areaCursos">
  <div>
    <h1>Produto e oferta</h1>
    <p>Explore estratégias para criar e apresentar produtos que atendam às necessidades do consumidor.</p>
  </div>
</a>

<a href="psicologia-consumo.html" class="areaCursos">
  <div>
    <h1>Psicologia do consumo</h1>
    <p>Compreenda os fatores emocionais e comportamentais que influenciam decisões de compra.</p>
  </div>
</a>

<a href="marketing-multicanal.html" class="areaCursos">
  <div>
    <h1>Marketing multicanal</h1>
    <p>Aprenda a integrar diferentes canais de comunicação para ampliar o alcance da sua marca.</p>
  </div>
</a>

<a href="planejamento-execucao.html" class="areaCursos">
  <div>
    <h1>Planejamento e execução</h1>
    <p>Domine técnicas para organizar e implementar campanhas de forma eficiente e estratégica.</p>
  </div>
</a>


    </div>
  </div>
</div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
