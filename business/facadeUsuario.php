<?php
//colocar no config e o dir ser uma variavel publica
$DIR =(strpos($_SERVER["PHP_SELF"],'admin') > 0) ? "../" : "";


require_once("/home/premioeducador2015/www/dao/daoUsuario.class.php");


class SessionFacadeUsuario {

	//Login
	//Listagem
	//
	
	public function login($email, $senha) {
		try {
			$retorno = 0;
			$UsuarioDAO = new UsuarioDAO();
				
			$result = $UsuarioDAO->loginUsuario($email, $senha);
			$retorno = mysql_fetch_array($result);
			
			if($retorno['id']  > 0)
			{
			session_start();
			//session_destroy();
			$_SESSION['usuario_id'] = $retorno['id'];
			$_SESSION['cadastro_usuarios'] = $retorno['cadastro_usuarios'];
			$_SESSION['lista_inscritos'] = $retorno['lista_inscritos'];
			$_SESSION['edicao_inscritos'] = $retorno['edicao_inscritos'];
			$_SESSION['relatorios'] = $retorno['relatorios'];
			
			$retorno = 1;
			} else 
			$retorno = 0;
			
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function verificaJaCadastrado($email) {
		try {
			$retorno = 0;
			$UsuarioDAO = new UsuarioDAO();
			
			if ($UsuarioDAO->getUsuario($email) == false) {
				$retorno = -1;
			}
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function cadastra($email, $senha, $nome, $cadastro_usuarios, $lista_inscritos, $edicao_inscritos, $relatorios) {
		try {
			$retorno = 0;
			$UsuarioDAO = new UsuarioDAO();
			
			$retorno = $UsuarioDAO->cadastrar($email, $senha, $nome, $cadastro_usuarios, $lista_inscritos, $edicao_inscritos, $relatorios);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function atualiza($id, $email, $senha, $nome, $cadastro_usuarios, $lista_inscritos, $edicao_inscritos, $relatorios) {
		try {
			$retorno = 0;
			$UsuarioDAO = new UsuarioDAO();
			
			$retorno = $UsuarioDAO->atualizar($id, $email, $senha, $nome);
			$retorno = $UsuarioDAO->atualizarPermissoes($id, $cadastro_usuarios, $lista_inscritos, $edicao_inscritos, $relatorios);
		}
		catch (Exception $e) {
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	public function getList($pagAtual=0, $pagLimite=0) {
		
		$retorno = null;
		
		try {
				$UsuarioDAO = new UsuarioDAO();	
				$retorno = $UsuarioDAO->getListUsuarios($pagAtual, $pagLimite);
			}
			catch (Exception $e) 
			{
				$retorno = null;
			}
		
		return $retorno;
   }

   	public function getListById($id) {
		$retorno = null;
		
		try {
			$UsuarioDAO = new UsuarioDAO();	
			$retorno = $UsuarioDAO->getListById($id);
		}
		catch (Exception $e) {
			$retorno = null;
		}
		
		return $retorno;
   }

}

?>