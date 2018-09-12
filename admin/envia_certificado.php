<?php
require_once('../business/facadeInscrito.php');
require_once("functions.php");

$value = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
$facadeInscrito = new SessionFacadeInscrito();

			
				//	echo "O inscrito id=". $value. " foi selecionado ! <br />";
				 //	$retorno = $value;
				 $retorno =	$facadeInscrito->lembretecertificadonv($value);


echo "<?xml version='1.0' encoding='utf-8'?>";
echo "<contatos>";
echo "	<contato>";
echo "		<nome>Retorno =".$retorno."</nome>";
echo "		<email>ID Passado--".$value."</email>";
echo "	</contato>";
echo "</contatos>";




?>


