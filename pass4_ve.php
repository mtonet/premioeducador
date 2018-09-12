<?php 
require_once("config.php");
require_once("functions-g.php");
require_once('dao/dao.class.php');
require_once("dao/daoDadosProfessor.class.php");
require_once("business/facadeDadosProfessor.php");
require_once("dao/daoDadosGestor.class.php");
require_once("business/facadeDadosGestor.php");

//******************************** valida loginPasso **********************************
validaPassoLogin(4); 
//******************************** valida loginPasso **********************************

//******************************** variaveis **********************************
$id = mysql_escape_string($_SESSION['id']);
$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;
$facadeDadosProfessor = new SessionFacadeDadosProfessor();
$facadeDadosGestor = new SessionFacadeDadosGestor();
$facadeInscrito = new SessionFacadeInscrito();

if ($action == 'save') {

	$categoria = $_REQUEST['categoria'];
	
	$titulo = mysql_escape_string( utf8_decode($_REQUEST['titulo']) );
	$numero = mysql_escape_string($_REQUEST['numero-alunos']);
	$duracao = mysql_escape_string( utf8_decode($_REQUEST['duracao']) );
	$ano_trabalho = mysql_escape_string($_REQUEST['ano-trabalho']);
	$necessidades = mysql_escape_string($_REQUEST['necessidades']);
	
	if ($categoria == 'P') {
		$segmento = mysql_escape_string($_REQUEST['segmento']);
		
		$disciplina = null;		
		if ($segmento == 'FI' || $segmento == 'FII') {
			$disciplina = mysql_escape_string($_REQUEST['disciplina']);
		}
		
		$faixa_etaria = mysql_escape_string( utf8_decode($_REQUEST['faixa-etaria']) );
		$ano_turma = mysql_escape_string( utf8_decode($_REQUEST['ano-turma']) );
		
		$facadeDadosProfessor->DadosProfessor($id, $segmento, $disciplina, $faixa_etaria, $ano_turma, $titulo, $numero, $duracao, $ano_trabalho, $necessidades);
		$facadeInscrito->setCategoria('P');
	}
	elseif ($categoria == 'G') {
		$segmento_ei = isset($_REQUEST['segmento-ei'])? 1 : 0;
		$segmento_fi = isset($_REQUEST['segmento-fi'])? 1 : 0;
		$segmento_fii = isset($_REQUEST['segmento-fii'])? 1 : 0;
		$segmento_em = isset($_REQUEST['segmento-em'])? 1 : 0;
		$atuacao = mysql_escape_string($_REQUEST['atuacao']);
		
		$facadeDadosGestor->DadosGestor($id, $atuacao, $segmento_ei, $segmento_fi, $segmento_fii, $segmento_em, $titulo, $numero, $duracao, $ano_trabalho, $necessidades);
		$facadeInscrito->setCategoria('G');
	}

	header("Location: pass" . $_SESSION['ultimo_passo'] . ".php");
}
else
{
	$e_professor = false;
	$e_gestor = false;

	$DadosProfessor = null;
	$DadosGestor = null;
	
	if ($facadeDadosProfessor->verificaJaCadastrado($id) > 0) {
		$DadosProfessor = $facadeDadosProfessor->getDadosPorIdInscrito($id);
		$e_professor = true;
	}
	elseif ($facadeDadosGestor->verificaJaCadastrado($id) > 0) {
		$DadosGestor = $facadeDadosGestor->getDadosPorIdInscrito($id);
		$e_gestor = true;
	}
}

