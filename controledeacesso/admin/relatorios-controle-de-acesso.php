<?php
require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__)."/functions.php");

//*********************Verificar Login********************************
$pagina = "relatorios-controle-de-acesso";
validaUsuarioAdmin($pagina);

//******************** Inicialização variaveis ***********************

$facadeControleDeAcesso = new SessionControleDeAcesso();

//get list of controleDeAcesso
$total = $facadeControleDeAcesso->getTotalList('', '', '', '', '');
$acompanhantes = $facadeControleDeAcesso->getTotalList('', '', 'sim', '', '');
$confirmados = $facadeControleDeAcesso->getTotalList('', '', '', 'sim', '');
//$presentesEAcompanhantes = $facadeControleDeAcesso->getTotalList('', '', 'sim', 'sim', '');
$presentes = $facadeControleDeAcesso->getTotalList('', '', '', '', 'sim');
$naoPresentes = $facadeControleDeAcesso->getTotalList('', '', '', '', 'nao');
$presentesEAcompanhantes = $facadeControleDeAcesso->getTotalList('', '', 'sim', 'sim', '', 'sim');

include(dirname(__FILE__). "/header.php");
?>

        
			<header class="topo-float">
            	<h1>Relatórios</h1>                
            </header>                             
     		<div class="dados-cadastrais">
	<div class="simpleTabs" style="margin-top:35px;">
    <ul class="simpleTabsNavigation">
      <li><a href="#">Relatório dos acompanhantes</a></li>
      <li><a href="#">Relatório dos presentes</a></li>
      <li><a href="#">Relatório dos presentes e acompanhantes</a></li>
      <li><a href="#">Relatório de vagas</a></li>
    </ul>
    
    <div class="simpleTabsContent">
		<table class="table table-striped table-bordered">                    
        <tbody>
          <tr>
            <td>Acompanhantes confirmados </td>
            <td><?php echo $acompanhantes; ?></td>                                    
          </tr>                                     
        </tbody>
        </table>
    </div>
    
    <div class="simpleTabsContent">
		<table class="table table-striped table-bordered">                    
        <tbody>
			<tr>
            	<td>Convidados confirmados</td>
	            <td><?php echo $confirmados; ?></td>                                    
	        </tr>
          <!--tr>
            <td>Presentes</td>
            <td><?php echo $presentes; ?></td>                                    
          </tr>
          <tr>
            <td>Não presentes</td>
            <td><?php echo $total-$presentes; ?></td>                        
          </tr-->                                
        </tbody>
        </table>
    </div>

    <div class="simpleTabsContent">
		<table class="table table-striped table-bordered">                    
        <tbody>
          <tr>
            <td>Presentes</td>
            <td><?php echo $presentes; ?></td>                                    
          </tr>
          <tr>
            <td>Não presentes</td>
            <td><?php echo $naoPresentes; ?></td>                        
          </tr>
          <tr>
            <td>Acompanhantes</td>
            <td><?php echo $presentesEAcompanhantes; ?></td>                        
          </tr>                                
        </tbody>
        </table>
    </div>
    
    <div class="simpleTabsContent">
		<table class="table table-striped table-bordered">                    
        <tbody>
          <tr>
            <td>Total de vagas</td>
            <td>1920</td>
          </tr>
          <tr>
            <td>Vagas disponíveis</td>
            <td><?php echo 1920 - ($confirmados + $acompanhantes); ?></td>
          </tr>
          <tr>
            <td>Total dos confirmados</td>
            <td><?php echo $confirmados; ?></td>
          </tr>
          <tr>
            <td>Total de acompanhantes</td>
            <td><?php echo $acompanhantes; ?></td>
          </tr>
        </tbody>
        </table>
    </div>
    
  </div>	                                                                            
            </div><!--Fim dados-cadastrais-->
       
<?php include(dirname(__FILE__). "/footer.php"); ?>
