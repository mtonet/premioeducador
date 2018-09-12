<ul class="nav nav-pills" style="width:500px;">          
					<?php if ($_SESSION['cadastro_usuarios'] == 1) { ?><li><a href="lista-certificados.php">Certificados</a></li><?php }?>
                  <?php if ($_SESSION['cadastro_usuarios'] == 1) { ?><li><a href="lista-usuarios.php">Lista de Usuários</a></li><?php }?>
                  <?php if ($_SESSION['lista_inscritos'] == 1) { ?><li><a href="lista-inscritos.php?paginaAtual=">Lista de Inscritos</a></li><?php }?>
                  <?php if ($_SESSION['relatorios'] == 1) { ?><li><a href="relatorios.php?paginaAtual=">Relatórios</a></li><?php }?>
</ul>