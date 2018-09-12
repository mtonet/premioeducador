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


$download = isset($_REQUEST['arquivo']) ? mysql_escape_string($_REQUEST['arquivo']) : null;

$facadeInscrito = new SessionFacadeInscrito();
$line = $facadeInscrito->getListById($id);
$line = mysql_fetch_array($line);

	$facadeStatus = new SessionFacadeStatus();

//if ($line['status'] == 1) {

  $facadeInscrito->setStatus($line['id'], 2);
  $facadeStatus->cadastraStatus(2, $line['id'], $id_usuario);  
 
 //echo ('arquivo='.$download);
 
//}



?>
<?php get_header(); ?>
<style>
@media print {
	.screen-only { display: none }
}
</style>

            <h2>Dados cadastrais</h2>
            <div class="border">
                <table width="100%" border="0">
                  <tr>
                    <td class="bold">Data</td>
                    <td><?php pretty_print_data($line['data_inscricao']); ?></td>
                    <td class="bold">Inscrição</td>
                    <td><?php echo $line['inscricao']; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="bold">Nome</td>
                    <td colspan="5"><?php echo utf8_encode($line['nome']); ?></td>
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
            <div align="center" style="margin-top:30px;"><button class="btn" onclick="download('<?php echo($arquivo); ?>');">Download...</button></div>


<script>

function download(obj) {

window.location=obj;

}


</script>



<?php get_footer(); ?>