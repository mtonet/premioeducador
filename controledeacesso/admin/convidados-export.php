<?php

require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__)."/functions.php");

$is_xlsx = isset($_REQUEST['xlsx']) && $_REQUEST['xlsx'] == 1 ? true : false;
if ($is_xlsx) {
	$mime = "application/vnd";
	$ext = ".xlsx";
}
else {
	$mime = "application/x-msexcel";
	$ext = ".xls";
}

header("Content-type: $mime; charset=UTF-8");
header("Content-Disposition: attachment; filename=convidados-premiovictor-" . date("Y-m-d-h-i-s") . $ext);
header('Pragma: no-cache');
header("Expires: 0");

//*********************Verificar Login********************************
$pagina = "convidados-export";
validaUsuarioAdmin($pagina);

//******************** Inicialização variaveis ***********************

session_start();

$paginaAtual = 0;
$paginaLimite = 99999999;

$facadeControleDeAcesso = new SessionControleDeAcesso();
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;

$busca = '';

$ordem = '';
$nome = '';
$codigo = '';
$acompanhante  = 'todos';
$confirmados = 'todos';


$get = array();


$busca 			= isset($_REQUEST['busca']) ? $_REQUEST['busca'] : "";

$ordem 			= isset($_REQUEST['ordem']) ? $_REQUEST['ordem'] : "codigo";
$nome 			= isset($_REQUEST['nome']) ? $_REQUEST['nome'] : "";
$codigo 		= isset($_REQUEST['codigo']) ? $_REQUEST['codigo'] : "";
$acompanhante 	= isset($_REQUEST['acompanhante']) ? $_REQUEST['acompanhante'] : 'todos';
$confirmados 	= isset($_REQUEST['confirmados']) ? $_REQUEST['confirmados'] : 'todos';
		

if($busca!=''){

	$get = array(
		'busca' => $busca,		
	);

	$result = $facadeControleDeAcesso->getListByKeyword($busca, $paginaAtual, $paginaLimite);
	$total = $facadeControleDeAcesso->getTotalListByKeyword($busca);
}
else{

	if ($ordem != "")
		$get["ordem"] = $ordem;

	if ($nome != "")
		$get["nome"] = $nome;
		
	if ($codigo != "")
		$get["codigo"] = $codigo;

	if ($acompanhante != "")
		$get["acompanhante"] = $acompanhante;

	if ($confirmados != "")
		$get["confirmados"] = $confirmados;

	//get list of controleDeAcesso
	$result = $facadeControleDeAcesso->getList($ordem, $nome, $codigo, $acompanhante, $confirmados, $paginaAtual, $paginaLimite);
	$total = $facadeControleDeAcesso->getTotalList($nome, $codigo, $acompanhante, $confirmados);
}

?>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Data</th>
				<th>C&oacute;digo</th>
				<th>Nome</th>
				<th>E-mail</th>
				<th>Telefone</th>
				<th>Celular</th>
				<th>CEP</th>
				<th>Endere&ccedil;o</th>
				<th>N&uacute;mero</th>
				<th>Complemento</th>
				<th>Bairro</th>
				<th>Cidade</th>
				<th>Estado</th>
				<th>Empresa</th>
				<th>VIP</th>
				<th>Acompanhante</th>
				<th>Confirmado</th>
				<th>Data de confirma&ccedil;&atilde;o</th>
			</tr>

		</thead>

		<tbody>
			<?php while($cad = mysql_fetch_assoc($result)): ?>
			<tr>
				<td><?php echo date('d.m.Y h:i', strtotime($cad['criado']));  ?></td>
				<td><?php echo $cad['codigo'];?></td>
				<td><?php if ($is_xlsx == false) echo $cad['nome']; else echo utf8_encode($cad['nome']); ?></td>
				<td><?php echo $cad['email'];?></td>
				<td><?php echo $cad['telefone'];?></td>
				<td><?php echo $cad['celular'];?></td>
				<td><?php echo $cad['cep'];?></td>
				<td><?php if ($is_xlsx == false) echo $cad['endereco']; else echo utf8_encode($cad['endereco']); ?></td>
				<td><?php echo $cad['numero'];?></td>
				<td><?php if ($is_xlsx == false) echo $cad['complemento']; else echo utf8_encode($cad['complemento']); ?></td>
				<td><?php if ($is_xlsx == false) echo $cad['bairro']; else echo utf8_encode($cad['bairro']); ?></td>
				<td><?php if ($is_xlsx == false) echo $cad['cidade']; else echo utf8_encode($cad['cidade']); ?></td>
				<td><?php echo $cad['estado'];?></td>
				<td><?php if ($is_xlsx == false) echo $cad['empresa']; else echo utf8_encode($cad['empresa']); ?></td>
				<td><?php if($cad['vip']==1): ?>Sim<?php else: ?>N&atilde;o<?php endif; ?></td>
				<td><?php if($cad['acompanhante']==1): ?>Sim<?php else: ?>N&atilde;o<?php endif; ?></td>
				<td><?php if($cad['confirmado']==''||$cad['confirmado']=='0000-00-00 00:00:00'): ?>N&atilde;o<?php else: ?>Sim<?php endif; ?></td>
				<td><?php if($cad['confirmado']==''||$cad['confirmado']=='0000-00-00 00:00:00'): ?>N/A<?php else: echo date('d.m.Y h:i', strtotime($cad['confirmado'])); endif; ?></td>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>


