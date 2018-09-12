<?php
/**
 * @see http://framework.zend.com/manual/1.12/en/zend.barcode.objects.html
 * Toda documentação da Zend Barcode, caso algum ajuste seja necessário
 */

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__).'/../../libs'),//the path
    get_include_path(),
)));
require "Zend/Loader/Autoloader.php";
$autoloader = Zend_Loader_Autoloader::getInstance();


$code = isset($_GET['cod']) ? filter_var($_GET['cod'], FILTER_SANITIZE_STRING) : null;

if ( !is_null($code))
{

    $barcodeOptions = array('text' => $code, 'drawText' => false);
    $rendererOptions = array();

    Zend_Barcode::render(
        'code128', 'image', $barcodeOptions, $rendererOptions
    );

}

