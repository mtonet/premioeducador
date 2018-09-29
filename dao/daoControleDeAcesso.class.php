<?php

class ControleDeAcessoDAO {
	
	private $banco;
	
	public function ControleDeAcessoDAO() {
		$this->banco = new DAO('../dao/config.xml');
	}
	
	//**********************************************************************************	
	
	
	public function getByCode($code) {		
		$this->banco->conecta();
		$result = $this->banco->executaQuery("SELECT * FROM controle_de_acesso WHERE codigo='$code'");
		$this->banco->desconecta();
		return $result;
	}
	
	public function getByName($nome) {
		$this->banco->conecta();
/*        $result = $this->banco->executaQuery("SELECT * FROM controle_de_acesso WHERE nome LIKE '%$nome%'" .
        " AND confirmado IS NOT NULL" .
        " AND (presente IS NULL OR (acompanhante = 1 AND acompanhante_presente IS NULL))");*/

        $result = $this->banco->executaQuery("SELECT * FROM controle_de_acesso WHERE nome LIKE '%$nome%'");

		$this->banco->desconecta();
		return $result;
	}
	
		
	public function cadastrar($codigo, $origem, $nome, $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $cargo, $acompanhante, $vip, $confirmado) {
		$criado = date('Y-m-d G:i:s');
		
		$this->banco->conecta();

		$query = "INSERT INTO controle_de_acesso SET codigo='$codigo', origem='$origem', nome='$nome', email='$email', telefone='$telefone', celular='$celular', cep='$cep', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', empresa='$empresa', cargo='$cargo', acompanhante=$acompanhante, vip=$vip, criado='$criado', atualizado='$criado'";

		//echo $query; exit;

		if($confirmado)
			$query .= ', confirmado = NOW()';

		$this->banco->executaQuerySemRetorno($query);
		$this->banco->desconecta();		
	}
	
	
	public function atualizar($id, $nome, $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $cargo, $acompanhante) {
		$confirmado = @date('Y-m-d G:i:s');

		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno("UPDATE controle_de_acesso SET nome='$nome', email='$email', telefone='$telefone', celular='$celular', cep='$cep', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$estado', empresa='$empresa', cargo='$cargo', acompanhante=$acompanhante, atualizado='$confirmado', confirmado='$confirmado' WHERE id = $id");
		$this->banco->desconecta();
	}
	
