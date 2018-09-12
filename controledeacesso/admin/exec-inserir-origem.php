<?php
require_once(dirname(__FILE__).'/../../dao/dao.class.php');
require_once(dirname(__FILE__).'/../../business/facadeControleDeAcesso.php');
require_once(dirname(__FILE__)."/functions.php");

//*********************Verificar Login********************************
$pagina = "exec-editar-convidados";
validaUsuarioAdmin($pagina);

//******************** Inicialização variaveis ***********************

$descricao = isset($_POST['origem']) ? $_POST['origem'] : "";

if(empty($descricao))
{
    $_SESSION['msg_erro'] = 'O campo Descrição está vazio!';
}
else
{

    $banco = new DAO('../dao/config.xml');

    $banco->conecta();

    $existe = $banco->executaQuery("select id from origem where descricao = '".addslashes($descricao)."'");
    $return_existe = mysql_fetch_array($existe);

    if($return_existe)
    {
        $_SESSION['msg_erro'] = 'Essa descrição já existe no banco!';
    }
    else
    {
        $result = $banco->executaQuery("INSERT INTO `origem`(`descricao`) VALUES ('".$descricao."')");

        if($result){
            $_SESSION['msg_sucesso'] = 'Descrição cadastrada com sucesso!';
            header('Location: /controledeacesso/admin/inserir-origem.php');
            exit;
        }
        else{
            $_SESSION['msg_erro'] = 'O cadastro não pôde ser criado!';
        }
    }
}

header('Location: /controledeacesso/admin/inserir-origem.php');

