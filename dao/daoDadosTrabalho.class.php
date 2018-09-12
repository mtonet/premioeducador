<?php

class DadosTrabalhoDAO {
	
	private $banco;
	
	public function DadosTrabalhoDAO() {
		$this->banco = new DAO('../dao/config.xml');
	}
	
	public function insertDados($id, $fileName, $fileSize, $fileType) {
		try {
			$this->banco->conecta();
			$this->banco->executaQuerySemRetorno("INSERT INTO trabalho SET nome_arquivo='$fileName', tipo='$fileType', tamanho='$fileSize', inscrito_id=$id");
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosTrabalhoDAO) - MÉTODO insertDados()");
		}
	}

	public function setStatus($id, $status) {
		try {
			$this->banco->conecta();
			$this->banco->executaQuerySemRetorno("UPDATE trabalho SET status=$status WHERE inscrito_id=$id");echo "UPDATE trabalho SET status=$status WHERE inscrito_id=$id";
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosTrabalhoDAO) - MÉTODO setStatus()");
		}
	}

	public function updateDados($id, $fileName, $fileSize, $fileType) {
		try {
			$this->banco->conecta();
			$this->banco->executaQuerySemRetorno("UPDATE trabalho SET nome_arquivo='$fileName', tipo='$fileType', tamanho='$fileSize' WHERE inscrito_id=$id");
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosTrabalhoDAO) - MÉTODO updateDados()");
		}
	}
	
	public function verificaJaCadastrado($id) {
		try {
			$this->banco->conecta();
			$retorno = 0;
			
			$sql = "SELECT count(*) FROM trabalho WHERE inscrito_id = $id";
			$retorno = $this->banco->executaQuery($sql);
			$row = mysql_fetch_row($retorno);
			
			$retorno = $row[0];
			
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
       	 	$this->banco->desconecta();
	   		throw new Exception("ERRO (DadosCadastraisDAO) - MÉTODO verificaJaCadastrado()");
		}
		
		return $retorno;
	}
	
	public function getDadosPorId($id) {
		try {
			$retorno = 0;
			$this->banco->conecta();
			$retorno = $this->banco->executaQuery("SELECT * FROM trabalho WHERE id = $id");
			$retorno = mysql_fetch_array($retorno);
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosTrabalhoDAO) - MÉTODO getDadosPorId()");
		}
		return $retorno;
	}
	
	public function getDadosPorIdInscrito($id) {
		try {
			$retorno = 0;
			$this->banco->conecta();
			$retorno = $this->banco->executaQuery("SELECT * FROM trabalho WHERE inscrito_id = $id");
			$retorno = mysql_fetch_array($retorno);
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosTrabalhoDAO) - MÉTODO getDadosPorIdInscrito()");
		}
		return $retorno;
	}
}