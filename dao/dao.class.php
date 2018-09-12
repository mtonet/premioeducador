<?php
require_once('config.php');

class DAO {

    private $host;
    private $usuario;
    private $senha;
    private $conexao;
    private $database;


  public function DAO($caminho) {
     // $xml = simplexml_load_file($caminho);

    	  
	  	$this->host = 'mysql.premioeducador2015.com.br';
        $this->usuario = 'premioeducador';
        $this->senha = 'premio2020';
       $this->database = 'premioeducador';
		
		
	  //	$this->host = 'mysql.inscricoespremioeducador.com.br';
       // $this->usuario = 'inscricoesprem';
      //  $this->senha = 'pvc220';
      //  $this->database = 'inscricoesprem';		
	   
	  // $this->host = 'mysql.inscricoespvc2012.com.br';
      //$this->usuario = 'inscricoespvc2';
      //$this->senha = 'pvc2012abril';
      //$this->database = 'inscricoespvc2'; 
    
  }


  public function conecta() {
      $this->conexao = mysql_connect($this->host,$this->usuario,$this->senha);
      mysql_select_db($this->database,$this->conexao) or die( "Could not select test database" );;
  }

  public function desconecta() {
      mysql_close($this->conexao);
  }


  public function executaQuery($query) {
      $retorno = mysql_query($query,$this->conexao) or die( mysql_error()); 
	 // or die( mysql_error())
      return $retorno;
  }
  
   public function executaQuerySemRetorno($query) {
      mysql_query($query,$this->conexao) or die( mysql_error()); 
  }
  
  public function executeProc($query){
  	 $retorno = mysql_query($query,$this->conexao);
	 // or die( mysql_error()); 
	  return $retorno;
   }

  public function iniciarTransacao() {
      $this->executaQuery('begin');   
  }


  public function efetuarTransacao() {
      $this->executaQuery('commit');
  }


  public function desfazerTransacao() {
      $this->desfazerTransacao('rollback');
  }

  public function id() {
      return mysql_insert_id();
  }
}
?>
