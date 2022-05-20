<?php

session_start();

unset($_SESSION['usu_id'], $_SESSION['usu_nome'], $_SESSION['usu_nascimento'], $_SESSION['usu_nomemat'],  $_SESSION['usu_cpf'], $_SESSION['usu_celular'], $_SESSION['usu_fixo'], $_SESSION['usu_endereco'], $_SESSION['usu_tipo'], $_SESSION['usu_login'], $_SESSION['usu_senha'], $_SESSION['aut'], $_SESSION['botaoLogin']);

if ($_SESSION['contaApagada']) {
    $_SESSION['msg'] = '<center><p class="status-bar-field">Dados excluídos com sucesso</p></center>';
}
else{
    $_SESSION['msg'] = '<center><p class="status-bar-field">Deslogado com sucesso</p></center>';
}

header("Location: index.php");

/*mysqli_close($conexao);*/
?>
?>
