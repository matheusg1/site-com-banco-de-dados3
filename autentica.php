<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once("conexao.php");

function obter3Primeiros($x) { //obter 3 primeiros valores da string 

    return substr($x, 0, -8);
}

function obter3Ultimos($x) { //obter 3 últimos valores da string 

    return substr($x, -3);
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
        <div class="window centraliza" style="width: 530px">
            <div class="title-bar">
              <div class="title-bar-text">Autenticação</div>
              <div class="title-bar-controls">
                <button aria-label="Minimize"></button>
                <button aria-label="Maximize"></button>
                <button aria-label="Close"></button>
              </div>
            </div>
            <div class="window-body">
                <form action="" method="POST">

                <?php
                $botaoLogin = filter_input(INPUT_POST, 'botaoLogin');
                $_SESSION['botaoLogin'] = $botaoLogin; //variável usada na página dados.acesso
                $numeroAleatorio = 5;
                $cpf = $_SESSION['usu_cpf'];
                $nomemat = $_SESSION['usu_nomemat'];
                $celular = $_SESSION['usu_celular'];
                $nascimento = $_SESSION['usu_nascimento'];

                $query1 = "UPDATE tentativa_acesso SET tent_tipo_aut ='" .$numeroAleatorio. "' ORDER BY tent_id DESC LIMIT 1"; // add chave primária do usuário na tentativa;
				$add1 = mysqli_query($conexao, $query1);
                
                if ($numeroAleatorio == 1) { //3 primeiros dígitos cpf

                    $cpf1 = filter_input(INPUT_POST, 'cpf1');
                    
                    echo '<label for="cpf1">
                    3 primeiros números do cpf <input type="text" name="cpf1" id="cpf1" max="3" placeholder=" Digite os 3 primeiros números do seu CPF">';
                    
                    if (obter3Primeiros($cpf) == $cpf1) {

                        $_SESSION['aut'] = true;
                        
                    }
                }
                else if ($numeroAleatorio == 2) { //3 últimos dígitos cpf
                    
                    $cpf2 = filter_input(INPUT_POST, 'cpf2');

                    echo '<label for="cpf2">
                    3 últimos números do cpf <input type="text" name="cpf2" id="cpf2" max="3" placeholder=" Digite os 3 últimos números do seu CPF">';
            
                    if (obter3Ultimos($cpf) == $cpf2) {

                        $_SESSION['aut'] = true;
                    }
                }
                else if ($numeroAleatorio == 3) { //celular

                    $celular2 = filter_input(INPUT_POST, 'celular2');

                    echo '<label for="celularId2">
                    Celular <input type="text" name="celular2" id="celularId2" maxlength="11" placeholder="Digite o número do seu celular">';

                    if ($celular == $celular2) {
                        
                        $_SESSION['aut'] = true;
                    }
                }
                else if ($numeroAleatorio == 4) { //data de nascimento

                    $nascimento2 = filter_input(INPUT_POST, 'nascimento2');

                    echo '<label for="nascimentoId2">
                    Data de nascimento* <input type="date" name="nascimento2" id="nascimentoId2" max="<?php dataLimite()?>">';
                
                    if ($nascimento == $nascimento2) {
                        
                        $_SESSION['aut'] = true;
                    }
                }
                else if ($numeroAleatorio == 5) {  //nome materno

                    $nomemat2 = filter_input(INPUT_POST, 'nomemat2');

                    echo '<label for="nomemat2">
                    Nome materno <input type="text" name="nomemat2" id="nomemat2" placeholder="Digite o primeiro nome da sua mãe">';
                    
                    if (strtolower($nomemat) == strtolower($nomemat2)) {
                        
                        $_SESSION['aut'] = true;    
                    }
                }
                if ($botaoLogin) { // usuário 2

                    if ($_SESSION['aut']) {

                        $query2 = "UPDATE tentativa_acesso SET tent_aut='S' ORDER BY tent_id DESC LIMIT 1";
                        $add2 = mysqli_query($conexao, $query2);

                        header("Location: dados_acesso_2.php");
                    }
                    else{

                        $_SESSION['aut'] = false;
                        
                        $query2 = "UPDATE tentativa_acesso SET tent_aut='N' ORDER BY tent_id DESC LIMIT 1";
                        $add2 = mysqli_query($conexao, $query2);

                        $_SESSION['msg'] = "<p class='status-bar-field alinhaCentro'>Dados incorretos</p>";
                        
                        header("Location: dados_acesso_2.php");
                    }
                }
                ?>
                        <br>
                        <button type="submit" name="botaoLogin" value="botaoLogin">Entrar</button>
                </form>
            </div>
        </div>
</body>
</html>
