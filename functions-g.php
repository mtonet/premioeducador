<?php

function validaPassoLogin($passo) 
{
	session_start();
	$sessionPasso = $_SESSION['ultimo_passo'] ;
	
	if ( !isset($_SESSION['id']) ) {
		header("Location: index.php");
	}
	elseif ($passo > $sessionPasso ||  ($passo == 0 && $sessionPasso > 0))
	{
		//evitar navega��o em passo que ainda est� frente
		header("Location: pass" .$sessionPasso. ".php");
	}
	elseif ($passo != 7 &&  $sessionPasso  == 7)
		header("Location: pass7.php");
	
}
?>