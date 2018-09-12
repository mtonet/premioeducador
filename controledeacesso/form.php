<?php
require_once(dirname(__FILE__) ."/../config.php");
require_once(dirname(__FILE__) ."/../functions.php");
require_once(dirname(__FILE__) ."/../functions-g.php");
require_once(dirname(__FILE__) .'/../business/facadeControleDeAcesso.php');

//echo $root = realpath($_SERVER["DOCUMENT_ROOT"]);

//echo 'HERE';

if(!isset($_POST['code'])){
    header('Location: ' .SITE_URL. 'controledeacesso');
}

$code = mysql_escape_string( $_POST['code'] );

$cda = new SessionControleDeAcesso();

$acesso = $cda->getByCode($code);

if(mysql_num_rows($acesso)==0){
    session_start();
    $_SESSION['error'] = 'O código não foi encontrado';

    $numTentativas = isset($_COOKIE['codefail'])&&$_COOKIE['codefail']!=''?($_COOKIE['codefail']+1):1;
    setcookie("codefail", $numTentativas, time()+600);

    header('Location: ' .SITE_URL. 'controledeacesso');
    exit;
}   

setcookie("codefail", 0);

$ac = mysql_fetch_assoc($acesso);

if($ac['confirmado'] != '' && $ac['confirmado'] != '0000-00-00 00:00:00'){
   session_start();
    $_SESSION['error'] = 'Presença já confirmada';
    header('Location: ' .SITE_URL. 'controledeacesso');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Prêmio Victor Civita</title>
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.1.7.2-min.js"></script>    
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="js/jquery.numeric.js"></script>

</head>

<body>

    <div class="geral">
    <div class="container">
      <div class="content">
      	<div id="header">
        	<img src="img/topo.png" alt="" />
        </div><!--fim header -->      
       	<div class="pg2">
        	<div id="left">
            	<img src="img/logos.png" alt=""  />
            </div><!--fim left -->
            <div id="right">        
        	<div class="dados">
                <h1>Confira os dados dos campos abaixo, se preciso, por gentileza, corrija as informações.</h1>
                <h2>(*) campos de preenchimento obrigatório</h2> 
                
                    <form id="confirmationForm" method="post" action="<?php echo SITE_URL ?>controledeacesso/proccessform.php">             
                        <div class="form-left">
                            <p>Código do seu convite (*)</p>
                            <p>Nome completo do convidado (*)</p>
                            <p>E-Mail (*)</p>
                            <p>Cep</p>
                            <p>Endereço</p>
                            <p>Número</p>
                            <p>Complemento</p>
                            <p>Bairro</p>
                            <p>Cidade (*)</p>
                            <p>Estado (*)</p>
                            <p>Telefone Residencial (*)</p>
                            <p>Telefone Celular (*)</p>
                            <p>Empresa (*)</p>
                            <p>Cargo (*)</p>
                            <p>Deseja confirmar <br />acompanhante? (*)</p>
                        </div>
                        <div class="form-right">
                            <input id="" type="hidden" name="id" value="<?php echo $ac['id']; ?>" />
                            <p><input class="input-xlarge focused" id="" type="text" name="codigo" value="<?php echo $ac['codigo']; ?>" readonly="readonly" /></p>
                            <p><input class="input-xlarge focused" id="" type="text" name="nome" value="<?php echo utf8_encode($ac['nome']); ?>" /></p>
                            <p><input class="input-xlarge focused" id="" type="text" name="email" value="<?php echo $ac['email']; ?>" /></p>
                            <p><input class="input-xlarge focused cep" id="" type="text" name="cep" value="<?php echo $ac['cep']; ?>" /> <span id="cep-carregando">Carregando...</span>
                            <p><input class="input-xlarge focused endereco" id="" type="text" name="endereco" value="<?php echo utf8_encode($ac['endereco']); ?>" /></p>
                            <p><input class="input-xlarge focused numeric" id="" type="text" name="numero" value="<?php echo $ac['numero']; ?>" /></p>
                            <p><input class="input-xlarge focused" id="" type="text" name="complemento" value="<?php echo utf8_encode($ac['complemento']); ?>" /></p>
                            <p><input class="input-xlarge focused bairro" id="" type="text" name="bairro" value="<?php echo utf8_encode($ac['bairro']); ?>" /></p>
                            <p><input class="input-xlarge focused cidade" id="" type="text" name="cidade" value="<?php echo utf8_encode($ac['cidade']); ?>" /></p>
                            <p>
                              <select class="input-xlarge estado" name="estado" style="width: 280px">
				                <option></option>
				                <option value="AC" <?php if (utf8_encode($ac['estado']) == "AC")  echo "selected=\"selected\" " ?>>Acre</option>
                                <option value="AL" <?php if (utf8_encode($ac['estado']) == "AL")  echo "selected=\"selected\" " ?>>Alagoas</option>
                                <option value="AP" <?php if (utf8_encode($ac['estado']) == "AP")  echo "selected=\"selected\" " ?>>Amapá</option>
			                    <option value="AM" <?php if (utf8_encode($ac['estado']) == "AM")  echo "selected=\"selected\" " ?>>Amazonas</option>
                                <option value="BA" <?php if (utf8_encode($ac['estado']) == "BA")  echo "selected=\"selected\" " ?>>Bahia</option>
                                <option value="CE" <?php if (utf8_encode($ac['estado']) == "CE")  echo "selected=\"selected\" " ?>>Ceará</option>
				                <option value="DF" <?php if (utf8_encode($ac['estado']) == "DF")  echo "selected=\"selected\" " ?>>Distrito Federal</option>
                                <option value="ES" <?php if (utf8_encode($ac['estado']) == "ES")  echo "selected=\"selected\" " ?>>Espírito Santo</option>
                                <option value="GO" <?php if (utf8_encode($ac['estado']) == "GO")  echo "selected=\"selected\" " ?>>Goiás</option>
                                <option value="MA" <?php if (utf8_encode($ac['estado']) == "MA")  echo "selected=\"selected\" " ?>>Maranhão</option>
                                <option value="MT" <?php if (utf8_encode($ac['estado']) == "MT")  echo "selected=\"selected\" " ?>>Mato Grosso</option>
                                <option value="MS" <?php if (utf8_encode($ac['estado']) == "MS")  echo "selected=\"selected\" " ?>>Mato Grosso do Sul</option>
				                <option value="MG" <?php if (utf8_encode($ac['estado']) == "MG")  echo "selected=\"selected\" " ?>>Minas Gerais</option>
                                <option value="PA" <?php if (utf8_encode($ac['estado']) == "PA")  echo "selected=\"selected\" " ?>>Pará</option>
                                <option value="PB" <?php if (utf8_encode($ac['estado']) == "PB")  echo "selected=\"selected\" " ?>>Paraíba</option>
				                <option value="PR" <?php if (utf8_encode($ac['estado']) == "PR")  echo "selected=\"selected\" " ?>>Paraná</option>
				                <option value="PE" <?php if (utf8_encode($ac['estado']) == "PE")  echo "selected=\"selected\" " ?>>Pernambuco</option>
                                <option value="PI" <?php if (utf8_encode($ac['estado']) == "PI")  echo "selected=\"selected\" " ?>>Piauí</option>
                                <option value="RJ" <?php if (utf8_encode($ac['estado']) == "RJ")  echo "selected=\"selected\" " ?>>Rio de Janeiro</option>
                                <option value="RN" <?php if (utf8_encode($ac['estado']) == "RN")  echo "selected=\"selected\" " ?>>Rio Grande do Norte</option>
                                <option value="RS" <?php if (utf8_encode($ac['estado']) == "RS")  echo "selected=\"selected\" " ?>>Rio Grande do Sul</option>
				                <option value="RO" <?php if (utf8_encode($ac['estado']) == "RO")  echo "selected=\"selected\" " ?>>Rondônia</option>
                                <option value="RR" <?php if (utf8_encode($ac['estado']) == "RR")  echo "selected=\"selected\" " ?>>Roraima</option>
                                <option value="SC" <?php if (utf8_encode($ac['estado']) == "SC")  echo "selected=\"selected\" " ?>>Santa Catarina</option>
				                <option value="SP" <?php if (utf8_encode($ac['estado']) == "SP")  echo "selected=\"selected\" " ?>>São Paulo</option>
                                <option value="SE" <?php if (utf8_encode($ac['estado']) == "SE")  echo "selected=\"selected\" " ?>>Sergipe</option>
                                <option value="TO" <?php if (utf8_encode($ac['estado']) == "TO")  echo "selected=\"selected\" " ?>>Tocantins</option>
                              </select>
							</p>
							<p><input class="input-xlarge focused telefone" id="" type="text" name="telefone" value="<?php echo $ac['telefone']; ?>" /></p>
                            <p><input class="input-xlarge focused celular" id="" type="text" name="celular" value="<?php echo $ac['celular']; ?>" /></p>
                            <p><input class="input-xlarge focused" id="" type="text" name="empresa" value="<?php echo utf8_encode($ac['empresa']); ?>" /></p>
                            <p><input class="input-xlarge focused" id="" type="text" name="cargo" value="<?php echo utf8_encode($ac['cargo']); ?>" /></p>
                            <p class="rad">
                                <input style="margin-right:5px;" type="radio" name="acompanhante"<?php if($ac['acompanhante']==1): ?> checked="checked"<?php endif; ?> value="1" /> Sim
                                <input style="margin:0 5px 0 25px;" type="radio" name="acompanhante"<?php if($ac['acompanhante']==0): ?> checked="checked"<?php endif; ?> value="0" /> Não
                            </p>
                            <p class="aviso-acomp"><b>Importante:</b> Uma vez confirmada ou declinada a sua presença e/ou de seu acompanhante, para efetuar qualquer alteração é necessário entrar em contato com a nossa Central de Atendimento.</p>
                        </div>      
                        <p class="pessoal">Convite pessoal e intransferível, válido para duas pessoas. Traje passeio completo. É indispensável a apresentação do convite na recepção do evento. Entrada pela Praça Júlio Prestes, nº 16.</p>
                        <div class="linha-confer"></div>            
                        <input type="submit" class="btn btn-success" value="Finalizar"> 
                    </form>

              </div><!--fim dados -->
          </div><!--fim right -->
        </div>
      </div><!-- end .pg1 -->
      </div><!-- end .content -->
    </div><!-- end .container -->
    </div><!-- end .geral --><script type="text/javascript">    
       function getEndereco() {
	      jQuery.ajax({
		      url: '../ajax-cep.php?cep=' + $('.cep').val(),
		      success: function(data) {
			      buscaEnd = jQuery.parseJSON(data);
			      if (buscaEnd.status == 'ok') {
				      $('.cep').css({'border-color': 'green'});
				      $('.cep').css({'background-color': 'white'});
				      $('.cep').css({'color': '#555'});
				
				      $('.endereco').val(buscaEnd.logradouro);
				      $('.bairro').val(buscaEnd.bairro);
				      $('.cidade').val(buscaEnd.cidade);
				      $('.estado').val(buscaEnd.uf);
			      }
			      else {
				      $('.cep').val('');
				
				      $('.cep').css({'border-color': 'red'});
				      $('.cep').css({'background-color': 'red'});
				      $('.cep').css({'color': 'white'});
				
				      //$('#box-invalido').css({'display': 'inline'});
			      }
			      $('#cep-carregando').css({'display': 'none'});
			      $('.endereco').removeAttr('disabled');
			      $('.bairro').removeAttr('disabled');
			      $('.cidade').removeAttr('disabled');
			      $('.estado').removeAttr('disabled');
		      }
	      });
       }

        $(document).ready(function(){
        
            $("#confirmationForm").validate({
                onfocusout: false,            
                rules: {
                    'codigo': "required",
                    'nome': "required",
                    'email': {
                        required: true,
                        email: true
                    },
                    'telefone': "required",
                    'celular': "required",                    
                    'cidade': "required",
                    'estado': "required",
                    'empresa': "required",
                    'cargo' : "required"
                    
                },
                messages: {
                    'codigo': "Informe seu codigo",
                    'nome': "Informe seu nome",
                    'email': {
                        required: "Informe seu e-mail", 
                        email: "Informe um e-mail válido"
                    },
                    'telefone': "Informe seu telefone",
                    'celular': "Informe seu celular",                
                    'cidade': "Informe a cidade",
                    'estado': "Informe o estado",
                    'empresa': "Informe a empresa",
                    'cargo' : "Informe o cargo"
                }
            });

            jQuery('.cep').mask('99999-999');
            jQuery('.telefone').mask('(99) 9999-9999');
            jQuery('.celular').mask('(99) 99999-9999');
            jQuery(".numeric").numeric();
            
            jQuery('.telefone').blur( function(event) {
               event.preventDefault();
               if ( $(this).val() == '(11) 1111-1111') {
                  $(this).val('');
               }
            });
            jQuery('.celular').blur( function(event) {
               event.preventDefault();
               if ( $(this).val() == '(11) 1111-1111' || $(this).val() == '(11) 11111-1111' ) {
                  $(this).val('');
               }
            });

			
			if ( jQuery('.estado').val() == "SP" ) {
				jQuery('.celular').unmask();
				jQuery('.celular').mask('(99) 99999-9999');
			}
			
			jQuery('.estado').change( function() {
				jQuery('.celular').unmask();
				
				if ( $(this).val() == "SP" ) {
					jQuery('.celular').mask('(99) 99999-9999');
					alert("Para o estado de SP, inserir o 9º dígito.");
				}
				else {
					jQuery('.celular').mask('(99) 9999-9999');
				}
			});
            
            /******************************************/
            
         	jQuery('.cep').blur( function(event) {
	            event.preventDefault();
	            if (jQuery('.cep').val() == '') {
		            jQuery('.cep').css({'border-color': 'red'});
		            jQuery('.cep').css({'background-color': 'red'});
		            jQuery('.cep').css({'color': 'white'});
	            }
	            else {
		            //jQuery('#box-invalido').css({'display': 'none'});
		            jQuery('#cep-carregando').css({'display': 'inline'});
		
		            jQuery('.endereco').attr('disabled', 'disabled');
		            jQuery('.bairro').attr('disabled', 'disabled');
		            jQuery('.cidade').attr('disabled', 'disabled');
		            jQuery('.estado').attr('disabled', 'disabled');
		
		            getEndereco();
	            }
            });
            
        });
        
    </script>

</body>
</html>
