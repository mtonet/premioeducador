<?php
require_once("config.php");
require_once("functions-g.php");
require_once('dao/dao.class.php');
require_once("dao/daoDadosTrabalho.class.php");
require_once("business/facadeDadosTrabalho.php");

//******************************** valida loginPasso **********************************
validaPassoLogin(5);
//******************************** valida loginPasso **********************************

//******************************** variaveis **********************************
$id = mysql_escape_string($_SESSION['id']);
$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;
$facadeInscrito = new SessionFacadeInscrito();
$facadeDadosTrabalho = new SessionFacadeDadosTrabalho();


//******************************** action form **********************************
if ($action == 'save') {
	if ( isset($_FILES['doc']) ) {
		$fileName = mysql_escape_string( utf8_decode($_FILES['doc']['name']) );
		$tmpName  = $_FILES['doc']['tmp_name'];
		$fileSize = mysql_escape_string($_FILES['doc']['size']);
		$fileType = mysql_escape_string($_FILES['doc']['type']);
		
		$retorno = $facadeDadosTrabalho->DadosTrabalho($id, $fileName, $tmpName, $fileSize, $fileType);
		if ($retorno == 0) {
			header("Location: pass" . $_SESSION['ultimo_passo'] . ".php");
		}
		elseif ($retorno == -2) {
			$file_type_error = true;
		}
		elseif ($retorno == -3) {
			$file_size_error = true;
		}
		elseif ($retorno == -4) {
			$big_file_size_error = true;
		}
	}
	else {
		if ($facadeDadosTrabalho->verificaJaCadastrado($id) > 0) {
			header("Location: pass" . $_SESSION['ultimo_passo'] . ".php");
		}
	}
}
else
{
	if ($facadeDadosTrabalho->verificaJaCadastrado($id) > 0) {
		$trabalho_line = $facadeDadosTrabalho->getDadosPorIdInscrito($id);
	}
}
//******************************** action form **********************************

include("header.php");
?>

		<?	
        include("includes/etapas.php");
        ?>
               
        <h1>5 - Envio do Trabalho</h1>
        <div class="legenda" style="font-size: 125%<?php if ($file_type_error): ?>; color: red<?php endif; ?>">Será aceito apenas um arquivo em Word (extensão .doc ou .docx) com tamanho máximo de 100 kB. Não devem ser inseridos no arquivo em Word: fotos, links de vídeos, etc.</div>
		<?php if ($facadeDadosTrabalho->verificaJaCadastrado($id) > 0): ?><div class="legenda" style="font-size: 125%">Importante: Revise o arquivo antes de realizar o envio.<br />Já foi enviado um arquivo anteriormente. Para visualizar o trabalho anexado, <a href="upload/<?php echo $trabalho_line['nome_arquivo']; ?>">clique aqui</a>.</div><?php endif; ?>
		<?php if ($file_size_error): ?><div class="legenda" style="color: red">Houve um erro no envio do arquivo. Por favor, tente novamente.</div><?php endif; ?>
		<?php if ($big_file_size_error): ?><div class="legenda" style="color: red">Arquivo com mais de 100 kB.</div><?php endif; ?>
		
        <form class="form-horizontal" action="pass5.php" method="POST" id="pass5-form" enctype="multipart/form-data">
			<input type="hidden" name="action" value="save">
			<!--<input type="hidden" name="MAX_FILE_SIZE" value="100000">-->
          <fieldset>

       
            <input type="file" class="input-xlarge" id="input01" name="doc">
            <!--<button type="submit" class="btn btn-mini">Procurar arquivo</button>-->
			<br /><button type="submit" class="btn" style=" margin:5px 0 0 0;">Enviar trabalho</button>
 

			<div class="form-actions">
            <button class="btn" id="sair-inscrito">Sair</button>
            <?php if ($_SESSION['ultimo_passo'] == 6): ?><button class="btn btn-primary" id="pass6-button">Avançar</button><?php endif; ?>
          	</div>

          </fieldset>
        </form>
       
<?php include('footer.php'); ?>