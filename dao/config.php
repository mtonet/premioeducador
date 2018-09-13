<?php
	define('DAO', $_SERVER['DOCUMENT_ROOT'] . 'pvc/dao/');
	define('ABSPATH', str_replace('\\', '/', dirname(__FILE__)) . '/');
	define('CONFIG_HOST','localhost');
	define('TITLE_RELEASE','RELEASE');
	define('DESCRIPTION_RELEASE','Veja aqui as novidades da PepsiCo. Os releases estão em ordem cronológica. Para obter releases mais antigos ou sobre outros assuntos que não foram abordados aqui, por favor envie um e-mail para <a href=\"mailto:debora.aguiar@edelman.com \">debora.aguiar@edelman.com </a>.');
	define('CONFIG_PAGINACAO_SITE',15);
	define('SITE_URL','/');

	//America/Sao_Paulo
	//date_default_timezone_set('America/Sao_Paulo');

	$tempPath1 = explode('/', str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME'])));
	$tempPath2 = explode('/', substr(ABSPATH, 0, -1));
	$tempPath3 = explode('/', str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])));

	for ($i = count($tempPath2); $i < count($tempPath1); $i++)
	    array_pop ($tempPath3);

	$urladdr = $_SERVER['HTTP_HOST'] . implode('/', $tempPath3);

	if ($urladdr{strlen($urladdr) - 1}== '/')
	    define('SITE_URL', 'http://' . $urladdr);
	else
	    define('SITE_URL', 'http://' . $urladdr . '/');

	unset($tempPath1, $tempPath2, $tempPath3, $urladdr);