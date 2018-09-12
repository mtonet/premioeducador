<?php
require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__)."/functions.php");

//*********************Verificar Login********************************
$pagina = "editar-convidados";
validaUsuarioAdmin($pagina);

//******************** Inicialização variaveis ***********************

$facadeControleDeAcesso = new SessionControleDeAcesso();
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;

$codigo = '';

$codigo = isset($_REQUEST['codigo']) ? $_REQUEST['codigo'] : "";

if ($codigo == "")
  header('Location: /controledeacesso/admin/dados-cadastrais.php');

//get list of controleDeAcesso
$result = $facadeControleDeAcesso->getByCode($codigo);

if(mysql_num_rows($result)!=1)
  header('Location: /controledeacesso/admin/dados-cadastrais.php');

$cad = mysql_fetch_assoc($result);

//echo '<pre>'; print_r($cad); '</pre>';

include(dirname(__FILE__). "/header.php");
?>


      
<?php @session_start(); ?>      

<?php if(isset($_SESSION['msg_sucesso'])): ?>
<div class="alert1 alert-success1" style="margin: 0 0 20px 0; width: 100%"><?php echo $_SESSION['msg_sucesso']; ?></div>
<?php unset($_SESSION['msg_sucesso']); endif; ?>

<?php if(isset($_SESSION['msg_erro'])): ?>
<div class="alert1 alert-danger" style="margin: 0 0 20px 0"><?php echo $_SESSION['msg_erro']; ?></div>
<?php unset($_SESSION['msg_erro']); endif; ?>

<header class="topo-float">
  	<h1>Editar convidado</h1>                
</header>                             

