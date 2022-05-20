<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
ob_start();
require_once("funcoes.php");

$botaoRegistrar = filter_input(INPUT_POST, 'botaoRegistrar');

if ($botaoRegistrar) {
    
    require_once 'conexao.php';
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    $dados["senha"] = password_hash($dados["senha"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario VALUES (null, ?, ?, ?, ?, ?, ?, ?, '2',  ?, ?)";
    
    if($stmt = mysqli_prepare($conexao, $sql)) {

        mysqli_stmt_bind_param($stmt, 'ssssiisss', $param_usu_nome, $param_usu_nascimento, $param_usu_nomemat, $param_usu_cpf, $param_usu_celular, $param_usu_fixo, $param_usu_endereco, $param_usu_login, $param_usu_senha);

        $param_usu_nome = $dados['nome'];
        $param_usu_nascimento = $dados['nascimento'];
        $param_usu_nomemat = $dados['nomemat'];
        $param_usu_cpf = $dados['cpf'];
        $param_usu_celular = $dados['celular'];
        $param_usu_fixo = $dados['fixo'];
        $param_usu_endereco = $dados['endereco'];
        $param_usu_login = $dados['login'];
        $param_usu_senha = $dados['senha'];

        if(mysqli_stmt_execute($stmt)){

            //comitar a transação
            mysqli_commit($conexao);

            // fecha o statement
            mysqli_stmt_close($stmt);
            
            // fecha a conexão com o Banco de Dados
            mysqli_close($conexao);

            // Se o usuário foi inserido com sucesso, então redireciono para a página principal.
            $_SESSION['msgcad'] = "Usuário cadastrado com sucesso";
            header("location: index.php");
        }
        else{

            $_SESSION['msg'] = "<p class='status-bar-field alinhaCentro'>Erro ao cadastrar o usuário</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - BD</title>
    <link rel="stylesheet" href="https://unpkg.com/98.css">
    <link href="folhaestilo1.css" rel="stylesheet">
    <link rel="icon" href="img/f1dd5233ac80be4.png">
</head>
<body>
    <div class="gradientao">
        <a href="index.php">Banco de dados</a>
        <nav>
            <ul>
                <li><a href="">Queries SQL</a></li>
                <li><a href="">Modelo de dados</a></li>
                <li><a href="">Cadastro</a></li>
            </ul>
        </nav>
    </div>
    <div class="window centraliza" style="width: 650px">
    <div class="title-bar">
        <div class="title-bar-text">Cadastro</div>
            <div class="title-bar-controls">
                <button aria-label="Minimize"></button>
                <button aria-label="Maximize"></button>
                <button aria-label="Close"></button>
            </div>
        </div>
    <div class="window-body">
    <?php
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
	?>
        <form action="" method="POST">
        
            <label for="nomeId">
                Nome* <input type="text" name="nome" id="nomeId" placeholder="Digite seu nome" autofocus> 
                
            <label for="nascimentoId">
                Data de nascimento* <input type="date" name="nascimento" id="nascimentoId" max="<?php dataLimite() ?>"required>

            <label for="nomeMatId" required>
                Nome materno* <input type="text" name="nomemat" id="nomeMatId" placeholder="Digite o nome da sua mãe" required>

            <label for="cpfId">
                CPF* <input type="text" name="cpf" id="cpfId" maxlength="11" placeholder="Digite seu número de cpf" required>

            <label for="celularId">
                Celular* <input type="text" name="celular" id="celularId" maxlength="11" placeholder="Digite seu número" required>

            <label for="fixoId">
                Telefone <input type="text" name="fixo" id="fixoId" maxlength="10" placeholder="Digite seu número">

            <label for="enderecoId">
                Endereço <input type="text" name="endereco" id="enderecoId" placeholder="Digite seu endereço completo">
 
            <label for="login">
                Login* <input type="text" value="" name="login" id="login" maxlength="15" placeholder="Crie seu login" required>

            <label for="senha">
                Senha* <input type="password" name="senha" id="senha" maxlength="15" placeholder="Crie sua senha" required><br>
                <div class="status-bar">
                    <p class="status-bar-field">Press F1 for help</p>
                    <p class="status-bar-field">CPU Usage: 99%</p>
                    <p class="status-bar-field">*Campos obrigatórios</p>
                </div>
                <button type="submit" name="botaoRegistrar" value="registrar">Registrar</button>
        </form>
    </div>
</div>
</body>
</html>