<?php 
require_once("config.php");
require_once("functions-g.php");
require_once('dao/dao.class.php');
require_once("dao/daoDadosCadastrais.class.php");
require_once("business/facadeDadosCadastrais.php");

//******************************** valida loginPasso **********************************
validaPassoLogin(1);
//******************************** valida loginPasso **********************************

//******************************** variaveis **********************************
$id = mysql_escape_string($_SESSION['id']);
$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;
$facadeInscrito = new SessionFacadeInscrito();
$facadeDadosCad = new SessionFacadeDadosCadastrais();



//******************************** action form **********************************
if ($action == 'save') {
	$nome = mysql_escape_string( utf8_decode($_REQUEST['nome']) );
	$sexo = mysql_escape_string($_REQUEST['sexo']);
	$faixa_etaria = mysql_escape_string($_REQUEST['faixa-etaria']);
	$cep = mysql_escape_string($_REQUEST['cep']);
	$endereco = mysql_escape_string( utf8_decode($_REQUEST['endereco']) );
	$numero = mysql_escape_string($_REQUEST['numero']);
	$complemento = mysql_escape_string($_REQUEST['complemento']);
	$bairro = mysql_escape_string( utf8_decode($_REQUEST['bairro']) );
	$cidade = mysql_escape_string( utf8_decode($_REQUEST['cidade']) );
	$estado = mysql_escape_string($_REQUEST['estado']);
	$telefone = mysql_escape_string($_REQUEST['telefone']);
	$celular = mysql_escape_string($_REQUEST['celular']);
	$rg = mysql_escape_string($_REQUEST['rg']);
	$orgao = mysql_escape_string($_REQUEST['orgao']);
	$fonte = mysql_escape_string($_REQUEST['fonte']);
	$fonte_outro = mysql_escape_string( utf8_decode($_REQUEST['fonte-outro']) );

	$facadeDadosCad->DadosCadastrais($id, $nome, $sexo, $faixa_etaria, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $telefone, $celular, $rg, $orgao, $fonte, $fonte_outro, "","");
	header("Location: pass" . $_SESSION['ultimo_passo']. ".php");


	


}
else
{
	if ($facadeDadosCad->verificaJaCadastrado($id)  > 0)
		$DadosCad = $facadeDadosCad->getDadosPorIdInscrito($id);
	else
		$DadosCad = null;
}
//******************************** action form **********************************
include("header.php");
?>
		<?	
        include("includes/etapas.php");
        ?>
               
        <h1>1 - Dados Cadastrais</h1>
        <div class="legenda">(*) Campos de preenchimento obrigatório</div>        

        <form class="form-horizontal" action="pass1.php" method="POST" id="pass1-form">
			<input type="hidden" name="action" value="save">
          <fieldset>


            <div class="control-group">
              <label class="control-label" for="input01">Nome completo (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-nome" maxlength="64" name="nome" value="<?php echo utf8_encode($DadosCad['nome']); ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label">Sexo (*)</label>
                <div class="controls" id="sexo-area">
                    <label class="radio inline">
                    <input type="radio" id="input-sexo-m" name="sexo" value="M" <?php  if ($DadosCad['sexo'] == "M")  echo "CHECKED "  ?> > Masculino
                    </label>
                    <label class="radio inline">
                    <input type="radio" id="input-sexo-f" name="sexo" value="F" <?php  if ($DadosCad['sexo'] == "F")  echo "CHECKED "  ?>> Feminino
                    </label>
					<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
                </div>
            </div>          
          

			<div class="control-group">
            <label class="control-label" for="select-idade">Faixa etária (*)</label>
            <div class="controls">
              <select id="select-idade" name="faixa-etaria">
                <option value="" >Selecione</option>
                <option value="1" <?php if ($DadosCad['faixa_etaria'] == 1) echo "SELECTED " ?>>Até 20 anos</option>
                <option value="2" <?php if ($DadosCad['faixa_etaria'] == 2) echo "SELECTED " ?>>de 21 a 30 anos</option>
                <option value="3" <?php if ($DadosCad['faixa_etaria'] == 3) echo "SELECTED " ?>>de 31 a 40 anos</option>
                <option value="4" <?php if ($DadosCad['faixa_etaria'] == 4) echo "SELECTED " ?>>de 41 a 50 anos</option>
                <option value="5" <?php if ($DadosCad['faixa_etaria'] == 5) echo "SELECTED " ?>>de 51 a 60 anos</option>                
                <option value="6" <?php if ($DadosCad['faixa_etaria'] == 6) echo "SELECTED " ?>>Acima de 60 anos</option>
              </select>
			  <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
          </div>


            <div class="control-group">
              <label class="control-label" for="input-cep">CEP (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-cep" name="cep" value="<?php echo $DadosCad['cep']; ?>">
				<span class="help-inline">(somente números)</span>
				<span id="box-carregando" style="font-size:10px; display: none">Carregando...</span>
				<span id="box-invalido" style="font-size:10px; color: red; display: none">CEP inválido.</span>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-endereco">Endereço (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-endereco" maxlength="64" name="endereco" value="<?php echo utf8_encode($DadosCad['endereco']); ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-numero">Número (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-numero" name="numero" value="<?php echo $DadosCad['numero'] ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-complemento">Complemento</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-complemento" name="complemento" value="<?php echo $DadosCad['complemento'] ?>">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-bairro">Bairro (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-bairro" maxlength="64" name="bairro" value="<?php echo utf8_encode($DadosCad['bairro']); ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-cidade">Cidade (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-cidade" name="cidade"  value="<?php echo utf8_encode($DadosCad['cidade']); ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

			<div class="control-group">
            <label class="control-label" for="select-estado">Estado (*)</label>
            <div class="controls">
              <select id="select-estado" name="estado">
				<option></option>
				<option value="AC" <?php  if ($DadosCad['estado'] =="AC")  echo "SELECTED "  ?>>Acre</option>
                <option value="AL" <?php  if ($DadosCad['estado'] =="AL")  echo "SELECTED "  ?>>Alagoas</option>
                <option value="AP" <?php  if ($DadosCad['estado'] =="AP")  echo "SELECTED "  ?>>Amapá</option>
			    <option value="AM" <?php  if ($DadosCad['estado'] =="AM")  echo "SELECTED "  ?>>Amazonas</option>
                <option value="BA" <?php  if ($DadosCad['estado'] =="BA")  echo "SELECTED "  ?>>Bahia</option>
                <option value="CE" <?php  if ($DadosCad['estado'] =="CE")  echo "SELECTED "  ?>>Ceará</option>
				<option value="DF" <?php  if ($DadosCad['estado'] =="DF")  echo "SELECTED "  ?>>Distrito Federal</option>
                <option value="ES" <?php  if ($DadosCad['estado'] =="ES")  echo "SELECTED "  ?>>Espírito Santo</option>
                <option value="GO" <?php  if ($DadosCad['estado'] =="GO")  echo "SELECTED "  ?>>Goiás</option>
                <option value="MA" <?php  if ($DadosCad['estado'] =="MA")  echo "SELECTED "  ?>>Maranhão</option>
                <option value="MT" <?php  if ($DadosCad['estado'] =="MT")  echo "SELECTED "  ?>>Mato Grosso</option>
                <option value="MS" <?php  if ($DadosCad['estado'] =="MS")  echo "SELECTED "  ?>>Mato Grosso do Sul</option>
				<option value="MG" <?php  if ($DadosCad['estado'] =="MG")  echo "SELECTED "  ?>>Minas Gerais</option>
                <option value="PA" <?php  if ($DadosCad['estado'] =="PA")  echo "SELECTED "  ?>>Pará</option>
                <option value="PB" <?php  if ($DadosCad['estado'] =="PB")  echo "SELECTED "  ?>>Paraíba</option>
				<option value="PR" <?php  if ($DadosCad['estado'] =="PR")  echo "SELECTED "  ?>>Paraná</option>
				<option value="PE" <?php  if ($DadosCad['estado'] =="PE")  echo "SELECTED "  ?>>Pernambuco</option>
                <option value="PI" <?php  if ($DadosCad['estado'] =="PI")  echo "SELECTED "  ?>>Piauí</option>
                <option value="RJ" <?php  if ($DadosCad['estado'] =="RJ")  echo "SELECTED "  ?>>Rio de Janeiro</option>
                <option value="RN" <?php  if ($DadosCad['estado'] =="RN")  echo "SELECTED "  ?>>Rio Grande do Norte</option>
                <option value="RS" <?php  if ($DadosCad['estado'] =="RS")  echo "SELECTED "  ?>>Rio Grande do Sul</option>
				<option value="RO" <?php  if ($DadosCad['estado'] =="RO")  echo "SELECTED "  ?>>Rondônia</option>
                <option value="RR" <?php  if ($DadosCad['estado'] =="RR")  echo "SELECTED "  ?>>Roraima</option>
                <option value="SC" <?php  if ($DadosCad['estado'] =="SC")  echo "SELECTED "  ?>>Santa Catarina</option>
				<option value="SP" <?php  if ($DadosCad['estado'] =="SP")  echo "SELECTED "  ?>>São Paulo</option>
                <option value="SE" <?php  if ($DadosCad['estado'] =="SE")  echo "SELECTED "  ?>>Sergipe</option>
                <option value="TO" <?php  if ($DadosCad['estado'] =="TO")  echo "SELECTED "  ?>>Tocantins</option>
              </select>
			  <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
          </div>


            <div class="control-group">
              <label class="control-label" for="input-telefone">Telefone residencial (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-telefone" name="telefone" value="<?php echo $DadosCad['telefone'] ?>">
                <span class="help-inline">(xx 1111-1111)</span>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>



            <div class="control-group">
              <label class="control-label" for="input-celular">Telefone celular (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-celular" name="celular" value="<?php echo $DadosCad['celular'] ?>">
                <span class="help-inline">(xx 11111-1111)</span>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="input-cpf">CPF (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-cpf" value="<?php echo mysql_escape_string($_SESSION['cpf']) ?>" disabled>
                <span class="help-inline">(somente números)</span>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="input-rg">RG (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-rg" name="rg" value="<?php echo $DadosCad['rg'] ?>">
                <span class="help-inline">(somente números)</span>
                <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="input-orgao">Orgão emissor (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-orgao" name="orgao" value="<?php echo $DadosCad['orgao_emissor'] ?>">
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="input-email">E-mail (*)</label>
              <div class="controls">
                <input type="email" class="input-xlarge" id="input-email" value="<?php echo mysql_escape_string($_SESSION['email']) ?>" disabled>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

			<div class="control-group">
            <label class="control-label" for="select-como">Como você ficou sabendo do Prêmio Victor Civita Educador Nota 10 (*)</label>
            <div class="controls">
              <select id="select-como" name="fonte">
                <option></option>
                <option value="1" <?php  if ($DadosCad['fonte'] =="1")  echo "SELECTED "  ?>>Revista NOVA ESCOLA</option>
                <option value="2"  <?php  if ($DadosCad['fonte'] =="2")  echo "SELECTED "  ?>>Revista GESTÃO ESCOLAR DIGITAL</option>
                <option value="3"  <?php  if ($DadosCad['fonte'] =="3")  echo "SELECTED "  ?>>Outras revistas</option>
                <option value="4"  <?php  if ($DadosCad['fonte'] =="4")  echo "SELECTED "  ?>>Site NOVA ESCOLA</option>
                <option value="4"  <?php  if ($DadosCad['fonte'] =="5")  echo "SELECTED "  ?>>Site GESTÃO ESCOLAR</option>
                <option value="5"  <?php  if ($DadosCad['fonte'] =="6")  echo "SELECTED "  ?>>Outros sites</option>
                <option value="6"  <?php  if ($DadosCad['fonte'] =="7")  echo "SELECTED "  ?>>Rádio</option>
                <option value="7"  <?php  if ($DadosCad['fonte'] =="8")  echo "SELECTED "  ?>>E-mail marketing</option>
                <option value="8"  <?php  if ($DadosCad['fonte'] =="9")  echo "SELECTED "  ?>>Secretaria Municipal de Educação</option>
                <option value="9"  <?php  if ($DadosCad['fonte'] =="10")  echo "SELECTED "  ?>>Secretaria Estadual de Educação</option>
                <!--<option value="10"  <?php  if ($DadosCad['fonte'] =="11")  echo "SELECTED "  ?>>Orkut</option> -->
                <option value="11"  <?php  if ($DadosCad['fonte'] =="12")  echo "SELECTED "  ?>>Facebook</option>
                <option value="12"  <?php  if ($DadosCad['fonte'] =="13")  echo "SELECTED "  ?>>Twitter</option>
                <option value="13"  <?php  if ($DadosCad['fonte'] =="14")  echo "SELECTED "  ?>>Outros. Qual?</option>
              </select>
			  <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
          </div>
		  
		  <div class="control-group" id="div-como-outro" <?php if ($DadosCad['fonte'] != "13") echo 'style="display: none"' ?>>
            <label class="control-label" for="input-como-outro">Outros. Qual?</label>
            <div class="controls">
				<input type="text" class="input-xlarge" id="input-como-outro" name="fonte-outro" value="<?php echo utf8_encode($DadosCad['fonte_outro']); ?>">
            </div>
          </div>


			<div class="form-actions">
            <button class="btn" id="sair-inscrito">Sair</button>
            <button type="submit" class="btn btn-primary">Avançar</button>
          	</div>

          </fieldset>
        </form>

<?php include("footer.php"); ?>