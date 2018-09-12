<?php
require_once('../business/facadeStatus.php');
require_once("functions.php");

//******************** valida user admin ***********************
validaUsuarioAdmin('lista-inscritos');
//******************** valida user admin ***********************

//******************** Inicialização variaveis ***********************

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$facadeStatus = new SessionFacadeStatus();

//******************************** action form **********************************

$result = $facadeStatus->getListById($id);

include("header.php");
?>

			<header class="topo-float">
            	<h1>Lista de status</h1>
                <div class="subnav">
                <ul class="nav nav-pills">          
                  <?php include("submenu.php");?>
                </ul>
  				</div>
            </header>

			<form>
                      <div class="table-inscritos">
                      <table class="table table-striped table-bordered">
					  <div class="alert alert-success">Foram encontrados <b><?php echo mysql_num_rows($result) ?> resultados</b></div>
                    <thead>
                      <tr>
                        <th>Data</th>
                        <th>Status</th>
						<th>Usuário</th>
                        <th>Inscrito</th>
                      </tr>
            
                    </thead>
                    <tbody>
					<?php while ( $line = mysql_fetch_array($result) ): ?>
                      <tr>
                        <td><?php pretty_print_data($line['data_revisao']); ?></td>
                        <td><?php print_status($line); ?></td>
						<td><?php echo utf8_encode($line['nome_usuario']); ?></td>
                        <td><?php echo utf8_encode($line['nome_inscrito']); ?></td>
                      </tr>
					<?php endwhile; ?>
                    </tbody>
      				</table>
                   <!--<div class="pagination" align="center" style="margin-top:30px;">
						<button class="btn" onclick="history.go(-2);" style="margin:5px 0 20px 772px; padding:5px 20px;">Voltar</button> 		
                  </div>-->
				  
                      </div><!--Fim table-inscritos-->
			</form>