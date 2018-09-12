<?php

require_once(dirname(__FILE__) . '/../../dao/dao.class.php');
require_once(dirname(__FILE__) . '/../../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__) . "/functions.php");

//*********************Verificar Login********************************
$pagina = "inserir-convidados";
validaUsuarioAdmin($pagina);

include(dirname(__FILE__) . "/header.php");

?>

<header class="topo-float">
    <h1>Inserir convidado</h1>
</header>
<div class="dados-cadastrais">
    <div class="simpleTabs" style="margin-top:35px;">

        <form id="formInserirConvidados" method="POST"
              action="<?php echo SITE_URL; ?>controledeacesso/admin/exec-inserir-convidados.php">
            <table width="100%" border="0">
                <tr>
                    <td class="right"><label>Origem</label></td>
                    <td>&nbsp;</td>
                    <td>
                        <select class="input-xlarge " name="origem" id="origem" style="width: 280px">
                            <option></option>
                            <?php
                            $origens = retorna_origens();
                            $total = count($origens);
                            for($i=0;$i<$total-1;$i++)
                            {
                                echo "<option value='".$origens[$i]->id."'>".$origens[$i]->descricao."</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="right"><label>Convidado Vip</label></td>
                    <td>&nbsp;</td>
                    <td><select class="large1" name="vip" id="vip">
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>
                        </select></td>
                </tr>
                <tr>
                    <td width="27%" class="right"><label>Código</label></td>
                    <td width="2%">&nbsp;</td>
                    <td width="50%">
                        <input type="text" name="codigo" id="codigo" class="input-cod" value="" readonly="readonly" />
                    </td>
                </tr>

                <tr>
                    <td class="right"><label>Nome</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="nome" class="input-xlarge" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>E-mail</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="email" class="input-xlarge" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>Cep</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="cep" class="input-xlarge cep" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>Endereço</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="endereco" class="input-xlarge endereco" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>Número</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="numero" class="input-xlarge" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>Complemento</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="complemento" class="input-xlarge" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>Bairro</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="bairro" class="input-xlarge bairro" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>Cidade</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="cidade" class="input-xlarge cidade" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>Estado</label></td>
                    <td>&nbsp;</td>
                    <td>
                        <select class="input-xlarge estado" id="estado" name="estado" style="width: 280px">
                            <option></option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="right"><label>Telefone residencial</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="telefone" class="input-xlarge" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>Telefone celular</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="celular" id="celular" class="input-xlarge celular" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>Empresa</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="empresa" class="input-xlarge" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>Cargo</label></td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="cargo" class="input-xlarge" value=""></td>
                </tr>
                <tr>
                    <td class="right"><label>Acompanhante</label></td>
                    <td>&nbsp;</td>
                    <td><select class="large1" name="acompanhante">
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="right"><label>Confirmado</label></td>
                    <td>&nbsp;</td>
                    <td><select class="large1" name="confirmados">
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>
                        </select>
                    </td>
                </tr>
            </table>
            <p align="center" style="margin-top:10px; margin:10px 0 40px 267px;">
                <button class="btn btn btn-success">Salvar</button>
            </p>
        </form>

    </div>
</div><!--Fim dados-cadastrais-->


<script type="text/javascript">
    function getEndereco() {
        jQuery.ajax({
            url: '../../ajax-cep.php?cep=' + $('.cep').val(),
            success: function (data) {
                buscaEnd = jQuery.parseJSON(data);
                if (buscaEnd.status == 'ok') {
                    $('.cep').css({'border-color': 'green'});
                    $('.cep').css({'background-color': 'white'});
                    $('.cep').css({'color': '#555'});

                    $('.endereco').val(buscaEnd.logradouro);
                    $('.bairro').val(buscaEnd.bairro);
                    $('.cidade').val(buscaEnd.cidade);
                    $('.estado').val(buscaEnd.uf);

                    jQuery('.celular').unmask();

                    if (buscaEnd.uf == "SP") {
                        jQuery('.celular').mask('(99) 99999-9999');
                    }
                    else {
                        jQuery('.celular').mask('(99) 9999-9999');
                    }
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

    jQuery(document).ready(function () {
        $("input[name=telefone]").mask("99.99.9999 99:99");
        $("input[name=telefone]").mask('(99) 9999-9999');
        if($('#estado').val() == "SP"){
            $("input[name=celular]").mask('(99) 99999-9999');
        }else{
            $("input[name=celular]").mask('(99) 9999-9999');
        }
        $('.cep').mask('99999-999');

        $("#formInserirConvidados").validate({

            rules: {
                'codigo': {
                    remote: {
                        url: Site.url + "controledeacesso/admin/check-codigo.php",
                        type: "post",
                        data: {
                            codigo: function () {
                                return $("#codigo").val();
                            }
                        }
                    },
                    'required': true
                },
                'nome': "required",
                'email': {"email": true},
                'origem': "required",
                'vip': "required"
                //'telefone': "required",

            },
            messages: {
                'codigo': {remote: "O codigo já existe", required: "Informe o código"},
                'nome': "Informe o nome",
                'origem': "Informe a origem",
                'vip': "Informe se ele é VIP ou não.",
                'email': {"email": "Informe um e-mail válido"}
            }
        });

        jQuery('.estado').change(function () {
            jQuery('.celular').unmask();

            if ($(this).val() == "SP") {
                jQuery('.celular').mask('(99) 99999-9999');
            }
            else {
                jQuery('.celular').mask('(99) 9999-9999');
            }
        });

        jQuery('.cep').blur(function (event) {
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

        jQuery('#estado').change(function(){
            jQuery('#celular').attr('value', '');
        });

    });
</script>

<?php include("footer.php"); ?>
