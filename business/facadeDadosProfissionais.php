<?
//colocar no config e o dir ser uma variavel publica
$DIR =(strpos($_SERVER["PHP_SELF"],'admin') > 0) ? "../" : "";
require_once($DIR."business/facadeInscrito.php");

class SessionFacadeDadosProfissionais {

	
	public function insertDadosProfissionais($id, $nome, $ideb_escola, $ideb_municipio, $categoria, $localizacao, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $email, $telefone, $fax, $cargo){
		try{
			$retorno = 0;
			$DadosProfissionaisDAO = new DadosProfissionaisDAO();
				
			$DadosProfissionaisDAO->insertDados($id, $nome, $ideb_escola, $ideb_municipio, $categoria, $localizacao, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $email, $telefone, $fax, $cargo);
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}

	
		public function DadosProfissionais($id, $nome, $ideb_escola, $ideb_municipio, $categoria, $localizacao, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $email, $telefone, $fax, $cargo){
		try{
			$retorno = 0;
			$DadosProfissionaisDAO = new DadosProfissionaisDAO();
			$existe = $DadosProfissionaisDAO->verificaJaCadastrado($id);
			
			$ideb_escola = (string) $ideb_escola;
			$ideb_municipio = (string) $ideb_municipio;
			
			$ideb_escola = str_replace(',', '.', $ideb_escola);
			$ideb_municipio = str_replace(',', '.', $ideb_municipio);
			
			if($existe == 0)
				$DadosProfissionaisDAO->insertDados($id, $nome, $ideb_escola, $ideb_municipio, $categoria, $localizacao, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $email, $telefone, $fax, $cargo);
			else
				$DadosProfissionaisDAO->updateDados($id, $nome, $ideb_escola, $ideb_municipio, $categoria, $localizacao, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $email, $telefone, $fax, $cargo);
		
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
			$DadosProfissionaisDAO = new DadosProfissionaisDAO();
				
			$retorno = $DadosProfissionaisDAO->verificaJaCadastrado($id);
		}
		catch(Exception $e){
			$retorno = -1;
		}
		
		return $retorno;
	}
	
	
	
	public function getDadosPorIdInscrito($id) {
		try{
			$retorno = 0;
			
			$DadosProfissionaisDAO = new DadosProfissionaisDAO();
			$retorno = $DadosProfissionaisDAO->getDadosPorIdInscrito($id);
			
		}
		catch(Exception $e){
			$retorno = -1;
			
		}
		
		return $retorno;
		
	}
	
	
	
}

?>