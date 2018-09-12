<?php 
require_once("config.php");
require_once("functions-g.php");
require_once('dao/dao.class.php');
require_once("dao/daoDadosAcademicos.class.php");
require_once("business/facadeDadosAcademicos.php");

//******************************** valida loginPasso **********************************
validaPassoLogin(3); 
//******************************** valida loginPasso **********************************

//******************************** variaveis **********************************
$id = mysql_escape_string($_SESSION['id']);
$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;
$facadeInscrito = new SessionFacadeInscrito();
$facadeDadosAca = new SessionFacadeDadosAcademicos();


//******************************** action form **********************************
if ($action == 'save') {
	$formacao = mysql_escape_string($_REQUEST['formacao']);
	$instituto = mysql_escape_string( utf8_decode($_REQUEST['instituto']) );
	$curso = mysql_escape_string( utf8_decode($_REQUEST['curso']) );
	$cidade = mysql_escape_string( utf8_decode($_REQUEST['cidade']) );
	$estado = mysql_escape_string($_REQUEST['estado']);
	$conclusao = mysql_escape_string($_REQUEST['conclusao']);
	
	$facadeDadosAca->DadosAcademicos($id, $formacao, $instituto, $curso, $cidade, $estado, $conclusao);
	header("Location: pass" . $_SESSION['ultimo_passo'] . ".php");
}
else
{
	if ($facadeDadosAca->verificaJaCadastrado($id)  > 0)
		$DadosAca = $facadeDadosAca->getDadosPorIdInscrito($id);
	else
		$DadosAca = null;
}
include("header.php");
?>

		<?	
        include("includes/etapas.php");
        ?>
               
        <h1>3 - Dados Acadêmicos</h1>
        <div class="legenda">(*) Campos de preenchimento obrigatório</div>       
 
 
        <form class="form-horizontal" action="pass3.php" method="POST" id="pass3-form">
			<input type="hidden" name="action" value="save">
          <fieldset>
 

 
		<div class="control-group">
            <label class="control-label" for="select-formacao">Formação (*)</label>
            <div class="controls">
              <select id="select-formacao" name="formacao">
                <option></option>
                <option value="NM" <?php  if ($DadosAca['formacao'] =="NM")  echo "SELECTED "  ?>>Ensino Médio</option>
                <option value="SI" <?php  if ($DadosAca['formacao'] =="SI")  echo "SELECTED "  ?>>Superior Incompleto</option>
                <option value="SC" <?php  if ($DadosAca['formacao'] =="SC")  echo "SELECTED "  ?>>Superior Completo</option>
                <option value="PG" <?php  if ($DadosAca['formacao'] =="PG")  echo "SELECTED "  ?>>Pós-Graduação</option>
              </select>
			  <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
          </div>

          
            <div class="control-group">
              <label class="control-label" for="input-instituto">Instituição de graduação (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-instituto" maxlength="64" name="instituto" value="<?php echo utf8_encode($DadosAca['instituto']); ?>">
                <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-curso">Curso (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-curso" name="curso" value="<?php echo utf8_encode($DadosAca['curso']); ?>">
                 <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="input-cidade">Cidade (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-cidade" name="cidade"  value="<?php echo utf8_encode($DadosAca['cidade']); ?>">
                <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>
         

            <div class="control-group">
              <label class="control-label" for="select-estado">Estado (*)</label>
              <div class="controls">
				  <select id="select-estado" name="estado">
					<option></option>
						<option value="AC" <?php  if ($DadosAca['estado'] =="AC")  echo "SELECTED "  ?>>Acre</option>
                <option value="AL" <?php  if ($DadosAca['estado'] =="AL")  echo "SELECTED "  ?>>Alagoas</option>
                <option value="AP" <?php  if ($DadosAca['estado'] =="AP")  echo "SELECTED "  ?>>Amapá</option>
			    <option value="AM" <?php  if ($DadosAca['estado'] =="AM")  echo "SELECTED "  ?>>Amazonas</option>
                <option value="BA" <?php  if ($DadosAca['estado'] =="BA")  echo "SELECTED "  ?>>Bahia</option>
                <option value="CE" <?php  if ($DadosAca['estado'] =="CE")  echo "SELECTED "  ?>>Ceará</option>
				<option value="DF" <?php  if ($DadosAca['estado'] =="DF")  echo "SELECTED "  ?>>Distrito Federal</option>
                <option value="ES" <?php  if ($DadosAca['estado'] =="ES")  echo "SELECTED "  ?>>Espírito Santo</option>
                <option value="GO" <?php  if ($DadosAca['estado'] =="GO")  echo "SELECTED "  ?>>Goiás</option>
                <option value="MA" <?php  if ($DadosAca['estado'] =="MA")  echo "SELECTED "  ?>>Maranhão</option>
                <option value="MT" <?php  if ($DadosAca['estado'] =="MT")  echo "SELECTED "  ?>>Mato Grosso</option>
                <option value="MS" <?php  if ($DadosAca['estado'] =="MS")  echo "SELECTED "  ?>>Mato Grosso do Sul</option>
				<option value="MG" <?php  if ($DadosAca['estado'] =="MG")  echo "SELECTED "  ?>>Minas Gerais</option>
                <option value="PA" <?php  if ($DadosAca['estado'] =="PA")  echo "SELECTED "  ?>>Pará</option>
                <option value="PB" <?php  if ($DadosAca['estado'] =="PB")  echo "SELECTED "  ?>>Paraíba</option>
				<option value="PR" <?php  if ($DadosAca['estado'] =="PR")  echo "SELECTED "  ?>>Paraná</option>
				<option value="PE" <?php  if ($DadosAca['estado'] =="PE")  echo "SELECTED "  ?>>Pernambuco</option>
                <option value="PI" <?php  if ($DadosAca['estado'] =="PI")  echo "SELECTED "  ?>>Piauí</option>
                <option value="RJ" <?php  if ($DadosAca['estado'] =="RJ")  echo "SELECTED "  ?>>Rio de Janeiro</option>
                <option value="RN" <?php  if ($DadosAca['estado'] =="RN")  echo "SELECTED "  ?>>Rio Grande do Norte</option>
                <option value="RS" <?php  if ($DadosAca['estado'] =="RS")  echo "SELECTED "  ?>>Rio Grande do Sul</option>
				<option value="RO" <?php  if ($DadosAca['estado'] =="RO")  echo "SELECTED "  ?>>Rondônia</option>
                <option value="RR" <?php  if ($DadosAca['estado'] =="RR")  echo "SELECTED "  ?>>Roraima</option>
                <option value="SC" <?php  if ($DadosAca['estado'] =="SC")  echo "SELECTED "  ?>>Santa Catarina</option>
				<option value="SP" <?php  if ($DadosAca['estado'] =="SP")  echo "SELECTED "  ?>>São Paulo</option>
                <option value="SE" <?php  if ($DadosAca['estado'] =="SE")  echo "SELECTED "  ?>>Sergipe</option>
                <option value="TO" <?php  if ($DadosAca['estado'] =="TO")  echo "SELECTED "  ?>>Tocantins</option>
				  </select>
                  <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input-conclusao">Ano de conclusão (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-conclusao" name="conclusao"  value="<?php echo $DadosAca['conclusao'] ?>">
                <span class="help-inline">(somente números, ex: 1998)</span>
              </div>
            </div>



			<div class="form-actions">
            <button class="btn" id="sair-inscrito">Sair</button>
            <button type="submit" class="btn btn-primary ">Avançar</button>
          	</div>

          </fieldset>
        </form>
        
<?php include("footer.php"); ?>