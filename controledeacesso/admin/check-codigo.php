<?php
require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__)."/functions.php");

//******************** Inicialização variaveis ***********************

$facadeControleDeAcesso = new SessionControleDeAcesso();

$codigo 		= isset($_POST['codigo']) ? $_POST['codigo'] : "";
$codigoAntigo 	= isset($_POST['codigoAntigo']) ? $_POST['codigoAntigo'] : "";

if($codigo!='' && $codigo == $codigoAntigo){
	echo 'true';
	exit;
} 

$result = $facadeControleDeAcesso->getByCode($codigo);

if(mysql_num_rows($result)>0){
	echo 'false';
}
else{
	echo 'true';
}
