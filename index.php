<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

 // so tem commit se altera estado
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
            <?php
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			if(isset($_SESSION['msgcad'])){
				echo $_SESSION['msgcad'];
				unset($_SESSION['msgcad']);
			}
		?>
                <form action="valida.php" method="POST">

                    <label for="loginId">
                        Login <input type="text" name="login" id="loginId" placeholder="Digite seu login">

                    <label for="senhaId">
                        Senha <input type="password" name="senha" id="senhaId" placeholder="Digite sua senha"><br>
                        
                        <button type="submit" name="botaoLogin" value="botaoLogin">Entrar</button>
                </form>
            </div>
        </div>
</body>
</html>
