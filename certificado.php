<?php
require_once("config.php");
require_once("functions-g.php");
require_once('dao/dao.class.php');
require_once("business/facadeInscrito.php");

$facadeInscrito = new SessionFacadeInscrito();
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
	
if ($action == "cert") {

         if(isset($_REQUEST["id"])) {
           
                $value = $_REQUEST["id"];
				$arquivo = fopen("certificado.html", "r");
					$conteudo = fread($arquivo, filesize("certificado.html"));
					fclose($arquivo);

					$line = $facadeInscrito->getListById($value);
					$line = mysql_fetch_array($line);					
					

					if (  ($line['inscricao_status']=="2") || ($line['inscricao_status']=="3") ) {
					$texto = "participou da 17ª edição do Prêmio Educador Nota 10.";
					}


					if ( $line['inscricao_status']=="7" ) {
					$texto = "ficou entre os 50 finalistas da 17ª edição do Educador Nota 10.";
					}
					
					
					if ( $line['inscricao_status']=="10" ) {
					$texto = "ficou entre os 20 premiados da 17ª edição do Prêmio Educador Nota 10.";
					}
					
					if ( $line['inscricao_status']=="8" ) {
					$texto = "ficou entre os 10 vencedores da 17ª edição do Prêmio Educador Nota 10.";
					}										
					
					
//STATUS TRABALHO-IMPRESSO: participou da 16ª edição do Prêmio Educador Nota 10.

//STATUS FINALISTA: ficou entre os 50 finalistas da 16ª edição do Prêmio Educador Nota 10.

//STATUS PREMIADO(novo): ficou entre os 20 premiados da 16ª edição do Prêmio Educador Nota 10.

//STATUS VENCEDOR: ficou entre os 10 vencedores da 16ª edição do Prêmio Educador Nota 10.

					$dia = date("d");
					
					$conteudo = str_replace('%nome%', utf8_encode($line['nome']), $conteudo);
					$conteudo = str_replace('%texto%', utf8_encode($texto), $conteudo);
					$conteudo = str_replace('%dia%', $dia , $conteudo);					
					
		//	echo $conteudo;	 	
			
			
	
include("MPDF57/mpdf.php");

$mpdf=new mPDF(); 
$mpdf->addPage('L','','','','',10,10,10,10,10,10);
$mpdf->WriteHTML($conteudo);
$mpdf->Output();
exit;		
			
			
			
	
         }  else  {
             echo ("Nenhum Inscrito selecionada!"); 
         }

}	

?>
