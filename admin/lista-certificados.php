<?php
require_once('../business/facadeInscrito.php');
require_once("functions.php");

//******************** valida user admin ***********************
validaUsuarioAdmin('lista-inscritos');
//******************** valida user admin ***********************

//******************** Inicialização variaveis ***********************

$paginaAtual = ($_GET['paginaAtual'] == "") ? 0 : $_GET['paginaAtual'];
$paginaAtual = ($paginaAtual == 1 || $paginaAtual == 0) ? 0 : $paginaAtual;
$paginaLimite = isset($_REQUEST['rpp']) ? $_REQUEST['rpp'] : 10;

$facadeInscrito = new SessionFacadeInscrito();
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;


//******************************** action form **********************************
$status = '';
$categoria  = 0;
$estado  = 0;
$esc_categoria  = 0;
$prof_disciplina = 0;
$segmento = 0;
$atuacao = 0;
$texto = "";

$get = array();


//echo ($action);

if ($action == 'buscar') {
	$texto = isset($_REQUEST['input01']) ? $_REQUEST['input01'] : "";

	$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
	$categoria = isset($_REQUEST['categoria']) && $_REQUEST['categoria'] != '' ? $_REQUEST['categoria'] : 0;
	$estado = isset($_REQUEST['estado']) ? $_REQUEST['estado'] : 0;
	$esc_categoria  = isset($_REQUEST['escola_categoria']) ? $_REQUEST['escola_categoria'] : 0;
	$prof_disciplina  = isset($_REQUEST['disciplina']) ? $_REQUEST['disciplina'] : 0;
	$segmento  = isset($_REQUEST['segmento']) ? $_REQUEST['segmento'] : 0;
	$atuacao  = isset($_REQUEST['atuacao']) ? $_REQUEST['atuacao'] : 0;
}

if ($action != null)
	$get["action"] = $action;

if ($texto != "")
	$get["input01"] = $texto;
	
if ($status != "")
	$get["status"] = $status;
	
	//echo($status);
	
	
	
if ($action == "enviar") {

 // Verifica se alguma cor foi selecionada
         if(isset($_POST["checkinsc"])) {
             // Faz um loop no Array de checkbox
             foreach($_POST["checkinsc"] as $key => $value) {
			
				//	echo "O inscrito id=". $value. " foi selecionado ! <br />";
				 	
				 	$facadeInscrito->lembretecertificado($value);
             }
         }  else  {
             echo ("Nenhum Inscrito selecionada!"); 
         }

}	
	
	
if ($categoria != '0')
	$get["categoria"] = $categoria;

if ($estado != '0')
	$get["estado"] = $estado;
	
if ($esc_categoria != '0')
	$get["escola_categoria"] = $esc_categoria;
	
if ($prof_disciplina != '0')
	$get["disciplina"] = $prof_disciplina;
	
if ($segmento != '0')
	$get["segmento"] = $segmento;

if ($atuacao != '0')
	$get["atuacao"] = $atuacao;

$result = $facadeInscrito->getListNoDisabled($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status, $texto, $paginaAtual, $paginaLimite);

	//SE Vier de busca insc / cpf ou nome nao validar o selects para o filtro
	//inserir selects na busca

include("header.php");
?>




			<header class="topo-float">
            	<h1 style="width:450px;">Certificados</h1>
                <div class="subnav">
                <ul class="nav nav-pills">          
                  <?php include("submenu.php");?>
                </ul>
  				</div>
            </header>
			


<!--        Script by hscripts.com          -->
<!--        copyright of HIOX INDIA         -->
<!-- Free javascripts @ http://www.hscripts.com -->
<script type="text/javascript">
checked=false;
function checkedAll (frm1) {
	var aa= document.getElementById('form2');
	 if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
	for (var i =0; i < aa.elements.length; i++) 
	{
	 aa.elements[i].checked = checked;
	}
      }
