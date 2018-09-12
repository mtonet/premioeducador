<?php

/**
 * Exemplo de como enviar um pedido de chamada pela API módulo de voz
 * Author: Team Developers DirectCall
 * Data: 2013-03-14
 * Referencia: http://doc.directcallsoft.com/display/cloudapi/Enviar+pedido+de+chamada
 * Pacote completo em: http://doc.directcallsoft.com/download/attachments/524373/Exemplos%20API%20PHP.zip?api=v2
 */

// URL que será feita a requisição
$urlVoz = "https://api.directcallsoft.com/sms/send";

// Numero de origem
$origem = "551137393119";

// Numero de destino
$destino = "5511986601385";



// Incluir o RequisitarToken.php para pegar o access_token
$access_token = "d1d4146144c7a67fcbca60c0189d5fc87b0463b3";

// Formato do retorno, pode ser JSON ou XML
$format = "JSON";

$SMS = "Teste de envio de sms via API directcall";

// Dados em formato QUERY_STRING
$data = http_build_query(array('origem'=>$origem, 'destino'=>$destino, 'texto'=>$SMS , 'access_token'=>$access_token, 'short_number'=> 's'));

$ch = 	curl_init();
		curl_setopt($ch, CURLOPT_URL, $urlVoz);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$return = curl_exec($ch);
		
		curl_close($ch);
		
		// Converte os dados de JSON para ARRAY
		$dados = json_decode($return, true);
		
		// Imprime o retorno
		echo "API: ".			$dados['api']."\n";
		echo "MODULO: ".		$dados['modulo']."\n";
		echo "STATUS: ".		$dados['status']."\n";
		echo "CODIGO: ".		$dados['codigo']."\n";
		echo "MENSAGEM: ".		$dados['msg']."\n";


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teste API Direct Call</title>
</head>

<body>
</body>
</html>
