<?php
//colocar no config e o dir ser uma variavel publica
$DIR =(strpos($_SERVER["PHP_SELF"],'admin') > 0) ? "../" : "";
require_once($DIR."business/facadeStatus.php");
require_once($DIR."phpmailer/class.phpmailer.php");

function enviar_lembrete_cadastro($destinatario, $nome, $senha, $utpasso) {
	$arquivo = fopen("../lembretecadastro.html", "r");
	$conteudo = fread($arquivo, filesize("../lembretecadastro.html"));
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
	$mail->Host = "smtp.inscricoespvc2012.com.br"; // Endere�o do servidor SMTP
	$mail->SMTPAuth = true; // Usa autentica��o SMTP? (opcional)
	$mail->Username = 'email@inscricoespvc2012.com.br'; // Usu�rio do servidor SMTP
	$mail->Password = '336699'; // Senha do servidor SMTP

	$mail->SetFrom('premio@fvc.org.br', 'Pr�mio Victor Civita 2014');
	$mail->AddReplyTo("premio@fvc.org.br", "Pr�mio Victor Civita 2014");

	$mail->AddAddress($destinatario, $nome);
	//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
	//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // C�pia Oculta

	$mail->IsHTML(true); // Define que o e-mail ser� enviado como HTML
	//$mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)

	$mail->Subject = "Lembrete de Cadastro"; // Assunto da mensagem
	$mail->Body = $conteudo;
	//$mail->AltBody = "Este � o corpo da mensagem de teste, em Texto Plano! \r\n <img src="http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";

	//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");&nbsp; // Insere um anexo

	// Envia o e-mail
	$enviado = $mail->Send();

	// Limpa os destinat�rios e os anexos
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();
}


function enviar_email_esqueci_senha($destinatario, $nome, $senha) {
	$arquivo = fopen($DIR."esqueci.html", "r");
	$conteudo = fread($arquivo, filesize($DIR."esqueci.html"));
	fclose($arquivo);

	if (!isset($nome)) {
		$nome = 'usu&aacute;rio';
	}

	$conteudo = str_replace('%nome%', $nome, $conteudo);
	$conteudo = str_replace('%senha%', $senha, $conteudo);
	
	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->Port = '587';
	$mail->Host = "smtp.inscricoespvc2012.com.br"; // Endere�o do servidor SMTP
	$mail->SMTPAuth = true; // Usa autentica��o SMTP? (opcional)
	$mail->Username = 'email@inscricoespvc2012.com.br'; // Usu�rio do servidor SMTP
	$mail->Password = '336699'; // Senha do servidor SMTP

	$mail->SetFrom('premio@fvc.org.br', 'Pr�mio Victor Civita 2014');
	$mail->AddReplyTo("premio@fvc.org.br", "Pr�mio Victor Civita 2014");

	$mail->AddAddress($destinatario, $nome);
	//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
	//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // C�pia Oculta

	$mail->IsHTML(true); // Define que o e-mail ser� enviado como HTML
	//$mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)

	$mail->Subject = "Nova senha"; // Assunto da mensagem
	$mail->Body = $conteudo;
	//$mail->AltBody = "Este � o corpo da mensagem de teste, em Texto Plano! \r\n <img src="http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";

	//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");&nbsp; // Insere um anexo

	// Envia o e-mail
	$enviado = $mail->Send();

	// Limpa os destinat�rios e os anexos
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();
}

class InscritoDAO {
	
	private $banco;
	
	public function InscritoDAO() {
		$this->banco = new DAO('../dao/config.xml');
	}
	
	public function getDadosPorId($id) {
		$this->banco->conecta();
		$result = $this->banco->executaQuery("SELECT * FROM inscrito WHERE id = $id");
		$this->banco->desconecta();
		return $result;
	}
	
	public function getInscritos() {
		$this->banco->conecta();
		$result = $this->banco->executaQuery("SELECT * FROM inscrito");
		$this->banco->desconecta();
		return $result;
	}

	public function setPasso($id, $ultimo_passo) {
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("UPDATE inscrito SET data_inscricao = now(), ultimo_passo=$ultimo_passo + 1 WHERE id=$id");
		$this->banco->desconecta();
	}
	
	public function setCategoria($id, $categoria) {
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("UPDATE inscrito SET categoria='$categoria' WHERE id=$id");
		$this->banco->desconecta();
	}

	public function setStatus($id, $status) {
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("UPDATE inscrito SET status='$status' WHERE id=$id");
		$this->banco->desconecta();
	}
	
	
	
	
	
