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
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.1.7.2-min.js"></script>    
<script type="text/javascript" src="js/jquery.validate.min.js"></script>

</head>

<body>

    <div class="geral">
    <div class="container">
      <div class="content">
       	<div class="pg1">
        	<img src="img/logo.jpg" />
            <p>As confirmações para a 15ª edição do Prêmio Victor Civita<br /> Educador Nota 10 estão encerradas.</p>          
            <div class="borda1"></div>            
        </div><!-- end .pg1 -->
      </div><!-- end .content -->
    </div><!-- end .container -->
    </div><!-- end .geral -->
    <div class="footer">
    	<div class="content-footer">
        <div class="realiza">
        <p>Realização</p>
        <img src="img/realiza.jpg" />
        </div>
        <div class="patrocina">
        <p>Patrocínio</p>
        <img src="img/patrocina.jpg" />
        </div>
        <div class="apoio">
        <p>Apoio</p>
        <img src="img/apoio.jpg" />
        </div>  
        </div><!-- end .content-footer -->
    </div>
    

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
