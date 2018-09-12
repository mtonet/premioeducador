<?
//colocar no config e o dir ser uma variavel publica
$DIR =(strpos($_SERVER["PHP_SELF"],'admin') > 0) ? "../" : "";
require_once($DIR."business/facadeInscrito.php");

class SessionFacadeDadosCadastrais {

	
	// Atualiza usuario
	// '0' - erro.
	public function insertDadosCadastrais($id, $nome, $sexo, $faixa_etaria, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $telefone, $celular, $rg, $orgao, $fonte){
		try{
			$retorno = 0;
			$DadosCadastraisDAO = new DadosCadastraisDAO();
				
			$DadosCadastraisDAO->insertDados($id, $nome, $sexo, $faixa_etaria, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $telefone, $celular, $rg, $orgao, $fonte);
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}

	
		public function DadosCadastrais($id, $nome, $sexo, $faixa_etaria, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $telefone, $celular, $rg, $orgao, $fonte, $fonte_outro = null, $email, $senha) {
		try{
			$retorno = 0;
			$DadosCadastraisDAO = new DadosCadastraisDAO();
			$existe = $DadosCadastraisDAO->verificaJaCadastrado($id);
			
			if($existe == 0)
				$DadosCadastraisDAO->insertDados($id, $nome, $sexo, $faixa_etaria, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $telefone, $celular, $rg, $orgao, $fonte, $fonte_outro, $email, $senha);
			else
				$DadosCadastraisDAO->updateDados($id, $nome, $sexo, $faixa_etaria, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $telefone, $celular, $rg, $orgao, $fonte, $fonte_outro, $email, $senha);
				
							
			
			if ($email != ''){
			$DadosCadastraisDAO->updateDadosEmailSenha($id, $email, $senha);
			}
			
			if ( isset($_SESSION['id']) && $existe == 0 ) {
				$InscritoFacade =  new SessionFacadeInscrito();
				$InscritoFacade->setPasso();
			}
		
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	
	public function verificaJaCadastrado($id){
		try{
			$retorno = 0;
			$DadosCadastraisDAO = new DadosCadastraisDAO();
				
			$retorno = $DadosCadastraisDAO->verificaJaCadastrado($id);
		}
		catch(Exception $e){
	
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	
	
	public function getDadosPorIdInscrito($id) {
		try{
			$retorno = 0;
			
			$DadosCadastraisDAO = new DadosCadastraisDAO();
			$retorno = $DadosCadastraisDAO->getDadosPorIdInscrito($id);
			
		}
		catch(Exception $e){
			$retorno = -1;
			
		}
		
		return $retorno;
		
	}
	
	
	
}

?>