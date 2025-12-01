<?php
// Conexão com o banco
$conn = new mysqli("localhost", "root", "1194viana@", "markzen");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Buscar vídeos da categoria "tutorial"
$sql = "SELECT id_video, titulo, url FROM videos WHERE categoria = 'tutorial'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Tutorial - Vídeos</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #000; /* fundo preto */
            color: #fff; /* texto branco */
            display: flex;
        }
        .sidebar {
            width: 25%;
            background-color: #2e004f; /* roxo escuro */
            overflow-y: scroll;
            height: 100vh;
            padding: 10px;
        }
        .sidebar h2 {
            text-align: center;
            color: #fff;
        }
        .video-list {
            list-style: none;
            padding: 0;
        }
        .video-list li {
            margin: 10px 0;
            padding: 10px;
            background-color: #4b0082; /* roxo */
            cursor: pointer;
            border-radius: 5px;
        }
        .video-list li:hover {
            background-color: #6a0dad;
        }
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #111;
            padding: 20px;
        }
        video {
            width: 80%;
            max-height: 70vh;
            border: 3px solid #fff;
            border-radius: 10px;
        }
        .fullscreen-btn {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #6a0dad;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .fullscreen-btn:hover {
            background-color: #9b30ff;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <button onclick="history.back()" 
        style="margin-top:20px; padding:10px 20px; background-color:#6a0dad; color:#fff; border:none; border-radius:5px; cursor:pointer;">
    Voltar
</button>

    <h2>Próximos Vídeos</h2>
    <ul class="video-list">
        <?php while($row = $result->fetch_assoc()): ?>
            <li onclick="playVideo('<?php echo $row['url']; ?>')">
                <?php echo $row['titulo']; ?>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<div class="main">
    <video id="videoPlayer" controls>
        <source src="" type="video/mp4">
        Seu navegador não suporta vídeo HTML5.
    </video>
    <button class="fullscreen-btn" onclick="toggleFullscreen()">Tela Cheia</button>
</div>

<script>
    function playVideo(url) {
        var player = document.getElementById('videoPlayer');
        player.src = url;
        player.play();
    }

    function toggleFullscreen() {
        var player = document.getElementById('videoPlayer');
        if (player.requestFullscreen) {
            player.requestFullscreen();
        } else if (player.webkitRequestFullscreen) { // Safari
            player.webkitRequestFullscreen();
        } else if (player.msRequestFullscreen) { // IE11
            player.msRequestFullscreen();
        }
    }
</script>

</body>
</html>