	public function atualizarByAdmin($codigoAntigo, $codigo, $nome, $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $cargo, $acompanhante, $criado, $confirmado) {
		$atualizado = @date('Y-m-d G:i:s');

		$query = "UPDATE controle_de_acesso SET ";

		if($acompanhante=='sim')
			$query .= "acompanhante = 1 ";
		else
			$query .= "acompanhante = 0 ";

		if($confirmado=='sim')
			$query .= ", confirmado = NOW() ";
		else
			$query .= ", confirmado = NULL ";

		$query .= ", codigo='$codigo' ";

		$query .= ", nome='$nome' ";

		$query .= ", email='$email' ";
			
		$query .= ", telefone='$telefone' ";
			
		$query .= ", celular='$celular' ";
			
		$query .= ", cep='$cep' ";
			
		$query .= ", endereco='$endereco' ";
			
		$query .= ", numero='$numero' ";
			
		$query .= ", complemento='$complemento' ";
			
		$query .= ", bairro='$bairro' ";

		$query .= ", cidade='$cidade' ";
			
		$query .= ", estado='$estado' ";
			
		$query .= ", empresa='$empresa' ";

		$query .= ", cargo='$cargo' ";

		$query .= ", atualizado='$atualizado' ";

		$query .= "WHERE codigo = '$codigoAntigo' ";

		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno($query);
		$this->banco->desconecta();
	}
	

	
	public function getList($ordem, $nome, $codigo, $acompanhante, $confirmados, $paginaAtual=0, $paginaLimite=0) {
		try {
			 $this->banco->conecta();
			 
			 $inicioPagina = ($paginaAtual*$paginaLimite)-$paginaLimite;
			 $fimPagina = ($inicioPagina+1) + $paginaLimite;
			 
			 //pegar ativos e ultmo passo == 7
			
			$sql = "SELECT * FROM controle_de_acesso WHERE 1=1";

			//other filters

			if($nome!='')
				$sql .= 'AND nome like "%'.$nome.'%" ';

			

			if($codigo!='')
				$sql .= 'AND codigo like "%'.$codigo.'%" ';

			if($acompanhante=='sim')
				$sql .= 'AND acompanhante = 1 ';
			elseif($acompanhante=='nao')
				$sql .= 'AND acompanhante = 0 ';

			if($confirmados!='' && ($confirmados=='sim' || $confirmados=='confirmados' || $confirmados=='Confirmado') )
				$sql .= 'AND confirmado IS NOT NULL AND confirmado <> \'0000-00-00 00:00:00\' ';
				
			if($confirmados!='' && $confirmados=='nao')
				$sql .= 'AND confirmado IS NULL ';
			

			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR ControleDeAcessoDAO getList()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}

			$ordem = $ordem!=''?$ordem.' ASC':'atualizado DESC';
			$sql .= " ORDER BY $ordem";
			
			if($paginaAtual > 1 && $paginaLimite>0){
				$limite_inferior = ($paginaAtual-1)*$paginaLimite;
				$sql  .= " LIMIT ".$limite_inferior.",".$paginaLimite."";
			}
			elseif  ($paginaAtual = 1 && $paginaLimite>0){
				$sql  .= " LIMIT 0,".$paginaLimite."";
			}

			
			//echo $sql ."<BR><BR>";

			
			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR ControleDeAcessoDAO getList()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}
			
		
			$this->banco->desconecta();
			
		 } catch(Exception $e) {
       	 	$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO ControleDeAcessoDAO METODO getList()");
   		 }
		 return $rs;
	}
	
	public function getPresentList($ordem, $nome, $codigo, $acompanhante, $confirmados, $presentes='', $acompanhantesPresentes = '', $paginaAtual=0, $paginaLimite=0) {
		try {
			 $this->banco->conecta();
			 
			 $inicioPagina = ($paginaAtual*$paginaLimite)-$paginaLimite;
			 $fimPagina = ($inicioPagina+1) + $paginaLimite;
			 
			 //pegar ativos e ultmo passo == 7
			
			$sql = "SELECT * FROM controle_de_acesso WHERE 1=1 ";

			//other filters

			if($nome!='')
				$sql .= 'AND nome like "%'.$nome.'%" ';

			if($codigo!='')
				$sql .= 'AND codigo like "%'.$codigo.'%" ';

			if($acompanhante=='sim')
				$sql .= 'AND acompanhante = 1 ';
			elseif($acompanhante=='nao')
				$sql .= 'AND acompanhante = 0 ';

			if($confirmados!='' && ($confirmados=='sim' || $confirmados=='confirmados' || $confirmados=='Confirmado') )
				$sql .= 'AND confirmado IS NOT NULL AND confirmado <> \'0000-00-00 00:00:00\' ';
				
			if($confirmados!='' && $confirmados=='nao')
				$sql .= 'AND confirmado IS NULL ';
				
			if($presentes!='' && $presentes=='sim')
				$sql .= 'AND presente IS NOT NULL AND presente <> \'0000-00-00 00:00:00\' ';	
			elseif($presentes!='' && $presentes=='nao')
				$sql .= 'AND presente IS NULL OR presente = \'0000-00-00 00:00:00\' ';

			if($acompanhantesPresentes!='' && $acompanhantesPresentes=='sim')
				$sql .= 'AND acompanhante_presente IS NOT NULL AND acompanhante_presente <> \'0000-00-00 00:00:00\' ';	
			elseif($acompanhantesPresentes!='' && $acompanhantesPresentes=='nao')
				$sql .= 'AND acompanhante_presente IS NULL OR acompanhante_presente = \'0000-00-00 00:00:00\' ';
			

			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR ControleDeAcessoDAO getList()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}

			$ordem = $ordem!=''?$ordem.' ASC':'atualizado DESC';
			$sql .= " ORDER BY $ordem";
			
			if($paginaAtual > 1 && $paginaLimite>0){
				$limite_inferior = ($paginaAtual-1)*$paginaLimite;
				$sql  .= " LIMIT ".$limite_inferior.",".$paginaLimite."";
			}
			elseif  ($paginaAtual = 1 && $paginaLimite>0){
				$sql  .= " LIMIT 0,".$paginaLimite."";
			}

			
			//echo $sql ."<BR><BR>";

			
			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR ControleDeAcessoDAO getList()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}
			
		
			$this->banco->desconecta();
			
		 } catch(Exception $e) {
       	 	$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO ControleDeAcessoDAO METODO getList()");
   		 }
		 return $rs;
	}

	public function getTotalList($nome, $codigo, $acompanhante, $confirmados, $presentes='', $acompanhantesPresentes = '') {
		try {
			 $this->banco->conecta();
			 
			 //pegar ativos e ultmo passo == 7
			
			$sql = "SELECT count(*) as total FROM controle_de_acesso WHERE 1=1 ";

			//other filters


			if($nome!='')
				$sql .= 'AND nome like "%'.$nome.'%" ';

			if($codigo!='')
				$sql .= 'AND codigo like "%'.$codigo.'%" ';

			if($acompanhante=='sim')
				$sql .= 'AND acompanhante = 1 ';
			elseif($acompanhante=='nao')
				$sql .= 'AND acompanhante = 0 ';

			if($confirmados!='' && ($confirmados=='sim' || $confirmados=='confirmados' || $confirmados=='Confirmado') )
				$sql .= 'AND confirmado IS NOT NULL AND confirmado <> \'0000-00-00 00:00:00\' ';
				
			if($confirmados!='' && $confirmados=='nao')
				$sql .= 'AND confirmado IS NULL ';
				
			if($presentes!='' && $presentes=='sim')
				$sql .= 'AND presente IS NOT NULL AND presente <> \'0000-00-00 00:00:00\' ';	
			elseif($presentes!='' && $presentes=='nao')
				$sql .= 'AND presente IS NULL OR presente = \'0000-00-00 00:00:00\' ';

			if($acompanhantesPresentes!='' && $acompanhantesPresentes=='sim')
				$sql .= 'AND acompanhante_presente IS NOT NULL AND acompanhante_presente <> \'0000-00-00 00:00:00\' ';	
			elseif($acompanhantesPresentes!='' && $acompanhantesPresentes=='nao')
				$sql .= 'AND acompanhante_presente IS NULL OR acompanhante_presente = \'0000-00-00 00:00:00\' ';

			//echo $sql;


			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR ControleDeAcessoDAO getList()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}
			
		
			 $this->banco->desconecta();
			
		 } catch(Exception $e) {
       	 	$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO ControleDeAcessoDAO METODO getList()");
   		 }

   		 $total = mysql_fetch_assoc($rs);

		 return $total['total'];
	}
	
	
	public function getListByKeyword($keyword, $paginaAtual=0, $paginaLimite=0) {
		try {
			 $this->banco->conecta();
			 
			 $inicioPagina = ($paginaAtual*$paginaLimite)-$paginaLimite;
			 $fimPagina = ($inicioPagina+1) + $paginaLimite;
			 
			 //pegar ativos e ultmo passo == 7
			
			$sql = "SELECT * FROM controle_de_acesso WHERE 1=1 ";

			//other filters

			if($keyword!='')
				$sql .= 'AND (nome like "%'.$keyword.'%" OR codigo like "%'.$keyword.'%" OR email like "%'.$keyword.'%") ';


			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR ControleDeAcessoDAO getList()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}


			$sql .= " ORDER BY codigo ASC";
			
			if($paginaAtual > 1 && $paginaLimite>0){
				$limite_inferior = ($paginaAtual-1)*$paginaLimite;
				$sql  .= " LIMIT ".$limite_inferior.",".$paginaLimite."";
			}
			elseif  ($paginaAtual = 1 && $paginaLimite>0){
				$sql  .= " LIMIT 0,".$paginaLimite."";
			}

			
			//echo $sql ."<BR><BR>";

			
			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR ControleDeAcessoDAO getList()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}
			
		
			$this->banco->desconecta();
			
		 } catch(Exception $e) {
       	 	$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO ControleDeAcessoDAO METODO getList()");
   		 }
		 return $rs;
	}

	public function getTotalListByKeyword($keyword) {
		try {
			 $this->banco->conecta();
			 
			 //pegar ativos e ultmo passo == 7
			
			$sql = "SELECT count(*) as total FROM controle_de_acesso WHERE 1=1 ";

			//other filters


			if($keyword!='')
				$sql .= 'AND (nome like "%'.$keyword.'%" OR codigo like "%'.$keyword.'%" OR email like "%'.$keyword.'%") ';

			//echo $sql;


			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR ControleDeAcessoDAO getList()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}
			
		
			 $this->banco->desconecta();
			
		 } catch(Exception $e) {
       	 	$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO ControleDeAcessoDAO METODO getList()");
   		 }

   		 $total = mysql_fetch_assoc($rs);

		 return $total['total'];
	}




	public function atualizarByCVS($codigo, $nome, $telefone, $celular, $email) {
		$atualizado = @date('Y-m-d G:i:s');

		$query = "UPDATE controle_de_acesso SET ";

		
		$query .= "nome='$nome' ";

		//if($telefone!='' && $telefone!=' ')
			$query .= ", telefone='$telefone' ";

		//if($celular!='')
			$query .= ", celular='$celular' ";

		//if($email!='')
			$query .= ", email='$email' ";

		$query .= ", atualizado='$atualizado' ";

		$query .= "WHERE codigo = '$codigo' ";

		//echo $query;

		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno($query);
		$this->banco->desconecta();
	}

	public function presenca_confirmada($codigo, $acompanhantePresente) {
		$atualizado = @date('Y-m-d G:i:s');

		$query = "UPDATE controle_de_acesso SET ";

		if($acompanhantePresente=='sim')
			$query .= "acompanhante_presente = '$atualizado' ";
		else
			$query .= "acompanhante_presente = null ";
		
		$query .= ", atualizado='$atualizado', presente='$atualizado' ";

		$query .= "WHERE codigo = '$codigo' ";

		//echo $query; exit;

		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno($query);
		$this->banco->desconecta();
	}

    public function confirmarPresencaConvidado($codigo, $convidadoPresente)
    {
        if ( $convidadoPresente === 'sim' )
        {
            $convidadoPresenteAux = date('Y-m-d H:i:s');
            $queryConvidadoPresente = "UPDATE controle_de_acesso SET convidado_presente = '{$convidadoPresenteAux}'";
            $this->banco->conecta();
            $this->banco->executaQuerySemRetorno($queryConvidadoPresente);
            $this->banco->desconecta();
        }
    }

	public function confirmacao($codigo, $acompanhante) {
		$atualizado = @date('Y-m-d G:i:s');

		$query = "UPDATE controle_de_acesso SET ";

		if($acompanhante=='sim')
			$query .= "acompanhante = 1 ";
		else
			$query .= "acompanhante = 0 ";
		
		$query .= ", atualizado='$atualizado', presente='$atualizado' ";

		$query .= "WHERE codigo = '$codigo' ";

		//echo $query; exit;

		$this->banco->conecta();
		$this->banco->executaQuerySemRetorno($query);
		$this->banco->desconecta();
	}

	public function getRandomList($limit=null){
		try {
			 $this->banco->conecta();
			 
			$sql = "SELECT * FROM controle_de_acesso WHERE 1=1 ";

			$sql .= " ORDER BY rand() ";
			
			if($limit){				
				$sql  .= " LIMIT $limit";
			}
		
			if(!($rs = $this->banco->executaQuery($sql))) {
	                throw new Exception("ERROR ControleDeAcessoDAO getList()");
            }else if(mysql_num_rows($rs)<1){
					//throw new Exception("ERROR daoManifest getListManifest()");			
			}
			
		
			$this->banco->desconecta();
			
		 } catch(Exception $e) {
       	 	$this->banco->desconecta();
			$rs = null;
	   		throw new Exception("ERRO ControleDeAcessoDAO METODO getList()");
   		 }
		 return $rs;
	}

}
