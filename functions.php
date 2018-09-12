<?php
require_once('dao/dao.class.php');
require_once('dao/daoInscrito.class.php');
require_once('dao/daoDadosGestor.class.php');
require_once('dao/daoDadosProfessor.class.php');
require_once('dao/daoDadosAcademicos.class.php');
require_once('dao/daoDadosProfissionais.class.php');
require_once('dao/daoDadosCadastrais.class.php');
require_once('dao/daoDadosTrabalho.class.php');
require_once("phpmailer/class.phpmailer.php");

function get_header() {
	include("header.php");
}

function get_footer() {
	include("footer.php");
}

function enviar_email($destinatario, $assunto, $nome, $inscricao, $modelo) {
	$arquivo = fopen($modelo, "r");
	$conteudo = fread($arquivo, filesize($modelo));
	fclose($arquivo);

	if (isset($nome)) {
		$conteudo = str_replace('%nome%', $nome, $conteudo);
	}
	$conteudo = str_replace('%inscricao%', $inscricao, $conteudo);
	
	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->Port = '587';
	$mail->Host = "smtp.premioeducador2015.com.br"; // Endereço do servidor SMTP
	$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
	$mail->Username = 'smtp@premioeducador2015.com.br'; // Usuário do servidor SMTP
	$mail->Password = 'premio2020'; // Senha do servidor SMTP

	$mail->SetFrom('premio@fvc.org.br', 'Prêmio Educador Nota 10');
	$mail->AddReplyTo("premio@fvc.org.br", "Prêmio Educador Nota 10");

	$mail->AddAddress($destinatario, $nome);
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

function print_ideb_escola($line) {
	$ideb = (string) $line['ideb_escola'];
	$ideb = str_replace('.', ',', $ideb);
	
	if ($ideb == '0') {
		$ideb = '0,0';
	}
	
	echo $ideb;
}

function print_ideb_municipio($line) {
	$ideb = (string) $line['ideb_municipio'];
	$ideb = str_replace('.', ',', $ideb);
	
	if ($ideb == '0') {
		$ideb = '0,0';
	}
	
	echo $ideb;
}

?>