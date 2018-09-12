<?php
require_once(dirname(__FILE__) ."/../../config.php");
require_once(dirname(__FILE__) ."/../../functions.php");
require_once(dirname(__FILE__) ."/../../functions-g.php");
require_once(dirname(__FILE__) .'/../../business/facadeControleDeAcesso.php');

//echo $root = realpath($_SERVER["DOCUMENT_ROOT"]);

//echo 'HERE';

if(!isset($_POST['codigo'])){
    header('Location: ' .SITE_URL. 'controledeacesso');
}

$code = mysql_escape_string( $_POST['codigo'] );

$cda = new SessionControleDeAcesso();

$acesso = $cda->getByCode($code);

if(mysql_num_rows($acesso)==0){
    session_start();
    $_SESSION['error'] = 'O código não foi encontrado';

    $numTentativas = isset($_COOKIE['codefail'])&&$_COOKIE['codefail']!=''?($_COOKIE['codefail']+1):1;
    setcookie("codefail", $numTentativas, time()+600);

    header('Location: ' .SITE_URL. 'controledeacesso/recepcao');
    exit;
}   

setcookie("codefail", 0);

$ac = mysql_fetch_assoc($acesso);

if (
   ($ac['presente'] != '' && $ac['presente'] != '0000-00-00 00:00:00') &&
   ($ac['acompanhante'] == 0 ||
      ($ac['acompanhante_presente'] != '' && $ac['acompanhante_presente'] != '0000-00-00 00:00:00')
   )){
   session_start();
    $_SESSION['error'] = 'Código já utilizado. O convidado já está presente';
    header('Location: ' .SITE_URL. 'controledeacesso/recepcao');
    exit;
}

if ($ac['confirmado'] == '' || $ac['confirmado'] == '0000-00-00 00:00:00') {
	session_start();
    $_SESSION['error'] = 'O convidado não foi confirmado previamente';
    header('Location: ' .SITE_URL. 'controledeacesso/recepcao');
    exit;
}

//echo '<pre>'; print_r($ac); echo '</pre>';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Página 4</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
<script type="text/javascript" src="js/jquery.1.7.2-min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

</head>

<body class="fundo">
	<div class="main">
    <?php if($ac['vip']==1): ?>
    	<div class="vip"><img src="img/convidadovip.png" width="207" height="540" /></div>
    <?php endif; ?>
		<div class="logo">
    		<img src="img/logo.png" />
    	</div>
        	<div class="content-form">
       			<form class="form" method="POST" id="formConfirmacao" action="execConfirmar.php">
                <input type="hidden" name="codigo" value="<?php echo $ac['codigo']; ?>" />
              	<table width="800" border="0">
					<tr>
    					<td class="txt">Código do Convite</td>
    					<td class="tdinput"><span class="input-xlarge uneditable-input"><?php echo $ac['codigo']; ?></span></td>
  					</tr>
					<tr>
    					<td class="txt">Convidado confirmado</td>
    					<td class="tdinput"><span class="input-xlarge uneditable-input"><?php if ($ac['confirmado']!='' && $ac['confirmado']!='0000-00-00 00:00:00'): echo "SIM"; else: echo "NÃO"; endif; ?></span></td>
  					</tr>
					<tr>
    					<td class="txt">Acompanhante confirmado</td>
    					<td class="tdinput"><span class="input-xlarge uneditable-input"><?php if ($ac['acompanhante']==1): echo "SIM"; else: echo "NÃO"; endif; ?></span></td>
  					</tr>
                    <tr>
                        <td class="txt">Convidado está presente?</td>
                        <td class="tdinput">
                            <select required name="convidado_presente" id="convidado_presente">
                                <option value="sim"<?php if($ac['convidado_presente']!='' && $ac['convidado_presente']!='0000-00-00 00:00:00'): ?> selected="selected"<?php endif; ?>>Sim</option>
                                <option value="nao"<?php if($ac['convidado_presente']=='' || $ac['convidado_presente']=='0000-00-00 00:00:00'): ?> selected="selected"<?php endif; ?>>Não</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
						<td class="txt">Acompanhante está presente?</td>
						<td class="tdinput">
						  <select required name="acompanhante_presente" id="acompanhante_presente">
								<option value="sim"<?php if($ac['acompanhante_presente']!='' && $ac['acompanhante_presente']!='0000-00-00 00:00:00'): ?> selected="selected"<?php endif; ?>>Sim</option>
								<option value="nao"<?php if($ac['acompanhante_presente']=='' || $ac['acompanhante_presente']=='0000-00-00 00:00:00'): ?> selected="selected"<?php endif; ?>>Não</option>
						  </select>
						</td>         
  					</tr>
  					<tr>
    					<td class="txt">Nome completo do Convidado</td>
    					<td class="tdinput"><span class="input-xlarge uneditable-input"><?php echo utf8_encode($ac['nome']); ?></span></td>
  					</tr>
  					<tr>
    					<td class="txt">E-mail</td>
    					<td class="tdinput"><span class="input-xlarge uneditable-input"><?php echo $ac['email']; ?></span></td>
 				    </tr>
  					<tr>
    				   <td class="txt">Telefone Residencial</td>
                       <td class="tdinput"><span class="input-xlarge uneditable-input"><?php echo $ac['telefone']; ?></span></td>
                    </tr>
             </table>
			<div class="bfinalizar">	
   					<button id="submitConfirmacao" class="btn btn-success" type="button">Finalizar</button>
        	</div>
            <div class="sucesso" style="display: none;">
               Finalizado com sucesso! Redirecionando...
            </div>
            	</form>
            </div>
   </div>

   <script type="text/javascript">
        jQuery(document).ready(function(){

            jQuery('#submitConfirmacao').click(function(e){
                e.preventDefault();
                formSubmit();
                
            });

            jQuery('#acompanhante').focus().keypress(function(e){                
                if(e.keyCode==32){                  
                    formSubmit();                    
                }
            });
        });

        function formSubmit(){
            console.log('form submit');

            jQuery('.sucesso').fadeIn();

            jQuery('#formConfirmacao').submit();
        }
   </script>
</body>
</html>
