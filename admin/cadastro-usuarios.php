<?php
require_once('../business/facadeUsuario.php');
require_once("functions.php");

//******************** valida user admin ***********************
validaUsuarioAdmin('cadastro-usuario');
//******************** valida user admin ***********************

$sucesso = true;
$id_usuario = isset($_REQUEST['id'])? mysql_escape_string($_REQUEST['id']) : null;
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;
$facadeUsuario = new SessionFacadeUsuario();

if ($action == 'save') {
	$email = mysql_escape_string($_REQUEST['email']);
	$senha = mysql_escape_string($_REQUEST['senha']);
	$nome = mysql_escape_string($_REQUEST['nome']);
	
	$cadastro_usuarios = isset($_REQUEST['cadastro-usuarios'])? 1 : 0;
	$lista_inscritos = isset($_REQUEST['lista-inscritos'])? 1 : 0;
	$edicao_inscritos = isset($_REQUEST['edicao-inscritos'])? 1 : 0;
	$relatorios = isset($_REQUEST['relatorios'])? 1 : 0;
	
	if ($email) {
		if ( isset($id_usuario) ) {
		
			if ($facadeUsuario->verificaJaCadastrado($email) == 0)
			{
				$retorno = $facadeUsuario->atualiza($id_usuario, $email, $senha, utf8_decode($nome), $cadastro_usuarios, $lista_inscritos, $edicao_inscritos, $relatorios);
				
				if ($retorno != 0)
					$sucesso = false;
			}
			else
				$sucesso = false;
		}
		else {
			$retorno = $facadeUsuario->cadastra($email, $senha, utf8_decode($nome), $cadastro_usuarios, $lista_inscritos, $edicao_inscritos, $relatorios);
				
			if ($retorno != 0)
				$sucesso = false;
		}
		
	}
	else
		$sucesso = false;
}

if ( isset($id_usuario) ) {
	$result = $facadeUsuario->getListById($id_usuario);
	$line = mysql_fetch_array($result);
}

include("header.php");
?>


			<header class="topo-float">
            	<h1>Cadastro de usuários</h1>
                <div class="subnav">
                <ul class="nav nav-pills">
                <?php include("submenu.php");?>
                </ul>
  				</div>
            </header>
            <section class="cadastro-usuarios">
                 <?php if ($action == 'save'): if ($sucesso): ?><div class="alert alert-success">Cadastrado com <b>sucesso!</b></div><?php else: ?><div class="alert alert-fail">O cadastro <b>falhou!</b> O e-mail especificado já existe.</div><?php endif; endif; ?>
            <form class="form-horizontal">
				<input type="hidden" name="action" value="save">
				<?php if ( isset($id_usuario) ): ?><input type="hidden" name="id" value="<?php echo $id_usuario; ?>"><?php endif; ?>
            <fieldset>
                <div class="control-group">
                	<label class="control-label" for="input-nome">Nome</label>
                <div class="controls">
                	<input type="text" class="input-xlarge" id="input-nome" name="nome" <?php if ( isset($id_usuario) ): ?> value="<?php echo utf8_encode($line['nome']); ?>" <?php endif; ?> >    
                </div>
                </div>
                <div class="control-group">
                	<label class="control-label" for="input-email">E-mail</label>
                <div class="controls">
                	<input type="text" class="input-xlarge" id="input-email" name="email" <?php if ( isset($id_usuario) ): ?> value="<?php echo $line['email']; ?>" <?php endif; ?> >    
                </div>
                </div>
                <div class="control-group">
                	<label class="control-label" for="input-senha">Senha</label>
                <div class="controls">
                	<input type="text" class="input-xlarge" id="input-senha" name="senha" <?php if ( isset($id_usuario) ): ?> value="<?php echo $line['senha']; ?>" <?php endif; ?> >    
                </div>
                </div>                                
            </fieldset>            
            <div class="controls" style="width:390px; margin:0 auto;">
            <label for="inlineCheckboxes" class="control-label" style="margin-left:24px;">Acesso</label>
              <label class="checkbox inline" style="margin-left:15px;">
                <input type="checkbox" <?php if ($line['cadastro_usuarios'] == 1): ?>checked="checked"<?php endif; ?> value="option1" id="checkbox-cadastro-usuarios" name="cadastro-usuarios" />Cadastro de usuários
              </label>
              <label class="checkbox inline" style="margin-left:30px;">
                <input type="checkbox" <?php if ($line['lista_inscritos'] == 1): ?>checked="checked"<?php endif; ?> value="option2" id="checkbox-lista-inscritos" name="lista-inscritos" />Lista de inscritos
              </label>

              <label class="checkbox inline" style="margin-left:15px; margin-top:10px;">
                <input type="checkbox" <?php if ($line['edicao_inscritos'] == 1): ?>checked="checked"<?php endif; ?> value="option3" id="checkbox-edicao-inscritos" name="edicao-inscritos" />Edição de inscritos
              </label>
              
              <label class="checkbox inline" style="margin-left:44px;">
                <input type="checkbox" <?php if ($line['relatorios'] == 1): ?>checked="checked"<?php endif; ?> value="option4" id="checkbox-relatorios" name="relatorios" /> Relatórios
              </label>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
        </section>

<?php get_footer(); ?>