include("header.php");
?>

		<?	
        include("includes/etapas.php");
        ?>
               
        <h1>4 - Dados do Trabalho</h1>
	    <div class="legenda">(*) Campos de preenchimento obrigatório</div>
        
        <form class="form-horizontal" action="pass4.php" method="POST" id="pass4-form" style="display: none">
			<input type="hidden" name="action" value="save">
          <fieldset>

        <div class="control-group">
          <label class="control-label" for="categoria-area">Você vai inscrever seu trabalho como ? (*)</label>
            <div class="controls" id="categoria-area">
                <label class="radio inline">
                <input type="radio" id="radio-categoria-p" name="categoria" value="P" <?php if ($e_professor): ?> checked="checked" <?php endif; ?>> Professor
                </label>
                <label class="radio inline">
                <input type="radio" id="radio-categoria-g" name="categoria" value="G" <?php if ($e_gestor): ?> checked="checked" <?php endif; ?>> Gestor
                </label>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
        </div> 


        <div class="control-group professor-group" <?php if ($e_professor == false): ?>style="display: none"<?php endif; ?> >
          <label class="control-label" for="segmento-professor-area">Segmento em que foi desenvolvido o trabalho (*)</label>
            <div class="controls" id="segmento-professor-area">
                <label class="radio inline">
                <input type="radio" id="input-segmento-professor-eic" name="segmento" value="EIC" class="segmento-limpa" <?php if ($DadosProfessor['segmento'] == 'EIC'): ?> checked="checked" <?php endif; ?>> Educação Infantil: Creche
                </label>
                                <label class="radio inline">
                <input type="radio" id="input-segmento-professor-eip" name="segmento" value="EIP" class="segmento-limpa" <?php if ($DadosProfessor['segmento'] == 'EIP'): ?> checked="checked" <?php endif; ?>> Educação Infantil: Pré-escola
                </label>
                <label class="radio inline">
                <input type="radio" id="input-segmento-professor-fi" name="segmento" onClick="reloadpg()"  value="FI" <?php if ($DadosProfessor['segmento'] == 'FI'): ?> checked="checked" <?php endif; ?>> Ensino Fundamental I
                </label>
                <label class="radio inline">
                <input type="radio" id="input-segmento-professor-fii" name="segmento" onClick="limparad()" value="FII" <?php if ($DadosProfessor['segmento'] == 'FII'): ?> checked="checked" <?php endif; ?>> Ensino Fundamental II
                </label>
                
<SCRIPT language="javascript">
function limparad() {
	document.getElementById('select-disciplina').value='';
}

function reloadpg() {
	document.getElementById('select-disciplina').value='Alfabetização';
}


</SCRIPT>                 
                
                
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
        </div>
		
		<div class="control-group gestor-group" <?php if ($e_gestor == false): ?>style="display: none"<?php endif; ?> >
          <label class="control-label" for="segmento-gestor-area">Segmento em que foi desenvolvido o trabalho (*)<br> <span class="subtexto">(Selecione uma ou mais opções)</span></label>
            <div class="controls" id="segmento-gestor-area">
                <label class="checkbox inline">
                <input type="checkbox" id="input-segmento-gestor-eic" name="segmento-eic" value="EI" <?php if ($DadosGestor['seg_edu_inf'] == 1): ?> checked="checked" <?php endif; ?>> Educação Infantil: Creche
                </label>
                
                
