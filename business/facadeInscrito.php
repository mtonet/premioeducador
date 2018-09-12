<?php
//colocar no config e o dir ser uma variavel publica
$DIR =(strpos($_SERVER["PHP_SELF"],'admin') > 0) ? "../" : "";
require_once($DIR."dao/daoInscrito.class.php");
require_once($DIR."phpmailer/class.phpmailer.php");

class SessionFacadeInscrito {




function enviar_lembrete_cadastro($destinatario, $nome, $senha, $utpasso) {
	$arquivo = fopen($DIR."lembretecadastro.html", "r");
	$conteudo = fread($arquivo, filesize($DIR."lembretecadastro.html"));
	fclose($arquivo);

	if (!isset($nome)) {
		$nome = 'usu&aacute;rio';
	}

	$conteudo = str_replace('%nome%', $nome, $conteudo);
	$conteudo = str_replace('%senha%', $senha, $conteudo);
	$conteudo = str_replace('%passo%', $utpasso, $conteudo);
	
	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->Port = '587';
	$mail->Host = "smtp.premioeducador2015.com.br"; // Endereço do servidor SMTP
	$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
	$mail->Username = 'smtp@premioeducador2015.com.br'; // Usuário do servidor SMTP
	$mail->Password = 'premio2020'; // Senha do servidor SMTP

	$mail->SetFrom('premio@fvc.org.br', 'Prêmio Victor Civita 2014');
	$mail->AddReplyTo("premio@fvc.org.br", "Prêmio Victor Civita 2014");

	$mail->AddAddress($destinatario, $nome);
	//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
	//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

	$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
	//$mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)

	$mail->Subject = "Lembrete de Cadastro"; // Assunto da mensagem
	$mail->Body = $conteudo;
	//$mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n <img src="http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";

	//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");&nbsp; // Insere um anexo

	// Envia o e-mail
	$enviado = $mail->Send();

	// Limpa os destinatários e os anexos
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();
}



