<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once("conexao.php");
$botaoLogin = filter_input(INPUT_POST, 'botaoLogin');
$dataAtual = date('Y-m-d', strtotime(date("Y-m-d")));
$horaAtual = date('H:i:s');

if($botaoLogin){

	$login = filter_input(INPUT_POST, 'login');
	$senha = filter_input(INPUT_POST, 'senha');

	if((!empty($login)) AND (!empty($senha))) {


		$result_usuario = "SELECT usu_id, usu_nome, usu_nascimento, usu_nomemat, usu_cpf, usu_celular, usu_fixo, usu_endereco, usu_tipo, usu_login, usu_senha FROM usuario WHERE usu_login= '$login' LIMIT 1"; 
		$resultadoUsuario = mysqli_query($conexao, $result_usuario); //recebe as informações do usuário

		if($resultadoUsuario){

			$row_usuario = mysqli_fetch_assoc($resultadoUsuario);

			if(password_verify($senha, $row_usuario['usu_senha'])){
		
				$query1 = "INSERT INTO tentativa_acesso (tent_data, tent_hora) VALUES ('$dataAtual', '$horaAtual');";
				$add1 =	mysqli_query($conexao, $query1);

				$_SESSION['usu_id'] = $row_usuario['usu_id'];
				$_SESSION['usu_nome'] = $row_usuario['usu_nome'];
				$_SESSION['usu_nascimento'] = $row_usuario['usu_nascimento'];
				$_SESSION['usu_nomemat'] = $row_usuario['usu_nomemat'];
				$_SESSION['usu_cpf'] = $row_usuario['usu_cpf'];
				$_SESSION['usu_celular'] = $row_usuario['usu_celular'];
				$_SESSION['usu_fixo'] = $row_usuario['usu_fixo'];
				$_SESSION['usu_endereco'] = $row_usuario['usu_endereco'];
				$_SESSION['usu_tipo'] = $row_usuario['usu_tipo'];
				$_SESSION['usu_login'] = $row_usuario['usu_login'];
				$_SESSION['usu_senha'] = $row_usuario['usu_senha'];

				if ($_SESSION['usu_tipo'] == 1) {

					header("Location: dados_acesso_1.php");	//usuário master(1) não passa por a2f 
				}
				else{

					header("Location: autentica.php");
				}

				$query2 = "UPDATE tentativa_acesso SET tent_usu_id='" .$_SESSION['usu_id']. "' ORDER BY tent_id DESC LIMIT 1"; // add chave primária do usuário na última coluna adicionada;
				$add2 = mysqli_query($conexao, $query2);

			}
			else{

				$_SESSION['msg'] = "<p class='status-bar-field alinhaCentro'>Login e senha incorretos</p>";
				header("Location: index.php");
			}
		}
	}
	else{

		$_SESSION['msg'] = "<p class='status-bar-field alinhaCentro'>Login e senha incorretos</p>";
		header("Location: index.php");
	}
}
else{

	$_SESSION['msg'] = "Página não encontrada";
	header("Location: index.php");
}
