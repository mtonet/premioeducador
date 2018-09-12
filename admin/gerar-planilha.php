<?php
	$nao_finalizados = isset($_REQUEST['nao_finalizados']) && $_REQUEST['nao_finalizados'] == 1 ? true : false;
	$is_xlsx = isset($_REQUEST['xlsx']) && $_REQUEST['xlsx'] == 1 ? true : false;
	if ($is_xlsx) {
		$mime = "application/vnd";
		$ext = ".xlsx";
	}
	else {
		$mime = "application/x-msexcel";
		$ext = ".xls";
	}
	
	header("Content-Type: $mime; charset=UTF-8");
	header("Content-Disposition: attachment; filename=pvc-inscricoes-" . date("Y-m-d-h-i-s") . $ext);
	
	require_once('../business/facadeInscrito.php');
	require_once('../business/facadeStatus.php');
	require_once('functions.php');
?>
		<table>
			<tr>
				<?php if ($nao_finalizados == true): ?><th>&Uacute;ltimo passo</th><?php endif; ?>
				<th>Data de inscri&ccedil;&atilde;o</th>
				<th>Inscri&ccedil;&atilde;o</th>
				<th>Impresso em</th>
				<th>Nome</th>
				<th>Sexo</th>
				<th>Faixa et&aacute;ria</th>
				<th>CEP</th>
				<th>Endere&ccedil;o</th>
				<th>N&uacute;mero</th>
				<th>Complemento</th>
				<th>Bairro</th>
				<th>Cidade</th>
				<th>UF</th>
				<th>Telefone</th>
				<th>Celular</th>
				<th>CPF</th>
				<th>RG</th>
				<th>&Oacute;rg&atilde;o emissor</th>
				<th>e-mail</th>
				<th>Como ficou sabendo</th>
				
				<th>Nome da escola</th>
				<th>IDEB da escola</th>
				<th>IDEB do munic&iacute;pio</th>
				<th>Categoria da escola</th>
				<th>Localiza&ccedil;&atilde;o da escola</th>
				<th>CEP da escola</th>
				<th>Endere&ccedil;o da escola</th>
				<th>N&uacute;mero da escola</th>
				<th>Complemento da escola</th>
				<th>Bairro da escola</th>
				<th>Cidade da escola</th>
				<th>UF da escola</th>
				<th>e-mail da escola</th>
				<th>Telefone da escola</th>
				<th>FAX da escola</th>
				<th>Cargo</th>
				
				<th>Forma&ccedil;&atilde;o</th>
				<th>Institui&ccedil;&atilde;o de gradua&ccedil;&atilde;o</th>
				<th>Curso</th>
				<th>Cidade</th>
				<th>UF</th>
				<th>Ano de conclus&atilde;o</th>
				
				<th>Tipo de inscri&ccedil;&atilde;o</th>
				<th>Segmento</th>
				<th>Atua&ccedil;&atilde;o</th>
				<th>Disciplina</th>
				<th>T&iacute;tulo do trabalho</th>
				<th>Ano da turma</th>
				<th>Faixa et&aacute;ria dos alunos</th>
				<th>N&uacute;mero de alunos</th>
				<th>Dura&ccedil;&atilde;o do trabalho</th>
				<th>Ano de realiza&ccedil;&atilde;o do trabalho</th>
				<th>Necessidades especiais</th>
			</tr>
			<?php
			$texto = isset($_REQUEST['texto']) ? $_REQUEST['texto'] : '';
			$estado = isset($_REQUEST['estado']) ? $_REQUEST['estado'] : 0;
			$esc_categoria = isset($_REQUEST['escola_categoria']) ? $_REQUEST['escola_categoria'] : 0;
			$prof_disciplina = isset($_REQUEST['disciplina']) ? $_REQUEST['disciplina'] : 0;
			$categoria = isset($_REQUEST['categoria']) ? $_REQUEST['categoria'] : 0;
			$segmento = isset($_REQUEST['segmento']) ? $_REQUEST['segmento'] : 0;
			$atuacao  = isset($_REQUEST['atuacao']) ? $_REQUEST['atuacao'] : 0;
			$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
			
			$facadeInscrito = new SessionFacadeInscrito();
			if ($nao_finalizados == true) {
				$resource = $facadeInscrito->getListNaoFinalizados($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status, $texto);
			}
			else {
				$resource = $facadeInscrito->getListNoDisabled($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status, $texto);
			}
			$facadeStatus = new SessionFacadeStatus();
			if ($resource) {
				while ( $line = mysql_fetch_array($resource) ): $lineStatus = mysql_fetch_array($facadeStatus->getListById($line['id']));
					?><tr>
						<?php if ($nao_finalizados == true): ?><td><?php echo $line['ultimo_passo']; ?></td><?php endif; ?>
						<td><?php pretty_print_data($line['data_inscricao']); ?></td>
						<td><?php if ($is_xlsx == false) echo '"' . $line['inscricao'] . '"'; else echo $line['inscricao']; ?></td>
						<td><?php print_data_impresso($line, $lineStatus); ?></td>
						<td><?php if ($is_xlsx == false) echo $line['nome']; else echo utf8_encode($line['nome']); ?></td>
						<td><?php print_sexo($line); ?></td>
						<td><?php print_faixa_etaria($line); ?></td>
						<td><?php echo '"' . $line['cep'].'"'; ?></td>
						<td><?php if ($is_xlsx == false) echo $line['endereco']; else echo utf8_encode($line['endereco']); ?></td>
						<td><?php echo $line['numero']; ?></td>
						<td><?php if ($is_xlsx == false) echo str_replace("Â","",$line['complemento']); else echo utf8_encode(str_replace("Â","",$line['complemento'])); ?></td>
						<td><?php if ($is_xlsx == false) echo $line['bairro']; else echo utf8_encode($line['bairro']); ?></td>
						<td><?php if ($is_xlsx == false) echo $line['cidade']; else echo utf8_encode($line['cidade']); ?></td>
						<td><?php echo $line['estado']; ?></td>
						<td><?php echo $line['telefone']; ?></td>
						<td><?php echo $line['celular']; ?></td>
						<td><?php echo $line['cpf']; ?></td>
						<td><?php echo $line['rg']; ?></td>
						<td><?php echo $line['orgao_emissor']; ?></td>
						<td><?php echo $line['email']; ?></td>
						<td><?php if ($is_xlsx == false) print_fonte_no_utf($line); else print_fonte($line); ?></td>
						
						<td><?php if ($is_xlsx == false) echo $line['esc_nome']; else echo utf8_encode($line['esc_nome']); ?></td>
						<td><?php echo $line['esc_ideb_escola']; ?></td>
						<td><?php echo $line['esc_ideb_municipio']; ?></td>
						<td><?php print_escola_categoria($line); ?></td>
						<td><?php print_escola_localizacao($line); ?></td>
						<td><?php  echo '"' . $line['esc_cep'].'"';  ?></td>
						<td><?php if ($is_xlsx == false) echo $line['esc_endereco']; else echo utf8_encode($line['esc_endereco']); ?></td>
						<td><?php echo $line['esc_numero']; ?></td>
						<td><?php if ($is_xlsx == false) echo str_replace("Â","",$line['esc_complemento']); else echo utf8_encode(str_replace("Â","",$line['esc_complemento'])); ?></td>
						<td><?php if ($is_xlsx == false) echo $line['esc_bairro']; else echo utf8_encode($line['esc_bairro']); ?></td>
						<td><?php if ($is_xlsx == false) echo $line['esc_cidade']; else echo utf8_encode($line['esc_cidade']); ?></td>
						<td><?php echo $line['esc_estado']; ?></td>
						<td><?php echo $line['esc_email']; ?></td>
						<td><?php echo $line['esc_telefone']; ?></td>
						<td><?php echo $line['esc_fax']; ?></td>
						<td><?php if ($is_xlsx == false) echo $line['esc_cargo']; else echo utf8_encode($line['esc_cargo']); ?></td>
						
						<td><?php print_formacao($line); ?></td>
						<td><?php if ($is_xlsx == false) echo $line['instituto']; else echo utf8_encode($line['instituto']); ?></td>
						<td><?php if ($is_xlsx == false) echo $line['curso']; else echo utf8_encode($line['curso']); ?></td>
						<td><?php if ($is_xlsx == false) echo $line['aca_cidade']; else echo utf8_encode($line['aca_cidade']); ?></td>
						<td><?php echo $line['aca_estado']; ?></td>
						<td><?php echo $line['conclusao']; ?></td>
						
						<td><?php print_categoria($line); ?></td>
						<td><?php print_segmento($line); ?></td>
						<td><?php print_atuacao($line); ?></td>
						<td><?php print_disciplina($line); ?></td>
						<td><?php if ($is_xlsx == false) print_trabalho_titulo_no_utf($line); else print_trabalho_titulo($line); ?></td>
						<td><?php print_trabalho_ano_turma_no_utf($line); ?></td>
						<td><?php print_trabalho_faixa_etaria_no_utf($line); ?></td>
						<td><?php print_trabalho_numero_alunos($line); ?></td>
						<td><?php if ($is_xlsx == false) print_trabalho_duracao_no_utf($line); else print_trabalho_duracao($line); ?></td>
						<td><?php print_trabalho_ano_trabalho($line); ?></td>
						<td><?php print_trabalho_necessidades($line); ?></td>
					</tr><?php
				endwhile;
			}
			?>
		</table>