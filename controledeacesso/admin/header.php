<?php require_once(dirname(__FILE__).'/../../config.php'); ?>
<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta charset="utf-8">
		<title>Prêmio Victor Civita</title>

        <script><?php $Site = array('url' => 'http://localhost/pvc/'); ?>
            Site = {};
            Site.url = '<?php echo SITE_URL; ?>';
            //Site.url = '';

        </script>

		<script type="text/javascript" src="assets/js/simpletabs_1.1.js"></script>
		<link rel="stylesheet" type="text/css" href="assets/css/simpletabs.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />

		<script src="assets/js/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
		<script src="js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="js/functions.js" type="text/javascript"></script>
	</head>

	<body>
		<div class="container">
			<section class="main">

				<div class="subnav" style="width: 248px">
				<ul class="nav nav-pills">          
					<li><a href="<?php echo SITE_URL; ?>controledeacesso/admin/dados-cadastrais.php">Convidados</a></li>
                    <li><a href="<?php echo SITE_URL; ?>controledeacesso/admin/relatorios-controle-de-acesso.php">Relatórios</a></li>
                    <li><a href="<?php echo SITE_URL; ?>controledeacesso/admin/inserir-origem.php">Origem</a></li>
				</ul>
			</div>
			<br />
