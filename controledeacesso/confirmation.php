<?php
require_once(dirname(__FILE__) ."/../config.php");
require_once(dirname(__FILE__) ."/../functions.php");
require_once(dirname(__FILE__) ."/../functions-g.php");
require_once(dirname(__FILE__) .'/../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__) ."/functions.php");

$code = mysql_escape_string( $_REQUEST['codigo'] );

$cda = new SessionControleDeAcesso();

$acesso = $cda->getByCode($code);

if(mysql_num_rows($acesso)==0){
    session_start();
    $_SESSION['error'] = 'O código não encontrado';

    header('Location: ' .SITE_URL. 'controledeacesso');
}
    

$ac = mysql_fetch_assoc($acesso);

$vars = array(
	'codigo' => $ac['codigo'],
	'nome' => utf8_encode($ac['nome']),
	'email' => $ac['email'],
	'acompanhante' => $ac['acompanhante'] == 1 ? 'SIM' : 'NÃO'
);

$destinatario = array(
	'email' => $ac['email'],
	'name' => utf8_encode($ac['nome']),
);

send_email_template($destinatario, '15ª edição do Prêmio Victor Civita Educador Nota 10', 'confirma.html', $vars);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Prêmio Victor Civita</title>
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="js/bootstrap.min.js"></script>
</head>

<body>

    <div class="geral">
    <div class="container">
      <div class="content">
      	<div id="header">
        	<img src="img/topo.png" alt="" />
        </div><!--fim header -->      
       	<div class="pg3">
        	<div id="left">
            	<img src="img/logos.png" alt=""  />
            </div><!--fim left -->
            
            <div id="right">        
       	  <p>Prezado(a) <?php echo utf8_encode($ac['nome']); ?>,</p>
            <p>Sua presença na 16ª edição do Prêmio Victor Civita Educador Nota 10 foi efetuada com sucesso!</p>
          <p>Para sua comodidade, enviamos as informações do evento para o e-mail cadastrado.<br />
            Dúvidas ou alteração de sua presença e/ou de seu acompanhante, por favor, entre em contato com a nossa Central de Atendimento de 2ª à 6ª feira, das 9h às 18h através do e-mail <a href="mailto:contatopremio2013@fvc.org.br">contatopremio2013@fvc.org.br</a> ou através do telefone 11 3037-2614.</p>
          </div><!--fim right -->
       	</div>
       	<!-- end .pg1 -->
      </div><!-- end .content -->
    </div><!-- end .container -->
    </div><!-- end .geral -->
</body>
</html>
