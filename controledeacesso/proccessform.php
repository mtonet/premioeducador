<?php
require_once(dirname(__FILE__) ."/../config.php");
require_once(dirname(__FILE__) ."/../functions.php");
require_once(dirname(__FILE__) ."/../functions-g.php");
require_once(dirname(__FILE__) .'/../business/facadeControleDeAcesso.php');

//echo $root = realpath($_SERVER["DOCUMENT_ROOT"]);

if(!isPost()){
    header('Location: ' .SITE_URL. 'controledeacesso');
}

$id 		= mysql_escape_string( $_POST['id'] );
$codigo 	= mysql_escape_string( $_POST['codigo'] );
$nome 		= mysql_escape_string( utf8_decode($_POST['nome']) );
$email 		= mysql_escape_string( $_POST['email'] );
$telefone 	= mysql_escape_string( $_POST['telefone'] );
$celular 	= mysql_escape_string( $_POST['celular'] );
$cep 		= mysql_escape_string( $_POST['cep'] );
$endereco 	= mysql_escape_string( utf8_decode($_POST['endereco']) );
$numero 	= mysql_escape_string( $_POST['numero'] );
$complemento = mysql_escape_string( utf8_decode($_POST['complemento']) );
$bairro 	= mysql_escape_string( utf8_decode($_POST['bairro']) );
$cidade 	= mysql_escape_string( utf8_decode($_POST['cidade']) );
$estado 	= mysql_escape_string( $_POST['estado'] );
$empresa 	= mysql_escape_string( utf8_decode($_POST['empresa']) );
$cargo      = mysql_escape_string( utf8_decode($_POST['cargo']) );
$acompanhante = mysql_escape_string( $_POST['acompanhante'] );

$cda = new SessionControleDeAcesso();

$cda->atualiza($id, $nome, $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $cargo, $acompanhante);

//$acesso = $cda->getByCode($codigo);

//$ac = mysql_fetch_assoc($acesso);

session_start();
$_SESSION['messages'] = array('update_success' => 'Cadastro atualizado com sucesso');
header('Location: ' .SITE_URL. 'controledeacesso/confirmation.php?codigo='.$codigo);

    
