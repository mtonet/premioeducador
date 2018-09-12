<?php
require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__)."/functions.php");

//*********************Verificar Login********************************
$pagina = "convidado-inserido";
validaUsuarioAdmin($pagina);

//******************** Inicialização variaveis ***********************

$facadeControleDeAcesso = new SessionControleDeAcesso();

$codigo = '';

$codigo = isset($_REQUEST['codigo']) ? $_REQUEST['codigo'] : "";

if ($codigo == "")
  header('Location: '.SITE_URL . 'controledeacesso/admin/dados-cadastrais.php');

//get list of controleDeAcesso
$result = $facadeControleDeAcesso->getByCode($codigo);

if(mysql_num_rows($result)!=1)
  header('Location: '.SITE_URL . 'controledeacesso/admin/dados-cadastrais.php');

$cad = mysql_fetch_assoc($result);

//echo '<pre>'; print_r($cad); '</pre>';

include(dirname(__FILE__). "/header.php");

unset($_SESSION['msg_sucesso']);
?>

			<header class="topo-float">
            	<h1>Cadastro realizado com sucesso</h1>                
            </header>                             
     		<div class="dados-cadastrais">
				<div class="simpleTabs" style="margin-top:35px;">
  
      
            		<table width="80%" border="0">
  <tr>
    <td width="48%" class="right"><label>Código</label></td>
    <td width="2%">&nbsp;</td>
    <td width="50%"><?php echo $cad['codigo']?></td>
    </tr>  
  </tr>
  <tr>
    <td class="right"><label>Nome</label></td>
    <td>&nbsp;</td>
    <td><?php echo $cad['nome']?></td>
    </tr>
  <tr>
    <td class="right"><label>E-mail</label></td>
    <td>&nbsp;</td>
    <td><?php echo $cad['email']?></td>
    </tr>
  <tr>
    <td class="right"><label>Telefone residencial</label></td>
    <td>&nbsp;</td>
    <td><?php echo $cad['telefone']?></td>
    </tr>  
  <tr>
   <td class="right"><label>Telefone celular</label></td>
    <td>&nbsp;</td>
    <td><?php echo $cad['celular']?></td>
    </tr>
  <tr>
   <td class="right"><label>Acompanhante</label></td>
    <td>&nbsp;</td>
    <td><?php echo $cad['acompanhante']==1?'Sim':'Não'; ?></td>
    </tr>
  <tr>
    <td class="right"><label>Confirmado</label></td>
    <td>&nbsp;</td>
    <td><?php echo ($cad['confirmado']!='' && $cad['confirmado']!='0000-00-00 00:00:00')?'Sim':'Não'; ?>
    </td>
    </tr>
  <tr>
    <td class="right"><label>Convidado Vip</label></td>
    <td>&nbsp;</td>
    <td><?php echo $cad['vip']==1?'Sim':'Não'; ?></td>
    </tr>
  <tr>
    <td colspan="3" align="center"><button class="btn btn btn-success" onclick="javascript: window.location='<?php echo SITE_URL; ?>controledeacesso/admin/inserir-convidados.php';">Cadastrar outro convidado</button></td>
    </tr>      
          </table>
<p align="center" style="margin-top:10px; margin:10px 0 40px 267px;">&nbsp;</p>        		
                     
                  
  </div>	                                                                                        
            </div><!--Fim dados-cadastrais-->
       
<?php include(dirname(__FILE__). "/footer.php"); ?>