	public function getInscrito($email, $cpf) {
		try {
			$retorno = 0;
			$this->banco->conecta();

			if ($email != null)
				$sql = "SELECT count(*) FROM inscrito WHERE email='$email' OR cpf='$cpf'";
			else
				$sql = "SELECT count(*) FROM inscrito WHERE cpf='$cpf'";

			$result = $this->banco->executaQuery($sql);
			$row = mysql_fetch_row($result);
				
			$retorno = $row[0];
			
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
       	 	$this->banco->desconecta();
	   		throw new Exception("ERRO (InscritoDAO) - M�TODO getInscrito()");
		}
		return $retorno;
	}
	
	public function resetPass($cpf) {
		try {
			$retorno = 0;
			$this->banco->conecta();

			$this->banco->executaQuerySemRetorno("UPDATE inscrito SET senha='" . mt_rand(1000, 99999999) . "' WHERE cpf='$cpf'");

			$result = $this->banco->executaQuery("SELECT id, email, senha FROM inscrito WHERE cpf='$cpf'");
			$row = mysql_fetch_assoc($result);

			$id = $row['id'];
			$email = $row['email'];
			$senha = $row['senha'];

			$result1 = $this->banco->executaQuery("SELECT nome FROM dados_cadastrais WHERE inscrito_id='$id'");
			$row1 = mysql_fetch_assoc($result1);
			//if ($row != false)
				$nome = $row1['nome'];
			//else
				//$nome = null;
				//$nome = "teste";
			
			enviar_email_esqueci_senha($email, $nome, $senha);
			
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
       	 	$this->banco->desconecta();
	   		throw new Exception("ERRO (InscritoDAO) - M�TODO getInscrito()");
		}
		return $retorno;
	}
	
	
	
public function lembretecadastro($id) {
		try {
			$retorno = 0;
			$this->banco->conecta();

		//	$this->banco->executaQuerySemRetorno("UPDATE inscrito SET senha='" . mt_rand(1000, 99999999) . "' WHERE cpf='$cpf'");

			$result = $this->banco->executaQuery("SELECT id, email, senha, ultimo_passo FROM inscrito WHERE id='$id'");
			$row = mysql_fetch_assoc($result);

			$id = $row['id'];
			$email = $row['email'];
			$senha = $row['senha'];
			$utpasso = $row['ultimo_passo'];

			$result1 = $this->banco->executaQuery("SELECT nome FROM dados_cadastrais WHERE inscrito_id='$id'");
			$row1 = mysql_fetch_assoc($result1);
			//if ($row != false)
				$nome = $row1['nome'];
			//else
				//$nome = null;
				//$nome = "teste";
			
			enviar_lembrete_cadastro($email, $nome, $senha, $utpasso);
			
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
       	 	$this->banco->desconecta();
	   		throw new Exception("ERRO (InscritoDAO) - M�TODO getInscrito()");
		}
		return $retorno;
	}	

	public function loginInscritos($email, $senha) {
		try{
		$retorno = 0;
		
		$this->banco->conecta();
		$result = $this->banco->executaQuery("SELECT * FROM inscrito WHERE email='$email' AND senha='$senha' AND status_ativo=1");
		$result = mysql_fetch_array($result);
		
			//colocar no facade
			session_start();
		$_SESSION['id'] = $result['id'];
		$_SESSION['ultimo_passo'] = $result['ultimo_passo'];
		$_SESSION['cpf']  = $result['cpf'];
		$_SESSION['email']  = $result['email'];
		
		if($result['id'])
			$retorno = 1;
		
		
		$this->banco->desconecta();
		}
		catch(Exception $e) {
			$retorno = -1;
       	 	$this->banco->desconecta();
	   		throw new Exception("ERRO (InscritoDAO) - M�TODO getInscrito()");
			
		}
		
		return $result;
	}
	
	

	public function cadastrar($email, $senha, $cpf) {
		$data = date('Y-m-d G:i:s');
		$inscricao = date('ym') . (string) rand(0, 9) . (string) rand(0, 9);
		
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("INSERT INTO inscrito SET email='$email', senha='$senha', cpf='$cpf', data_inscricao='$data', ultimo_passo=0");
		$result = $this->banco->executaQuery("SELECT id, ultimo_passo, email, cpf  FROM inscrito WHERE email='$email'");		
		$result = mysql_fetch_array($result);
		
		$id = $result['id'];
		$inscricao = (string) $id . $inscricao;
		$this->banco->executaQuerySemRetorno("UPDATE inscrito SET inscricao='$inscricao' WHERE id=$id");
		$this->banco->desconecta();
		
		$facadeStatus = new SessionFacadeStatus();
		$facadeStatus->cadastraStatus(0, $id);
		
		//colocar no facade
		session_start();
		$_SESSION['id'] = $id;
		$_SESSION['ultimo_passo'] = $result['ultimo_passo'];
		$_SESSION['cpf']  = $result['cpf'];
		$_SESSION['email']  = $result['email'];
		
		return $id;
	}
	
