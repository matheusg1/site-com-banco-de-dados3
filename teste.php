<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
require_once("funcoes.php"); // require mostra erro fatal quando o arquivo não é encontrado

echo '<form action="" method="POST">';
echo '<button type="submit" name="btnApagaConta">Apagar conta</button>';
echo '</form>';

$btnApagaConta = filter_input(INPUT_POST, 'btnApagaConta');
$btnApagaConfirma = filter_input(INPUT_POST, 'btnApagaConfirma');
$btnAualiza = filter_input(INPUT_POST, 'btnAualiza');
$btnVoltar = filter_input(INPUT_POST, 'btnVoltar');
$apagou = false;

if (isset($btnAualiza)){

    header("Refresh:0");
}

if (isset($btnLogout)) {

    header("Location: logout.php");
}

if (isset($btnApagaConta)) {

    echo '<div class="confirmacao">';
    echo "Tem certeza?";
    echo '<form action="" method="POST">';
    echo '<button type="submit" name="btnApagaConfirma">Confirma</button>';
    echo '<button type="submit" name="btnVoltar">Voltar</button>';
    echo '</form>';
    echo '</div>';

}

if (isset($btnVoltar)) {

    header("Refresh:0");
}
if (isset($btnApagaConfirma)){

    $sql = "DELETE FROM tentativa_acesso WHERE tent_usu_id=?";
    $param_id = "123";

    preparaEnviaFecha($sql, "i", $param_id);

    $sql = "DELETE FROM usuario WHERE usu_id=?";
    preparaEnviaFecha($sql, "i", $param_id);

}

if (mysqli_num_rows($result) == 0) {
    echo "email was not found";
} else {
    echo "email was found";
}



/*$sql = "DELETE FROM tentativa_acesso WHERE tent_usu_id='123'";

if (isset($btnAualiza)){

    echo 'ALOOOO';
}
if (isset($btnApagaConfirma)){
               
    if($stmt = mysqli_prepare($conexao, $sql)){

        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        $param_id = "123";

        if(mysqli_stmt_execute($stmt)){

            mysqli_commit($conexao);
            mysqli_stmt_close($stmt);
            mysqli_close($conexao);
            echo "UMPALUMPA";
        }
    }
}*/
?>
<script>
    console.log(<?= json_encode($btnApagaConfirma); ?>);


</script>
</body>
</html>
