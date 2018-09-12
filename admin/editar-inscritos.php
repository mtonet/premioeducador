<?php
require_once("functions.php");
require_once("../dao/dao.class.php");

require_once("../business/facadeInscrito.php");
require_once("../business/facadeAtualizacao.php");
require_once("../business/facadeDadosCadastrais.php");
require_once("../business/facadeDadosProfissionais.php");
require_once("../business/facadeDadosAcademicos.php");
require_once("../business/facadeDadosGestor.php");
require_once("../business/facadeDadosProfessor.php");

//******************** valida user admin ***********************
validaUsuarioAdmin('edicao-inscritos');
//******************** valida user admin ***********************

//##corrigir e colocar no padrao com facade
//deixar logica na facade e codigo mais limpo

$id_usuario = mysql_escape_string($_SESSION['usuario_id']);

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;

$facadeDadosCad = new SessionFacadeDadosCadastrais();
$facadeDadosPro = new SessionFacadeDadosProfissionais();
$facadeDadosAca = new SessionFacadeDadosAcademicos();
$facadeDadosProfessor = new SessionFacadeDadosProfessor();
$facadeDadosGestor = new SessionFacadeDadosGestor();
$facadeInscrito = new SessionFacadeInscrito();
$facadeAtualizacao = new SessionFacadeAtualizacao();

if ($action == 'save-cadastro') {
	$status = mysql_escape_string($_REQUEST['cadastro-status']);

	$nome = mysql_escape_string( utf8_decode($_REQUEST['cadastro-nome']) );
	$sexo = mysql_escape_string($_REQUEST['cadastro-sexo']);
	$faixa_etaria = mysql_escape_string($_REQUEST['cadastro-faixa-etaria']);
	$cep = mysql_escape_string($_REQUEST['cadastro-cep']);
	$endereco = mysql_escape_string( utf8_decode($_REQUEST['cadastro-endereco']) );
	$numero = mysql_escape_string($_REQUEST['cadastro-numero']);
	$complemento = mysql_escape_string($_REQUEST['cadastro-complemento']);
	$bairro = mysql_escape_string( utf8_decode($_REQUEST['cadastro-bairro']) );
	$cidade = mysql_escape_string( utf8_decode($_REQUEST['cadastro-cidade']) );
	$estado = mysql_escape_string($_REQUEST['cadastro-estado']);
	$telefone = mysql_escape_string($_REQUEST['cadastro-telefone']);
	$celular = mysql_escape_string($_REQUEST['cadastro-celular']);
	
	
	$email = mysql_escape_string($_REQUEST['cadastro-email']);
	$senha = mysql_escape_string($_REQUEST['cadastro-senha']);	
	
	$rg = mysql_escape_string($_REQUEST['cadastro-rg']);
	$orgao = mysql_escape_string($_REQUEST['cadastro-orgao']);
	$fonte = mysql_escape_string($_REQUEST['cadastro-fonte']);
	$fonte_outro = mysql_escape_string( utf8_decode($_REQUEST['fonte-outro']) );
	
	$facadeDadosCad->DadosCadastrais($id, $nome, $sexo, $faixa_etaria, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $telefone, $celular, $rg, $orgao, $fonte, $fonte_outro, $email, $senha);
	$facadeStatus = new SessionFacadeStatus();
	$facadeStatus->cadastraStatus($status, $id, $id_usuario);
}
elseif ($action == 'save-escola') {
	$nome = mysql_escape_string( utf8_decode($_REQUEST['escola-nome']) );
	$ideb_escola = mysql_escape_string($_REQUEST['escola-ideb-escola']);
	$ideb_municipio = mysql_escape_string($_REQUEST['escola-ideb-municipio']);
	$categoria = mysql_escape_string($_REQUEST['escola-categoria']);
	$localizacao = mysql_escape_string($_REQUEST['escola-localizacao']);
	$cep = mysql_escape_string($_REQUEST['escola-cep']);
	$endereco = mysql_escape_string( utf8_decode($_REQUEST['escola-endereco']) );
	$numero = mysql_escape_string($_REQUEST['escola-numero']);
	$complemento = mysql_escape_string($_REQUEST['escola-complemento']);
	$bairro = mysql_escape_string( utf8_decode($_REQUEST['escola-bairro']) );
	$cidade = mysql_escape_string( utf8_decode($_REQUEST['escola-cidade']) );
	$estado = mysql_escape_string($_REQUEST['escola-estado']);
	$email = mysql_escape_string( utf8_decode($_REQUEST['escola-email']) );
	$telefone = mysql_escape_string($_REQUEST['escola-telefone']);
	$fax = mysql_escape_string($_REQUEST['escola-fax']);
	$cargo = mysql_escape_string( utf8_decode($_REQUEST['escola-cargo']) );
	
	$facadeDadosPro->DadosProfissionais($id, $nome, $ideb_escola, $ideb_municipio, $categoria, $localizacao, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $email, $telefone, $fax, $cargo);
}
elseif ($action == 'save-academia') {
	$formacao = mysql_escape_string($_REQUEST['academia-formacao']);
	$instituto = mysql_escape_string( utf8_decode($_REQUEST['academia-instituto']) );
	$curso = mysql_escape_string( utf8_decode($_REQUEST['academia-curso']) );
	$cidade = mysql_escape_string( utf8_decode($_REQUEST['academia-cidade']) );
	$estado = mysql_escape_string($_REQUEST['academia-estado']);
	$conclusao = mysql_escape_string($_REQUEST['academia-ano-conclusao']);
	
	$facadeDadosAca->DadosAcademicos($id, $formacao, $instituto, $curso, $cidade, $estado, $conclusao);
}
elseif ($action == 'save-trabalho') {
	$categoria = $_REQUEST['trabalho-categoria'];
	
	$titulo = mysql_escape_string( utf8_decode($_REQUEST['trabalho-titulo']) );
	$numero = mysql_escape_string($_REQUEST['trabalho-numero-alunos']);
	$duracao = mysql_escape_string( utf8_decode($_REQUEST['trabalho-duracao']) );
	$ano_trabalho = mysql_escape_string($_REQUEST['trabalho-ano-realizacao']);
	$necessidades = mysql_escape_string($_REQUEST['trabalho-necessidades']);
	
	if ($categoria == 'P') {
		$segmento = mysql_escape_string($_REQUEST['trabalho-segmento']);
		
		$disciplina = null;		
		if ($segmento == 'FI' || $segmento == 'FII') {
			$disciplina = mysql_escape_string($_REQUEST['trabalho-disciplina']);
		}
		
		$faixa_etaria = mysql_escape_string( utf8_decode($_REQUEST['trabalho-faixa-etaria']) );
		$ano_turma = mysql_escape_string( utf8_decode($_REQUEST['trabalho-ano-turma']) );
		
		
		$facadeDadosProfessor->DadosProfessor($id, $segmento, $disciplina, $faixa_etaria, $ano_turma, $titulo, $numero, $duracao, $ano_trabalho, $necessidades);
		//$facadeInscrito->setCategoria('P');
	}
	elseif ($categoria == 'G') {
		$segmento_ei = isset($_REQUEST['trabalho-segmento-ei'])? 1 : 0;
		$segmento_fi = isset($_REQUEST['trabalho-segmento-fi'])? 1 : 0;
		$segmento_fii = isset($_REQUEST['trabalho-segmento-fii'])? 1 : 0;
		$segmento_em = isset($_REQUEST['trabalho-segmento-em'])? 1 : 0;
		$atuacao = mysql_escape_string($_REQUEST['trabalho-atuacao']);
		
		$facadeDadosGestor->DadosGestor($id, $atuacao, $segmento_ei, $segmento_fi, $segmento_fii, $segmento_em, $titulo, $numero, $duracao, $ano_trabalho, $necessidades);
		//$facadeInscrito->setCategoria('G');
	}
}

