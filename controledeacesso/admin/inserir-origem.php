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
    <h1>Inserir origem</h1>
</header>

<?php if(isset($_SESSION['msg_erro'])): ?>
    <div class="alert1 alert-danger" style="margin: 0 0 20px 0"><?php echo $_SESSION['msg_erro']; ?></div>
<?php unset($_SESSION['msg_erro']); endif; ?>

<?php if(isset($_SESSION['msg_sucesso'])): ?>
    <div class="alert1 alert-success1" style="margin: 0 0 20px 0; width: 100%"><?php echo $_SESSION['msg_sucesso']; ?></div>
<?php unset($_SESSION['msg_sucesso']); endif; ?>

<div class="dados-cadastrais">
    <div class="simpleTabs" style="margin-top:35px;">

        <form id="formInserirOrigem" method="POST" action="<?php echo SITE_URL; ?>controledeacesso/admin/exec-inserir-origem.php">
            <table width="100%" border="0">
                <tr>
                    <td width="27%" class="right"><label>Descrições já cadastradas</label></td>
                    <td width="2%">&nbsp;</td>
                    <td width="50%">
                        <select class="input-xlarge" name="origem-cadastrada" style="width: 280px">
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
                    <td width="27%" class="right"><label>Descrição</label></td>
                    <td width="2%">&nbsp;</td>
                    <td width="50%">
                        <input type="text" name="origem" id="origem" class="input-cod" value="">
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

    jQuery(document).ready(function () {

        $("#formInserirOrigem").validate({

            rules: {
                'origem': "required",
            },
            messages: {
                'origem': "Informe a descrição da origem.",
            }
        });
    });
</script>

<?php include("footer.php"); ?>
