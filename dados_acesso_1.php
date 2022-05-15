<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once("conexao.php");

function mostraAutenticacao($x) {   //função que traduz os tipos de autenticação

    switch ($x) {

        case 1:                     

            $x = "3 primeiros dígitos do CPF";  //caso o tipo seja 1
            break;

        case 2:

            $x = "3 últimos dígitos do CPF";    //caso seja 2
            break;

        case 3:

            $x = "Número do celular";
            break;

        case 4:

            $x = "Data de nascimento";  //caso seja 4
            break;

        case 5:

            $x = "Nome materno";        //          5
            break;
        
        default:

            $x = "Não necessária";      // caso o usuário seja master == caso o valor do registro seja nulo
        
    }
    return $x;
}

/*function mostraAutenticacao($x) { 

    if ($x['tent_tipo_aut'] == ) {

        $x['tent_tipo_aut'] = "3 primeiros dígitos do CPF"; 
    }
    else if ($x['tent_tipo_aut'] == 2) {

        $x['tent_tipo_aut'] = "3 últimos dígitos do CPF";   //caso seja 2
    }
    else if ($x['tent_tipo_aut'] == 3) {

        $x['tent_tipo_aut'] = "Número do celular";          //caso seja 3
    }
    else if ($x['tent_tipo_aut'] == 4) {

        $x['tent_tipo_aut'] = "Data de nascimento";         //caso seja 4
    }
    else if ($x['tent_tipo_aut'] == 5) {
        
        $x['tent_tipo_aut'] = "Nome materno";               //          5
    }
    else if (!$x['tent_tipo_aut']){

        $x['tent_tipo_aut'] = "Não necessária";             // caso o usuário seja master == caso o valor do registro seja nulo
    }
    return $x['tent_tipo_aut'];
}*/

function autenticou($x) {   //função que mostra se autenticou ou não

    if ($x == 'S' or !$x) {

        return $x = "Sim";

    }
    else {

        return $x = "Não"; 
    }
}

function formataData($x) { //função que formata a data para um padrão mais convencional
    
    return date('d/m/Y',strtotime($x));

}

function Mostrar() {

    return "echo";
}

function mostraRegistro($x) { //tabela???

    echo "Login: " . $x['usu_login'] . "<br>";
    echo "Data: " . formataData($x['tent_data']) . "<br>";
    echo "Hora: " . $x['tent_hora'] . "<br>";
    echo "Autenticou: " . autenticou($x['tent_aut']) . "<br>";
    echo "Tipo de autenticação: " . mostraAutenticacao($x['tent_tipo_aut']) . "<br>";

    
}

if ($_SESSION['usu_tipo'] == 1) { // caso usuario seja tipo 1

	$_SESSION['aut'] = true; //autenticação é aprovada

	$query1 = "SELECT us.usu_login, ta.tent_data, ta.tent_hora, ta.tent_tipo_aut, ta.tent_aut FROM usuario AS us JOIN tentativa_acesso AS ta ON ta.tent_usu_id = us.usu_id"; 
	$add1 = mysqli_query($conexao, $query1);

	
}
	


if ($_SESSION['usu_tipo'] == 2) {

    $_SESSION['msg'] = "Área restrita";										//acesso negado
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
        <div class="window centraliza" style="width: 350px" >
            <div class="title-bar">
              <div class="title-bar-text">Registros</div>
              <div class="title-bar-controls">
                <button aria-label="Minimize"></button>
                <button aria-label="Maximize"></button>
                <button aria-label="Close"></button>
            </div>
        </div>
            <div class="window-body registros">
                <div>
            <p>
                <?php  
                if ($add1) {

                    while ($row_resultado = mysqli_fetch_assoc($add1)) {
            
                        mostraRegistro($row_resultado);
                        echo "<hr>";
                    }
                }
                ?>
            </p>
                </div>
                <a href='logout.php'><button type="submit" name="botaoLogout" value="botaoLogout"><?php echo "Deslogar" ?></button></a>
            </form>
        </div>
    </div>
</body>
</html>