<?php
require_once(dirname(__FILE__) ."/../phpmailer/class.phpmailer.php");

function send_email_template($to, $assunto, $modelo, $vars) {

    $arquivo = strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/"));

    $modelo = substr_replace ( $_SERVER['SCRIPT_FILENAME'] , $modelo , -($arquivo-1) );

	$arquivo = fopen($modelo, "r");

	$conteudo = fread($arquivo, filesize($modelo));
	fclose($arquivo);

	foreach ($vars as $key => $value) {
		$conteudo = str_replace('${' . $key . '}', $value, $conteudo);
	}
	
	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->Port = '587';
	$mail->Host = "smtp.inscricoespvc2012.com.br"; // Endereço do servidor SMTP
	$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
	$mail->Username = 'email@inscricoespvc2012.com.br'; // Usuário do servidor SMTP
	$mail->Password = '336699'; // Senha do servidor SMTP

	$mail->SetFrom('premio@fvc.org.br', 'Prêmio Victor Civita 2012');
	$mail->AddReplyTo("premio@fvc.org.br", "Prêmio Victor Civita 2012");

	$mail->AddAddress($to['email'], $to['name']);
	//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
	//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

	$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
	$mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)

	$mail->Subject = $assunto; // Assunto da mensagem
	$mail->Body = $conteudo;
	//$mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n <img src="http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";

	//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");&nbsp; // Insere um anexo

	// Envia o e-mail
	$enviado = $mail->Send();

	// Limpa os destinatários e os anexos
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();
}

?>