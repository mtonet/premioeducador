<?php
require_once("functions.php");
require_once("../business/facadeInscrito.php");

//******************** valida user admin ***********************
validaUsuarioAdmin('lista-inscritos');
//******************** valida user admin ***********************

//corrigir codigo, tem coisa fora padrao
$id = isset($_REQUEST['id']) ? mysql_escape_string($_REQUEST['id']) : null;
if ( !isset($_REQUEST['id']) ) {
	header("Location: index.php");
}

$facadeInscrito = new SessionFacadeInscrito();
$line = $facadeInscrito->getListById($id);
$line = mysql_fetch_array($line);

?>
<?php get_header(); ?>
<style>
@media print {
	.screen-only { display: none }
}
</style>

			<header class="topo">
            	<h1>Ficha de inscrição</h1>                
            </header>
            <h2>Dados cadastrais</h2>
            <div class="border">
                <table width="100%" border="0">
                  <tr>
                    <td width="21%" class="bold">Data</td>
                    <td width="3%"></td>
                    <td width="76%"><?php pretty_print_data($line['data_inscricao']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Inscrição</td>
                    <td></td>
                    <td><?php echo $line['inscricao']; ?></td>
                  </tr>
                  <tr class="screen-only">
                    <td class="bold">Status</td>
                    <td></td>
                    <td><?php print_status($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Nome</td>
                    <td></td>
                    <td><?php echo utf8_encode($line['nome']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Sexo</td>
                    <td></td>
                    <td><?php print_sexo($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Faixa etária</td>
                    <td></td>
                    <td><?php print_faixa_etaria($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Cep</td>
                    <td></td>
                    <td><?php echo $line['cep']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Endereço</td>
                    <td></td>
                    <td><?php echo utf8_encode($line['endereco']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Número</td>
                    <td></td>
                    <td><?php echo $line['numero']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Complemento</td>
                    <td></td>
                    <td><?php echo $line['complemento']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Bairro</td>
                    <td></td>
                    <td><?php echo utf8_encode($line['bairro']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Cidade</td>
                    <td></td>
                    <td><?php echo utf8_encode($line['cidade']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Estado</td>
                    <td></td>
                    <td><?php echo $line['estado']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Telefone residencial</td>
                    <td></td>
                    <td><?php echo $line['telefone']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Telefone celular</td>
                    <td></td>
                    <td><?php echo $line['celular']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">CPF</td>
                    <td></td>
                    <td><?php echo $line['cpf']; ?></td>
                  </tr>
                  <tr>
                   <td class="bold">RG</td>
                   <td></td>
                    <td><?php echo $line['rg']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Órgão emissor</td>
                    <td></td>
                    <td><?php echo $line['orgao_emissor']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">E-mail</td>
                    <td></td>
                    <td><?php echo $line['email']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Onde conheceu?</td>
                    <td></td>
                    <td><?php print_fonte($line); ?></td>
                  </tr>
                </table>
			</div><!--Fim border-->
            
          <h2>Dados profissionais</h2>
            <div class="border">
                <table width="100%" border="0">
                  <tr>
                    <td width="21%" class="bold">Nome da Escola</td>
                    <td width="3%"></td>
                    <td width="76%"><?php echo utf8_encode($line['esc_nome']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">IDEB 2009 da escola</td>
                    <td></td>
                    <td><?php echo $line['esc_ideb_escola']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">IDEB 2009 do município</td>
                    <td></td>
                    <td><?php echo $line['esc_ideb_municipio']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Categoria da escola</td>
                    <td></td>
                    <td><?php print_escola_categoria($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Localização da escola</td>
                    <td></td>
                    <td><?php print_escola_localizacao($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Cep da escola</td>
                    <td></td>
                    <td><?php echo $line['esc_cep']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Endereço da escola</td>
                    <td></td>
                    <td><?php echo utf8_encode($line['esc_endereco']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Número</td>
                    <td></td>
                    <td><?php echo $line['esc_numero']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Complemento</td>
                    <td></td>
                    <td><?php echo $line['esc_complemento']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Bairro</td>
                    <td></td>
                    <td><?php echo utf8_encode($line['esc_bairro']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Cidade</td>
                    <td></td>
                    <td><?php echo utf8_encode($line['esc_cidade']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Estado</td>
                    <td></td>
                    <td><?php echo $line['esc_estado']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">E-mail da escola</td>
                    <td></td>
                    <td><?php echo $line['esc_email']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Telefone</td>
                    <td></td>
                    <td><?php echo $line['esc_telefone']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Fax</td>
                    <td></td>
                    <td><?php echo $line['esc_fax']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Cargo</td>
                    <td></td>
                    <td><?php echo utf8_encode($line['esc_cargo']); ?></td>
                  </tr>
                </table>
			</div><!--Fim border-->
            
            <h2>Dados acadêmicos</h2>
            <div class="border">
                <table width="100%" border="0">
                  <tr>
                    <td width="21%" class="bold">Formação</td>
                    <td width="3%"></td>
                    <td width="76%"><?php print_formacao($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Instituição de graduação</td>
                    <td></td>
                    <td><?php echo utf8_encode($line['instituto']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Curso</td>
                    <td></td>
                    <td><?php echo utf8_encode($line['curso']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Cidade</td>
                    <td></td>
                    <td><?php echo utf8_encode($line['aca_cidade']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Estado</td>
                    <td></td>
                    <td><?php echo $line['aca_estado']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Ano de Conclusão</td>
                    <td></td>
                    <td><?php echo $line['conclusao']; ?></td>
                  </tr>
                </table>
			</div><!--Fim border-->
            
            <h2>Dados do trabalho</h2>
            <div class="border">
                <table width="100%" border="0">
                <tr>
                    <td width="21%" class="bold">Categoria</td>
                    <td width="3%"></td>
                    <td width="76%"><?php print_categoria($line); ?> Nota 10</td>
                  </tr>
                  <tr>
                    <td width="21%" class="bold">Segmento</td>
                    <td width="3%"></td>
                    <td width="76%"><?php print_segmento($line); ?></td>
                  </tr>
				  <tr class="screen-only">
					<td class="bold">Atuação</td>
					<td></td>
					<td><?php print_atuacao($line); ?></td>
				  </tr>
                  <tr>
                    <td class="bold">Disciplina</td>
                    <td></td>
                    <td><?php print_disciplina($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Título do Trabalho</td>
                    <td></td>
                    <td><?php print_trabalho_titulo($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Ano da turma</td>
                    <td></td>
                    <td><?php print_trabalho_ano_turma($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Faixa etária dos alunos</td>
                    <td></td>
                    <td><?php print_trabalho_faixa_etaria($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Número de alunos envolvidos</td>
                    <td></td>
                    <td><?php print_trabalho_numero_alunos($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Duração do trabalho</td>
                    <td></td>
                    <td><?php print_trabalho_duracao($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Ano de realização do trabalho</td>
                    <td></td>
                    <td><?php print_trabalho_ano_trabalho($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Necessidades educacionais<br />
                    especiais</td>
                    <td></td>
                    <td><?php print_trabalho_necessidades($line); ?></td>
                  </tr>
                </table>
			</div><!--Fim border-->
            <div align="center" style="margin-top:30px;"><button class="btn" onclick="window.print();">Imprimir...</button></div>

<?php get_footer(); ?>