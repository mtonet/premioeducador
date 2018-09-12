<?php 
require_once("config.php");
require_once("functions.php");
require_once("functions-g.php");
require_once('dao/dao.class.php');
require_once('business/facadeInscrito.php');
require_once('dao/daoInscrito.class.php');
require_once('dao/daoDadosCadastrais.class.php');

//******************************** valida loginPasso **********************************
validaPassoLogin(0);
//******************************** valida loginPasso **********************************

//******************************** variaveis **********************************

//echo "id_session".$_SESSION['id']."<br>";

$id = mysql_escape_string($_SESSION['id']);
$facadeInscrito = new SessionFacadeInscrito();
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;

if ($action == 'save') {
	$facadeInscrito->setPasso();
	header("Location: pass" . $_SESSION['ultimo_passo']. ".php");
}
else 
{

//echo "var id=".$id."<br>";
	$line = mysql_fetch_array($facadeInscrito->getDadosPorId($id));
	
	//echo "line=".$line;
enviar_email($line['email'], 'Inscrição Prêmio Educador Nota 10 - Cadastro login e senha', $line['nome'], $line['inscricao'], 'confirma.html');
//echo $line['email']."----".$line['inscricao'];

}

include("header.php");
?>

    	<div id="title">
        	<h1>Cadastro de Login e Senha</h1>
        </div>
      <p>Prezado(a) usuário(a),</p>
      <p>Seu login e senha foram cadastrados com sucesso!</p>
<p>Número de inscrição: <span class="inscricao"><?php echo $line['inscricao']; ?></span></p>
      <p>Lembramos que sua inscrição só será validada após você finalizar o preenchimento de todas as etapas no site e enviar o seu trabalho.</p>
        <p>Para saber mais sobre o Prêmio Educador Nota 10 e obter orientações sobre o processo de inscrição acesse: <a href="http://www.educadornota10.org.br" target="_blank">www.educadornota10.org.br.</a></p>
        
    <form class="form-horizontal" action="confirma.php" method="POST">
		<input type="hidden" name="action" value="save">
          <fieldset>
			<div class="form-actions">
            <button class="btn" id="sair-inscrito">Sair</button>
            <button type="submit" class="btn btn-primary">Avançar</button>
          	</div>
    </fieldset>
        </form>

<?php include('footer.php'); ?>