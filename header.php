<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <title>PRÊMIO EDUCADOR NOTA 10</title>
    <meta name="description" content="Prêmio Educador Nota 10, iniciativa da Fundação Victor Civita"/>
    <meta name="author" content="MãonaWeb">

    <!-- Le styles -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="assets/css/docs.css" rel="stylesheet">
    <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon" href="assets/ico/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/ico/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/ico/apple-touch-icon-114x114.png">
	
	<script><?php $Site = array('url' => 'http://maonaweb.premiovictor.tagnclick.com.br/pvc/'); ?>
		Site = {};
		Site.url = '<?php $Site['url'] ?>';
		Site.ultimo_passo = '<?php echo isset($_SESSION['ultimo_passo']) ? $_SESSION['ultimo_passo'] : ''; ?>';
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="js/jquery.maskedinput-1.3.min.js"></script>
	<script src="js/functions.js"></script>
  </head>
  
  <body>
		<div id="top"> <a href="http://www.grupoabril.com.br/pt/"><img id="link-abril" src="http://premioeducador2015.web2165.uni5.net/assets/img/alpha.png" /></a>
                <a href="http://www.redeglobo.globo.com/TVG/0,,3916,00.html"><img id="link-globo" src="http://premioeducador2015.web2165.uni5.net/assets/img/alpha.png" /></a>        
        </div>
		<div id="container">

			<div id="left">
				<?php
				include("includes/patrocinio.php");
				?>
			</div> <!-- ID LEFT -->

			<div id="right">