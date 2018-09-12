<?php 
require_once("config.php");
require_once("functions.php");
require_once("functions-g.php");
require_once('dao/dao.class.php');
require_once("dao/daoInscrito.class.php");
require_once("business/facadeInscrito.php");
require_once("business/facadeDadosCadastrais.php");

//******************************** valida loginPasso **********************************
validaPassoLogin(7); 
//******************************** valida loginPasso **********************************

//******************************** variaveis **********************************
$id = mysql_escape_string($_SESSION['id']);
$ultimo_passo = mysql_escape_string($_SESSION['ultimo_passo']);
$facadeInscrito = new SessionFacadeInscrito();
$facadeCadastro = new SessionFacadeDadosCadastrais();
$line = mysql_fetch_array($facadeInscrito->getDadosPorId($id));
$cadastro_line = $facadeCadastro->getDadosPorIdInscrito($id);

enviar_email($line['email'], 'Inscrição Prêmio Victor Civita 2015', $cadastro_line['nome'], $line['inscricao'], 'finaliza.html');

include("header.php");
?>
            
		<?	
        include("includes/etapas.php");
        ?>
               
        <h1>7 - Finalização da Inscrição</h1>

		<p>Sua inscrição foi realizada com sucesso!</p>
		<p>Anote o número de sua inscrição: <span class="inscricao"><?php echo $line['inscricao']; ?></span></p>
		<p>Uma mensagem de confirmação será enviada para o e-mail cadastrado: <a href="mailto:<?php echo $line['email']; ?>"><?php echo $line['email']; ?></a>.</p>
		<p>Para qualquer alteração ou dúvida, entre em contato com a nossa central de atendimento através do e-mail: <a href="mailto:premio@fvc.org.br">premio@fvc.org.br</a>.</p>
		<p>Observação: Os e-mails serão respondidos de 2ª a 6ª feira, das 9h às 17h.</p>
        <p>
        <div id="fb-root"></div>
<script type="text/javascript">
window.fbAsyncInit = function () {
	FB.init({
		appId  : '111803635690137',
		status : true, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml  : true,  // parse XFBML
		oauth  : true // enable OAuth 2.0
	});
};

(function() {
	var e = document.createElement('script');
	e.src = document.location.protocol + '//connect.facebook.net/pt_BR/all.js';
	e.async = true;
	document.getElementById('fb-root').appendChild(e);
}());
</script>

<div id="container">
<!--	<a id="share-button" href="#" title="Facebook Share Button" rel="alternate">Compartilhe sua inscrição no Facebook</a> <img src="http://www.inscricoespvc2014.com.br/assets/img/fb_ico.png" /></a> -->
    
  <div class="fb-share-button" data-href="http://www.fvc.org.br/premio-victor-civita/" data-type="button"></div>  
    
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!--<script type="text/javascript">
$('#share-button').click(function(e){
	e.preventDefault();
	FB.ui({
		method: 'feed',
		name: 'PRÊMIO VICTOR CIVITA - EDUCADOR NOTA 10',
		link: 'http://www.premiovc.org.br/',
		picture: 'http://www.fvc.org.br/premio-victor-civita/img/layout/selo-premio-2013.png',
		caption: 'Estou participando do Prêmio Victor Civita 2014. Torça por mim!',
		description: 'O Prêmio Victor Civita Educador Nota 10 é uma iniciativa da Fundação Victor Civita.'
	});
});
</script> -->
        </p>


	  <?php include("footer.php"); ?>