<div class="dados-cadastrais">

  <div class="simpleTabs" style="margin-top:35px;">
   
    <form method="POST" id="formEditarConvidados" action="<?php echo SITE_URL.'controledeacesso/admin/exec-editar-convidados.php' ?>">
      <input type="hidden" name="codigoAntigo" id="codigoAntigo" class="" value="<?php echo $cad['codigo']?>">
    	<table width="100%" border="0">
      <tr>
        <td width="27%" class="right"><label>Data</label></td>
        <td width="2%">&nbsp;</td>
        <td width="50%"><input type="text" name="criado" class="input-xlarge" value="<?php echo date('d.m.Y h:i', strtotime($cad['atualizado']));  ?>" disabled="disabled"></td>
      </tr>
      <tr>
        <td class="right"><label>Código</label></td>
        <td>&nbsp;</td>
        <td><input type="text" name="codigo" id="codigo" class="input-xlarge" value="<?php echo $cad['codigo']?>"></td>
      </tr>  
      </tr>
      <tr>
        <td class="right"><label>Nome</label></td>
        <td>&nbsp;</td>
        <td><input type="text" name="nome" class="input-xlarge" value="<?php echo utf8_encode($cad['nome']); ?>"></td>
      </tr>
      <tr>
        <td class="right"><label>E-mail</label></td>
        <td>&nbsp;</td>
        <td><input type="text" name="email" class="input-xlarge" value="<?php echo $cad['email']?>"></td>
      </tr>
	  <tr>
		<td class="right"><label>Cep</label></td>
		<td>&nbsp;</td>
		<td><input type="text" name="cep" class="input-xlarge cep" value="<?php echo $cad['cep']; ?>"></td>
	  </tr>
	  <tr>
		<td class="right"><label>Endereço</label></td>
		<td>&nbsp;</td>
		<td><input type="text" name="endereco" class="input-xlarge endereco" value="<?php echo utf8_encode($cad['endereco']); ?>"></td>
	  </tr>
	  <tr>
		<td class="right"><label>Número</label></td>
		<td>&nbsp;</td>
		<td><input type="text" name="numero" class="input-xlarge" value="<?php echo $cad['numero']; ?>"></td>
	  </tr>
	  <tr>
		<td class="right"><label>Complemento</label></td>
		<td>&nbsp;</td>
		<td><input type="text" name="complemento" class="input-xlarge" value="<?php echo utf8_encode($cad['complemento']); ?>"></td>
	  </tr>
	  <tr>
		<td class="right"><label>Bairro</label></td>
		<td>&nbsp;</td>
		<td><input type="text" name="bairro" class="input-xlarge bairro" value="<?php echo utf8_encode($cad['bairro']); ?>"></td>
	  </tr>
	  <tr>
		<td class="right"><label>Cidade</label></td>
		<td>&nbsp;</td>
		<td><input type="text" name="cidade" class="input-xlarge cidade" value="<?php echo utf8_encode($cad['cidade']); ?>"></td>
	  </tr>
	  <tr>
		<td class="right"><label>Estado</label></td>
		<td>&nbsp;</td>
		<td>
		  <select class="input-xlarge estado" name="estado" style="width: 280px">
			<option></option>
			<option value="AC" <?php if (utf8_encode($cad['estado']) == "AC")  echo "selected=\"selected\" " ?>>Acre</option>
			<option value="AL" <?php if (utf8_encode($cad['estado']) == "AL")  echo "selected=\"selected\" " ?>>Alagoas</option>
			<option value="AP" <?php if (utf8_encode($cad['estado']) == "AP")  echo "selected=\"selected\" " ?>>Amapá</option>
			<option value="AM" <?php if (utf8_encode($cad['estado']) == "AM")  echo "selected=\"selected\" " ?>>Amazonas</option>
			<option value="BA" <?php if (utf8_encode($cad['estado']) == "BA")  echo "selected=\"selected\" " ?>>Bahia</option>
			<option value="CE" <?php if (utf8_encode($cad['estado']) == "CE")  echo "selected=\"selected\" " ?>>Ceará</option>
			<option value="DF" <?php if (utf8_encode($cad['estado']) == "DF")  echo "selected=\"selected\" " ?>>Distrito Federal</option>
			<option value="ES" <?php if (utf8_encode($cad['estado']) == "ES")  echo "selected=\"selected\" " ?>>Espírito Santo</option>
			<option value="GO" <?php if (utf8_encode($cad['estado']) == "GO")  echo "selected=\"selected\" " ?>>Goiás</option>
			<option value="MA" <?php if (utf8_encode($cad['estado']) == "MA")  echo "selected=\"selected\" " ?>>Maranhão</option>
			<option value="MT" <?php if (utf8_encode($cad['estado']) == "MT")  echo "selected=\"selected\" " ?>>Mato Grosso</option>
			<option value="MS" <?php if (utf8_encode($cad['estado']) == "MS")  echo "selected=\"selected\" " ?>>Mato Grosso do Sul</option>
			<option value="MG" <?php if (utf8_encode($cad['estado']) == "MG")  echo "selected=\"selected\" " ?>>Minas Gerais</option>
			<option value="PA" <?php if (utf8_encode($cad['estado']) == "PA")  echo "selected=\"selected\" " ?>>Pará</option>
			<option value="PB" <?php if (utf8_encode($cad['estado']) == "PB")  echo "selected=\"selected\" " ?>>Paraíba</option>
			<option value="PR" <?php if (utf8_encode($cad['estado']) == "PR")  echo "selected=\"selected\" " ?>>Paraná</option>
			<option value="PE" <?php if (utf8_encode($cad['estado']) == "PE")  echo "selected=\"selected\" " ?>>Pernambuco</option>
			<option value="PI" <?php if (utf8_encode($cad['estado']) == "PI")  echo "selected=\"selected\" " ?>>Piauí</option>
			<option value="RJ" <?php if (utf8_encode($cad['estado']) == "RJ")  echo "selected=\"selected\" " ?>>Rio de Janeiro</option>
			<option value="RN" <?php if (utf8_encode($cad['estado']) == "RN")  echo "selected=\"selected\" " ?>>Rio Grande do Norte</option>
			<option value="RS" <?php if (utf8_encode($cad['estado']) == "RS")  echo "selected=\"selected\" " ?>>Rio Grande do Sul</option>
			<option value="RO" <?php if (utf8_encode($cad['estado']) == "RO")  echo "selected=\"selected\" " ?>>Rondônia</option>
			<option value="RR" <?php if (utf8_encode($cad['estado']) == "RR")  echo "selected=\"selected\" " ?>>Roraima</option>
			<option value="SC" <?php if (utf8_encode($cad['estado']) == "SC")  echo "selected=\"selected\" " ?>>Santa Catarina</option>
			<option value="SP" <?php if (utf8_encode($cad['estado']) == "SP")  echo "selected=\"selected\" " ?>>São Paulo</option>
			<option value="SE" <?php if (utf8_encode($cad['estado']) == "SE")  echo "selected=\"selected\" " ?>>Sergipe</option>
			<option value="TO" <?php if (utf8_encode($cad['estado']) == "TO")  echo "selected=\"selected\" " ?>>Tocantins</option>
		  </select>
		</td>
	  </tr>
      <tr>
        <td class="right"><label>Telefone residencial</label></td>
        <td>&nbsp;</td>
        <td><input type="text" name="telefone" class="input-xlarge" value="<?php echo $cad['telefone']?>"></td>
      </tr>  
      <tr>
       <td class="right"><label>Telefone celular</label></td>
        <td>&nbsp;</td>
        <td><input type="text" name="celular" class="input-xlarge celular" value="<?php echo $cad['celular']?>"></td>
      </tr>
	  <tr>
	   <td class="right"><label>Empresa</label></td>
		<td>&nbsp;</td>
		<td><input type="text" name="empresa" class="input-xlarge" value="<?php echo utf8_encode($cad['empresa'])?>"></td>
	  </tr>
      <tr>
       <td class="right"><label>Acompanhante</label></td>
        <td>&nbsp;</td>
        <td><select class="large1" name="acompanhante">
               <option value="sim"<?php if ($cad['acompanhante']==1): ?>selected="selected"<?php endif; ?>>Sim</option>
               <option value="nao"<?php if ($cad['acompanhante']==0): ?>selected="selected"<?php endif; ?>>Não</option>
               </select>
        </td>
      </tr>
      <tr>
       <td class="right"><label>Confirmado</label></td>
        <td>&nbsp;</td>
        <td><select class="large1" name="confirmados">
               <option value="sim"<?php if ($cad['confirmado']==1): ?>selected="selected"<?php endif; ?>>Sim</option>
               <option value="nao"<?php if ($cad['confirmado']==0): ?>selected="selected"<?php endif; ?>>Não</option>
               </select>
        </td>
      </tr>      
    </table>
  <p align="center" style="margin-top:10px; margin:10px 0 40px 267px;"><input type="submit" class="btn btn btn-success" value="Salvar" /></p>        		
  </form>
   
    
    
  </div>	                                                                            

