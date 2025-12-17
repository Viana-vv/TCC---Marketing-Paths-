<?php
session_start();

include'../php.config/config.php';
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$id_usuario = $_SESSION['id_usuario']; // pega da sessão

// Corrigido para trazer todos os campos que você usa
$sql = "SELECT nome, telefone, email, imagens, rua, bairro, estado FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Perfil Marketing paths</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../CSS/perfil.css">
    <link rel="icon" href="../img/icone.png">
</head>

<body>
    <form action="../phpFuncions/AtualizarUsuario.php" method="post" enctype="multipart/form-data">
        <div class="caixa">
            <div class="caixa1">
                <ul>
                    <li><h1>Seus Dados</h1></li>
                    <li>
                        <?php
                        if ($result->num_rows > 0) {
                            if ($row = $result->fetch_assoc()) {
                                if (!empty($row['imagens'])) {
                                    $ImagemBase64 = base64_encode($row['imagens']);
                                    echo '<p style="justify-content: center; align-items:center;">Trocar Imagem</p>';
                                    echo '<label for="fileInput">';
                                    echo '<input type="file" id="fileInput" name="imagens" onchange="VerImage()" class="form-control" style="visibility: hidden;">';
                                    echo '<img id="Imagem" src="data:image/jpeg;base64,' . $ImagemBase64 . '" class="imagemusuario">';
                                    echo '<i class="bi bi-pencil-square"></i>';
                                    echo '</label>';
                                } else {
                                    echo '<p style="justify-content: center; align-items:center;">Trocar Imagem</p>';
                                    echo '<label for="fileInput">';
                                    echo '<input type="file" id="fileInput" name="imagens" onchange="VerImage()" class="form-control" style="visibility: hidden;">';
                                    echo '<img id="Imagem" src="../img/usuario.jfif" class="imagemusuario">';
                                    echo '<i class="bi bi-pencil-square"></i>';
                                    echo '</label>';
                                }

                                echo '<li><p>Nome</p>';
                                echo '<fieldset disabled>';
                                echo '<div class="mb-3">';
                                echo '<input type="text" id="disabledTextInput" class="form-control" placeholder="' . $row['nome'] . '">';
                                echo '</div>';
                                echo '</fieldset></li>';

                                echo '<li><p>Email</p>';
                                echo '<fieldset disabled>';
                                echo '<div class="mb-3">';
                                echo '<input type="text" id="disabledTextInput" class="form-control" placeholder="' . $row['email'] . '">';
                                echo '</div>';
                                echo '</fieldset></li>';

                                echo '<li><p>Telefone</p>';
                                echo '<div class="input-group flex-nowrap">';
                                echo '<input name="telefone" type="number" class="form-control" placeholder="' . $row['telefone'] . '" aria-label="Username" aria-describedby="addon-wrapping">';
                                echo '</div></li>';

                                echo '<li><div class="container text-center"><div class="row align-items-center">';
                                echo '<div class="col-md-4"><p>Rua</p><div class="input-group flex-nowrap">';
                                echo '<input name="rua" type="text" class="form-control" placeholder="' . $row['rua'] . '" aria-label="Username" aria-describedby="addon-wrapping">';
                                echo '</div></div>';

                                echo '<div class="col-md-4"><p>Bairro</p><div class="input-group flex-nowrap">';
                                echo '<input type="text" class="form-control" placeholder="' . $row['bairro'] . '" aria-label="Username" aria-describedby="addon-wrapping" name="bairro">';
                                echo '</div></div>';

                                $estados = [
                                    "AC" => "Acre","AL" => "Alagoas","AP" => "Amapá","AM" => "Amazonas","BA" => "Bahia",
                                    "CE" => "Ceará","DF" => "Distrito Federal","ES" => "Espírito Santo","GO" => "Goiás",
                                    "MA" => "Maranhão","MT" => "Mato Grosso","MS" => "Mato Grosso do Sul","MG" => "Minas Gerais",
                                    "PA" => "Pará","PB" => "Paraíba","PR" => "Paraná","PE" => "Pernambuco","PI" => "Piauí",
                                    "RJ" => "Rio de Janeiro","RN" => "Rio Grande do Norte","RS" => "Rio Grande do Sul",
                                    "RO" => "Rondônia","RR" => "Roraima","SC" => "Santa Catarina","SP" => "São Paulo",
                                    "SE" => "Sergipe","TO" => "Tocantins"
                                ];

                                echo '<div class="col-md-4"><p>Estado</p><select name="estado" class="form-control">';
                                echo '<option value="">Selecione um estado</option>';
                                foreach ($estados as $sigla => $nome_estado) {
                                    $selecionado = ($row['estado'] == $sigla) ? 'selected' : '';
                                    echo "<option value=\"$sigla\" $selecionado>$nome_estado</option>";
                                }
                                echo '</select></div></div></div></li>';

                                echo '<li><button type="submit" class="btn btn-success">Editar</button></li>';
                                echo '</form>';
?>
<li>
                              <button type="submit" class="btn btn-danger"  onclick="window.history.go(-1)">Sair</button>
                              </li>
                              </ul>
<?php                            } else {
                                echo '<input type="text" id="disabledTextInput" class="form-control" placeholder="Não encontrado">';
                                echo '<div class="container text-center"><div class="row align-items-center"><div class="col-md-4">';
                                echo '<a href="login.html">Login</a>';
                            }
                        }
                        ?>
            </div>
            <div class="caixa2">
                <img src="../img/icone-inteiro.png">
            </div>
        </div>
    </form>

    <script>
        function VerImage() {
            var input = document.getElementById('fileInput');
            var preview = document.getElementById('Imagem');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
