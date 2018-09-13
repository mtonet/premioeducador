<?php

class DadosGestorDAO {
	
	private $banco;
	
	public function DadosGestorDAO() {
		$this->banco = new DAO('../dao/config.xml');
	}
	
	public function insertDados($id, $atuacao, $segmento_ei, $segmento_fi, $segmento_fii, $segmento_em, $titulo, $numero, $duracao, $ano_trabalho, $necessidades) {
		try {
			$this->banco->conecta();
			$this->banco->executaQuerySemRetorno("INSERT INTO dados_gestor SET atuacao='$atuacao', seg_edu_inf=$segmento_ei, seg_edu_fun_i=$segmento_fi, seg_edu_fun_ii=$segmento_fii, seg_edu_med=$segmento_em, titulo='$titulo', numero_alunos=$numero, duracao='$duracao', ano_trabalho='$ano_trabalho', nece_especial='$necessidades', inscrito_id=$id");
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosGestorDAO) - MÉTODO insertDados()");
		}
	}

	public function updateDados($id, $atuacao, $segmento_ei, $segmento_fi, $segmento_fii, $segmento_em, $titulo, $numero, $duracao, $ano_trabalho, $necessidades) {
		try {
			$this->banco->conecta();
			$this->banco->executaQuerySemRetorno("UPDATE dados_gestor SET atuacao='$atuacao', seg_edu_inf=$segmento_ei, seg_edu_fun_i=$segmento_fi, seg_edu_fun_ii=$segmento_fii, seg_edu_med=$segmento_em, titulo='$titulo', numero_alunos=$numero, duracao='$duracao', ano_trabalho='$ano_trabalho', nece_especial='$necessidades' WHERE inscrito_id=$id");
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosGestorDAO) - MÉTODO updateDados()");
		}
	}
	
	public function verificaJaCadastrado($id) {
		try {
			$this->banco->conecta();
			$retorno = 0;
			
			$sql = "SELECT count(*) FROM dados_gestor WHERE inscrito_id = $id";
			$retorno = $this->banco->executaQuery($sql);
			$row = mysql_fetch_row($retorno);
			
			$retorno = $row[0];
			
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
       	 	$this->banco->desconecta();
	   		throw new Exception("ERRO (DadosGestorDAO) - MÉTODO verificaJaCadastrado()");
		}
		
		return $retorno;
	}
	
	public function getDadosPorId($id) {
		try {
			$retorno = 0;
			$this->banco->conecta();
			$retorno = $this->banco->executaQuery("SELECT * FROM dados_gestor WHERE id = $id");
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosGestorDAO) - MÉTODO getDadosPorId()");
		}
		return $retorno;
	}
	
	public function getDadosPorIdInscrito($id) {
		try {
			$retorno = 0;
			$this->banco->conecta();
			$retorno = $this->banco->executaQuery("SELECT * FROM dados_gestor WHERE inscrito_id = $id");
			$retorno = mysql_fetch_array($retorno);
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$retorno = -1;
			$this->banco->desconecta();
			throw new Exception("ERRO (DadosGestorDAO) - MÉTODO getDadosPorIdInscrito()");
		}
		return $retorno;
	}

}