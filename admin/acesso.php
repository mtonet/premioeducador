<?php
require_once("functions.php");

//******************** valida user admin ***********************
validaUsuarioAdmin('acesso');
//******************** valida user admin ***********************

include("header.php");

?>



			<header class="topo">
            	<h1>Selecione uma seção</h1>
            </header>
            <section class="acesso">
			
				<?php if ($_SESSION['cadastro_usuarios'] == 1) { ?>
                <div class="control-group">
                <button type="submit" class="btn btn-success" id="lista-usuarios" style="width:195px;margin:0 10px 0 0;">Lista de Usuários</button>
                
                </div>
				<?php }?>
				
				<?php if ($_SESSION['lista_inscritos'] == 1) { ?>
                <div class="control-group" style="margin-top:16px;">
                <button type="submit" class="btn btn-info" id="lista-inscritos" style="width:195px;margin:0 10px 0 0;">Lista de Inscritos</button>
                
                </div>
				<?php }?>
				
				<?php if ($_SESSION['relatorios'] == 1) { ?>
                <div class="control-group" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary" id="lista-relatorios" style="width:195px;margin:0 10px 0 0;">Relatórios</button>
                
                </div>
				<?php }?>
				
				
            </section>
<?php
include("footer.php");?>