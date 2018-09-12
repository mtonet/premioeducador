<?php 
require_once("config.php");
require_once("functions.php");
require_once("functions-g.php");
require_once('dao/dao.class.php');
require_once("dao/daoDadosProfissionais.class.php");
require_once("business/facadeDadosProfissionais.php");

//******************************** valida loginPasso **********************************
validaPassoLogin(2); 
//******************************** valida loginPasso **********************************

//******************************** variaveis **********************************
$id = mysql_escape_string($_SESSION['id']);
$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;
$facadeInscrito = new SessionFacadeInscrito();
$facadeDadosPro = new SessionFacadeDadosProfissionais();


//******************************** action form **********************************

//$inscrito = new InscritoDAO('dao\config.xml');


if ($action == 'save') {
	$nome = mysql_escape_string( utf8_decode($_REQUEST['nome']) );
	$ideb_escola = mysql_escape_string($_REQUEST['ideb-escola']);
	$ideb_municipio = mysql_escape_string($_REQUEST['ideb-municipio']);
	$categoria = mysql_escape_string($_REQUEST['categoria']);
	$localizacao = mysql_escape_string($_REQUEST['localizacao']);
	$cep = mysql_escape_string($_REQUEST['cep']);
	$endereco = mysql_escape_string( utf8_decode($_REQUEST['endereco']) );
	$numero = mysql_escape_string($_REQUEST['numero']);
	$complemento = mysql_escape_string($_REQUEST['complemento']);
	$bairro = mysql_escape_string( utf8_decode($_REQUEST['bairro']) );
	$cidade = mysql_escape_string( utf8_decode($_REQUEST['cidade']) );
	$estado = mysql_escape_string($_REQUEST['estado']);
	$email = mysql_escape_string( utf8_decode($_REQUEST['email']) );
	$telefone = mysql_escape_string($_REQUEST['telefone']);
	$fax = mysql_escape_string($_REQUEST['fax']);
	$cargo = mysql_escape_string( utf8_decode($_REQUEST['cargo']) );
	
	$facadeDadosPro->DadosProfissionais($id, $nome, $ideb_escola, $ideb_municipio, $categoria, $localizacao, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $email, $telefone, $fax, $cargo);
	header("Location: pass" . $_SESSION['ultimo_passo'] . ".php");
}
else
{
	if ($facadeDadosPro->verificaJaCadastrado($id)  > 0)
		$DadosPro = $facadeDadosPro->getDadosPorIdInscrito($id);
	else
		$DadosPro = null;
}

