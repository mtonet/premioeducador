<?php
require_once("config.php");
require_once('../dao/dao.class.php');
require_once("../business/facadeUsuario.php");



//******************************** variaveis **********************************
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;
$facadeUsuario = new SessionFacadeUsuario();


switch ($action) {
	case 'login':
		$email = mysql_escape_string($_REQUEST['email']);
		$senha = mysql_escape_string($_REQUEST['senha']);
		
		if ($email && $senha) {
		
			if ($facadeUsuario->Login($email,$senha) > 0)
				echo json_encode( array('status' => 'ok', 'email' => 'ok', 'senha' => 'ok') );
			else 
				echo json_encode( array('status' => 'error', 'email' => 'incorrect', 'senha' => 'incorrect') );
		
		}
		else {
			echo json_encode( array('status' => 'error', 'email' => 'incorrect', 'senha' => 'incorrect') );
		}
		break;

	case 'logout':
		session_start();
		session_destroy();
		echo json_encode( array('status' => 'ok') );
		break;
}