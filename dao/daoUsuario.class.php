<?php

class UsuarioDAO {
	
	private $banco;
	
	public function UsuarioDAO() {
		$this->banco = new DAO('../dao/config.xml');
	}
	
	//**********************************************************************************
	
	public function loginUsuario($email, $senha) {
		try{
		$retorno = 0;
		
		$this->banco->conecta();
		$result = $this->banco->executaQuery("SELECT  * FROM `usuario` a, permissoes_usuario b WHERE a.id = b.usuario_id AND a.email='$email' AND a.senha='$senha' AND a.status_ativo=1");
		
		$retorno = $result ;
		
		
		$this->banco->desconecta();
		}
		catch(Exception $e) {
			$retorno = -1;
       	 	$this->banco->desconecta();
	   		throw new Exception("ERRO (UsuarioDAO) - MÉTODO loginUsuario()");
			
		}
		
		return $result;
	}
		
	//**********************************************************************************
	
	public function getDadosPorId($id) {
		$this->banco->conecta();
		$result = $this->banco->executaQuery("SELECT * FROM usuario WHERE id = $id");
		$this->banco->desconecta();
		return $result;
	}

	public function getUsuarios() {
		$this->banco->conecta();
		$result = $this->banco->executaQuery("SELECT * FROM usuario");
		$this->banco->desconecta();
		return $result;
	}
	
	public function getUsuario($email) {
		$this->banco->conecta();
		$result = $this->banco->executaQuery("SELECT * FROM usuario WHERE email='$email'");
		$this->banco->desconecta();
		return $result;
	}
	
	public function getUsuarioExcluindo($email, $id) {
		$this->banco->conecta();
		$result = $this->banco->executaQuery("SELECT * FROM usuario WHERE email='$email' AND id <> $id");
		$this->banco->desconecta();
		return $result;
	}
	
	public function getUsuarioByStatus($email, $ativo = true) {
		if ($ativo) {
			$ativo = 1;
		}
		else {
			$ativo = 0;
		}

		$this->banco->conecta();
		$result = $this->banco->executaQuery("SELECT * FROM usuario WHERE email='$email' AND status_ativo = $ativo");
		$this->banco->desconecta();
		return $result;
	}
	
	public function getPermissoesPorUsuarioId($id) {
		$this->banco->conecta();
		$result = $this->banco->executaQuery("SELECT * FROM permissoes_usuario WHERE usuario_id = $id");
		$this->banco->desconecta();
		return $result;
	}
	
	public function cadastrar($email, $senha, $nome, $cadastro_usuarios, $lista_inscritos, $edicao_inscritos, $relatorios) {
		$data = date('Y-m-d G:i:s');
		
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("INSERT INTO usuario SET email='$email', senha='$senha', nome='$nome', data_cadastro='$data'");
		$this->banco->desconecta();
		$line = mysql_fetch_array($this->getUsuario($email));
		$id = $line['id'];
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("INSERT INTO permissoes_usuario SET cadastro_usuarios=$cadastro_usuarios, lista_inscritos=$lista_inscritos, edicao_inscritos=$edicao_inscritos, relatorios=$relatorios, usuario_id=$id");
		$this->banco->desconecta();
	}
	
	public function atualizar($id, $email, $senha, $nome) {
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("UPDATE usuario SET email='$email', senha='$senha', nome='$nome' WHERE id = $id");
		$this->banco->desconecta();
	}
	
	public function atualizarPermissoes($id, $cadastro_usuarios, $lista_inscritos, $edicao_inscritos, $relatorios) {
		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("UPDATE permissoes_usuario SET cadastro_usuarios=$cadastro_usuarios, lista_inscritos=$lista_inscritos, edicao_inscritos=$edicao_inscritos, relatorios=$relatorios WHERE usuario_id = $id");
		$this->banco->desconecta();
	}
	
	public function getListUsuarios($paginaAtual=0, $paginaLimite=0) {
		try {
			 $this->banco->conecta();
			 
			 $inicioPagina = ($paginaAtual*$paginaLimite)-$paginaLimite;
			 $fimPagina = ($inicioPagina+1) + $paginaLimite;
			 
			 //pegar ativos e ultmo passo == 7
			
			$sql = "SELECT * FROM vw_usuario WHERE 1=1";
			$sql .= " ORDER BY nome ASC";
			
			if($paginaAtual > 1 && $paginaLimite>0){
				$limite_inferior = ($paginaAtual-1)*$paginaLimite;
				$sql  .= " LIMIT ".$limite_inferior.",".$paginaLimite."";
			}
			elseif  ($paginaAtual = 1 && $paginaLimite>0){
				$sql  .= " LIMIT 0,".$paginaLimite."";
			}
			
			
			//echo $sql ."<BR><BR>";

			
			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR UsuarioDAO getListUsuarios()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}
			
		
			 $this->banco->desconecta();
			
		 } catch(Exception $e) {
       	 	$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO UsuarioDAO METODO getListUsuarios()");
   		 }
		 return $rs;
	}
	
	public function getListById($id) {
		try {
			$this->banco->conecta();
			$sql = "SELECT * FROM vw_usuario WHERE id=$id";
			
			if (!($rs = $this->banco->executaQuery($sql))) {
	            throw new Exception("ERROR UsuarioDAO getListById()");
			}
			else if (mysql_num_rows($rs) < 1 ) {
				// throw new Exception("ERROR daoManifest getListManifest()");			
			}
			
			$this->banco->desconecta();
			
		}
		catch (Exception $e) {
       		$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO UsuarioDAO METODO getListById()");
   		}
		return $rs;
	}

}