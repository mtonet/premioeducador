<?php
require_once($_SERVER["DOCUMENT_ROOT"].'dao/dao.class.php');
require_once($_SERVER["DOCUMENT_ROOT"].'business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__)."/functions.php");

/*atualiza presença*/
$acao=$mysqli->real_escape_string(strip_tags(trim($_GET['acao'])));
$id=$mysqli->real_escape_string(strip_tags(trim($_GET['id'])));

if($acao=="yes" AND $id!=""){
$up="UPDATE controle_de_acesso SET confirmado='".date("Y-m-d H:i:s")."' WHERE id='".$id."'";
$queryy=$mysqli->query($up);
header("location:dados-cadastrais.php?ordem=nome&acao=ok");
}



/*fim atualiza presença*/


//echo '<pre>'; print_r($_SERVER); echo '</pre>';

//*********************Verificar Login********************************
$pagina = "dados-cadastrais";
validaUsuarioAdmin($pagina);

//******************** Inicialização variaveis ***********************

$paginaAtual = (!isset($_GET['paginaAtual']) || $_GET['paginaAtual'] == "") ? 0 : $_GET['paginaAtual'];
$paginaAtual = ($paginaAtual == 1 || $paginaAtual == 0) ? 0 : $paginaAtual;
$paginaLimite = isset($_REQUEST['limite']) ? $_REQUEST['limite'] : 30;

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
$ordem 			= isset($_REQUEST['ordem']) ? $_REQUEST['ordem'] : "";
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

//echo '<pre>'; print_r($get); exit;
//echo $total; echo '<pre>'; while($r = mysql_fetch_assoc($result)){ print_r($r); } echo '</pre>';







include(dirname(__FILE__). "/header.php");


//header("location:dados-cadastrais.php?ordem=nome",TRUE,301);
//echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=dados-cadastrais.php?ordem=nome>";
?>


<header class="topo-float">
	<h1>Convidados</h1>
   	<div class="controls">
   		<form method="GET">
      		<input type="text" name="busca" id="busca" class="input-xlarge" value="<?php if($busca!=''): ?><?php echo $busca; ?><?php else: ?>Pesquisa rápida<?php endif; ?>" onfocus="if (this.value == 'Pesquisa rápida' ){ this.value = ''};" onblur="if( this.value == '' ) { this.value = 'Pesquisa rápida'}"/>
      		
      		<button type="submit" class="btn">Buscar</button>
      	</form>
    </div>            
</header>      

<div class="select-inscritos">          
	<form method="GET">
		<div class="insc-left">
	        <p>Código <input type="text" name="codigo" class="input-large" id="input01" value="<?php echo $codigo; ?>"></p>
	        <p>
	        Acompanhante
	        <select name="acompanhante">
	        	<option value="">Todos</option>
	        	<option value="sim"<?php if($acompanhante=='sim'): ?> selected="selected"<?php endif; ?>>Sim</option>
		        <option value="nao"<?php if($acompanhante=='nao'): ?> selected="selected"<?php endif; ?>>Não</option>
	      	</select></p>
	    </div>
	        
	    <div class="insc-center">
	        <p>Nome <input type="text" name="nome" class="input-large" id="input01" value="<?php echo $nome; ?>"></p>
	        <p>
	        Confirmados
	        <select name="confirmados">
	            <option value="todos"<?php if($confirmados=='todos'): ?> selected="selected"<?php endif; ?>>Todos</option>
	            <option value="confirmados"<?php if($confirmados=='confirmados'): ?> selected="selected"<?php endif; ?>>Confirmado</option>
				<option value="nao"<?php if($confirmados=='nao'): ?> selected="selected"<?php endif; ?>>Não-Confirmado</option>
	      	</select></p>
	    </div>
	        
	     <div class="insc-right">
	     	<p>
	     	Ordenar por 
	    	<select name="ordem">
	    		<option value="">Data</option>
		        <option value="codigo"<?php if($ordem=='codigo'): ?> selected="selected"<?php endif; ?>>Código</option>
		        <option value="nome"<?php if($ordem=='nome'): ?> selected="selected"<?php endif; ?>>Nome</option>
	      	</select>
	      	</p>                  
	  	</div>
	                   
	  	<button type="submit" class="btn" style="margin:15px 0 20px 766px;">Buscar</button>  	
	</form>
</div><!--Fim select-inscritos-->

<?php if($acao=="ok"){?>
<div class="alert1 alert-danger" style="text-align: center;">Confirmação realizada com sucesso!</div>
<?php }?>

<div class="alert1 alert-success1">Total da seleção: <b><?php echo $total; ?> <?php if($total==1): ?>Registro<?php else: ?>Registros<?php endif; ?></b></div>



<div class="table-inscritos">
	<p style="font-size:14px; color:#666; float:left;">Registros por página:
  		<select id="selectLimite" data-url="<?php echo SITE_URL . 'controledeacesso/admin/dados-cadastrais.php?'.$_SERVER['QUERY_STRING'].'&limite='; ?>">
		    <option value="10">10</option>
		    <option value="20"<?php if($paginaLimite==20): ?>selected="selected"<?php endif; ?>>20</option>
		    <option value="30"<?php if($paginaLimite==30): ?>selected="selected"<?php endif; ?>>30</option>
	  	</select>
  	</p> 
  	<button type="submit" class="btn" style="margin:8px 0 20px 470px;" onclick="javascript: location.href=Site.url+'controledeacesso/admin/inserir-convidados.php'">Inserir Novo Convidado </button>

<?php if($total > 0): ?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Data</th>
				<th>Código</th>
				<th>Nome</th>
				<th>E-mail</th>
				<th>Telefone</th>
				<th>Celular</th>
				<!--<th>Acompanhante</th>-->
				<th>Confirmado</th>
			</tr>

		</thead>

		<tbody>
			<?php while($cad = mysql_fetch_assoc($result)): ?>
			<tr>
				<td><?php echo date('d.m.Y h:i', strtotime($cad['atualizado']));  ?></td>
				<td><?php echo $cad['codigo'];?></td>
				<td><?php echo utf8_encode($cad['nome']);?></td>
				<td><?php echo $cad['email'];?></td>
				<td><?php echo $cad['telefone'];?></td>
				<td><?php echo $cad['celular'];?></td>
				<!--<td><a href="javascript:;"><i class="<?php if($cad['acompanhante']==0): ?>icon-remove<?php else: ?>icon-ok<?php endif; ?>"></i></a></td>-->
				<td><?php if($cad['confirmado']==""){?><a href="?id=<?php echo $cad['id'];?>&acao=yes"><?php }?><i class="<?php if($cad['confirmado']==''||$cad['confirmado']=='0000-00-00 00:00:00'): ?>icon-remove<?php else: ?>icon-ok<?php endif; ?>"></i><?php if($cad['confirmado']==""){?></a><?php }?></td>
                <td><a href="<?php echo SITE_URL . 'controledeacesso/admin/editar-convidados.php?codigo='.$cad['codigo']; ?>"><i class="icon-edit"></i></a></td>
                <td><a href="<?php echo SITE_URL . 'controledeacesso/admin/convidados-codigos.php?barcode=1&codigo='.$cad['codigo']; ?>" target="_blank"><i class="">Imprimir</i></a></td>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
    <div id="btnActions" style="margin: 20px 0 20px; text-align: right;">
        <button type="button" class="btn" style="" onclick="javascript: window.open(Site.url+'controledeacesso/admin/convidados-codigos.php?barcode=1&<?php echo $_SERVER['QUERY_STRING'] ?>', '_blank')">Gerar código de barras</button>
        <button type="button" class="btn" style="" onclick="javascript: location.href=Site.url+'controledeacesso/admin/convidados-export.php?xlsx=0&<?php echo $_SERVER['QUERY_STRING'] ?>'">Gerar relatório (Office)</button>
        <button type="button" class="btn" style="" onclick="javascript: location.href=Site.url+'controledeacesso/admin/convidados-export.php?xlsx=1&<?php echo $_SERVER['QUERY_STRING'] ?>'">Gerar relatório (LibreOffice)</button>
	</div>
	<!--<button type="button" class="btn" style="margin:0 0 20px 716px;" onclick="javascript: location.href=Site.url+'controledeacesso/admin/convidados-export.php?<?php echo $_SERVER['QUERY_STRING'] ?>'">Gerar relatório</button>-->

	<div class="pagination" align="center" style="margin-top:10px;">
		<!--ul>
			<li class="disabled"><a href="#">«</a></li>
			<li class="active"><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>            
			<li><a href="#">»</a></li>
		</ul-->

		<ul>
	  	<?php  echo htmlPaginacao($paginaAtual, $paginaLimite, $total, $get) ?>
	  	</ul>
	</div>

	<?php else: ?>
	<div class="alert1" style="text-align: center;">Não foram encontrados convidados com os parâmetros informados.</div>
	<?php endif; ?>

</div><!--Fim table-inscritos-->


<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#selectLimite').change(function(){
		console.log('oi');
		window.location = jQuery(this).attr('data-url') + jQuery(this).val();
	});
});
</script>
<?php include(dirname(__FILE__). "/footer.php"); ?>



