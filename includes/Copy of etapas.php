<ul id="etapas">
<?php if ($_SESSION['ultimo_passo'] == 1): ?><li class="etapa-select">1. Dados Cadastrais</li><?php else: ?><li><a href="pass1.php">1. Dados Cadastrais</a></li><?php endif; ?>
<?php if ($_SESSION['ultimo_passo'] == 2): ?><li class="etapa-select">2. Dados Profissionais</li><?php else: ?><li><a href="pass2.php">2. Dados Profissionais</a></li><?php endif; ?>
<?php if ($_SESSION['ultimo_passo'] == 3): ?><li class="etapa-select">3. Dados Acadêmicos</li><?php else: ?><li><a href="pass3.php">3. Dados Acadêmicos</a></li><?php endif; ?>
<?php if ($_SESSION['ultimo_passo'] == 4): ?><li class="etapa-select">4. Dados do Trabalho</li><?php else: ?><li><a href="pass4.php">4. Dados do Trabalho</a></li><?php endif; ?>
<?php if ($_SESSION['ultimo_passo'] == 5): ?><li class="etapa-select">5. Envio do Trabalho</li><?php else: ?><li><a href="pass5.php">5. Envio do Trabalho</a></li><?php endif; ?>
<?php if ($_SESSION['ultimo_passo'] == 6): ?><li class="etapa-select">6. Revisão dos dados</li><?php else: ?><li><a href="pass6.php">6. Revisão dos dados</a></li><?php endif; ?>
<?php if ($_SESSION['ultimo_passo'] == 7): ?><li class="etapa-select">7. Finalização de inscrição</li><?php else: ?><li><a href="pass7.php">7. Finalização de inscrição</a></li><?php endif; ?>
</ul>
<hr> 