	public function getListInscritos($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status='', $texto='', $paginaAtual=0, $paginaLimite=0) {
		try {
			 $this->banco->conecta();
			 
			 $inicioPagina = ($paginaAtual*$paginaLimite)-$paginaLimite;
			 $fimPagina = ($inicioPagina+1) + $paginaLimite;
			 
			 //pegar ativos e ultmo passo == 7
			
			$sql = "SELECT * FROM vw_inscrito WHERE  1=1";
			
			if($texto != '')
			{
				$sql .= " AND (inscricao = '" . $texto. "' OR cpf = '" . $texto. "'  OR nome like '%" . $texto. "%') ";	
			}
			else
			{
				if($categoria != '0')
				$sql .= " AND categoria = '" . $categoria. "'";
				
				if($estado != '0')
				$sql .= " AND estado = '" . $estado. "'";		
				
				if($esc_categoria != '0')
				$sql .= " AND esc_categoria = '" . $esc_categoria. "'";	
				
				if($prof_disciplina != '0')
				$sql .= " AND prof_disciplina = '" . $prof_disciplina. "'";	
				
				if($status != '')
				$sql .= " AND inscricao_status = " . $status;
				
				if($atuacao != '0')
				$sql .= " AND atuacao = '" . $atuacao . "'";
						
				if($segmento != '0')
				{
				
				$sql .= " AND (prof_segmento = '" . $segmento. "'  OR (";
				
				switch ($segmento) {
								case 'EI':
									$sql .= "seg_edu_inf = 1 ";	
									break;
								case 'FI':
									$sql .= "seg_edu_fun_i = 1";
									break;
								case 'FII':
									$sql .= "seg_edu_fun_ii = 1";
									break;
								case 'EM':
									$sql .= "seg_edu_med = 1";
									break;
							}
				
				$sql .= "))";
					
				
				}
				
			}
			
			$sql  .= " ORDER BY data_inscricao DESC";
			
			if($paginaAtual > 1 && $paginaLimite>0){
				$limite_inferior = ($paginaAtual-1)*$paginaLimite;
				$sql  .= " LIMIT ".$limite_inferior.",".$paginaLimite."";
			}
			elseif  ($paginaAtual = 1 && $paginaLimite>0){
				$sql  .= " LIMIT 0,".$paginaLimite."";
			}
						
			
			//echo $sql ."<BR><BR>";	
	

						 
			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR InscritoDAO getListInscritos()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}
			
		
			 $this->banco->desconecta();
			
		 } catch(Exception $e) {
       	 	$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO InscritoDAO METODO getListRelease()");
   		 }
		 return $rs;
	}
	
	public function getListInscritosNaoFinalizados($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status='', $texto='', $paginaAtual=0, $paginaLimite=0) {
		try {
			$this->banco->conecta();

			$inicioPagina = ($paginaAtual*$paginaLimite)-$paginaLimite;
			$fimPagina = ($inicioPagina+1) + $paginaLimite;
			 
			$sql = "SELECT * FROM vw_inscrito_nao_finalizado WHERE ultimo_passo < 7";
			
			if ($texto != '') {
				$sql .= " AND (inscricao = '" . $texto. "' OR cpf = '" . $texto. "'  OR nome like '%" . $texto. "%') ";	
			}
			else {
				if ($categoria != '0')
					$sql .= " AND categoria = '" . $categoria. "'";
				
				if ($estado != '0')
					$sql .= " AND estado = '" . $estado. "'";		
				
				if ($esc_categoria != '0')
					$sql .= " AND esc_categoria = '" . $esc_categoria. "'";	
				
				if ($prof_disciplina != '0')
					$sql .= " AND prof_disciplina = '" . $prof_disciplina. "'";	
				
				if ($status != '')
					$sql .= " AND inscricao_status = " . $status;
				
				if ($atuacao != '0')
					$sql .= " AND atuacao = '" . $atuacao . "'";
						
				if ($segmento != '0') {
					$sql .= " AND (prof_segmento = '" . $segmento. "'  OR (";
				
					switch ($segmento) {
						case 'EI':
							$sql .= "seg_edu_inf = 1 ";	
							break;
						case 'FI':
							$sql .= "seg_edu_fun_i = 1";
							break;
						case 'FII':
							$sql .= "seg_edu_fun_ii = 1";
							break;
						case 'EM':
							$sql .= "seg_edu_med = 1";
							break;
					}

					$sql .= "))";
				}
			}
			
			$sql  .= " ORDER BY data_inscricao DESC";
			
			if ($paginaAtual > 1 && $paginaLimite > 0) {
				$limite_inferior = ($paginaAtual-1)*$paginaLimite;
				$sql .= " LIMIT " . $limite_inferior . "," . $paginaLimite . "";
			}
			elseif ($paginaAtual = 1 && $paginaLimite > 0) {
				$sql .= " LIMIT 0," . $paginaLimite . "";
			}

			if (!($rs = $this->banco->executaQuery($sql))) {
				throw new Exception("ERROR InscritoDAO getListInscritos()");
            } else if(mysql_num_rows($rs)<1){
				//throw new Exception("ERROR daoManifest getListManifest()");			
			}

			$this->banco->desconecta();
		}
		catch(Exception $e) {
			$this->banco->desconecta();
			$rs = null;
			throw new Exception("ERRO InscritoDAO METODO getListRelease()");
		}
		return $rs;
	}

	public function getListInscritosNoDisabled($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status, $texto='', $paginaAtual=0, $paginaLimite=0) {
		try {
			 $this->banco->conecta();
			 
			 $inicioPagina = ($paginaAtual*$paginaLimite)-$paginaLimite;
			 $fimPagina = ($inicioPagina+1) + $paginaLimite;
			 
			 //pegar ativos e ultmo passo == 7
			
			$sql = "SELECT * FROM vw_inscrito WHERE  ultimo_passo='7'";
			
			if($texto != '')
			{
				$sql .= " AND (inscricao = '" . $texto. "' OR cpf = '" . $texto. "'  OR nome like '%" . $texto. "%') ";	
			}
			else
			{
				if($categoria != '0')
				$sql .= " AND categoria = '" . $categoria. "'";
				
				if($estado != '0')
				$sql .= " AND estado = '" . $estado. "'";		
				
				if($esc_categoria != '0')
				$sql .= " AND esc_categoria = '" . $esc_categoria. "'";	
				
				if($prof_disciplina != '0')
				$sql .= " AND prof_disciplina = '" . $prof_disciplina. "'";	
				
				if($status != '') {
				$sql .= " AND inscricao_status = " . $status;
				} else {
				$sql .= " AND inscricao_status != 9";
				}
				
				if($atuacao != '0')
				$sql .= " AND atuacao = '" . $atuacao . "'";
						
				if($segmento != '0')
				{
				
				$sql .= " AND (prof_segmento = '" . $segmento. "'  OR (";
				
				switch ($segmento) {
								case 'EI':
									$sql .= "seg_edu_inf = 1 ";	
									break;
								case 'FI':
									$sql .= "seg_edu_fun_i = 1";
									break;
								case 'FII':
									$sql .= "seg_edu_fun_ii = 1";
									break;
								case 'EM':
									$sql .= "seg_edu_med = 1";
									break;
							}
				
				$sql .= "))";
					
				
				}
				
			}
			
			$sql  .= " ORDER BY data_inscricao DESC";
			
			if($paginaAtual > 1 && $paginaLimite>0){
				$limite_inferior = ($paginaAtual-1)*$paginaLimite;
				$sql  .= " LIMIT ".$limite_inferior.",".$paginaLimite."";
			}
			elseif  ($paginaAtual = 1 && $paginaLimite>0){
				$sql  .= " LIMIT 0,".$paginaLimite."";
			}
						
			
			//echo $sql ."<BR><BR>";	
	

						 
			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR InscritoDAO getListInscritos()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}
			
		
			 $this->banco->desconecta();
			
		 } catch(Exception $e) {
       	 	$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO InscritoDAO METODO getListRelease()");
   		 }
		 return $rs;
	}
	
	public function getListById($id) {
		try {
			$this->banco->conecta();
			$sql = "SELECT * FROM vw_inscrito WHERE id=$id";
			
			if (!($rs = $this->banco->executaQuery($sql))) {
	            throw new Exception("ERROR InscritoDAO getListById()");
			}
			else if (mysql_num_rows($rs) < 1 ) {
				// throw new Exception("ERROR daoManifest getListManifest()");			
			}
			
			$this->banco->desconecta();
			
		}
		catch (Exception $e) {
       		$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO InscritoDAO METODO getListRelease()");
   		}
		return $rs;
	}
	
}