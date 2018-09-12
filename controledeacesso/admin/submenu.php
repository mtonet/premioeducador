<ul class="nav nav-pills">          
                  <?php if (isset($_SESSION['cadastro_usuarios']) || $_SESSION['cadastro_usuarios'] == 1) { ?><li><a href="lista-usuarios.php">Lista de Usuários</a></li><?php }?>
                  <?php if (isset($_SESSION['lista_inscritos']) || $_SESSION['lista_inscritos'] == 1) { ?><li><a href="lista-inscritos.php?paginaAtual=">Lista de Inscritos</a></li><?php }?>
                  <?php if (isset($_SESSION['relatorios']) || $_SESSION['relatorios'] == 1) { ?><li><a href="relatorios.php?paginaAtual=">Relatórios</a></li><?php }?>
</ul>