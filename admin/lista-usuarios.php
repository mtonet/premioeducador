<?php
require_once('../business/facadeUsuario.php');
require_once("functions.php");

//******************** valida user admin ***********************
validaUsuarioAdmin('cadastro-usuario');
//******************** valida user admin ***********************

$id = mysql_escape_string($_SESSION['usuario_id']);

$facadeUsuario = new SessionFacadeUsuario();
$result = $facadeUsuario->getList();

include("header.php");
?>

			<header class="topo-float">
            	<h1  style="width:450px;">Lista de usuários</h1>
                <div class="subnav">
				<?php include("submenu.php");?>
  				</div>
            </header>
            <section class="lista-usuarios">
                <div class="control-group">
                <button type="submit" class="btn btn-primary" id="signup">Cadastrar novo usuário</button>
                </div>                
               	<table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Cadastro de usuário</th>
                        <th>Lista de inscritos</th>
                        <th>Edição de inscritos</th>
                        <th>Relatórios</th>
                        <th>Editar</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php while ( $line = mysql_fetch_array($result) ): ?>
                      <tr>
                        <td style="text-align:left;"><?php echo utf8_encode($line['nome']); ?></td>
                        <td><a href="mailto:<?php echo $line['email']; ?>" title="Escrever e-mail para <?php echo utf8_encode($line['nome']); ?>"><?php echo $line['email']; ?></a></td>
                        <td><i class="<?php if ($line['cadastro_usuarios'] == 1): ?>icon-ok<?php else: ?>icon-remove<?php endif; ?>"></i></td>
                        <td><i class="<?php if ($line['lista_inscritos'] == 1): ?>icon-ok<?php else: ?>icon-remove<?php endif; ?>"></i></td>
                        <td><i class="<?php if ($line['edicao_inscritos'] == 1): ?>icon-ok<?php else: ?>icon-remove<?php endif; ?>"></i></td>
                        <td><i class="<?php if ($line['relatorios'] == 1): ?>icon-ok<?php else: ?>icon-remove<?php endif; ?>"></i></td>
                        <td><a href="cadastro-usuarios.php?id=<?php echo $line['id'] ?>"><i class="icon-edit"></i></a></td>
                      </tr>
					<?php endwhile; ?>
                    </tbody>
				</table>                
            </section>

<?php get_footer(); ?>