<?php
date_default_timezone_set('America/Sao_Paulo');

function preparaEnviaFecha($sql, $tipo, $param_id) {

    require("conexao.php");

    $conexao = mysqli_connect($host, $user, $pass, $banco); // pq refiz a conexao? nao sei

    if ($stmt = mysqli_prepare($conexao, $sql)) {

        mysqli_stmt_bind_param($stmt, $tipo, $param_id);

        if(mysqli_stmt_execute($stmt)) {

            mysqli_commit($conexao);
            mysqli_stmt_close($stmt);
            mysqli_close($conexao);
            return true;
        }
    }
    
}

function dataLimite(){ //função que limita a data de nascimento

    echo date('Y-m-d',strtotime('-120 month', strtotime(str_replace("/", "-", (date('d-m-Y')))))); // 10 anos
}

function mostraAutenticacao($x) {               //função que traduz os tipos de autenticação

    switch ($x) {

        case 1:                     
            $x = "3 primeiros dígitos do CPF";  //caso o tipo seja  1
            break;
        case 2:
            $x = "3 últimos dígitos do CPF";    //                  2
            break;
        case 3:
            $x = "Número do celular";           //                  3
            break;
        case 4:
            $x = "Data de nascimento";          //                  4
            break;
        case 5:
            $x = "Nome materno";                //                  5
            break;
        default:
            $x = "Não necessária";              // caso o usuário seja master == caso o valor do registro seja nulo
        
    }
    return $x;
}

function autenticou($x) {                       //função que mostra se autenticou ou não

    if ($x == 'S') {
        return $x = "Sim";

    }
    else {
        return $x = "Não"; 
    }
}

function formataData($x) {                      //função que formata a data para um padrão mais convencional
    
    return date('d/m/Y',strtotime($x));

}

function mostraRegistro($x) { 

    echo "Login: " . $x['usu_login'] . "<br>";
    echo "Data: " . formataData($x['tent_data']) . "<br>";
    echo "Hora: " . $x['tent_hora'] . "<br>";
    echo "Autenticou: " . autenticou($x['tent_aut']) . "<br>";
    echo "Tipo de autenticação: " . mostraAutenticacao($x['tent_tipo_aut']) . "<br>";
}

function obter3Primeiros($x) { //obter 3 primeiros valores da string 

    return substr($x, 0, -8);
}

function obter3Ultimos($x) { //obter 3 últimos valores da string 

    return substr($x, -3);
}

?>