include("header.php");
?>
    
		<?	
        include("includes/etapas.php");
        ?>
        
        <h1>2 - Dados Profissionais</h1>
        <div class="legenda">(*) Campos de preenchimento obrigatório</div> 
 
        <form class="form-horizontal" action="pass2.php" method="POST" id="pass2-form">
			<input type="hidden" name="action" value="save">
          <fieldset>


            <div class="control-group">
              <label class="control-label" for="input-nome">Nome da escola (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-nome" maxlength="64" name="nome" value="<?php echo utf8_encode($DadosPro['nome']); ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-ideb-escola">IDEB 2011 da escola </label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-ideb-escola" name="ideb-escola" value="<?php print_ideb_escola($DadosPro); ?>">
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="input-ideb-municipio">IDEB 2011 do município </label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-ideb-municipio" name="ideb-municipio" value="<?php print_ideb_municipio($DadosPro); ?>">
              </div>
            </div>

			<div style="margin-left:170px; font-size:10px; margin-bottom:20px;">
	            <a class="btn btn-mini" href="http://ideb.inep.gov.br/" target="_blank">Clique aqui</a> para consultar o IDEB da sua escola e do seu município. Digite nos campos acima as informações encontradas.
            </div>
          
			<div class="control-group">
            <label class="control-label" for="select-categoria">Categoria da escola (*)</label>
            <div class="controls">
              <select id="select-categoria" name="categoria">
                <option></option>
                <option value="1"  <?php  if ($DadosPro['categoria'] == 1)  echo "SELECTED "  ?>>Pública</option>
                <option value="2" <?php  if ($DadosPro['categoria'] == 2)  echo "SELECTED "  ?>>Particular</option>
                <option value="3" <?php  if ($DadosPro['categoria'] == 3)  echo "SELECTED "  ?>>Comunitária</option>
                <option value="4" <?php  if ($DadosPro['categoria'] == 4)  echo "SELECTED "  ?>>Particular Filantrópica</option>
              </select>
			  <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
          </div>


			<div class="control-group">
            <label class="control-label" for="select-localizacao">Localização da escola (*)</label>
            <div class="controls">
              <select id="select-localizacao" name="localizacao">
                <option></option>
                <option value="U" <?php  if ($DadosPro['localizacao'] == "U")  echo "SELECTED "  ?>>Urbana</option>
                <option value="R" <?php  if ($DadosPro['localizacao'] == "R" ) echo "SELECTED "  ?>>Rural</option>
              </select>
			  <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
          </div>          
          

            <div class="control-group">
              <label class="control-label" for="input-cep">CEP da escola (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-cep" name="cep" value="<?php echo $DadosPro['cep']; ?>">
				<span class="help-inline">(somente números)</span>
				<span id="box-carregando" style="font-size:10px; display: none">Carregando...</span>
				<span id="box-invalido" style="font-size:10px; color: red; display: none">CEP inválido.</span>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-endereco">Endereço da escola (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-endereco" maxlength="64" name="endereco" value="<?php echo utf8_encode($DadosPro['endereco']); ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="input-numero">Número (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-numero" name="numero" value="<?php echo $DadosPro['numero']; ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-complemento">Complemento</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-complemento" name="complemento" value="<?php echo $DadosPro['complemento']; ?>">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-bairro">Bairro (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-bairro" maxlength="64" name="bairro" value="<?php echo utf8_encode($DadosPro['bairro']); ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-cidade">Cidade (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-cidade" name="cidade" value="<?php echo utf8_encode($DadosPro['cidade']); ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

			<div class="control-group">
            <label class="control-label" for="select-estado">Estado (*)</label>
            <div class="controls">
              <select id="select-estado" name="estado">
				<option></option>
				<option value="AC" <?php  if ($DadosPro['estado'] =="AC")  echo "SELECTED "  ?>>Acre</option>
                <option value="AL" <?php  if ($DadosPro['estado'] =="AL")  echo "SELECTED "  ?>>Alagoas</option>
                <option value="AP" <?php  if ($DadosPro['estado'] =="AP")  echo "SELECTED "  ?>>Amapá</option>
			    <option value="AM" <?php  if ($DadosPro['estado'] =="AM")  echo "SELECTED "  ?>>Amazonas</option>
                <option value="BA" <?php  if ($DadosPro['estado'] =="BA")  echo "SELECTED "  ?>>Bahia</option>
                <option value="CE" <?php  if ($DadosPro['estado'] =="CE")  echo "SELECTED "  ?>>Ceará</option>
				<option value="DF" <?php  if ($DadosPro['estado'] =="DF")  echo "SELECTED "  ?>>Distrito Federal</option>
                <option value="ES" <?php  if ($DadosPro['estado'] =="ES")  echo "SELECTED "  ?>>Espírito Santo</option>
                <option value="GO" <?php  if ($DadosPro['estado'] =="GO")  echo "SELECTED "  ?>>Goiás</option>
                <option value="MA" <?php  if ($DadosPro['estado'] =="MA")  echo "SELECTED "  ?>>Maranhão</option>
                <option value="MT" <?php  if ($DadosPro['estado'] =="MT")  echo "SELECTED "  ?>>Mato Grosso</option>
                <option value="MS" <?php  if ($DadosPro['estado'] =="MS")  echo "SELECTED "  ?>>Mato Grosso do Sul</option>
				<option value="MG" <?php  if ($DadosPro['estado'] =="MG")  echo "SELECTED "  ?>>Minas Gerais</option>
                <option value="PA" <?php  if ($DadosPro['estado'] =="PA")  echo "SELECTED "  ?>>Pará</option>
                <option value="PB" <?php  if ($DadosPro['estado'] =="PB")  echo "SELECTED "  ?>>Paraíba</option>
				<option value="PR" <?php  if ($DadosPro['estado'] =="PR")  echo "SELECTED "  ?>>Paraná</option>
				<option value="PE" <?php  if ($DadosPro['estado'] =="PE")  echo "SELECTED "  ?>>Pernambuco</option>
                <option value="PI" <?php  if ($DadosPro['estado'] =="PI")  echo "SELECTED "  ?>>Piauí</option>
                <option value="RJ" <?php  if ($DadosPro['estado'] =="RJ")  echo "SELECTED "  ?>>Rio de Janeiro</option>
                <option value="RN" <?php  if ($DadosPro['estado'] =="RN")  echo "SELECTED "  ?>>Rio Grande do Norte</option>
                <option value="RS" <?php  if ($DadosPro['estado'] =="RS")  echo "SELECTED "  ?>>Rio Grande do Sul</option>
				<option value="RO" <?php  if ($DadosPro['estado'] =="RO")  echo "SELECTED "  ?>>Rondônia</option>
                <option value="RR" <?php  if ($DadosPro['estado'] =="RR")  echo "SELECTED "  ?>>Roraima</option>
                <option value="SC" <?php  if ($DadosPro['estado'] =="SC")  echo "SELECTED "  ?>>Santa Catarina</option>
				<option value="SP" <?php  if ($DadosPro['estado'] =="SP")  echo "SELECTED "  ?>>São Paulo</option>
                <option value="SE" <?php  if ($DadosPro['estado'] =="SE")  echo "SELECTED "  ?>>Sergipe</option>
                <option value="TO" <?php  if ($DadosPro['estado'] =="TO")  echo "SELECTED "  ?>>Tocantins</option>
              </select>
			  <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
          </div>


            <div class="control-group">
              <label class="control-label" for="input-email">Email da escola (*)</label>
              <div class="controls">
                <input type="email" class="input-xlarge" id="input-email" name="email" value="<?php echo utf8_encode($DadosPro['email']); ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="input-telefone">Telefone da escola (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-telefone" name="telefone" value="<?php echo $DadosPro['telefone']; ?>">
              
                <span class="help-inline">(xx 1111-1111)</span>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-fax">Fax</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-fax" name="fax" value="<?php echo $DadosPro['fax']; ?>">
                <span class="help-inline">(xx 1111-1111)</span>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="input-cargo">Cargo (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-cargo" name="cargo" value="<?php echo utf8_encode($DadosPro['cargo']); ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>


			<div class="form-actions">
            <button class="btn" id="sair-inscrito">Sair</button>
            <button type="submit" class="btn btn-primary ">Avançar</button>
          	</div>

          </fieldset>
        </form>
        
<?php include("footer.php"); ?>