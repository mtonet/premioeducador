<?php
require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__)."/functions.php");

//*********************Verificar Login********************************
$pagina = "exec-inserir-convidados";
validaUsuarioAdmin($pagina);

//******************** Inicialização variaveis ***********************

$facadeControleDeAcesso = new SessionControleDeAcesso();

$codigoAntigo 	= isset($_POST['codigoAntigo']) ? $_POST['codigoAntigo'] : "codigoAntigo";
$codigo 		= isset($_POST['codigo']) ? $_POST['codigo'] : "";
$nome 			= isset($_POST['nome']) ? $_POST['nome'] : "";
$email 			= isset($_POST['email']) ? $_POST['email'] : "";
$telefone 		= isset($_POST['telefone']) ? $_POST['telefone'] : "";
$celular 		= isset($_POST['celular']) ? $_POST['celular'] : "";
$cep 		    = isset($_POST['cep']) ? mysql_escape_string( $_POST['cep'] ) : '';
$endereco 	    = isset($_POST['endereco']) ? mysql_escape_string( utf8_decode($_POST['endereco']) ) : '';
$numero 	    = isset($_POST['numero']) ? mysql_escape_string( $_POST['numero'] ) : '';
$complemento    = isset($_POST['complemento']) ? mysql_escape_string( utf8_decode($_POST['complemento']) ) : '';
$bairro 	    = isset($_POST['bairro']) ? mysql_escape_string( utf8_decode($_POST['bairro']) ) : '';
$cidade 	    = isset($_POST['cidade']) ? mysql_escape_string( utf8_decode($_POST['cidade']) ) : '';
$estado 	    = isset($_POST['estado']) ? mysql_escape_string( $_POST['estado'] ) : '';
$empresa 	    = isset($_POST['empresa']) ? mysql_escape_string( utf8_decode($_POST['empresa']) ) : '';
$cargo 	    = isset($_POST['cargo']) ? mysql_escape_string( utf8_decode($_POST['cargo']) ) : '';

$acompanhante 	= isset($_POST['acompanhante']) ? $_POST['acompanhante'] : 'todos';
$criado 		= isset($_POST['criado']) ? $_POST['criado'] : 'todos';
$confirmados 	= isset($_POST['confirmados']) ? $_POST['confirmados'] : 'sim';


$result = $facadeControleDeAcesso->atualizarByAdmin($codigoAntigo, $codigo, utf8_decode($nome), $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $cargo, $acompanhante, $criado, $confirmados);

if($result!=-1){
	$_SESSION['msg_sucesso'] = 'Cadastro editado com sucesso!';
	
	header('Location: /controledeacesso/admin/editar-convidados.php?codigo=' . $codigo);
	exit;
	
}
else{
	$_SESSION['msg_erro'] = 'O cadastro não pôde ser editado!';
}

header('Location: /controledeacesso/admin/editar-convidados.php?codigo=' . $codigoAntigo);

