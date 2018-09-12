<?php

class StatusDAO {
	
	private $banco;
	
	public function StatusDAO() {
		$this->banco = new DAO('../dao/config.xml');
	}
	
	function cadastraStatus($status, $inscrito_id, $usuario_id = 'NULL') {
	
		try {
			$this->banco->conecta();
			$this->banco->executaQuerySemRetorno("INSERT INTO inscricao_status SET status=$status, inscrito_id=$inscrito_id, usuario_id=$usuario_id");
			$this->banco->desconecta();
		}
		catch (Exception $e) {
			$this->banco->desconecta();
			throw new Exception("ERRO (StatusDAO) - MÉTODO cadastraStatus()");
		}
	}
	
	public function getListById($id, $paginaAtual=0, $paginaLimite=0) {
		try {
			 $this->banco->conecta();
			 
			 $inicioPagina = ($paginaAtual*$paginaLimite)-$paginaLimite;
			 $fimPagina = ($inicioPagina+1) + $paginaLimite;
			 
			 //pegar ativos e ultmo passo == 7
			
			$sql = "SELECT * FROM vw_status WHERE inscrito_id=$id";
			$sql .= " ORDER BY data_revisao DESC";
			
			if($paginaAtual > 1 && $paginaLimite>0){
				$limite_inferior = ($paginaAtual-1)*$paginaLimite;
				$sql  .= " LIMIT ".$limite_inferior.",".$paginaLimite."";
			}
			elseif  ($paginaAtual = 1 && $paginaLimite>0){
				$sql  .= " LIMIT 0,".$paginaLimite."";
			}
			
			//echo $sql ."<BR><BR>";

			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR StatusDAO getList()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getList()");			
			}
			
		
			 $this->banco->desconecta();
			
		 } catch(Exception $e) {
       	 	$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO StatusDAO METODO getList()");
   		 }
		 return $rs;
	}
	
	public function getStatusById($id) {
		try {
			$this->banco->conecta();
			
			$sql = "SELECT * FROM vw_status WHERE inscrito_id=$id ORDER BY data_revisao DESC LIMIT 1";
			$rs = $this->banco->executaQuery($sql);
			
			if ($rs == false) {
	            throw new Exception("ERROR StatusDAO getList()");
            }
			
			$this->banco->desconecta();
			
		 } catch (Exception $e) {
       	 	$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO StatusDAO METODO getList()");
   		 }
		 return $rs;
	}
	
}