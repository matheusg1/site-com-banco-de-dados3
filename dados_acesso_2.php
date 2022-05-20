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
        <div class="window centraliza" style="width: 1000px; height:450px">
            <div class="title-bar">
              <div class="title-bar-text">Dados do usuário</div>
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

            if ((isset($_SESSION['usu_id']) && isset($_SESSION['aut']))) {          

                if (!empty($_SESSION['usu_id'] && ($_SESSION['aut']))) {            

                    switch ($_SESSION['usu_tipo']) {
                    
                        default:                                                 
                            $_SESSION['msg'] = "Área restrita";
                            header("Location: index.php");
                            break;
                        case 2:
                            echo '<form action="" method="POST">';

                            echo '<div class="camposRename">';

                            echo 'Nome: <input type="text" name="newNome" value="' . $_SESSION['usu_nome'] .'" autofocus>';
                            echo '<button type="submit" name="btnNome">Salvar</button><br>';

                            echo 'Data de nascimento: <input type="date" name="newData" value="' . $_SESSION['usu_nascimento'] .'" max="',dataLimite(), '">';
                            echo '<button type="submit" name="btnData">Salvar</button> <br>';

                            echo 'Nome materno: <input type="text" name="newNomemat" value="' . $_SESSION['usu_nomemat'] .'">';
                            echo '<button type="submit" name="btnNomemat">Salvar</button><br>';

                            echo 'CPF: <input type="text" name="newCpf" maxlength="11" value="' . $_SESSION['usu_cpf'] .'">';
                            echo '<button type="submit" name="btnCpf">Salvar</button><br>';

                            echo 'Celular: <input type="text" name="newCelular" maxlength="11" value="' . $_SESSION['usu_celular'] .'">';
                            echo '<button type="submit" name="btnCelular">Salvar</button><br>';

                            echo 'Fixo: <input type="text" name="newFixo" maxlength="10" value="' . $_SESSION['usu_fixo'] .'">';
                            echo '<button type="submit" name="btnFixo">Salvar</button><br>';

                            echo 'Endereço: <input type="text" name="newEndereco" value="' . $_SESSION['usu_endereco'] .'">';
                            echo '<button type="submit" name="btnEndereco">Salvar</button><br>';

                            echo 'Login: <input type="text" maxlength="15" name="newLogin" value="' . $_SESSION['usu_login'] .'">';
                            echo '<button type="submit" name="btnLogin">Salvar</button><br>';

                            echo 'Senha: <input type="password" maxlength="15" name="newSenha">';
                            echo '<button type="submit" name="btnSenha">Salvar</button><br>';

                            echo '</div>';
                            echo '<div class="botoesDados">';
                            echo '<button type="submit" name="btnLogout">Deslogar</button>';

                            echo '<button type="submit" name="btnAualiza">Atualizar</button>';
                            
                            echo '<button type="submit" name="btnApagaConta">Apagar conta</button>';
                            echo '</div>';

                            echo '</form>';
                            
                            $btnNome = filter_input(INPUT_POST, 'btnNome');
                            $btnData = filter_input(INPUT_POST, 'btnData');
                            $btnNomemat = filter_input(INPUT_POST, 'btnNomemat');
                            $btnCpf = filter_input(INPUT_POST, 'btnCpf');
                            $btnCelular = filter_input(INPUT_POST, 'btnCelular');
                            $btnFixo = filter_input(INPUT_POST, 'btnFixo');
                            $btnEndereco = filter_input(INPUT_POST, 'btnEndereco');
                            $btnLogin = filter_input(INPUT_POST, 'btnLogin');
                            $btnSenha = filter_input(INPUT_POST, 'btnSenha');
                            $btnAualiza = filter_input(INPUT_POST, 'btnAualiza');
                            $btnApagaConta = filter_input(INPUT_POST, 'btnApagaConta');
                            $btnLogout = filter_input(INPUT_POST, 'btnLogout');
                            $btnApagaConfirma = filter_input(INPUT_POST, 'btnApagaConfirma');
                            $btnVoltar = filter_input(INPUT_POST, 'btnVoltar');
                            
                            if (isset($btnAualiza)){

                                header("Refresh:0");
                            }

                            if (isset($btnLogout)) {

                                header("Location: logout.php");
                            }

                            if (isset($btnApagaConta)) {
                                echo '<div class="confirmacao">';

                                echo '<div class="window" style="width: 200px; height:100px">';
                                echo '<div class="title-bar">';
                                echo  '<div class="title-bar-text">Atenção</div>';
                                echo  '<div class="title-bar-controls">';
                                echo      '<button aria-label="Minimize"></button>';
                                echo      '<button aria-label="Maximize"></button>';
                                echo      '<button aria-label="Close"></button>';
                                echo    '</div>';
                                echo  '</div>';
                                echo  '<div class="window-body">';
                                echo   '<p>';
                                echo "Tem certeza?";
                                echo '<form action="" method="POST">';
                                echo '<button type="submit" name="btnApagaConfirma">Confirma</button>';
                                echo '<button type="submit" name="btnVoltar">Voltar</button>';
                                echo '</form>';
                                echo '</div>';
                                echo  '</p>';
                                echo'</div>';
                                echo'</div>';
                                  

                            }
                            if (isset($btnApagaConfirma)){

                                $sql = "DELETE FROM tentativa_acesso WHERE tent_usu_id=?";
                                $param_id = $_SESSION['usu_id'];
                            
                                preparaEnviaFecha($sql, "i", $param_id);
                            
                                $sql = "DELETE FROM usuario WHERE usu_id=?";
                                preparaEnviaFecha($sql, "i", $param_id);
                                
                                $_SESSION['contaApagada'] = true;
                                header("Location: logout.php");
                            }
                            if (isset($btnVoltar)) {

                                header("Refresh:0");
                            }

                            if (isset($btnNome)) {          

                                $newNome = filter_input(INPUT_POST, 'newNome');

                                if ($newNome != $_SESSION['usu_nome']) {

                                    $sql ='UPDATE usuario SET usu_nome =? WHERE usu_id = "'. $_SESSION['usu_id'] . '"';
                                    $param_id = $newNome;

                                    preparaEnviaFecha($sql, "s", $param_id);
                                    
                                    if(preparaEnviaFecha($sql, "s", $param_id)){
                                        $_SESSION['usu_nome'] = $newNome;
                                        echo "Mudança feita com sucesso, atualize para ver.";
                                    }
                                    else {
                                        echo "Erro";
                                    }
                                }
                            }

                            if (isset($btnData)) {          

                                $newData = filter_input(INPUT_POST, 'newData');

                                if ($newData != $_SESSION['usu_nascimento']) {

                                    $sql ='UPDATE usuario SET usu_nascimento =? WHERE usu_id = "'. $_SESSION['usu_id'] . '"';
                                    $param_id = $newData;

                                    preparaEnviaFecha($sql, "s", $param_id);

                                    if(preparaEnviaFecha($sql, "s", $param_id)){
                                        $_SESSION['usu_nascimento'] = $newData;
                                        echo "Mudança feita com sucesso, atualize para ver.";
                                    }
                                    else {
                                        echo "Erro";
                                    }
                                }
                            }
                            
                            if (isset($btnNomemat)) {          

                                $newNomemat = filter_input(INPUT_POST, 'newNomemat');

                                if ($newNomemat != $_SESSION['usu_nomemat']) {

                                    $sql ='UPDATE usuario SET usu_nomemat =? WHERE usu_id = "'. $_SESSION['usu_id'] . '"';
                                    $param_id = $newNomemat;

                                    preparaEnviaFecha($sql, "s", $param_id);
                                    
                                    if(preparaEnviaFecha($sql, "s", $param_id)){
                                        $_SESSION['usu_nomemat'] = $newNomemat;
                                        echo "Mudança feita com sucesso, atualize para ver.";
                                    }
                                    else {
                                        echo "Erro";
                                    }
                                }
                            }
                            if (isset($btnCpf)) {          

                                $newCpf = filter_input(INPUT_POST, 'newCpf');
                                $query = 'SELECT usu_cpf FROM usuario WHERE usu_cpf = "' . $newCpf . '" '; 
                                $add = mysqli_query($conexao, $query);
                                
                                if (mysqli_num_rows($add) >= 1) {
                                    echo "CPF já cadastrado";
                                } 
                                else {
                                
                                    if ($newCpf != $_SESSION['usu_cpf']) {

                                        $sql ='UPDATE usuario SET usu_cpf =? WHERE usu_id = "'. $_SESSION['usu_id'] . '"';
                                        $param_id = $newCpf;

                                        preparaEnviaFecha($sql, "s", $param_id);
                                        
                                        if(preparaEnviaFecha($sql, "s", $param_id)){

                                            $_SESSION['usu_cpf'] = $newCpf;
                                            echo "Mudança feita com sucesso, atualize para ver.";
                                        }
                                        else {
                                            echo "Erro";
                                        }
                                    }
                                }
                            }

                            if (isset($btnCelular)) {          

                                $newCelular = filter_input(INPUT_POST, 'newCpf');

                                if ($newCelular != $_SESSION['usu_celular']) {

                                    $sql ='UPDATE usuario SET usu_celular=? WHERE usu_id = "'. $_SESSION['usu_id'] . '"';
                                    $param_id = $newCelular;
                                    
                                    preparaEnviaFecha($sql, "s", $param_id);
        
                                    if(preparaEnviaFecha($sql, "s", $param_id)){
                                        $_SESSION['usu_celular'] = $newCelular;
                                        echo "Mudança feita com sucesso, atualize para ver.";
                                    }
                                    else {
                                        echo "Erro";
                                    }
                                }
                            }

                            if (isset($btnFixo)) {          

                                $newFixo = filter_input(INPUT_POST, 'newFixo');

                                if ($newFixo != $_SESSION['usu_fixo']) {

                                    $sql ='UPDATE usuario SET usu_fixo=? WHERE usu_id = "'. $_SESSION['usu_id'] . '"';
                                    $param_id = $newFixo;

                                    preparaEnviaFecha($sql, "s", $param_id);
                                    
                                    if(preparaEnviaFecha($sql, "s", $param_id)){
                                        $_SESSION['usu_fixo'] = $newFixo;
                                        echo "Mudança feita com sucesso, atualize para ver.";
                                    }
                                    else {
                                        echo "Erro";
                                    }
                                }
                            }

                            if (isset($btnEndereco)) {          

                                $newEndereco = filter_input(INPUT_POST, 'newEndereco');

                                if ($newEndereco != $_SESSION['usu_endereco']) {

                                    $sql ='UPDATE usuario SET usu_endereco=? WHERE usu_id = "'. $_SESSION['usu_id'] . '"';
                                    $param_id = $newEndereco;

                                    preparaEnviaFecha($sql, "s", $param_id);
                                    
                                    if(preparaEnviaFecha($sql, "s", $param_id)){
                                        $_SESSION['usu_endereco'] = $newEndereco;
                                        echo "Mudança feita com sucesso, atualize para ver.";
                                    }
                                    else {
                                        echo "Erro";
                                    }
                                }
                            }

                            if (isset($btnLogin)) {          

                                $newLogin = filter_input(INPUT_POST, 'newLogin');
                                $query = 'SELECT usu_login FROM usuario WHERE usu_login = "' . $newLogin . '" '; 
                                $add = mysqli_query($conexao, $query);
                                
                                if (mysqli_num_rows($add) == 1) {
                                    echo "Login já existente";
                                } 
                                else {
                                
                                    if ($newLogin != $_SESSION['usu_login']) {

                                        $sql ='UPDATE usuario SET usu_login=? WHERE usu_id = "'. $_SESSION['usu_id'] . '"';
                                        $param_id = $newLogin;

                                        preparaEnviaFecha($sql, "s", $param_id);
                                        
                                        if(preparaEnviaFecha($sql, "s", $param_id)){
                                            $_SESSION['usu_login'] = $newLogin;
                                            echo "Mudança feita com sucesso, atualize para ver.";
                                        }
                                        else {
                                            echo "Erro";
                                        }
                                    }
                                }
                            }

                            if (isset($btnSenha)) {          

                                $newSenha = filter_input(INPUT_POST, 'newSenha');
                                $newSenha = password_hash($newSenha, PASSWORD_DEFAULT);

                                if ($newSenha != $_SESSION['usu_senha']) {

                                    $sql ='UPDATE usuario SET usu_senha=? WHERE usu_id = "'. $_SESSION['usu_id'] . '"';
                                    $param_id = $newSenha;

                                    preparaEnviaFecha($sql, "s", $param_id);
                                    
                                    if(preparaEnviaFecha($sql, "s", $param_id)){
                                        $_SESSION['usu_senha'] = $newSenha;
                                        echo "Mudança feita com sucesso, atualize para ver.";
                                    }
                                    else {
                                        echo "Erro";
                                    }
                                }
                            }
                    }
                }
            }
            else{

                $_SESSION['msg'] = "Área restrita";
                header("Location: index.php");
            }
            ?>
            </div>
        </div>
</body>
</html>