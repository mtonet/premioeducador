<?php
require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__)."/functions.php");

//*********************Verificar Login********************************
$pagina = "convidados-codigos";
validaUsuarioAdmin($pagina);

//******************** Inicialização variaveis ***********************

session_start();

$paginaAtual = 0;
$paginaLimite = 99999999;

$facadeControleDeAcesso = new SessionControleDeAcesso();
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;

$busca = '';

$ordem = '';
$nome = '';
$codigo = '';
$acompanhante  = 'todos';
$confirmados = 'todos';


$get = array();


$busca 			= isset($_REQUEST['busca']) ? $_REQUEST['busca'] : "";

$ordem 			= isset($_REQUEST['ordem']) ? $_REQUEST['ordem'] : "codigo";
$nome 			= isset($_REQUEST['nome']) ? $_REQUEST['nome'] : "";
$codigo 		= isset($_REQUEST['codigo']) ? $_REQUEST['codigo'] : "";
$acompanhante 	= isset($_REQUEST['acompanhante']) ? $_REQUEST['acompanhante'] : 'todos';
$confirmados 	= isset($_REQUEST['confirmados']) ? $_REQUEST['confirmados'] : 'todos';


if($busca!=''){

    $get = array(
        'busca' => $busca,
    );

    $result = $facadeControleDeAcesso->getListByKeyword($busca, $paginaAtual, $paginaLimite);
    $total = $facadeControleDeAcesso->getTotalListByKeyword($busca);
}
else{

    if ($ordem != "")
        $get["ordem"] = $ordem;

    if ($nome != "")
        $get["nome"] = $nome;

    if ($codigo != "")
        $get["codigo"] = $codigo;

    if ($acompanhante != "")
        $get["acompanhante"] = $acompanhante;

    if ($confirmados != "")
        $get["confirmados"] = $confirmados;

    //get list of controleDeAcesso
    $result = $facadeControleDeAcesso->getList($ordem, $nome, $codigo, $acompanhante, $confirmados, $paginaAtual, $paginaLimite);
    $total = $facadeControleDeAcesso->getTotalList($nome, $codigo, $acompanhante, $confirmados);
}

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
        <title>Código de Barras - Convites</title>
        <script>window.print();</script>
        <style>
            #container{overflow: hidden; width: 100%;}
            .dados-cadastrais{border: 0px solid; width: 41mm; float: left; height: 27mm; font-family: Arial; font-size: 9px; }
            .codigo-convite{border: 0px solid; width: 44mm; float: left; height: 22mm; font-family: Arial; text-align: center; margin-left:0mm; padding-top: 1mm; font-size: 10px;}
            #etiqueta{border: 0px solid; width: 92mm; height: 29mm; margin-bottom:3mm }
            body{margin: 0 0 0 3.5mm; padding: 0; border: 0px solid #000}
        </style>
    </head>
    <body>
    <div id="container">
        <?php while($cad = mysql_fetch_assoc($result)): ?>
        <div id="etiqueta" >
            <div class="dados-cadastrais">
                <p>
                    <?php echo strtoupper(utf8_encode($cad['nome'])); ?><br />

                    <?php
                    if ( !empty($cad['endereco']) AND !empty($cad['numero']) AND !empty($cad['bairro']))
                    {
                        echo utf8_encode($cad['endereco']). ', ' .$cad['numero']. '-' .utf8_encode($cad['bairro']);
                    }

                    if( !empty($cad['cidade']))
                    {
                        echo  '<br />' .utf8_encode($cad['cidade']);
                    }

                    if( !empty($cad['cep']))
                    {
                        echo '<br />' . $cad['cep'];
                    }
                    ?>
                </p>
            </div>

            <div class="codigo-convite">
                <?php echo $cad['codigo']; ?><br />
                <img src="gera_codigo.php?cod=<?php echo $cad['codigo']?>" /><br />
                <?php
                    $nome = explode(" ", $cad['nome']);
                    echo utf8_encode($nome[0]);
                ?>
            </div>
        </div>

        <div style="clear: both;"></div>
        <?php endwhile; ?>
    </body>
</html>
