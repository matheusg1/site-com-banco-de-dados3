<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once("conexao.php");
require_once("funcoes.php");
switch ($_SESSION['usu_tipo']) {

    case 1:
        $_SESSION['aut'] = true;
        $query = "SELECT us.usu_login, ta.tent_data, ta.tent_hora, ta.tent_tipo_aut, ta.tent_aut FROM usuario AS us JOIN tentativa_acesso AS ta ON ta.tent_usu_id = us.usu_id"; 
        $add = mysqli_query($conexao, $query);
        break;
    default:
        $_SESSION['msg'] = "Área restrita";
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - BD</title>
    <link rel="stylesheet" href="https://unpkg.com/98.css">
    <link rel="stylesheet" href="folhaestilo1.css">
    <link rel="icon" href="img/f1dd5233ac80be4.png">
</head>
<body>
    <div class="gradientao">
        <a href="index.php">Banco de dados</a>
        <nav>
            <ul>
                <li><a href="" >Queries SQL</a></li>
                <li><a href="" >Modelo de dados</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
            </ul>
        </nav>
    </div>
        <div class="window centraliza" style="width: 650px">
            <div class="title-bar">
              <div class="title-bar-text">Registros</div>
              <div class="title-bar-controls">
                <button aria-label="Minimize"></button>
                <button aria-label="Maximize"></button>
                <button aria-label="Close"></button>
            </div>
        </div>
            <div class="window-body">
                <?php
                if ($add) {

                    while ($row_resultado = mysqli_fetch_assoc($add)) {

                        echo "<p class='registros'>";
                        mostraRegistro($row_resultado);
                        echo "<hr>";
                    }
                }
                ?>
                </p>
            </div>
                <a href='logout.php'><button type="submit" name="botaoLogout" value="botaoLogout"><?php echo "Deslogar" ?></button></a>
    </div>
</body>
</html>