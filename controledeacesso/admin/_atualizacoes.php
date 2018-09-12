<?php

require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__)."/functions.php");

$facadeControleDeAcesso = new SessionControleDeAcesso();

$abraArq = fopen("import-19092012.csv", "r");

if (!$abraArq){
	echo ("<p>Arquivo não encontrado</p>");
}else{

	//echo '<pre>';

	while ($valores = fgetcsv ($abraArq, 1, ";")) {
		//$query_salva = "INSERT INTO TABELA VALUES (NULL, '.$valores[0].' , '.$valores[1].')";


		//echo '<pre>';
		//print_r($valores);
		//echo '</pre>';

		
		$facadeControleDeAcesso->atualizarByCVS(
			@addslashes($valores[5]), 
			@addslashes($valores[0]),
			@addslashes($valores[1].' '.$valores[2]), 
			@addslashes($valores[3]),
			@addslashes($valores[4])
		);
		
	}

	fclose($abraArq);
}