</script>
<!-- Script by hscripts.com -->

            
            
            
			<form class="" action="lista-certificados.php?paginaAtual=" method="POST" id="form">
			<input type="hidden" name="action" value="buscar">
			
            <section class="lista-inscritos">
                <div class="control-group">            
            <div class="controls" style="width: 280px; margin-top: -18px">
              (nome ou inscrição ou CPF) <input type="text" id="input01" name="input01" class="input-xlarge" value="<?php echo $texto; ?>" />                           
            </div>
            <button type="submit" class="btn">Buscar</button>
          </div>                  	                                                    
            </section>
            	<div class="select-inscritos">
            	<p style="font-size:14px;">Filtrar por:</p>
                    <span style="margin:0 8px 0 21px;">Status</span>
                    <select id="select01" style="margin:0 29px 0 0;" name="status">
                        <option value="" <?php if ($status === '') echo "selected"; ?>>Todos</option>
                        <option value="0" <?php if ($status === '0') echo "selected"; ?>>Não impresso</option>
                        <option value="1" <?php if ($status === '1') echo "selected"; ?>>Ficha-impressa</option>
                        <option value="2" <?php if ($status === '2') echo "selected"; ?>>Trabalho-impresso</option>
                        <option value="3" <?php if ($status === '3') echo "selected"; ?>>Não selecionado</option>
                        <option value="4" <?php if ($status === '4') echo "selected"; ?>>Desclassificado</option>
                        <option value="5" <?php if ($status === '5') echo "selected"; ?>>Pré-selecionado</option>
                        <option value="6" <?php if ($status === '6') echo "selected"; ?>>Em avaliação</option>
                        <option value="7" <?php if ($status === '7') echo "selected"; ?>>Finalista</option>
                        <option value="8" <?php if ($status === '8') echo "selected"; ?>>Vencedor</option>
                        <option value="9" <?php if ($status === '9') echo "selected"; ?>>Desativado</option>
                        <option value="10" <?php if ($status === '10') echo "selected"; ?>>Premiado</option>
                      </select>
                      
                      <span style="margin: 0 8px 012px;">Estado</span>
                    <select id="estado" name="estado" style="margin:0 35px 0 0px;">
                        <option value="0" <?php if ($estado === 0) echo "selected"; ?>>Todos</option>
                        <option value="AC" <?php if ($estado === 'AC') echo "selected"; ?>>AC</option>
                        <option value="AL" <?php if ($estado === 'AL') echo "selected"; ?>>AL</option>
                        <option value="AM" <?php if ($estado === 'AM') echo "selected"; ?>>AM</option>
                        <option value="AP" <?php if ($estado === 'AP') echo "selected"; ?>>AP</option>
                        <option value="BA" <?php if ($estado === 'BA') echo "selected"; ?>>BA</option>
                        <option value="CE" <?php if ($estado === 'CE') echo "selected"; ?>>CE</option>
                        <option value="DF" <?php if ($estado === 'DF') echo "selected"; ?>>DF</option>
                        <option value="ES" <?php if ($estado === 'ES') echo "selected"; ?>>ES</option>
                        <option value="GO" <?php if ($estado === 'GO') echo "selected"; ?>>GO</option>
                        <option value="MA" <?php if ($estado === 'MA') echo "selected"; ?>>MA</option>
                        <option value="MG" <?php if ($estado === 'MG') echo "selected"; ?>>MG</option>
                        <option value="MS" <?php if ($estado === 'MS') echo "selected"; ?>>MS</option>
                        <option value="MT" <?php if ($estado === 'MT') echo "selected"; ?>>MT</option>
                        <option value="PA" <?php if ($estado === 'PA') echo "selected"; ?>>PA</option>
                        <option value="PB" <?php if ($estado === 'PB') echo "selected"; ?>>PB</option>
                        <option value="PE" <?php if ($estado === 'PE') echo "selected"; ?>>PE</option>
                        <option value="PI" <?php if ($estado === 'PI') echo "selected"; ?>>PI</option>
                        <option value="PR" <?php if ($estado === 'PR') echo "selected"; ?>>PR</option>
                        <option value="RJ" <?php if ($estado === 'RJ') echo "selected"; ?>>RJ</option>
                        <option value="RN" <?php if ($estado === 'RN') echo "selected"; ?>>RN</option>
                        <option value="RO" <?php if ($estado === 'RO') echo "selected"; ?>>RO</option>
                        <option value="RR" <?php if ($estado === 'RR') echo "selected"; ?>>RR</option>
                        <option value="RS" <?php if ($estado === 'RS') echo "selected"; ?>>RS</option>
                        <option value="SC" <?php if ($estado === 'SC') echo "selected"; ?>>SC</option>
                        <option value="SE" <?php if ($estado === 'SE') echo "selected"; ?>>SE</option>
                        <option value="SP" <?php if ($estado === 'SP') echo "selected"; ?>>SP</option>
                        <option value="TO" <?php if ($estado === 'TO') echo "selected"; ?>>TO</option>
                      </select>
                      
                      <span style="margin:0 8px 0 0;">Escola</span>
                    <select id="escola_categoria" name="escola_categoria">
                        <option value="0" <?php if ($esc_categoria === 0) echo "selected"; ?>>Todos</option>
                        <option value="1" <?php if ($esc_categoria === '1') echo "selected"; ?>>Pública</option>
                        <option value="2" <?php if ($esc_categoria === '2') echo "selected"; ?>>Particular</option>
                        <option value="3" <?php if ($esc_categoria === '3') echo "selected"; ?>>Comunitária</option>
                        <option value="4" <?php if ($esc_categoria === '4') echo "selected"; ?>>Particular Filantrópica</option>
                        </select>
                      
                       <span style="margin:0 7px 0 2px;">Segmento</span>
                    <select id="segmento" name="segmento">
                        <option value="0" <?php if ($segmento === 0) echo "selected"; ?>>Todos</option>
                        <option value="EI" <?php if ($segmento === 'EI') echo "selected"; ?>>Educação Infantil</option>
                        <option value="FI" <?php if ($segmento === 'FI') echo "selected"; ?>>Ensino Fundamental I</option>        
                        <option value="FII" <?php if ($segmento === 'FII') echo "selected"; ?>>Ensino Fundamental II</option>
                        <option value="EM" <?php if ($segmento === 'EM') echo "selected"; ?>>Ensino Médio</option>                        
                      </select>
					  
                       <span style="margin: 0 8px 0 20px;">Disciplina</span>
						<select id="disciplina" name="disciplina" <?php if ($segmento === 'EI' || $segmento === 'EM') echo "disabled"; ?> >
						<option value="0" <?php if ($prof_disciplina === 0) echo "selected"; ?>>Todos</option>
						<option value="1" <?php if ($prof_disciplina === '1') echo "selected"; ?>>Alfabetização</option>
						<option value="2" <?php if ($prof_disciplina === '2') echo "selected"; ?>>Artes</option>
						<option value="3" <?php if ($prof_disciplina === '3') echo "selected"; ?>>Ciências</option>
						<option value="4" <?php if ($prof_disciplina === '4') echo "selected"; ?>>Educação Física</option>
						<option value="5" <?php if ($prof_disciplina === '5') echo "selected"; ?>>Geografia</option>
						<option value="6" <?php if ($prof_disciplina === '6') echo "selected"; ?>>História</option>
						<option value="7" <?php if ($prof_disciplina === '7') echo "selected"; ?>>Língua Estrangeira</option>
						<option value="8" id="portugues" <?php if ($prof_disciplina === '8') echo "selected"; ?>>Língua Portuguesa Fund.<?php if ($segmento === 'FI') echo " I"; elseif ($segmento === 'FII') echo " II"; ?></option>
						<option value="9" id="matematica" <?php if ($prof_disciplina === '9') echo "selected"; ?>>Matemática Fund.<?php if ($segmento === 'FI') echo " I"; elseif ($segmento === 'FII') echo " II"; ?></option>
                      </select>
                      
                       <span style="margin: 0 8px 0 21px;">Categoria</span>
                    <select id="categoria" name="categoria" <?php if ($segmento === 'EM' || $atuacao === 'D' || $atuacao === 'C' || $atuacao === 'O') echo "disabled"; ?> >
                        <option value="0" <?php if ($categoria === 0) echo "selected"; ?>>Todos</option>
                        <option value="P" <?php if ($categoria === 'P') echo "selected"; ?>>Professor</option>
                        <option value="G" <?php if ($categoria === 'G' || $segmento === 'EM' || $atuacao === 'D' || $atuacao === 'C' || $atuacao === 'O') echo "selected"; ?>>Gestor</option>        
                      </select>
					  
					  	<span style="margin:0 8px 0 612px;">Atuação</span>
						<select id="atuacao" name="atuacao">
							<option value="0" <?php if ($atuacao === 0) echo "selected"; ?>>Todos</option>
							<option value="D" <?php if ($atuacao === 'D') echo "selected"; ?>>Diretor Escolar</option>
							<option value="C" <?php if ($atuacao === 'C') echo "selected"; ?>>Coordenador Escolar</option>
							<option value="O" <?php if ($atuacao === 'O') echo "selected"; ?>>Orientador Pedagógico</option>
                        </select>
						
                      <button type="submit" class="btn" style="margin:15px 0 20px 768px;">Filtrar</button>
                      
                      
                      </div>
					  <!--Fim select-inscritos-->
					  
					  <p style="font-size:14px; color:#666;">Registros por página:
						  <select name="rpp" id="rpp" style="width: 50px">
							<option <?php if ($paginaLimite == 10) echo "selected"; ?> value="10" >10</option>
							<option <?php if ($paginaLimite == 20) echo "selected"; ?> value="20" >20</option>
							<option <?php if ($paginaLimite == 30) echo "selected"; ?> value="30" >30</option>       
						  </select>
						 <!-- <a href="ver-desativados.php" style="margin: 0 0 0 500px">Lista de desativados</a> -->
              <a href="ver-nao-finalizados.php" style="margin: 0 0 0 30px">Lista de não-finalizados</a>
					  </p>
					  </form>
					  
                      
                      
                      
                      <div class="table-inscritos">
                      
                      
                      <form class="" action="lista-certificados.php?action=enviar&paginaAtual=" method="POST" id="form2">
                      
                      <table class="table table-striped table-bordered">
					  <!--- Corrigir result para voltar só o count-->
					  <?php 
					  $res = $facadeInscrito->getListNoDisabled($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status, $texto)
					  
					  ?>
					  <div class="alert alert-success">Foram encontrados <b><?php echo mysql_num_rows($res) ?> resultados</b></div>
                    <thead>
                      <tr>
                        <th>Data</th>
                        <th>Inscrição</th>
                        <th>Status</th>
                        <th>Nome</th>
                        <th>Disciplina</th>
                        <th>Segmento</th>
                        <th>Categoria</th>
                        <th>Visualizar</th>
                        <th><label>
                          <input type="checkbox" name="checkall" id="checkall"  onclick="checkedAll(form2);" />
                        </label></th>
                      </tr>
                    </thead>
                    <tbody>
					<?php 
					
					$countline=0;
					
					while ( $line = mysql_fetch_array($result) ): 
					
					$countline++;
					
					?>
                      <tr>
                        <td><?php pretty_print_data($line['data_inscricao']); ?></td>
                        <td><?php echo $line['inscricao']; ?></td>
                        <td><a href="ver-status.php?id=<?php echo $line['id']; ?>"><span id="printstatus<?php echo($countline); ?>"><?php print_status($line); ?></span></a></td>
                        <td><?php echo utf8_encode($line['nome']); ?></td>
                        <td><?php print_disciplina($line); ?></td>
                        <td><?php print_segmento($line); ?></td>
                        <td><?php print_categoria($line); ?></td>
                        <td>
                        <a target="_blank" href="../certificado.php?id=<?php echo $line['id']; ?>&action=cert"><i class="icon-download"></i></a>
                        </td>
                        <td>
                          <input type="checkbox" name="checkinsc[]" id="checkinsc[]" value="<?php echo $line['id']; ?>" />                        </td>
                      </tr>
					<?php endwhile; ?>
                    
                                          <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="4" align="right">
                        
                        
                          <button type="submit" class="btn">Enviar Certificado</button>
                        
                        </td>
                      </tr>
                    </tbody>
      				</table>
                    
                    </form>
                    
                   <div class="pagination" align="center" style="margin-top:30px;">
                    <ul>
				 <?php echo htmlPaginacao($_GET['paginaAtual'], $paginaLimite, $facadeInscrito->getListNoDisabled($estado, $esc_categoria, $prof_disciplina, $categoria, $segmento, $atuacao, $status, $texto, 0,0), $get) ?>
				  </ul>
                  </div>
				  
                      </div><!--Fim table-inscritos-->

<?php get_footer(); ?>