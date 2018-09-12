<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Código do convite</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <script type="text/javascript" src="js/jquery.1.7.2-min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

</head>

<body class="fundo">
<div class="main">
    <div class="logo">
        <img src="img/logo.png" />
    </div>
    <form method="POST" action="execBuscapornome.php" id="formCodigo">
        <div class="busca">
            <p class="pbusca">
                Digite o nome ou o código do convidado
            </p>
            <input id="nome" name="nome" type="text" placeholder="Digite o nome ou o código" />
            <?php if(isset($_SESSION['error']) && $_SESSION['error'] != ' '): ?><p style="color: red;text-align: center;"><?php echo $_SESSION['error']; ?></p><?php unset($_SESSION['error']); endif; ?>
            <?php if(isset($_SESSION['sucesso']) && $_SESSION['sucesso'] != ' '): ?><p style="color: green;text-align: center;"><?php echo $_SESSION['sucesso']; ?></p><?php unset($_SESSION['sucesso']); endif; ?>
        </div>
        <div class="botao">
            <button id="submitCodigo" class="btn btn-success" type="button">PESQUISAR</button>
        </div>

    </form>
</div>


<script type="text/javascript">
    jQuery(document).ready(function(){

        jQuery('#submitCodigo').click(function(e){
            e.preventDefault();
            formSubmit();

        });

        jQuery('#nome').val('').focus();

    });

    function formSubmit(){
        console.log('form submit');

        //exibir o botao de "ok"

        jQuery('#formCodigo').submit();
    }
</script>


</body>
</html>
