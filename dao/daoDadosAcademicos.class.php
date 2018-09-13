<?php

class DadosAcademicosDAO {
	
	private $banco;
	
	public function DadosAcademicosDAO() {
		$this->banco = new DAO('../dao/config.xml');
	}
	
	public function insertDados($id, $formacao, $instituto, $curso, $cidade, $estado, $conclusao) {
	try{
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("INSERT INTO dados_academicos SET formacao='$formacao', instituto='$instituto', curso='$curso', cidade='$cidade', estado='$estado', conclusao='$conclusao', inscrito_id=$id");
		$this->banco->desconecta();
		}
		catch(Exception $e){
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosAcademicosDAO) - MÉTODO insertDados()");
		}
	}
	
	
		public function updateDados($id, $formacao, $instituto, $curso, $cidade, $estado, $conclusao) {
		try{
		
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("UPDATE dados_academicos SET formacao='$formacao', instituto='$instituto', curso='$curso', cidade='$cidade', estado='$estado', conclusao='$conclusao' WHERE inscrito_id=$id");
		$this->banco->desconecta();
		}
		catch(Exception $e){
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosAcademicosDAO) - MÉTODO updateDados()");
		}
		
	}
	


	
	
	public function verificaJaCadastrado($id) {
		try{
			$this->banco->conecta();
			$retorno = 0;
			
			$sql = "SELECT count(*) FROM dados_academicos WHERE inscrito_id = $id";
			$retorno = $this->banco->executaQuery($sql);
			$row = mysql_fetch_row($retorno);
			
			$retorno = $row[0];
			
			$this->banco->desconecta();
			
		}
		catch(Exception $e) {
			$retorno = -1;
       	 	$this->banco->desconecta();
	   		throw new Exception("ERRO (DadosAcademicosDAO) - MÉTODO selectUsuario()");
			
		}
		
		return $retorno;
		
	}
	
	
	public function getDadosPorIdInscrito($id) {
	try{
		$retorno = 0;
		$this->banco->conecta();
		$retorno = $this->banco->executaQuery("SELECT * FROM dados_academicos WHERE inscrito_id = $id");
		$retorno = mysql_fetch_array($retorno);
		$this->banco->desconecta();
		}
	catch(Exception $e) {
		$retorno = -1;
       	$this->banco->desconecta();
	   	throw new Exception("ERRO (DadosAcademicosDAO) - MÉTODO getDadosPorIdInscrito()");
			
		}
		return $retorno;
	}

}