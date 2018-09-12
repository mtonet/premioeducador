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

$id_usuario = mysql_escape_string($_SESSION['usuario_id']);

$facadeInscrito = new SessionFacadeInscrito();
$line = $facadeInscrito->getListById($id);
$line = mysql_fetch_array($line);

	$facadeStatus = new SessionFacadeStatus();

if ($line['status'] == 0) {
  $facadeInscrito->setStatus($line['id'], 1);
  $facadeStatus->cadastraStatus(1, $line['id'], $id_usuario);  
}





?>
<?php get_header(); ?>
<style>
@media print {
	.screen-only { display: none }
}
</style>

            <h2>Dados cadastrais</h2>
            <div class="border">
                <table width="100%" border="0" style="line-height:15px;">
                  <tr>
                    <td class="bold" style="width:200px;" nowrap="nowrap">Data</td>
                    <td><?php pretty_print_data($line['data_inscricao']); ?></td>
                    <td class="bold"  style="width:200px;" nowrap="nowrap">Inscrição</td>
                    <td><?php echo $line['inscricao']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Nome</td>
                    <td colspan="5"><?php echo utf8_encode($line['nome']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Faixa etária</td>
                    <td><?php print_faixa_etaria($line); ?></td>
                    <td class="bold">Sexo</td>
                    <td><?php print_sexo($line); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Cep</td>
                    <td><?php echo $line['cep']; ?></td>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Endereço</td>
                    <td colspan="5"><span class="bold"><?php echo utf8_encode($line['endereco']); ?></span></td>
                  </tr>
                  <tr>
                    <td class="bold">Número</td>
                    <td><?php echo $line['numero']; ?></td>
                    <td class="bold">Complemento</td>
                    <td><?php echo $line['complemento']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Bairro</td>
                    <td colspan="2"><?php echo utf8_encode($line['bairro']); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Cidade</td>
                    <td colspan="2"><?php echo utf8_encode($line['cidade']); ?></td>
                    <td>&nbsp;</td>
                    <td class="bold">Estado</td>
                    <td><?php echo $line['estado']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Telefone residencial</td>
                    <td><?php echo $line['telefone']; ?></td>
                    <td class="bold">Telefone celular</td>
                    <td><?php echo $line['celular']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">CPF</td>
                    <td><?php echo $line['cpf']; ?></td>
                    <td class="bold">RG</td>
                    <td><?php echo $line['rg']; ?></td>
                    <td class="bold">Órgão emissor</td>
                    <td><?php echo $line['orgao_emissor']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">E-mail</td>
                    <td><?php echo $line['email']; ?></td>
                    <td>Senha:</td>
                    <td><?php echo $line['senha']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Onde conheceu?</td>
                    <td><?php print_fonte($line); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="6"><h2>Dados profissionais</h2></td>
                  </tr>
                  
                  <tr>
                    <td class="bold">Nome da Escola</td>
                    <td colspan="2"><?php echo utf8_encode($line['esc_nome']); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">IDEB 2009 da escola</td>
                    <td><?php echo $line['esc_ideb_escola']; ?></td>
                    <td class="bold">IDEB 2009 do município</td>
                    <td><?php echo $line['esc_ideb_municipio']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Categoria da escola</td>
                    <td><?php print_escola_categoria($line); ?></td>
                    <td class="bold">Localização da escola</td>
                    <td><?php print_escola_localizacao($line); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Cep da escola</td>
                    <td><?php echo $line['esc_cep']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Endereço da escola</td>
                    <td colspan="5"><?php echo utf8_encode($line['esc_endereco']); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Número</td>
                    <td><?php echo $line['esc_numero']; ?></td>
                    <td class="bold">Complemento</td>
                    <td><?php echo $line['esc_complemento']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Bairro</td>
                    <td><?php echo utf8_encode($line['esc_bairro']); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Cidade</td>
                    <td colspan="2"><?php echo utf8_encode($line['esc_cidade']); ?></td>
                    <td>&nbsp;</td>
                    <td class="bold">Estado</td>
                    <td><?php echo $line['esc_estado']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">E-mail da escola</td>
                    <td colspan="5"><?php echo $line['esc_email']; ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Telefone</td>
                    <td><?php echo $line['esc_telefone']; ?></td>
                    <td class="bold">Fax</td>
                    <td><?php echo $line['esc_fax']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Cargo</td>
                    <td><?php echo utf8_encode($line['esc_cargo']); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="6"><h2>Dados acadêmicos</h2></td>
                  </tr>
                  
                  <tr>
                    <td class="bold">Formação</td>
                    <td><?php print_formacao($line); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Instituição de graduação</td>
                    <td><?php echo utf8_encode($line['instituto']); ?></td>
                    <td class="bold">Curso</td>
                    <td colspan="2"><?php echo utf8_encode($line['curso']); ?></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Cidade</td>
                    <td><?php echo utf8_encode($line['aca_cidade']); ?></td>
                    <td class="bold">Estado</td>
                    <td><?php echo $line['aca_estado']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Ano de Conclusão</td>
                    <td><?php echo $line['conclusao']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="6"><h2>Dados do trabalho</h2></td>
                  </tr>
                  
                  <tr>
                    <td class="bold">Categoria</td>
                    <td><?php print_categoria($line); ?> Nota 10</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Segmento</td>
                    <td><?php print_segmento($line); ?></td>
                    <td class="bold">Atuação</td>
                    <td><?php print_atuacao($line); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Disciplina</td>
                    <td><?php print_disciplina($line); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Título do Trabalho</td>
                    <td colspan="5"><?php print_trabalho_titulo($line); ?></td>
                  </tr>
                  <tr>
                    <td class="bold">Ano da turma</td>
                    <td><?php print_trabalho_ano_turma($line); ?></td>
                    <td class="bold">Faixa etária dos alunos</td>
                    <td><?php print_trabalho_faixa_etaria($line); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Número de alunos envolvidos</td>
                    <td><?php print_trabalho_numero_alunos($line); ?></td>
                    <td class="bold">Duração do trabalho</td>
                    <td><?php print_trabalho_duracao($line); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Ano de realização do trabalho</td>
                    <td><?php print_trabalho_ano_trabalho($line); ?></td>
                    <td class="bold">Necessidades educacionais<br />
                      especiais</td>
                    <td><?php print_trabalho_necessidades($line); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
			</div><!--Fim border--><!--Fim border--><!--Fim border-->
			<div class="border"></div><!--Fim border-->
            <div align="center" style="margin-top:30px;"><button class="btn" onclick="window.print();">Imprimir...</button></div>

<?php get_footer(); ?>