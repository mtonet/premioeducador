<?php
require_once(dirname(__FILE__) ."/../../config.php");
require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
//require_once(dirname(__FILE__)."/functions.php");

//******************** Inicialização variaveis ***********************

$facadeControleDeAcesso = new SessionControleDeAcesso();

//echo '<pre>'; print_r($_POST); exit;

$codigo               = isset($_POST['codigo']) ? $_POST['codigo'] : "";
$acompanhantePresente = isset($_POST['acompanhante_presente']) ? $_POST['acompanhante_presente'] : "nao";
$convidadoPresente = isset($_POST['convidado_presente']) ? $_POST['convidado_presente'] : "nao";

$result = $facadeControleDeAcesso->presenca_confirmada($codigo, $acompanhantePresente);
$convidadoConfirmado = $facadeControleDeAcesso->confirmarPresencaConvidado($codigo, $convidadoPresente);

session_start();

if( $result!=-1 AND $convidadoConfirmado ){
	$_SESSION['sucesso'] = 'Presença confirmada!';
	header('Location: '.SITE_URL . 'controledeacesso/recepcao');
	exit;
	
}
else{
	$_SESSION['erro'] = 'A presença não pôde ser editada!';
}

header('Location: '.SITE_URL . 'controledeacesso/recepcao');