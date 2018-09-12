<?php
require_once(dirname(__FILE__) ."/../../config.php");
require_once(dirname(__FILE__) ."/../../functions.php");
require_once(dirname(__FILE__) ."/../../functions-g.php");
require_once(dirname(__FILE__) .'/../../business/facadeControleDeAcesso.php');

$cda = new SessionControleDeAcesso();

$acesso = $cda->getRandomList(20);

if(mysql_num_rows($acesso)==0){
    echo 'nada foi encontrado';
}   

?>

<div style="width: 100%; text-align: center;">
<?php while($ac = mysql_fetch_assoc($acesso)): ?>

    <img src="http://www.barcodesinc.com/generator/image.php?code=<?php echo $ac['codigo'] ?>&style=198&type=C39&width=600&height=200&xres=4&font=5" /><br /><br />

<?php endwhile; ?>
</div>