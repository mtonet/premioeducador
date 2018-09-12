 <?php
//colocar no config e o dir ser uma variavel publica
require_once($_SERVER["DOCUMENT_ROOT"]."dao/daoControleDeAcesso.class.php");



class SessionControleDeAcesso {

public function getByCode($codigo){
try {
$retorno = 0;
$ControleDeAcessoDAO = new ControleDeAcessoDAO();

$retorno = $ControleDeAcessoDAO->getByCode($codigo);
}
catch (Exception $e) {
$retorno = -1;
}

return $retorno;
}

public function getByName($nome){
try {
$retorno = 0;
$ControleDeAcessoDAO = new ControleDeAcessoDAO();

$retorno = $ControleDeAcessoDAO->getByName($nome);
}
catch (Exception $e) {
$retorno = -1;
}

return $retorno;
}

public function cadastra($codigo, $origem, $nome, $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $cargo, $acompanhante, $vip, $confirmado=false) {
try {
$retorno = 0;
$ControleDeAcessoDAO = new ControleDeAcessoDAO();

$retorno = $ControleDeAcessoDAO->cadastrar($codigo, $origem, $nome, $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $cargo, $acompanhante, $vip, $confirmado);
}
catch (Exception $e) {
$retorno = -1;
}

return $retorno;
}


public function atualiza($id, $nome, $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $cargo, $acompanhante) {
try {
$retorno = 0;
$ControleDeAcessoDAO = new ControleDeAcessoDAO();
$retorno = $ControleDeAcessoDAO->atualizar($id, $nome, $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $cargo, $acompanhante);
}
catch (Exception $e) {
$retorno = -1;
}

return $retorno;
}

public function atualizarByAdmin($codigoAntigo, $codigo, $nome, $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $cargo, $acompanhante, $criado, $confirmado) {
try {
$retorno = 0;
$ControleDeAcessoDAO = new ControleDeAcessoDAO();

$retorno = $ControleDeAcessoDAO->atualizarByAdmin($codigoAntigo, $codigo, $nome, $email, $telefone, $celular, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $empresa, $cargo, $acompanhante, $criado, $confirmado);
}
catch (Exception $e) {
$retorno = -1;
}

return $retorno;
}



public function getList($order, $nome, $codigo, $acompanhante, $confirmados, $pagAtual=0, $pagLimite=0) {

$retorno = null;

try {
$ControleDeAcessoDAO = new ControleDeAcessoDAO();
$retorno = $ControleDeAcessoDAO->getList($order, $nome, $codigo, $acompanhante, $confirmados, $pagAtual, $pagLimite);
}
catch (Exception $e)
{
$retorno = null;
}

return $retorno;
}


public function getPresentList($order, $nome, $codigo, $acompanhante, $confirmados, $presentes="", $acompanhantesPresentes = "", $pagAtual=0, $pagLimite=0) {


$retorno = null;

try {
$ControleDeAcessoDAO = new ControleDeAcessoDAO();
$retorno = $ControleDeAcessoDAO->getPresentList($order, $nome, $codigo, $acompanhante, $confirmados, $presentes, $acompanhantesPresentes, $pagAtual, $pagLimite);
}
catch (Exception $e)
{
$retorno = null;
}

return $retorno;
}

public function getTotalList($nome, $codigo, $acompanhante, $confirmados, $presentes="", $acompanhantesPresentes = "") {

$retorno = null;

try {
$ControleDeAcessoDAO = new ControleDeAcessoDAO();
$retorno = $ControleDeAcessoDAO->getTotalList($nome, $codigo, $acompanhante, $confirmados, $presentes, $acompanhantesPresentes);
}
catch (Exception $e)
{
$retorno = null;
}

return $retorno;
}

public function getListByKeyword($keyword, $pagAtual=0, $pagLimite=0) {

$retorno = null;

try {
$ControleDeAcessoDAO = new ControleDeAcessoDAO();
$retorno = $ControleDeAcessoDAO->getListByKeyword($keyword, $pagAtual, $pagLimite);
}
catch (Exception $e)
{
$retorno = null;
}

return $retorno;
}

public function getTotalListByKeyword($keyword) {

$retorno = null;

try {
$ControleDeAcessoDAO = new ControleDeAcessoDAO();
$retorno = $ControleDeAcessoDAO->getTotalListByKeyword($keyword);
}
catch (Exception $e)
{
$retorno = null;
}

return $retorno;
}


public function atualizarByCVS($codigo, $nome, $telefone, $celular, $email) {
try {
$retorno = 0;
$ControleDeAcessoDAO = new ControleDeAcessoDAO();

$retorno = $ControleDeAcessoDAO->atualizarByCVS($codigo, $nome, $telefone, $celular, $email);
}
catch (Exception $e) {
$retorno = -1;
}

return $retorno;
}

public function presenca_confirmada($codigo, $acompanhantePresente) {
try {
$retorno = 0;
$ControleDeAcessoDAO = new ControleDeAcessoDAO();

$retorno = $ControleDeAcessoDAO->presenca_confirmada($codigo, $acompanhantePresente);
}
catch (Exception $e) {
$retorno = -1;
}

return $retorno;
}

public function confirmarPresencaConvidado($codigo, $convidadoPresente)
{
try
{
$daoControleAcesso = new ControleDeAcessoDAO();
return $daoControleAcesso->confirmarPresencaConvidado($codigo, $convidadoPresente);
}
catch (Exception $e)
{
error_log("Ocorreu uma excessão ao confirmar convidade: {$e->getMessage()} ");
return false;
}
}

public function confirmacao($codigo, $acompanhante) {
try {
$retorno = 0;
$ControleDeAcessoDAO = new ControleDeAcessoDAO();

$retorno = $ControleDeAcessoDAO->confirmacao($codigo, $acompanhante);
}
catch (Exception $e) {
$retorno = -1;
}

return $retorno;
}

public function getRandomList($limit=null){
try {
$retorno = 0;
$ControleDeAcessoDAO = new ControleDeAcessoDAO();

$retorno = $ControleDeAcessoDAO->getRandomList($limit);
}
catch (Exception $e) {
$retorno = -1;
}

return $retorno;
}

}

?>