if ( isset($id) ) {
	$line = $facadeInscrito->getListById($id);
	$line = mysql_fetch_array($line);
	
	$status = $facadeAtualizacao->getStatusById($id);
}

if ( !isset($id) || $line == false ) {
	header("location: lista-inscritos.php");
}


include("header.php");
?>

    	<!--<section class="main-dados">-->
			<header class="topo-float">
            	<h1>Editar inscrito</h1>
                <div class="subnav">
                <ul class="nav nav-pills">          
                  <?php include("submenu.php"); ?>
                </ul>
  				</div>
            </header>                             
     		<div class="dados-cadastrais">
				<div class="simpleTabs" style="margin-top:35px;">
					<ul class="simpleTabsNavigation">
					  <li><a href="#cadastro-area">Dados cadastrais</a></li>
					  <li><a href="#escola-area">Dados profissionais</a></li>
					  <li><a href="#academia-area">Dados acadêmicos</a></li>
					  <li><a href="#trabalho-area">Dados do trabalho</a></li>
					</ul>
    
					<div class="simpleTabsContent">
					  <form action="editar-inscritos.php" method="POST" style="margin-top:30px;" id="cadastro-area">
						<input type="hidden" name="action" value="save-cadastro">
						<input type="hidden" name="id" value="<?php echo $line['id']; ?>">
									<table width="80%" border="0">
				  <tr>
					<td width="48%" class="right"><label>Data</label></td>
					<td width="2%">&nbsp;</td>
					<td width="50%"><input type="text" class="input-xlarge" value="<?php $tempo = strtotime($line['data_inscricao']); echo date('d.m.Y H:i', $tempo); ?>" disabled></td>
				  </tr>
				  <tr>
					<td class="right"><label>Inscrição</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" value="<?php echo $line['inscricao']; ?>" disabled></td>
				  </tr>
				  <tr>
					<td class="right"><label>Status</label></td>
					<td>&nbsp;</td>
					<td>
						<select name="cadastro-status">
							<option <?php if ($line['inscricao_status'] == 0) echo "selected"; ?> value="0">Não impresso</option>
							<option <?php if ($line['inscricao_status'] == 1) echo "selected"; ?> value="1">Ficha-impressa</option>
							<option <?php if ($line['inscricao_status'] == 2) echo "selected"; ?> value="2">Trabalho-impresso</option>
							<option <?php if ($line['inscricao_status'] == 3) echo "selected"; ?> value="3">Não selecionado</option>
							<!--<option <?php if ($line['inscricao_status'] == 4) echo "selected"; ?> value="4">Desclassificado</option>
							<option <?php if ($line['inscricao_status'] == 5) echo "selected"; ?> value="5">Pré-selecionado</option> 
							<option <?php if ($line['inscricao_status'] == 6) echo "selected"; ?> value="6">Em avaliação</option>-->
							<option <?php if ($line['inscricao_status'] == 7) echo "selected"; ?> value="7">Finalista</option>
							<option <?php if ($line['inscricao_status'] == 8) echo "selected"; ?> value="8">Vencedor</option>
							<option <?php if ($line['inscricao_status'] == 9) echo "selected"; ?> value="9">Desativado</option>
                            <option <?php if ($line['inscricao_status'] == 10) echo "selected"; ?> value="10">Premiado</option>
						</select>
					</td>
				  </tr>
				  <tr>
					<td class="right"><label>Nome</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-nome" value="<?php echo utf8_encode($line['nome']); ?>"></td>
				  </tr>
                  
 				  <tr>
					<td class="right"><label>E-mail</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-email" value="<?php echo $line['email'] ?>"></td>
				  </tr>
                  
				  <tr>
					<td class="right"><label>Senha</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-senha" value="<?php echo $line['senha'] ?>"></td>
				  </tr>                                   
                  
                  
                  
				  <tr>
					<td class="right"><label>Sexo</label></td>
					<td>&nbsp;</td>
					<td>
					<label class="radio" style="float:left; margin-right:30px;">
				   <input type="radio" name="cadastro-sexo" <?php if ($line['sexo'] == 'M') { echo 'checked="checked"'; } ?> value="M" id="optionsRadios1" name="optionsRadios"/>
				   Masculino
				   </label>
				   <label class="radio">
				   <input type="radio" name="cadastro-sexo" <?php if ($line['sexo'] == 'F') { echo 'checked="checked"'; } ?> value="F" id="optionsRadios1" name="optionsRadios"/>
				   Feminino
				   </label>
				   </td>
				  </tr>
				  <tr>
					<td class="right"><label>Faixa etária</label></td>
					<td>&nbsp;</td>
					<td>
						<select name="cadastro-faixa-etaria">
							<option value="" <?php if ($line['faixa_etaria'] == 0) echo "selected"; ?>>Selecione</option>
							<option value="1" <?php if ($line['faixa_etaria'] == 1) echo "selected"; ?>>Até 20 anos</option>
							<option value="2" <?php if ($line['faixa_etaria'] == 2) echo "selected"; ?>>de 21 a 30 anos</option>
							<option value="3" <?php if ($line['faixa_etaria'] == 3) echo "selected"; ?>>de 31 a 40 anos</option>
							<option value="4" <?php if ($line['faixa_etaria'] == 4) echo "selected"; ?>>de 41 a 50 anos</option>
							<option value="5" <?php if ($line['faixa_etaria'] == 5) echo "selected"; ?>>de 51 a 60 anos</option>                
							<option value="6" <?php if ($line['faixa_etaria'] == 6) echo "selected"; ?>>Acima de 60 anos</option>
						</select>
					</td>
				  </tr>
				  <tr>
					<td class="right"><label>Cep</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-cep" value="<?php echo $line['cep']; ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Endereço</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-endereco" value="<?php echo utf8_encode($line['endereco']); ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Número</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-numero" value="<?php echo $line['numero']; ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Complemento</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-complemento" value="<?php echo $line['complemento']; ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Bairro</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-bairro" value="<?php echo utf8_encode($line['bairro']); ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Cidade</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-cidade" value="<?php echo utf8_encode($line['cidade']); ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Estado</label></td>
					<td>&nbsp;</td>
					<td>
						<select name="cadastro-estado">
							<option <?php  if ($line['estado'] == "")  echo "SELECTED "  ?>></option>
							<option value="AC" <?php  if ($line['estado'] =="AC")  echo "SELECTED "  ?>>Acre</option>
							<option value="AL" <?php  if ($line['estado'] =="AL")  echo "SELECTED "  ?>>Alagoas</option>
							<option value="AP" <?php  if ($line['estado'] =="AP")  echo "SELECTED "  ?>>Amapá</option>
							<option value="AM" <?php  if ($line['estado'] =="AM")  echo "SELECTED "  ?>>Amazonas</option>
							<option value="BA" <?php  if ($line['estado'] =="BA")  echo "SELECTED "  ?>>Bahia</option>
							<option value="CE" <?php  if ($line['estado'] =="CE")  echo "SELECTED "  ?>>Ceará</option>
							<option value="DF" <?php  if ($line['estado'] =="DF")  echo "SELECTED "  ?>>Distrito Federal</option>
							<option value="ES" <?php  if ($line['estado'] =="ES")  echo "SELECTED "  ?>>Espírito Santo</option>
							<option value="GO" <?php  if ($line['estado'] =="GO")  echo "SELECTED "  ?>>Goiás</option>
							<option value="MA" <?php  if ($line['estado'] =="MA")  echo "SELECTED "  ?>>Maranhão</option>
							<option value="MT" <?php  if ($line['estado'] =="MT")  echo "SELECTED "  ?>>Mato Grosso</option>
							<option value="MS" <?php  if ($line['estado'] =="MS")  echo "SELECTED "  ?>>Mato Grosso do Sul</option>
							<option value="MG" <?php  if ($line['estado'] =="MG")  echo "SELECTED "  ?>>Minas Gerais</option>
							<option value="PA" <?php  if ($line['estado'] =="PA")  echo "SELECTED "  ?>>Pará</option>
							<option value="PB" <?php  if ($line['estado'] =="PB")  echo "SELECTED "  ?>>Paraíba</option>
							<option value="PR" <?php  if ($line['estado'] =="PR")  echo "SELECTED "  ?>>Paraná</option>
							<option value="PE" <?php  if ($line['estado'] =="PE")  echo "SELECTED "  ?>>Pernambuco</option>
							<option value="PI" <?php  if ($line['estado'] =="PI")  echo "SELECTED "  ?>>Piauí</option>
							<option value="RJ" <?php  if ($line['estado'] =="RJ")  echo "SELECTED "  ?>>Rio de Janeiro</option>
							<option value="RN" <?php  if ($line['estado'] =="RN")  echo "SELECTED "  ?>>Rio Grande do Norte</option>
							<option value="RS" <?php  if ($line['estado'] =="RS")  echo "SELECTED "  ?>>Rio Grande do Sul</option>
							<option value="RO" <?php  if ($line['estado'] =="RO")  echo "SELECTED "  ?>>Rondônia</option>
							<option value="RR" <?php  if ($line['estado'] =="RR")  echo "SELECTED "  ?>>Roraima</option>
							<option value="SC" <?php  if ($line['estado'] =="SC")  echo "SELECTED "  ?>>Santa Catarina</option>
							<option value="SP" <?php  if ($line['estado'] =="SP")  echo "SELECTED "  ?>>São Paulo</option>
							<option value="SE" <?php  if ($line['estado'] =="SE")  echo "SELECTED "  ?>>Sergipe</option>
							<option value="TO" <?php  if ($line['estado'] =="TO")  echo "SELECTED "  ?>>Tocantins</option>
						</select>
					</td>
				  </tr>
				  <tr>
					<td class="right"><label>Telefone residencial</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-telefone" value="<?php echo $line['telefone']; ?>"></td>
				  </tr>
				  <tr>
				   <td class="right"><label>Telefone celular</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-celular" value="<?php echo $line['celular']; ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>CPF</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-cpf" value="<?php echo $line['cpf'] ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>RG</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-rg" value="<?php echo $line['rg'] ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Órgão emissor</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="cadastro-orgao" value="<?php echo $line['orgao_emissor'] ?>"></td>
				  </tr>

				  <tr>
					<td class="right"><label>Onde conheceu?</label></td>
					<td>&nbsp;</td>
					<td>
						<select id="select-como" name="cadastro-fonte">
							<option></option>
							<option value="1" <?php  if ($line['fonte'] =="1")  echo "SELECTED "  ?>>Revista NOVA ESCOLA</option>
							<option value="2"  <?php  if ($line['fonte'] =="2")  echo "SELECTED "  ?>>Revista GESTÃO ESCOLAR</option>
							<option value="3"  <?php  if ($line['fonte'] =="3")  echo "SELECTED "  ?>>Outras revistas</option>
							<option value="4"  <?php  if ($line['fonte'] =="4")  echo "SELECTED "  ?>>Site NOVA ESCOLA</option>
							<option value="5"  <?php  if ($line['fonte'] =="5")  echo "SELECTED "  ?>>Outros sites</option>
							<option value="6"  <?php  if ($line['fonte'] =="6")  echo "SELECTED "  ?>>Rádio</option>
							<option value="7"  <?php  if ($line['fonte'] =="7")  echo "SELECTED "  ?>>E-mail marketing</option>
							<option value="8"  <?php  if ($line['fonte'] =="8")  echo "SELECTED "  ?>>Secretaria Municipal de Educação</option>
							<option value="9"  <?php  if ($line['fonte'] =="8")  echo "SELECTED "  ?>>Secretaria Estadual de Educação</option>
							<option value="10"  <?php  if ($line['fonte'] =="10")  echo "SELECTED "  ?>>Orkut</option>
							<option value="11"  <?php  if ($line['fonte'] =="11")  echo "SELECTED "  ?>>Facebook</option>
							<option value="12"  <?php  if ($line['fonte'] =="12")  echo "SELECTED "  ?>>Twitter</option>
							<option value="13"  <?php  if ($line['fonte'] =="13")  echo "SELECTED "  ?>>Outros. Qual?</option>
						</select>
					</td>
				  </tr>
				  <tr id="tr-como-outro" <?php if ($line['fonte'] != "13") echo 'style="display: none"' ?>>
					<td class="right"><label>Outro</label></td>
					<td>&nbsp;</td>
					<td>
						<input type="text" class="input-xlarge" id="input-como-outro" name="fonte-outro" value="<?php echo utf8_encode($line['fonte_outro']); ?>">
					</td>
				  </tr>
				</table>
				<p align="center" style="margin-top:10px; margin-bottom:40px;"><button class="btn btn btn-success">Salvar</button></p>        		
			</form>
					</div>
					
					<div class="simpleTabsContent">
					  <form action="editar-inscritos.php" method="POST" style="margin-top:30px;" id="escola-area">
					  <input type="hidden" name="action" value="save-escola">
					  <input type="hidden" name="id" value="<?php echo $line['id']; ?>">
									<table width="80%" border="0">
				  <tr>
					<td width="48%" class="right"><label>Nome da Escola</label></td>
					<td width="2%">&nbsp;</td>
					<td width="50%"><input type="text" class="input-xlarge" name="escola-nome" value="<?php echo utf8_encode($line['esc_nome']); ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>IDEB 2009 da escola</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-ideb-escola" value="<?php echo $line['esc_ideb_escola']; ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>IDEB 2009 do município</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-ideb-municipio" value="<?php echo $line['esc_ideb_municipio']; ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Categoria da escola</label></td>
					<td>&nbsp;</td>
					<td>
					<select name="escola-categoria">
						<option></option>
						<option value="1" <?php  if ($line['esc_categoria'] == 1)  echo "SELECTED "  ?>>Pública</option>
						<option value="2" <?php  if ($line['esc_categoria'] == 2)  echo "SELECTED "  ?>>Particular</option>
						<option value="3" <?php  if ($line['esc_categoria'] == 3)  echo "SELECTED "  ?>>Comunitária</option>
						<option value="4" <?php  if ($line['esc_categoria'] == 4)  echo "SELECTED "  ?>>Particular Filantrópica</option>
					</select>
					</td>
				  </tr>
				  <tr>
					<td class="right"><label>Localização da escola</label></td>
					<td>&nbsp;</td>
					<td>
						<select name="escola-localizacao">
							<option></option>
							<option value="U" <?php  if ($line['esc_localizacao'] == "U")  echo "SELECTED "  ?>>Urbana</option>
							<option value="R" <?php  if ($line['esc_localizacao'] == "R" ) echo "SELECTED "  ?>>Rural</option>
						</select>    
					</td>
				  </tr>
				  <tr>
					<td class="right"><label>Cep da escola</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-cep" value="<?php echo $line['esc_cep']; ?>"></td>
				  </tr>    
				  <tr>
					<td class="right"><label>Endereço da escola</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-endereco" value="<?php echo utf8_encode($line['esc_endereco']); ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Número</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-numero" value="<?php echo $line['esc_numero']; ?>"></td>
				  </tr>  
				  <tr>
					<td class="right"><label>Complemento</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-complemento" value="<?php echo $line['esc_complemento']; ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Bairro</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-bairro" value="<?php echo utf8_encode($line['esc_bairro']); ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Cidade</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-cidade" value="<?php echo utf8_encode($line['esc_cidade']); ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Estado</label></td>
					<td>&nbsp;</td>
					<td>
					  <select id="select-estado" name="escola-estado">
						<option></option>
						<option value="AC" <?php  if ($line['esc_estado'] =="AC")  echo "SELECTED "  ?>>Acre</option>
						<option value="AL" <?php  if ($line['esc_estado'] =="AL")  echo "SELECTED "  ?>>Alagoas</option>
						<option value="AP" <?php  if ($line['esc_estado'] =="AP")  echo "SELECTED "  ?>>Amapá</option>
						<option value="AM" <?php  if ($line['esc_estado'] =="AM")  echo "SELECTED "  ?>>Amazonas</option>
						<option value="BA" <?php  if ($line['esc_estado'] =="BA")  echo "SELECTED "  ?>>Bahia</option>
						<option value="CE" <?php  if ($line['esc_estado'] =="CE")  echo "SELECTED "  ?>>Ceará</option>
						<option value="DF" <?php  if ($line['esc_estado'] =="DF")  echo "SELECTED "  ?>>Distrito Federal</option>
						<option value="ES" <?php  if ($line['esc_estado'] =="ES")  echo "SELECTED "  ?>>Espírito Santo</option>
						<option value="GO" <?php  if ($line['esc_estado'] =="GO")  echo "SELECTED "  ?>>Goiás</option>
						<option value="MA" <?php  if ($line['esc_estado'] =="MA")  echo "SELECTED "  ?>>Maranhão</option>
						<option value="MT" <?php  if ($line['esc_estado'] =="MT")  echo "SELECTED "  ?>>Mato Grosso</option>
						<option value="MS" <?php  if ($line['esc_estado'] =="MS")  echo "SELECTED "  ?>>Mato Grosso do Sul</option>
						<option value="MG" <?php  if ($line['esc_estado'] =="MG")  echo "SELECTED "  ?>>Minas Gerais</option>
						<option value="PA" <?php  if ($line['esc_estado'] =="PA")  echo "SELECTED "  ?>>Pará</option>
						<option value="PB" <?php  if ($line['esc_estado'] =="PB")  echo "SELECTED "  ?>>Paraíba</option>
						<option value="PR" <?php  if ($line['esc_estado'] =="PR")  echo "SELECTED "  ?>>Paraná</option>
						<option value="PE" <?php  if ($line['esc_estado'] =="PE")  echo "SELECTED "  ?>>Pernambuco</option>
						<option value="PI" <?php  if ($line['esc_estado'] =="PI")  echo "SELECTED "  ?>>Piauí</option>
						<option value="RJ" <?php  if ($line['esc_estado'] =="RJ")  echo "SELECTED "  ?>>Rio de Janeiro</option>
						<option value="RN" <?php  if ($line['esc_estado'] =="RN")  echo "SELECTED "  ?>>Rio Grande do Norte</option>
						<option value="RS" <?php  if ($line['esc_estado'] =="RS")  echo "SELECTED "  ?>>Rio Grande do Sul</option>
						<option value="RO" <?php  if ($line['esc_estado'] =="RO")  echo "SELECTED "  ?>>Rondônia</option>
						<option value="RR" <?php  if ($line['esc_estado'] =="RR")  echo "SELECTED "  ?>>Roraima</option>
						<option value="SC" <?php  if ($line['esc_estado'] =="SC")  echo "SELECTED "  ?>>Santa Catarina</option>
						<option value="SP" <?php  if ($line['esc_estado'] =="SP")  echo "SELECTED "  ?>>São Paulo</option>
						<option value="SE" <?php  if ($line['esc_estado'] =="SE")  echo "SELECTED "  ?>>Sergipe</option>
						<option value="TO" <?php  if ($line['esc_estado'] =="TO")  echo "SELECTED "  ?>>Tocantins</option>
					  </select>
					</td>
				  </tr>
				  <tr>
					<td class="right"><label>E-mail da escola</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-email" value="<?php echo utf8_encode($line['esc_email']); ?>"></td>
				  </tr>    
				  <tr>
					<td class="right"><label>Telefone</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-telefone" value="<?php echo $line['esc_telefone']; ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Fax</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-fax" value="<?php echo $line['esc_fax']; ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Cargo</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="escola-cargo" value="<?php echo utf8_encode($line['esc_cargo']); ?>"></td>
				  </tr>
				</table>
				<p align="center" style="margin-top:10px; margin-bottom:40px;"><button class="btn btn btn-success">Salvar</button></p>        		
								</form>
					</div>

					<div class="simpleTabsContent">
					  <form action="editar-inscritos.php" method="POST" style="margin-top:30px;" id="academia-area">
					  <input type="hidden" name="action" value="save-academia">
					  <input type="hidden" name="id" value="<?php echo $line['id']; ?>">
									<table width="80%" border="0">
				  <tr>
					<td width="48%" class="right"><label>Formação</label></td>
					<td width="2%">&nbsp;</td>
					<td width="50%">
					  <select id="select-formacao" name="academia-formacao">
						<option></option>
						<option value="NM" <?php  if ($line['formacao'] =="NM")  echo "SELECTED "  ?>>Nível Médio</option>
						<option value="SI" <?php  if ($line['formacao'] =="SI")  echo "SELECTED "  ?>>Superior Incompleto</option>
						<option value="SC" <?php  if ($line['formacao'] =="SC")  echo "SELECTED "  ?>>Superior Completo</option>
						<option value="PG" <?php  if ($line['formacao'] =="PG")  echo "SELECTED "  ?>>Pós-Graduação</option>
					  </select>
					</td>
				  </tr>
				  <tr>
					<td class="right"><label>Instituição de graduação</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="academia-instituto" value="<?php echo utf8_encode($line['instituto']); ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Curso</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="academia-curso" value="<?php echo utf8_encode($line['curso']); ?>"></td>
				  </tr>    
				  <tr>
					<td class="right"><label>Cidade</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="academia-cidade" value="<?php echo utf8_encode($line['aca_cidade']); ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Estado</label></td>
					<td>&nbsp;</td>
					<td>
						<select id="select-estado" name="academia-estado">
							<option></option>
							<option value="AC" <?php  if ($line['aca_estado'] =="AC")  echo "SELECTED "  ?>>Acre</option>
							<option value="AL" <?php  if ($line['aca_estado'] =="AL")  echo "SELECTED "  ?>>Alagoas</option>
							<option value="AP" <?php  if ($line['aca_estado'] =="AP")  echo "SELECTED "  ?>>Amapá</option>
							<option value="AM" <?php  if ($line['aca_estado'] =="AM")  echo "SELECTED "  ?>>Amazonas</option>
							<option value="BA" <?php  if ($line['aca_estado'] =="BA")  echo "SELECTED "  ?>>Bahia</option>
							<option value="CE" <?php  if ($line['aca_estado'] =="CE")  echo "SELECTED "  ?>>Ceará</option>
							<option value="DF" <?php  if ($line['aca_estado'] =="DF")  echo "SELECTED "  ?>>Distrito Federal</option>
							<option value="ES" <?php  if ($line['aca_estado'] =="ES")  echo "SELECTED "  ?>>Espírito Santo</option>
							<option value="GO" <?php  if ($line['aca_estado'] =="GO")  echo "SELECTED "  ?>>Goiás</option>
							<option value="MA" <?php  if ($line['aca_estado'] =="MA")  echo "SELECTED "  ?>>Maranhão</option>
							<option value="MT" <?php  if ($line['aca_estado'] =="MT")  echo "SELECTED "  ?>>Mato Grosso</option>
							<option value="MS" <?php  if ($line['aca_estado'] =="MS")  echo "SELECTED "  ?>>Mato Grosso do Sul</option>
							<option value="MG" <?php  if ($line['aca_estado'] =="MG")  echo "SELECTED "  ?>>Minas Gerais</option>
							<option value="PA" <?php  if ($line['aca_estado'] =="PA")  echo "SELECTED "  ?>>Pará</option>
							<option value="PB" <?php  if ($line['aca_estado'] =="PB")  echo "SELECTED "  ?>>Paraíba</option>
							<option value="PR" <?php  if ($line['aca_estado'] =="PR")  echo "SELECTED "  ?>>Paraná</option>
							<option value="PE" <?php  if ($line['aca_estado'] =="PE")  echo "SELECTED "  ?>>Pernambuco</option>
							<option value="PI" <?php  if ($line['aca_estado'] =="PI")  echo "SELECTED "  ?>>Piauí</option>
							<option value="RJ" <?php  if ($line['aca_estado'] =="RJ")  echo "SELECTED "  ?>>Rio de Janeiro</option>
							<option value="RN" <?php  if ($line['aca_estado'] =="RN")  echo "SELECTED "  ?>>Rio Grande do Norte</option>
							<option value="RS" <?php  if ($line['aca_estado'] =="RS")  echo "SELECTED "  ?>>Rio Grande do Sul</option>
							<option value="RO" <?php  if ($line['aca_estado'] =="RO")  echo "SELECTED "  ?>>Rondônia</option>
							<option value="RR" <?php  if ($line['aca_estado'] =="RR")  echo "SELECTED "  ?>>Roraima</option>
							<option value="SC" <?php  if ($line['aca_estado'] =="SC")  echo "SELECTED "  ?>>Santa Catarina</option>
							<option value="SP" <?php  if ($line['aca_estado'] =="SP")  echo "SELECTED "  ?>>São Paulo</option>
							<option value="SE" <?php  if ($line['aca_estado'] =="SE")  echo "SELECTED "  ?>>Sergipe</option>
							<option value="TO" <?php  if ($line['aca_estado'] =="TO")  echo "SELECTED "  ?>>Tocantins</option>
							</select>
					</td>
				  </tr>  
				  <tr>
					<td class="right"><label>Ano de conclusão</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="academia-ano-conclusao" value="<?php echo $line['conclusao'] ?>"></td>
				  </tr>
				</table>
				<p align="center" style="margin-top:10px; margin-bottom:40px;"><button class="btn btn btn-success">Salvar</button></p>        		
							  </form>
					</div>
					
					<div class="simpleTabsContent">
			<form action="editar-inscritos.php" method="POST" style="margin-top:30px;" id="trabalho-area">
			<input type="hidden" name="action" value="save-trabalho">
			<input type="hidden" name="id" value="<?php echo $line['id']; ?>">
									<table width="80%" border="0">
				  <tr>
					<td class="right"><label>Escolha a categoria</label></td>
					<td>&nbsp;</td>
					<td>
						<input type="hidden" name="trabalho-categoria" value="<?php echo $line['categoria']; ?>" />
						<input class="input-xlarge disabled" id="disabledInput" value="<?php if ($line['categoria'] == 'P'): echo 'Professor'; elseif ($line['categoria'] == 'G'): echo 'Gestor'; endif; ?> Nota 10" disabled="disabled" type="text">            
				   </td>
				  </tr>
					<td class="right"><label>Segmento</label></td>
					<td>&nbsp;</td>
					<td>
                    
                    
					<?php if ($line['categoria'] == 'P'): ?>
						<select id="select05" name="trabalho-segmento" style="width:279px;">                        
							<option value="EIC" <?php if ($line['prof_segmento'] == "EI")  echo "SELECTED "  ?>>Educação Infantil :Creche</option>
                            
							<option value="EIP" <?php if ($line['prof_segmento'] == "EI")  echo "SELECTED "  ?>>Educação Infantil: Pré-escola</option>                            
                            
							<option value="FI" <?php if ($line['prof_segmento'] == "FI")  echo "SELECTED "  ?>>Ensino Fundamental I</option>
							<option value="FII" <?php if ($line['prof_segmento'] == "FII")  echo "SELECTED "  ?>>Ensino Fundamental II</option>
						</select>
					<?php elseif ($line['categoria'] == 'G'): ?>
						<input type="checkbox" id="input-segmento-gestor-ei" name="trabalho-segmento-ei" value="EIC" <?php if ($line['seg_edu_inf'] == 1): ?> checked="checked" <?php endif; ?>> Educação Infantil: Creche</label>
						<input type="checkbox" id="input-segmento-gestor-ei" name="trabalho-segmento-ei" value="EIP" <?php if ($line['seg_edu_inf'] == 1): ?> checked="checked" <?php endif; ?>> Educação Infantil: Pré-escola</label>                        
                        
                        
                        
                        
                        
						<input type="checkbox" id="input-segmento-gestor-fi" name="trabalho-segmento-fi" value="FI" <?php if ($line['seg_edu_fun_i'] == 1): ?> checked="checked" <?php endif; ?>> Ensino Fundamental I</label>
						<input type="checkbox" id="input-segmento-gestor-fii" name="trabalho-segmento-fii" value="FII" <?php if ($line['seg_edu_fun_ii'] == 1): ?> checked="checked" <?php endif; ?>> Ensino Fundamental II</label>
						<input type="checkbox" id="input-segmento-gestor-em" name="trabalho-segmento-em" value="EM" <?php if ($line['seg_edu_med'] == 1): ?> checked="checked" <?php endif; ?>> Ensino Médio</label>
					<?php endif; ?>
					 </td>
				  </tr>
				  <?php if ($line['categoria'] == 'G'): ?>
				  <tr>
					<td class="right"><label>Atuação</label></td>
					<td>&nbsp;</td>
					<td>
						<input type="radio" id="input-atuacao-d" name="trabalho-atuacao" value="D" <?php if ($line['atuacao'] == 'D'): ?> checked="checked" <?php endif; ?>> Diretor Escolar
						<input type="radio" id="input-atuacao-c" name="trabalho-atuacao" value="C" <?php if ($line['atuacao'] == 'C'): ?> checked="checked" <?php endif; ?>> Coordenador Escolar
						<input type="radio" id="input-atuacao-o" name="trabalho-atuacao" value="O" <?php if ($line['atuacao'] == 'O'): ?> checked="checked" <?php endif; ?>> Orientador Pedagógico
					</td>
				  </tr>
				  <?php endif; ?>
				  
				  <?php if ($line['categoria'] == 'P'): ?>
				  <tr>
					<td class="right"><label>Disciplina</label></td>
					<td>&nbsp;</td>
					<td>
		              <select id="select-disciplina" name="trabalho-disciplina">
						<option></option>
						<option value="1" <?php if ($line['prof_disciplina'] == 1): ?> selected="selected" <?php endif; ?>>Alfabetização</option>
						<option value="2" <?php if ($line['prof_disciplina'] == 2): ?> selected="selected" <?php endif; ?>>Artes</option>
						<option value="3" <?php if ($line['prof_disciplina'] == 3): ?> selected="selected" <?php endif; ?>>Ciências</option>
						<option value="4" <?php if ($line['prof_disciplina'] == 4): ?> selected="selected" <?php endif; ?>>Educação Física</option>
						<option value="5" <?php if ($line['prof_disciplina'] == 5): ?> selected="selected" <?php endif; ?>>Geografia</option>
						<option value="6" <?php if ($line['prof_disciplina'] == 6): ?> selected="selected" <?php endif; ?>>História</option>
						<option value="7" <?php if ($line['prof_disciplina'] == 7): ?> selected="selected" <?php endif; ?>>Língua Estrangeira</option>
						<option value="8" id="portugues" <?php if ($line['prof_disciplina'] == 8): ?> selected="selected" <?php endif; ?>>Língua Portuguesa Fund. I</option>
						<option value="9" id="matematica" <?php if ($line['prof_disciplina'] == 9): ?> selected="selected" <?php endif; ?>>Matemática Fund. I</option>
					  </select>
					</td>
				  </tr>
				  <?php endif; ?>
				  <tr>
					<td class="right"><label>Título do trabalho</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="trabalho-titulo" maxlength="40" <?php if ($line['categoria'] == 'P'): ?> value="<?php echo utf8_encode($line['prof_titulo']); ?>" <?php else: ?> value="<?php echo utf8_encode($line['titulo']); ?>" <?php endif; ?>></td>
				  </tr>
				  <?php if ($line['categoria'] == 'P'): ?>
				  <tr>
					<td class="right"><label>Ano da turma</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="trabalho-ano-turma" value="<?php echo utf8_encode($line['prof_ano_turma']); ?>"></td>
				  </tr>
				  <tr>
					<td class="right"><label>Faixa etária dos alunos</label></td>
					<td>&nbsp;</td>
					<td>
						<input type="text" class="input-xlarge" id="input-idade" name="trabalho-faixa-etaria" value="<?php echo utf8_encode($line['prof_faixa_etaria']); ?>">
					</td>
				  </tr>
				  <?php endif; ?>
				  <tr>
					<td class="right"><label>Número de alunos envolvidos</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="trabalho-numero-alunos" <?php if ($line['categoria'] == 'P'): ?> value="<?php echo $line['prof_numero_alunos']; ?>" <?php else: ?> value="<?php echo $line['numero_alunos']; ?>" <?php endif; ?>></td>
				  </tr>
				  <tr>
					<td class="right"><label>Duração do trabalho</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="trabalho-duracao" <?php if ($line['categoria'] == 'P'): ?> value="<?php echo utf8_encode($line['prof_duracao']); ?>" <?php else: ?> value="<?php echo utf8_encode($line['duracao']); ?>" <?php endif; ?>></td>
				  </tr>
				  <tr>
					<td class="right"><label>Ano de realização do trabalho</label></td>
					<td>&nbsp;</td>
					<td><input type="text" class="input-xlarge" name="trabalho-ano-realizacao" <?php if ($line['categoria'] == 'P'): ?> value="<?php echo $line['prof_ano_trabalho']; ?>" <?php else: ?> value="<?php echo $line['ano_trabalho']; ?>" <?php endif; ?>></td>
				  </tr>
				  <tr>
					<td class="right"><label>Necessidades educacionais especiais</label></td>
					<td>&nbsp;</td>
					<td>
						<label class="radio" style="float:left; margin-right:30px;">
							<input type="radio" id="input-necessidades-s" name="trabalho-necessidades" value="1" <?php if ($line['categoria'] == 'P'): if ($line['prof_nece_especial'] == 1): ?> checked="checked" <?php endif; else: if ($line['nece_especial'] == 1): ?> checked="checked" <?php endif; endif; ?>> Sim
						</label>
						<label class="radio">
							<input type="radio" id="input-necessidades-n" name="trabalho-necessidades" value="0" <?php if ($line['categoria'] == 'P'): if ($line['prof_nece_especial'] == 0): ?> checked="checked" <?php endif; else: if ($line['nece_especial'] == 0): ?> checked="checked" <?php endif; endif; ?>> Não
						</label>
				   </td>
				  </tr>  
				</table>
				<p align="center" style="margin-top:10px; margin-bottom:40px;"><button class="btn btn btn-success">Salvar</button></p>        		
			</form>
					</div>
					
				  </div>
            <p>Última atualização: <?php print_ultima_atualizacao($status); ?></p>
            </div><!--Fim dados-cadastrais-->

<?php get_footer(); ?>