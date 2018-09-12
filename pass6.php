<?php 
require_once("config.php");
require_once("functions-g.php");
require_once('dao/dao.class.php');
require_once("business/facadeInscrito.php");

//******************************** valida loginPasso **********************************
validaPassoLogin(6); 
//******************************** valida loginPasso **********************************

//******************************** variaveis **********************************
$id = mysql_escape_string($_SESSION['id']);
$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;

if ($action == 'save') {
	$facadeInscrito = new SessionFacadeInscrito();
	$revisao = 1;
	$facadeInscrito->setPasso($revisao);
	
	//funcao de enviar email

	header("Location: pass" . $_SESSION['ultimo_passo'] . ".php");
}

include("header.php");
?>
    
		<?	
        include("includes/etapas.php");
        ?>
               
        <h1>6 - Revis&atilde;o dos Dados</h1>
        <div class="legenda" style="font-size: 125%">Selecione a etapa que deseja fazer a revis&atilde;o.</div>         
        
               
      <form class="form-horizontal" action="pass6.php" method="POST" id="pass6-form">
			<input type="hidden" name="action" value="save">
          <fieldset>
         <div class="well">
                <ul class="nav nav-list">
                      <li><a href="pass1.php">1 Dados Cadastrais </a></li>
                      <li><a href="pass2.php">2 Dados Profissionais</a></li>
                      <li><a href="pass3.php">3 Dados Acad&ecirc;micos</a></li>
                      <li><a href="pass4.php">4 Dados do Trabalho</a></li>
                      <li><a href="pass5.php">5 Envio do Trabalho</a></li>   
                </ul>

               <?php if( isset($_SESSION['arquivoSalvo']) ) : ?> 
               <!--  <br />
                 &nbsp;&nbsp;&nbsp;&nbsp;<a href="upload/<?php echo $_SESSION['arquivoSalvo']; ?>" target="_blank">Visualizar Trabalho Cadastrado</a> -->
               <?php endif; ?>

              </div>

             <input type="submit" onclick="javascript:return ConfirmaExclusao();" class="btn btn-primary" value="Finalizar">

        <script type="text/javascript" language="javascript">
            function ConfirmaExclusao() {
                return confirm('Você revisou o trabalho anexado? Tem certeza que deseja finalizar?  Lembre-se: uma vez finalizada a sua inscrição você não poderá substituir o trabalho enviado.');
            }
		</script>

        </fieldset>
        </form>
        
<?php include("footer.php"); ?>