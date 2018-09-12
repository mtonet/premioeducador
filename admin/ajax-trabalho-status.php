<?php
require_once("config.php");
require_once('../dao/dao.class.php');
require_once("../business/facadeDadosTrabalho.php");



//******************************** variaveis **********************************
$id = isset($_REQUEST['id'])? $_REQUEST['id'] : 0;
$status = isset($_REQUEST['status'])? $_REQUEST['status'] : null;
$facadeTrabalho = new SessionFacadeDadosTrabalho();

if ($id > 0) {
	$facadeTrabalho->setStatus($id, 1);
}