<?php
require_once(dirname(__FILE__) ."/../../config.php");
require_once(dirname(__FILE__) ."/../../functions.php");
require_once(dirname(__FILE__) ."/../../functions-g.php");
require_once(dirname(__FILE__) .'/../../business/facadeControleDeAcesso.php');

//echo $root = realpath($_SERVER["DOCUMENT_ROOT"]);

//echo 'HERE';

if(!isset($_POST['nome'])){
    header('Location: ' .SITE_URL. 'controledeacesso');
}

$nome = mysql_escape_string( utf8_decode($_POST['nome']) );

$cda = new SessionControleDeAcesso();

$acesso = $cda->getByName($nome);

if(mysql_num_rows($acesso)==0){
    $acesso = $cda->getByCode($nome);

    if(mysql_num_rows($acesso)==0)
    {
        session_start();
        $_SESSION['error'] = 'O convidado não foi encontrado';

        $numTentativas = isset($_COOKIE['codefail'])&&$_COOKIE['codefail']!=''?($_COOKIE['codefail']+1):1;
        setcookie("codefail", $numTentativas, time()+600);

        header('Location: ' .SITE_URL. 'controledeacesso/recepcao/');
        exit;
    }
}   

setcookie("codefail", 0);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Código do convite</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
<script type="text/javascript" src="js/jquery.1.7.2-min.js"></script>
<script>
    $(document).ready(function(){
       $('#cdg').click(function(){
           $('#usuarios').submit();
       });
    });
</script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

</head>

<body class="fundo">
	<div class="main">
		<div class="logo">
    		<img src="img/logo.png" />
    	</div>
        <div class="busca" style="height: auto">
            <p class="pbusca">
                Escolha um dos códigos a seguir:
            </p>
            <table style="width: 350px">
                <tr>
                    <td style="text-align: left">Nome</td>
                    <td style="text-align: left">Código</td>
                </tr>
                <?php while ($ac = mysql_fetch_assoc($acesso)): ?>
                    <form id="usuarios<?php echo $ac['codigo']; ?>" name="usuarios" method="post" action="confirmacao.php">
                        <tr>
                            <input type="hidden" name="codigo" value="<?php echo $ac['codigo']; ?>" />
                            <td id="nome">
                                <a onclick="$('#usuarios<?php echo $ac['codigo']; ?>').submit()" style="cursor: pointer">
                                    <?php echo utf8_encode($ac['nome']); ?>
                                </a>
                            </td>
                            <td>
                                <a onclick="$('#usuarios<?php echo $ac['codigo']; ?>').submit()" style="cursor: pointer">
                                    <?php echo $ac['codigo']; ?>
                                </a>
                            </td>
                        </tr>
                    </form>
                <?php endwhile; ?>
            </table>
            <?php if(isset($_SESSION['error']) && $_SESSION['error'] != ' '): ?><p style="color: red;text-align: center;"><?php echo $_SESSION['error']; ?></p><?php unset($_SESSION['error']); endif; ?>
            <?php if(isset($_SESSION['sucesso']) && $_SESSION['sucesso'] != ' '): ?><p style="color: green;text-align: center;"><?php echo $_SESSION['sucesso']; ?></p><?php unset($_SESSION['sucesso']); endif; ?>
        </div>
   </div>


</body>
</html>
