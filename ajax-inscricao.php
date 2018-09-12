<?php
require_once("config.php");
require_once("functions-g.php");
require_once("isCpfValid.php");
require_once('dao/dao.class.php');
require_once("dao/daoInscrito.class.php");
require_once("business/facadeInscrito.php");

ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);

//******************************** variaveis **********************************
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;
$facadeInscrito = new SessionFacadeInscrito();
$email = mysql_escape_string($_REQUEST['email']);
$senha = mysql_escape_string($_REQUEST['senha']);


switch ($action) {
	case 'login':
	
		if ($facadeInscrito->login($email,$senha)  > 0 && $email) 
			echo json_encode( array('status' => 'ok', 'email' => 'ok', 'senha' => 'ok', 'ultimo_passo' => $_SESSION['ultimo_passo']) );
		else
			echo json_encode( array('status' => 'error', 'email' => 'incorrect', 'senha' => 'incorrect') );
		
		break;

	case 'logout':
		session_start();
		session_destroy();
		echo json_encode( array('status' => 'ok') );
		break;

	
	case 'signup':
		$cpf = mysql_escape_string($_REQUEST['cpf']);
		
		//validar se o email ou o cpf ja existe e se der true mostra msg 
		//caso contrario faz o cadastro
		//o proprio facade que criara a sessao
		
		if ( isCpfValid($cpf) ) {
			if ($facadeInscrito->verificaJaCadastrado($email, $cpf) == 0 && $email)
			{
				$retorno = $facadeInscrito->cadastra($email, $senha, $cpf);
				
				if ($retorno > 0)
					echo json_encode( array('status' => 'ok', 'email' => 'ok', 'senha' => 'ok', 'cpf' => 'ok', 'ultimo_passo' => $_SESSION['ultimo_passo'] ) ) ;
				else
					echo json_encode( array('status' => 'error', 'email' => 'existent', 'senha' => 'ok', 'cpf' => 'existent') );
			
			}
			else
				echo json_encode( array('status' => 'error', 'email' => 'existent', 'senha' => 'ok', 'cpf' => 'existent') );
		}
		else
			echo json_encode( array('status' => 'error', 'email' => 'ok', 'senha' => 'ok', 'cpf' => 'invalid') );
			
		break;

	case 'forget':
		$cpf = mysql_escape_string($_REQUEST['cpf']);
		
		//validar se o email ou o cpf ja existe e se der true mostra msg 
		//caso contrario faz o cadastro
		//o proprio facade que criara a sessao
		
		if ( isCpfValid($cpf) ) {
			if ($facadeInscrito->verificaJaCadastrado(null, $cpf) > 0)
			{
				$facadeInscrito->resetPass($cpf);
				echo json_encode( array('status' => 'ok', 'email' => 'null', 'senha' => 'null', 'cpf' => 'ok' ) ) ;
			}
			else
				echo json_encode( array('status' => 'error', 'email' => 'null', 'senha' => 'null', 'cpf' => 'inexistent') );
		}
		else
			echo json_encode( array('status' => 'error', 'email' => 'null', 'senha' => 'null', 'cpf' => 'invalid') );
			
		break;
}