</div><!--Fim dados-cadastrais-->

<script type="text/javascript">
function getEndereco() {
  jQuery.ajax({
	  url: '../../ajax-cep.php?cep=' + $('.cep').val(),
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

jQuery(document).ready(function(){
  //$("input[name=criado]").mask("99.99.9999 99:99");
  $("input[name=telefone]").mask('(99) 9999-9999');
  $("input[name=celular]").mask('(99) 9999-9999?9');
  $('.cep').mask('99999-999');

  $("#formEditarConvidados").validate({
      
      rules: {
          'criado': {required:true},
          'codigo': {
            required: true,
            remote: {
              url: Site.url+"controledeacesso/admin/check-codigo.php",
              type: "post",
              data: {
                codigo: function() {
                  return $("#codigo").val();
                },
                codigoAntigo: function() {
                  return $("#codigoAntigo").val();
                }
              }
            }
          },
          'nome': "required",
          'email': {"email":true},
          //'telefone': "required",
          
      },
      messages: {
          'criado': {required:'A data é obrigatória'},
          'codigo': {required: 'O codigo é obrigatório', remote: "O codigo já existe"},
          'nome': "Informe o nome",
          'email': {"email":"Informe um e-mail válido"},
          //'telefone': "Informe o telefone",
          
      }
  });
  
  	jQuery('.estado').change( function() {
		jQuery('.celular').unmask();
		
		if ( $(this).val() == "SP" ) {
			jQuery('.celular').mask('(99) 99999-9999');
		}
		else {
			jQuery('.celular').mask('(99) 9999-9999');
		}
	});
  
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

<?php include(dirname(__FILE__). "/footer.php");
