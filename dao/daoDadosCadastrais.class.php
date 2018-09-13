<?php

class DadosCadastraisDAO {
	
	private $banco;
	
	public function DadosCadastraisDAO() {
		$this->banco =  new DAO('../dao/config.xml');	
	}
	

	public function insertDados($id, $nome, $sexo, $faixa_etaria, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $telefone, $celular, $rg, $orgao, $fonte, $fonte_outro = null) {
		try {
			$sql = "INSERT INTO dados_cadastrais SET nome='$nome', sexo='$sexo', faixa_etaria='$faixa_etaria', cep='$cep', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', telefone='$telefone', celular='$celular', rg='$rg', orgao_emissor='$orgao', fonte='$fonte'";
			if ($fonte == 13 && isset($fonte_outro) && $fonte_outro != '') {
				$sql .= ", fonte_outro='$fonte_outro'";
			}
			$sql .= ", inscrito_id=$id";
			$this->banco->conecta();
			$this->banco->executaQuerySemRetorno($sql);
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosCadastraisDAO) - MÉTODO insertDados()");
		}
		
	}
	
	public function updateDados($id, $nome, $sexo, $faixa_etaria, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $telefone, $celular, $rg, $orgao, $fonte, $fonte_outro = null, $email, $senha) {
		try {
			$sql = "UPDATE dados_cadastrais SET nome='$nome', sexo='$sexo', faixa_etaria=$faixa_etaria, cep='$cep', endereco='$endereco', numero=$numero, complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', telefone='$telefone', celular='$celular', rg='$rg', orgao_emissor='$orgao', fonte=$fonte";
			if ($fonte == 13 && isset($fonte_outro) && $fonte_outro != '') {
				$sql .= ", fonte_outro='$fonte_outro'";
			}
			$sql .= " WHERE inscrito_id=$id";
			
			$this->banco->conecta();
			$this->banco->executaQuerySemRetorno($sql);
			$this->banco->desconecta();

		}
		catch (Exception $e) {
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosCadastraisDAO) - MÉTODO updateDados()");
		}
		
	}
	

	public function updateDadosEmailSenha($id, $email, $senha) {
		try {
			$sql = "UPDATE inscrito SET email='$email', senha='$senha'";
			$sql .= " WHERE id=$id";
			
			$this->banco->conecta();
			$this->banco->executaQuerySemRetorno($sql);
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosCadastraisDAO) - MÉTODO updateDadosEmailSenha()");
		}
		
	}	
	
	
	public function verificaJaCadastrado($id) {
		try{
			$this->banco->conecta();
			$retorno = 0;
			
			$sql = "SELECT count(*) FROM dados_cadastrais WHERE inscrito_id = $id";
			$retorno = $this->banco->executaQuery($sql);
			$row = mysql_fetch_row($retorno);
			
			$retorno = $row[0];
			
			$this->banco->desconecta();
			
		}
		catch(Exception $e) {
			$retorno = -1;
       	 	$this->banco->desconecta();
	   		throw new Exception("ERRO (DadosCadastraisDAO) - MÉTODO selectUsuario()");
			
		}
		
		return $retorno;
		
	}
	
	public function getDadosPorId($id) {
		$this->banco->conecta();
		$retorno = $this->banco->executaQuery("SELECT * FROM dados_cadastrais WHERE id = $id");
		$this->banco->desconecta();
		return $retorno;
	}
	
	public function getDadosPorIdInscrito($id) {
	try{
		$retorno = 0;
		$this->banco->conecta();
		$retorno = $this->banco->executaQuery("SELECT * FROM dados_cadastrais WHERE inscrito_id = $id");
		$retorno = mysql_fetch_array($retorno);
		$this->banco->desconecta();
		}
	catch(Exception $e) {
		$retorno = -1;
       	$this->banco->desconecta();
	   	throw new Exception("ERRO (DadosCadastraisDAO) - MÉTODO getDadosPorIdInscrito()");
			
		}
		return $retorno;
	}

}