	public function setPasso($revisao=0) {
		try {
			$retorno = 0;
			$InscritoDAO = new InscritoDAO();
			
			session_start();
			$id = mysql_escape_string($_SESSION['id']);
			$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
			
			if ($ultimo_passo != 6  || $revisao == 1 && $ultimo_passo < 8)
			{
				$InscritoDAO->setPasso($id, $ultimo_passo);
				$_SESSION['ultimo_passo'] += 1;
			}
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
	


	public function lembretecadastro($idusu) {
		try {
			$retorno = 0;
			$InscritoDAO = new InscritoDAO();
			
			session_start();
			$id = mysql_escape_string($_SESSION['id']);
			$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
			
				$InscritoDAO->lembretecadastro($idusu);
			
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function lembretecadastrofinalizado($idusu) {
		try {
			$retorno = 0;
			$InscritoDAO = new InscritoDAO();
			
			session_start();
			$id = mysql_escape_string($_SESSION['id']);
			$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
			
				$InscritoDAO->lembretecadastrofinalizado($idusu);
			
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}	


	public function lembretecertificado($idusu) {
		try {
			$retorno = 0;
			$InscritoDAO = new InscritoDAO();
			
			session_start();
			$id = mysql_escape_string($_SESSION['id']);
			$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
			
				$InscritoDAO->lembretecertificado($idusu);
			
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}	


	public function lembretecertificadonv($idusu) {
		try {
			$retorno = "0";
			$InscritoDAO = new InscritoDAO();
			
			session_start();
			$id = mysql_escape_string($_SESSION['id']);
			$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
			
			$retorno =	$InscritoDAO->lembretecertificadonv($idusu);
			
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}	
	
	
	public function setCategoria($categoria) {
		try {
			$retorno = 0;
			$InscritoDAO = new InscritoDAO();
			
			session_start();
			$id = mysql_escape_string($_SESSION['id']);
			$InscritoDAO->setCategoria($id, $categoria);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}

	public function setStatus($id, $status) {
		try {
			$retorno = 0;
			$InscritoDAO = new InscritoDAO();
			
			$id = mysql_escape_string($id);
			$status = mysql_escape_string($status);
			$InscritoDAO->setStatus($id, $status);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}

	//atualizar
	public function cadastra($email, $senha, $cpf) {
		try {
			$retorno = 0;
			$InscritoDAO = new InscritoDAO();
			
			$retorno = $InscritoDAO->cadastrar($email, $senha, $cpf);
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function verificaJaCadastrado($email, $cpf) {
		try {
			$retorno = 0;
			$InscritoDAO = new InscritoDAO();
			
			$retorno = $InscritoDAO->getInscrito($email, $cpf);
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	
	public function verificaStatus($id) {
		try {
			$retorno = 0;
			$InscritoDAO = new InscritoDAO();
			
			$retorno = $InscritoDAO->getInscritoStatus($id);
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}	
	
	
	
	

	public function resetPass($cpf) {
		try {
			$retorno = 0;
			$InscritoDAO = new InscritoDAO();
			
			$retorno = $InscritoDAO->resetPass($cpf);
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function login($email, $senha) {
		try {
			$retorno = 0;
			$InscritoDAO = new InscritoDAO();
				
			$retorno = $InscritoDAO->loginInscritos($email, $senha);
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function getDadosPorId($id) {
		try {
			$retorno = 0;
			
			$InscritoDAO = new InscritoDAO();
			
			$retorno = $InscritoDAO->getDadosPorIdconf($id);
			
		}
		catch (Exception $e) {
			//$retorno = -1;
			$retorno = $e;
		}
		
		return $retorno;
	}
	
	
	public function getList($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status='', $texto='', $pagAtual=0, $pagLimite=0){
		
		$retorno = null;
		
		try {
				$InscritoDAO = new InscritoDAO();	
				$retorno = $InscritoDAO->getListInscritos($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status, $texto, $pagAtual, $pagLimite);
			}
			catch(Exception $e) 
			{
				$retorno = null;
			}
		
		return $retorno;
   }
   
   	public function getListNoDisabled($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status='', $texto='', $pagAtual=0, $pagLimite=0){
		
		$retorno = null;
		
		try {
				$InscritoDAO = new InscritoDAO();	
				$retorno = $InscritoDAO->getListInscritosNoDisabled($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status, $texto, $pagAtual, $pagLimite);
			}
			catch(Exception $e) 
			{
				$retorno = null;
			}
		
		return $retorno;
   }
   
   
   
   	public function getListNoDisablednovo($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status='', $texto='', $pagAtual=0, $pagLimite=0){
		
		$retorno = null;
		
		try {
				$InscritoDAO = new InscritoDAO();	
				$retorno = $InscritoDAO->getListInscritosNoDisablednovo($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status, $texto, $pagAtual, $pagLimite);
			}
			catch(Exception $e) 
			{
				$retorno = null;
			}
		
		return $retorno;
   }   
   
   
   
   
   

	public function getListNaoFinalizados($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status='', $texto='', $pagAtual=0, $pagLimite=0) {
		$retorno = null;

		try {
			$InscritoDAO = new InscritoDAO();	
			$retorno = $InscritoDAO->getListInscritosNaoFinalizados($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status, $texto, $pagAtual, $pagLimite);
		}
		catch (Exception $e) {
			$retorno = null;
		}

		return $retorno;
	}

   	public function getListById($id) {
		$retorno = null;
		
		try {
			$InscritoDAO = new InscritoDAO();	
			$retorno = $InscritoDAO->getListById($id);
		}
		catch (Exception $e) {
			$retorno = null;
		}
		
		return $retorno;
   }
   
   
   
   	public function CertificadoById($id) {
		$retorno = null;
		
		try {
			$InscritoDAO = new InscritoDAO();	
			$retorno = $InscritoDAO->getListById($id);
		}
		catch (Exception $e) {
			$retorno = null;
		}
		
		return $retorno;
   }   
   
   
   
   
   
}

?>