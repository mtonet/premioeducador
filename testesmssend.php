<?php


function requisicaoApi($params, $endpoint)
{
$url = "http://api.directcallsoft.com/{$endpoint}";

$data = http_build_query($params);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$return = curl_exec($ch);

curl_close($ch);

// Converte os dados de JSON para ARRAY
$dados = json_decode($return, true);

return $dados;
}


$nome = $_REQUEST['nome'];
$email = $_REQUEST['email'];
$mensagem = $_REQUEST['mensagem'];



// Monta a mensagem
$SMS = "Contato de: {$nome} - <{$email}> - {$mensagem}";

// Array com os parametros para o envio

$data = array(
'origem'=>"551137393119", // Seu numero que Ã© origem
'destino'=>"5511986601385", // E o numero de destino
'tipo'=>"texto",
'access_token'=>$access_token,
'texto'=>$SMS
);
// realiza o envio
$req_sms = requisicaoApi($data, "sms/send");
// FIM




?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>


<body>

<?php 

// Imprime o retorno
		echo "API: ".			$req_sms['api']."\n";
		echo "MODULO: ".		$req_sms['modulo']."\n";
		echo "STATUS: ".		$req_sms['status']."\n";
		echo "CODIGO: ".		$req_sms['codigo']."\n";
		echo "MENSAGEM: ".		$req_sms['msg']."\n";


echo "Resultado envio SMS=".$req_sms;

?>



</body>
</html>
