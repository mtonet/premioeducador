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


		$char = $valores[5][strlen($valores[5])-1];
		$vip = $char=='V' || $char=='v'? 1 : 0 ;
		


		//echo '<pre>';
		//print_r($valores);
		//echo addslashes($valores[0]);
		//echo '</pre>';


		$facadeControleDeAcesso->cadastra(
			$valores[5], 
			@addslashes($valores[0]), 
			'', 
			'', 
			'', 
			$valores[4], 
			@addslashes($valores[1]), 
			'', 
			@addslashes($valores[2]), 
			@addslashes($valores[3]), 
			@addslashes($valores[4]), 
			$valores[5], 
			'', 
			0, 
			$vip, 
			false
			);
	}

	fclose($abraArq);
}