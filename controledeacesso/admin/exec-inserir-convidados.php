<?php
require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__)."/functions.php");

//*********************Verificar Login********************************
$pagina = "exec-editar-convidados";
validaUsuarioAdmin($pagina);

//******************** Inicialização variaveis ***********************

//echo '<pre>'; print_r($_POST); exit;

$facadeControleDeAcesso = new SessionControleDeAcesso();

$codigo 		= isset($_POST['codigo']) ? $_POST['codigo'] : "";
$origem			= isset($_POST['origem']) ? $_POST['origem'] : "";
$nome 			= isset($_POST['nome']) ? $_POST['nome'] : "";
$email 			= isset($_POST['email']) ? $_POST['email'] : "";
$telefone 		= isset($_POST['telefone']) ? $_POST['telefone'] : "";
$celular 		= isset($_POST['celular']) ? $_POST['celular'] : "";
$cep 		    = isset($_POST['cep']) ? mysql_escape_string( $_POST['cep'] ) : null;
$endereco 	    = isset($_POST['endereco']) ? mysql_escape_string( utf8_decode($_POST['endereco']) ) : null;
$numero 	    = isset($_POST['numero']) ? mysql_escape_string( $_POST['numero'] ) : null;
$complemento    = isset($_POST['complemento']) ? mysql_escape_string( utf8_decode($_POST['complemento']) ) : null;
$bairro 	    = isset($_POST['bairro']) ? mysql_escape_string( utf8_decode($_POST['bairro']) ) : null;
$cidade 	    = isset($_POST['cidade']) ? mysql_escape_string( utf8_decode($_POST['cidade']) ) : null;
$estado 	    = isset($_POST['estado']) ? mysql_escape_string( $_POST['estado'] ) : null;
$empresa 	    = isset($_POST['empresa']) ? mysql_escape_string( utf8_decode($_POST['empresa']) ) : null;
$cargo 	    = isset($_POST['cargo']) ? mysql_escape_string( utf8_decode($_POST['cargo']) ) : null;

$acompanhante 	= isset($_POST['acompanhante']) ? $_POST['acompanhante'] : 'nao';
$confirmados 	= isset($_POST['confirmados']) ? $_POST['confirmados'] : 'nao';
$vip 			= isset($_POST['vip']) ? $_POST['vip'] : 'nao';


$acompanhante 	= $acompanhante=='sim'?1:0;
$confirmados 	= $confirmados=='sim'?true:false;
$vip 			= $vip=='sim'?1:0;


$result = $facadeControleDeAcesso->cadastra($codigo, $origem, utf8_decode($nome), $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $acompanhante, $vip, $confirmados);

if($result!=-1){
	$_SESSION['msg_sucesso'] = 'Cadastro criado com sucesso!';	
	header('Location: /controledeacesso/admin/convidado-inserido.php?codigo=' . $codigo);
	exit;
}
else{
	$_SESSION['msg_erro'] = 'O cadastro não pôde ser criado!';
}

header('Location: /controledeacesso/admin/inserir-convidados.php');

