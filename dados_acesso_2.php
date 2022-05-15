<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once("conexao.php");
if ($_SESSION['usu_tipo'] == 2) { // caso usuario seja tipo 1

	$_SESSION['aut'] = true; //autenticação é aprovada

	$query1 = "SELECT us.usu_login, ta.tent_data, ta.tent_hora, ta.tent_tipo_aut, ta.tent_aut FROM usuario AS us JOIN tentativa_acesso AS ta ON ta.tent_usu_id = us.usu_id"; 

	$add1 = mysqli_query($conexao, $query1);

}

if(!empty($_SESSION['usu_id'] && $_SESSION['aut'] == true)){ //caso haja algum usuário na sessão e a autenticação seja aprovada

	echo "Olá ".$_SESSION['usu_nome'].", Bem vindo <br>";						//acesso bem-sucedido
	echo "<a href='logout.php'>Sair</a>";

}

if ($_SESSION['usu_tipo'] == 2) {
 
    echo "Nome " . $_SESSION['usu_nome'] . "<br>";
    echo "nascimento " . $_SESSION['usu_nascimento'] . "<br>";
    echo "Nome materno " . $_SESSION['usu_nomemat'] . "<br>";
    echo "CPF " . $_SESSION['usu_cpf'] . "<br>";
    echo "Celular " . $_SESSION['usu_celular'] . "<br>";
    echo "Fixo " . $_SESSION['usu_fixo'] . "<br>";
    echo "Endereço " . $_SESSION['usu_endereco'] . "<br>";
    echo "Login " . $_SESSION['usu_login'] . "<br>";

	if ($_SESSION['botaoLogin'] == null) { //caso o usuario seja tipo 2 e o botao nao foi apertado
			
		$_SESSION['msg'] = "Área restrita";										//acesso negado
		header("Location: index.php");	
	}
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
              <div class="title-bar-text">Login</div>
              <div class="title-bar-controls">
                <button aria-label="Minimize"></button>
                <button aria-label="Maximize"></button>
                <button aria-label="Close"></button>
              </div>
            </div>
            <div class="window-body">

            <a href='logout.php'><button type="submit" name="botaoLogout" value="botaoLogout"><?php echo "Deslogar" ?></button></a>
                </form>
            </div>
        </div>
</body>
</html>
<?php



/* Tipos de autenticação
1 - 3 primeiros dígitos do CPF
2 - 3 últimos dígitos do CPF
3 - Número do celular
4 - Data de nascimento
5 - Nome materno

*/
?>

</html>