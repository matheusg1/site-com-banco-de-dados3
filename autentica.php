<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once("conexao.php");
require_once("funcoes.php");
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
                $_SESSION['botaoLogin'] = $botaoLogin; 
                $numeroAleatorio = 5;
                $cpf = $_SESSION['usu_cpf'];
                $nomemat = $_SESSION['usu_nomemat'];
                $celular = $_SESSION['usu_celular'];
                $nascimento = $_SESSION['usu_nascimento'];

                if ($_SESSION['usu_tipo'] == 2) { //caso seja usuário comum, acontece update no tipo de tentativa

                    $sql = "UPDATE tentativa_acesso SET tent_tipo_aut=? ORDER BY tent_id DESC LIMIT 1"; 

                    if($stmt = mysqli_prepare($conexao, $sql)) {

                        mysqli_stmt_bind_param($stmt, "i", $param_tent_tipo_aut);
                        
                        $param_tent_tipo_aut = $numeroAleatorio;
                        
                        if(mysqli_stmt_execute($stmt)){

                            mysqli_commit($conexao);
                            mysqli_stmt_close($stmt);
                            
                        }
                    }
                }

                switch ($numeroAleatorio){

                    case 1:                                                 //3 primeiros dígitos cpf
                        $cpf1 = filter_input(INPUT_POST, 'cpf1');
                        
                        echo '<label for="cpf1">
                        3 primeiros números do cpf <input type="text" name="cpf1" id="cpf1" max="3" placeholder=" Digite os 3 primeiros números do seu CPF">';

                        if (obter3Primeiros($cpf) == $cpf1) {

                            $_SESSION['aut'] = true;
                            break;
                        }
                    case 2:
                        $cpf2 = filter_input(INPUT_POST, 'cpf2');           //3 últimos dígitos cpf

                        echo '<label for="cpf2">
                        3 últimos números do cpf <input type="text" name="cpf2" id="cpf2" max="3" placeholder=" Digite os 3 últimos números do seu CPF">';
                
                        if (obter3Ultimos($cpf) == $cpf2) {

                            $_SESSION['aut'] = true;
                        }

                        break;
                    case 3:                                             
                        $celular2 = filter_input(INPUT_POST, 'celular2');   //celular

                        echo '<label for="celularId2">
                        Celular <input type="text" name="celular2" id="celularId2" maxlength="11" placeholder="Digite o número do seu celular">';

                        if ($celular == $celular2) {
                            
                            $_SESSION['aut'] = true;
                        }

                        break;
                    case 4:                                                 //data de nascimento
                        $nascimento2 = filter_input(INPUT_POST, 'nascimento2');

                        echo '<label for="nascimentoId2">
                        Data de nascimento* <input type="date" name="nascimento2" id="nascimentoId2" max="<?php dataLimite()?>">';
                    
                        if ($nascimento == $nascimento2) {
                            
                            $_SESSION['aut'] = true;
                        }

                        break;

                    case 5:                                                 //nome materno

                        $nomemat2 = filter_input(INPUT_POST, 'nomemat2');

                        echo '<label for="nomemat2">
                        Nome materno <input type="text" name="nomemat2" id="nomemat2" placeholder="Digite o primeiro nome da sua mãe">';
                        
                        if (strtolower($nomemat) == strtolower($nomemat2)) {
                            
                            $_SESSION['aut'] = true;    
                        }
                    }

                if ($_SESSION['usu_tipo'] == 1) {                           //caso usuário seja tipo 1, autenticação é definida como "S"

                    $_SESSION['aut'] = true;
                }

                if (($botaoLogin) or $_SESSION['usu_tipo'] == 1) {          //caso o 2º botão de login seja apertado ou o usuário seja tipo 1

                    if ($_SESSION['aut']) {

                        $sql2 = "UPDATE tentativa_acesso SET tent_aut=? ORDER BY tent_id DESC LIMIT 1";
                        
                        if($stmt2 = mysqli_prepare($conexao, $sql2)){

                            mysqli_stmt_bind_param($stmt2, "s", $param_tent_aut);

                            $param_tent_aut = "S";

                            if(mysqli_stmt_execute($stmt2)){
                    
                                mysqli_commit($conexao);
                                mysqli_stmt_close($stmt2);
                                mysqli_close($conexao);
                                
                                switch ($_SESSION['usu_tipo']) {

                                    case 1:

                                        header("Location: dados_acesso_1.php");
                                        break;

                                    case 2:
                                        header("Location: dados_acesso_2.php");
                                }
                            }
                        }
                    }
                    else{

                        $_SESSION['aut'] = false;
                        
                        $sql2 = "UPDATE tentativa_acesso SET tent_aut=? ORDER BY tent_id DESC LIMIT 1";

                        if ($stmt2 = mysqli_prepare($conexao, $sql2)) {
                            
                            mysqli_stmt_bind_param($stmt2, "s", $param_tent_aut);
                            
                            $param_tent_aut = "N";
                            
                            if (mysqli_stmt_execute($stmt2)) {
                    
                                mysqli_commit($conexao);
                                mysqli_stmt_close($stmt2);
                                mysqli_close($conexao);
 
                                $_SESSION['msg'] = "<p class='status-bar-field alinhaCentro'>Dados incorretos</p>";
                        
                                header("Location: dados_acesso_2.php");
                            }
                        }
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
