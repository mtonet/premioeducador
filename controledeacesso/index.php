<?php
require_once(dirname(__FILE__) ."/../config.php");

session_start();

$fails = 0;
if(isset($_COOKIE['codefail'])&&$_COOKIE['codefail']!='') 
    $fails = $_COOKIE['codefail'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Prêmio Victor Civita</title>
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.1.7.2-min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>

</head>

<body>

    <div class="geral">
    <div class="container">
      <div class="content">
      	<div id="header">
        	<img src="img/topo.png" alt="" />
        </div><!--fim header -->
       	<div class="pg1">
        	<div id="left">
            	<img src="img/logos.png" alt=""  />
            </div><!--fim left -->
            <div id="right">
            <p>15 de Outubro de 2012, Sala São Paulo<br />Praça Júlio Prestes, nº 16, São Paulo, SP</p>
            <p>19h30 - Coquetel</p>
            <p>20h00 - Cerimônia de Premiação</p>
            <p>22h00 - Encerramento</p>
            <div class="borda1"></div>
            <form id="codeForm" method="post" action="<?php echo SITE_URL ?>controledeacesso/form.php">
                <p class="obrig">(*) campo de preenchimento obrigatório</p>
                <p class="cod"><strong>Insira aqui o código do seu convite (*)</strong></p>
                <p><input type="text" name="code" <?php if($fails>=3): ?>disabled="disabled"<?php endif; ?> />
                <?php if(isset($_SESSION['error']) && $_SESSION['error'] != ' '): ?><p style="color: red;text-align: center;"><?php echo $_SESSION['error']; ?></p><?php unset($_SESSION['error']); endif; ?>
                <?php if($fails>=3): ?><p style="color: red;text-align: center;">O número de tentativas ultrapassou o permitido</p><?php endif; ?></p>
                <p><input type="submit" class="btn btn-success" value="Verificar"></p>                
            </form>                        
            </div><!--fim right -->
        </div><!-- end .pg1 -->
      </div><!-- end .content -->
    </div><!-- end .container -->
    </div><!-- end .geral -->
    

    <script type="text/javascript">    
        $(document).ready(function(){
        
            $("#codeForm").validate({
                onfocusout: false,            
                rules: {
                    'code': "required",                
                },
                messages: {
                    'code': "O código é obrigatório",                
                }
            });
            
        });
        
    </script>
</body>
</html>
