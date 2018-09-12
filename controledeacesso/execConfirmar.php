<?php
require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
//require_once(dirname(__FILE__)."/functions.php");

//******************** Inicialização variaveis ***********************

$facadeControleDeAcesso = new SessionControleDeAcesso();


$codigo 		= isset($_POST['codigo']) ? $_POST['codigo'] : "";
$acompanhante 	= isset($_POST['acompanhante']) ? $_POST['acompanhante'] : 'todos';


$result = $facadeControleDeAcesso->confirmacao($codigo, $acompanhante);

session_start();

if($result!=-1){
	$_SESSION['msg_sucesso'] = 'Presença confirmada!';
	
	header('Location: '.SITE_URL . 'controledeacesso/recepcao');
	exit;
	
}
else{
	$_SESSION['msg_erro'] = 'A presença não pôde ser editado!';
}

header('Location: '.SITE_URL . 'controledeacesso/recepcao');