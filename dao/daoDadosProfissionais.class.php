<?php

class DadosProfissionaisDAO {
	
	private $banco;
	
	public function DadosProfissionaisDAO() {
		$this->banco = new DAO('../dao/config.xml');
	}
	
	public function insertDados($id, $nome, $ideb_escola, $ideb_municipio, $categoria, $localizacao, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $email, $telefone, $fax, $cargo) {
		
		try{
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("INSERT INTO escola SET nome='$nome', ideb_escola='$ideb_escola', ideb_municipio='$ideb_municipio', categoria='$categoria', localizacao='$localizacao', cep='$cep', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', email='$email', telefone='$telefone', fax='$fax', cargo='$cargo', inscrito_id=$id");
		$this->banco->desconecta();
		}
		catch(Exception $e){
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosProfissionaisDAO) - MÉTODO insertDados()");
		}
	}
	
	
	public function updateDados($id, $nome, $ideb_escola, $ideb_municipio, $categoria, $localizacao, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $email, $telefone, $fax, $cargo) {
		try{
		
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("UPDATE escola  SET nome='$nome', ideb_escola='$ideb_escola', ideb_municipio='$ideb_municipio', categoria='$categoria', localizacao='$localizacao', cep='$cep', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', email='$email', telefone='$telefone', fax='$fax', cargo='$cargo' WHERE inscrito_id=$id");
		$this->banco->desconecta();
		}
		catch(Exception $e){
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosProfissionaisDAO) - MÉTODO updateDados()");
		}
		
	}
	
	public function getDadosPorIdInscrito($id) {
	try{
		$retorno = 0;
		$this->banco->conecta();
		$retorno = $this->banco->executaQuery("SELECT * FROM escola WHERE inscrito_id = $id");
		$retorno = mysql_fetch_array($retorno);
		$this->banco->desconecta();
		}
	catch(Exception $e) {
		$retorno = -1;
       	$this->banco->desconecta();
	   	throw new Exception("ERRO (DadosProfissionaisDAO) - MÉTODO getDadosPorIdInscrito()");
			
		}
		return $retorno;
	}
	
	
	public function verificaJaCadastrado($id) {
		try{
			$this->banco->conecta();
			$retorno = 0;
			
			$sql = "SELECT count(*) FROM escola WHERE inscrito_id = $id";
			$retorno = $this->banco->executaQuery($sql);
			$row = mysql_fetch_row($retorno);
			
			$retorno = $row[0];
			
			$this->banco->desconecta();
			
		}
		catch(Exception $e) {
			$retorno = -1;
       	 	$this->banco->desconecta();
	   		throw new Exception("ERRO (DadosProfissionaisDAO) - MÉTODO verificaJaCadastrado()");
			
		}
		
		return $retorno;
		
	}

}