<label class="checkbox inline">
                <input type="checkbox" id="input-segmento-gestor-eip" name="segmento-eip" value="EI" <?php if ($DadosGestor['seg_edu_inf'] == 1): ?> checked="checked" <?php endif; ?>> Educação Infantil: Pré-escola
                </label>                
                
                <label class="checkbox inline">
                <input type="checkbox" id="input-segmento-gestor-fi" name="segmento-fi" value="FI" <?php if ($DadosGestor['seg_edu_fun_i'] == 1): ?> checked="checked" <?php endif; ?>> Ensino Fundamental I
                </label>
                <label class="checkbox inline">
                <input type="checkbox" id="input-segmento-gestor-fii" name="segmento-fii" value="FII" <?php if ($DadosGestor['seg_edu_fun_ii'] == 1): ?> checked="checked" <?php endif; ?>> Ensino Fundamental II
                </label>
                <label class="checkbox inline">
                <input type="checkbox" id="input-segmento-gestor-em" name="segmento-em" value="EM" <?php if ($DadosGestor['seg_edu_med'] == 1): ?> checked="checked" <?php endif; ?>> Ensino Médio
                </label>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
        </div> 
		
		<div class="control-group gestor-group" <?php if ($e_gestor == false): ?>style="display: none"<?php endif; ?> >
          <label class="control-label" for="atuacao-area">Atuação (*)</label>
            <div class="controls" id="atuacao-area">
                <label class="radio inline">
                <input type="radio" id="input-atuacao-d" name="atuacao" value="D" <?php if ($DadosGestor['atuacao'] == 'D'): ?> checked="checked" <?php endif; ?>> Diretor Escolar
                </label>
                <label class="radio inline">
                <input type="radio" id="input-atuacao-c" name="atuacao" value="C" <?php if ($DadosGestor['atuacao'] == 'C'): ?> checked="checked" <?php endif; ?>> Coordenador Pedagógico
                </label>
                <label class="radio inline">
                <input type="radio" id="input-atuacao-o" name="atuacao" value="O" <?php if ($DadosGestor['atuacao'] == 'O'): ?> checked="checked" <?php endif; ?>> Orientador Educacional
                </label>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
        </div>
		
		<br />

		<div class="control-group professor-group" <?php if ($e_professor == false): ?>style="display: none"<?php endif; ?> >
            <label class="control-label" for="select-disciplina">Disciplina (*)</label>
            <div class="controls">
            
            
              <select id="select-disciplina" name="disciplina" <?php if ($DadosProfessor['segmento'] == 'EI'): ?>disabled<?php endif; ?> >
			    <option></option>
                
				<option value="1" id="alfabetizaca" <?php if ($DadosProfessor['disciplina'] == 1): ?> selected="selected" <?php endif; ?>>Alfabetização</option>
				<option value="2" <?php if ($DadosProfessor['disciplina'] == 2): ?> selected="selected" <?php endif; ?> id="arte" >Arte</option>
				<option value="3" <?php if ($DadosProfessor['disciplina'] == 3): ?> selected="selected" <?php endif; ?> id="ciencias" >Ciências</option>
				<option value="4" <?php if ($DadosProfessor['disciplina'] == 4): ?> selected="selected" <?php endif; ?> id="fisica">Educação Física</option>
				<option value="5" <?php if ($DadosProfessor['disciplina'] == 5): ?> selected="selected" <?php endif; ?> id="geografia">Geografia</option>
				<option value="6" <?php if ($DadosProfessor['disciplina'] == 6): ?> selected="selected" <?php endif; ?> id="historia">História</option>
				<option value="7" <?php if ($DadosProfessor['disciplina'] == 7): ?> selected="selected" <?php endif; ?> id="lingua">Língua Estrangeira</option>
				<option value="8" id="portugues" <?php if ($DadosProfessor['disciplina'] == 8): ?> selected="selected" <?php endif; ?>>Língua Portuguesa</option>
				<option value="9" id="matematica" <?php if ($DadosProfessor['disciplina'] == 9): ?> selected="selected" <?php endif; ?>>Matemática</option>
				<option value="10" id="creche" <?php if ($DadosProfessor['disciplina'] == 10): ?> selected="selected" <?php endif; ?>>Creche</option>
				<option value="11" id="prescola" <?php if ($DadosProfessor['disciplina'] == 11): ?> selected="selected" <?php endif; ?>>Pré-escola</option>                
                
              </select>
              
              
              
              
              
              
              
              
              
			  <span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
        </div>

            <div class="control-group" <?php if ($e_professor == false && $e_gestor == false): ?>style="display: none"<?php endif; ?> >
              <label class="control-label" for="input-titulo">Título do trabalho (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-titulo" name="titulo" maxlength="40" <?php if ($e_professor): ?> value="<?php echo utf8_encode($DadosProfessor['titulo']); ?>" <?php else: ?> value="<?php echo utf8_encode($DadosGestor['titulo']); ?>" <?php endif; ?>>
				<span class="help-inline">(título limitado a 40 caracteres)</span>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>


            <div class="control-group professor-group" <?php if ($e_professor == false): ?>style="display: none"<?php endif; ?> >
              <label class="control-label" for="input-ano">Ano da turma (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-ano" name="ano-turma" value="<?php echo utf8_encode($DadosProfessor['ano_turma_char']); ?>">
				<span class="help-inline">(Ex: 8º ano, 1º ano, etc.)</span>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>
         
			<div class="control-group professor-group" <?php if ($e_gestor == false): ?>style="display: none"<?php endif; ?> >
            <label class="control-label" for="input-idade">Faixa etária dos alunos (*)</label>
            <div class="controls">
				<input type="text" class="input-xlarge" id="input-idade" name="faixa-etaria" value="<?php echo utf8_encode($DadosProfessor['faixa_etaria_char']); ?>">
				<span class="help-inline">(Ex: 9 anos, 2 e 3 anos, 7 a 9 anos, etc.)</span>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
          </div>

            <div class="control-group" <?php if ($e_professor == false && $e_gestor == false): ?>style="display: none"<?php endif; ?> >
              <label class="control-label" for="input-numero">Número de alunos envolvidos (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-numero" name="numero-alunos" <?php if ($e_professor): ?> value="<?php echo $DadosProfessor['numero_alunos']; ?>" <?php else: ?> value="<?php echo $DadosGestor['numero_alunos']; ?>" <?php endif; ?>>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
				<br /><span class="subtexto">Aqui você deve informar o número total de alunos que foram impactados com este trabalho</span>
              </div>
            </div>


            <div class="control-group" <?php if ($e_professor == false && $e_gestor == false): ?>style="display: none"<?php endif; ?> >
              <label class="control-label" for="input-duracao">Duração do trabalho (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-duracao" name="duracao" <?php if ($e_professor): ?> value="<?php echo utf8_encode($DadosProfessor['duracao']); ?>" <?php else: ?> value="<?php echo utf8_encode($DadosGestor['duracao']); ?>" <?php endif; ?>>
                <span class="help-inline">(Ex: 1 mês, 2 meses, 4 meses, etc.)</span>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
              </div>
            </div>


            <div class="control-group" <?php if ($e_professor == false && $e_gestor == false): ?>style="display: none"<?php endif; ?> >
              <label class="control-label" for="input-ano-trabalho">Ano de realização do trabalho (*)</label>
              <div class="controls">
                <input type="text" class="input-xlarge" id="input-ano-trabalho" name="ano-trabalho" <?php if ($e_professor): ?> value="<?php echo $DadosProfessor['ano_trabalho']; ?>" <?php else: ?> value="<?php echo $DadosGestor['ano_trabalho']; ?>" <?php endif; ?>>
				<span class="help-inline">(aaaa)</span>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
				<br /><span class="subtexto">Seu trabalho deve ter sido realizado no ano letivo de 2013 ou no 1º semestre de 2014. No entanto, para ser inscrito, o trabalho deve estar concluído e ter sido avaliado.</span>
              </div>
            </div>
  

        <div class="control-group" <?php if ($e_professor == false && $e_gestor == false): ?>style="display: none"<?php endif; ?> >
          <label class="control-label" for="necessidades-area" id="necessidades-label">Na sua turma há alunos com necessidades educacionais especiais (Transtorno Global do Desenvolvimento, Deficiência ou Altas Habilidades)? (*)</label>
            <div class="controls" id="necessidades-area">
                <label class="radio inline">
                <input type="radio" id="input-necessidades-s" name="necessidades" value="1" <?php if ($e_professor): if ($DadosProfessor['nece_especial'] == 1): ?> checked="checked" <?php endif; else: if ($DadosGestor['nece_especial'] == 1): ?> checked="checked" <?php endif; endif; ?>> Sim
                </label>
                <label class="radio inline">
                <input type="radio" id="input-necessidades-n" name="necessidades" value="0" <?php if ($e_professor): if ($DadosProfessor['nece_especial'] == 0): ?> checked="checked" <?php endif; else: if ($DadosGestor['nece_especial'] == 0): ?> checked="checked" <?php endif; endif; ?>> Não
                </label>
				<span class="box-obrigatorio" style="font-size:10px; color: red; display: none">Campo obrigatório.</span>
            </div>
        </div> 


			<div class="form-actions">
            <button class="btn" id="sair-inscrito">Sair</button>
            <button type="submit" class="btn btn-primary ">Avançar</button>
          	</div>

          </fieldset>
        </form>
        
<?php include('footer.php'); ?>