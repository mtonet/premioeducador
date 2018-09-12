<?php
require_once('../dao/dao.class.php');
require_once('../dao/daoUsuario.class.php');
require_once('../dao/daoInscrito.class.php');
require_once('../dao/daoDadosGestor.class.php');
require_once('../dao/daoDadosProfessor.class.php');
require_once('../dao/daoDadosAcademicos.class.php');
require_once('../dao/daoDadosProfissionais.class.php');
require_once('../dao/daoDadosCadastrais.class.php');
require_once('../dao/daoDadosTrabalho.class.php');


function get_header() {
	include("header.php");
}

function get_footer() {
	include("footer.php");
}

function validaUsuarioAdmin($pagina)
{
	session_start();

	if ( !isset($_SESSION['usuario_id']) ) {
		header("Location: index.php");
	}
	
	
	if($pagina == "cadastro-usuario" && $_SESSION['cadastro_usuarios'] == 0)
		header("Location:acesso.php");
	elseif($pagina == "lista-inscritos" && $_SESSION['lista_inscritos'] == 0)
		header("Location: acesso.php");
	elseif($pagina == "edicao-inscritos" && $_SESSION['edicao_inscritos'] == 0)
		header("Location: acesso.php");
	elseif($pagina == "relatorios" && $_SESSION['relatorios'] == 0)
		header("Location: acesso.php");
	
}

function get_url($get) {
	$get_string = "";
	foreach ($get as $key => $value) {
		$get_string .= "&" . $key . "=" . $value;
	}
	return $get_string;
}


function htmlPaginacao($pagAt, $configPaginacao, $result, $get = array()){

$get_string = get_url($get);
	
		$total_de_paginas = getTotalPaginas($result,$configPaginacao);
	
	
	//PAGINACAO
	$pagina_atual 		= ($pagAt == "") ? 1 : $pagAt;
	$pagina_anterior 	= $pagina_atual  - 1; 
	$pagina_posterior 	= $pagina_atual  + 1; 
	$link_de_navegacao = ''; 
	
	if ($total_de_paginas > 0) 
		{
			
			$limiteListaPaginacao = 15;
			
			// link "anterior"  
			if($pagina_atual > 1) 
			    $link_de_navegacao .= "  <li><a href=\"?paginaAtual=$pagina_anterior$get_string#lista\" style=\"color:#5a5a5a; text-decoration:none;\">«</a> </li>"; 
			
			$pagAt = (int)$pagAt;
			
			$inicio = ($total_de_paginas > $limiteListaPaginacao && $pagAt > $limiteListaPaginacao) ?  ($pagAt-$limiteListaPaginacao) : 1;
			$fim = ($pagAt+$limiteListaPaginacao > $total_de_paginas) ? $total_de_paginas : $pagAt+$limiteListaPaginacao;
			
						
			for($i = $inicio; $i <= $fim; $i++) 
			{ 
			  			   
			    if($i != $pagina_atual) 
			        $link_de_navegacao .= " <li><a href=\"?paginaAtual=$i$get_string#lista\" style=\"color:#5a5a5a; text-decoration:none;\">$i</a></li> "; 
			    else
			        $link_de_navegacao .= "<li class='active'><a href='#'>$i</a></li> "; 
			} 
			
			// link "proximo"
			if($pagina_atual != $total_de_paginas) 
			    $link_de_navegacao .= " <li><a href=\"?paginaAtual=$pagina_posterior$get_string#lista\" style=\"color:#5a5a5a; text-decoration:none;\" class=\"paginacao\">»</a></li>"; 
		}
	
	
	return $link_de_navegacao;
}

function getTotalPaginas($rs, $registros_por_pagina){
	$total_de_registros = mysql_num_rows($rs);
	
	if($total_de_registros > 0){
		$total_de_paginas = 0;
		
		if($total_de_registros > $registros_por_pagina){
		
			if (($total_de_registros % $registros_por_pagina) == 0) 
	 	   		$total_de_paginas = ($total_de_registros / $registros_por_pagina); 
			else
	   			$total_de_paginas = ($total_de_registros / $registros_por_pagina) + 1; 
	
			$total_de_paginas = (int) $total_de_paginas; 	
		}
	}
	
	return $total_de_paginas;
}


function pretty_print_data($data) {
	$tempo = strtotime($data);
	echo date('d.m.Y H:i', $tempo);
}

function pretty_print_data_barra($data) {
	$tempo = strtotime($data);
	echo date('d/m/Y', $tempo);
}

function print_categoria($line) {
	switch ($line['categoria']) {
		case 'P':
			echo 'Professor';
			break;
		case 'G':
			echo 'Gestor';
			break;
	}
}

function print_atuacao($line) {
	if ($line['categoria'] == 'G') {
		switch ($line['atuacao']) {
			case 'D':
				echo 'Diretor Escolar';
				break;
			case 'C':
				echo 'Coordenador Pedag&oacute;gico';
				break;
			case 'O':
				echo 'Orientador Educacional';
				break;
		}
	}
	elseif ($line['categoria'] == 'P') {
		echo '---------';
	}
}

function print_disciplina($line) {
	if ($line['categoria'] == 'P') {
		if ($line['prof_segmento'] == 'FI' || $line['prof_segmento'] == 'FII') {
			switch ($line['prof_disciplina']) {
				case 1:
					echo 'Alfabetiza&ccedil;&atilde;o';
					break;
				case 2:
					echo 'Artes';
					break;
				case 3:
					echo 'Ci&ecirc;ncias';
					break;
				case 4:
					echo 'Educa&ccedil;&atilde;o F&iacute;sica';
					break;
				case 5:
					echo 'Geografia';
					break;
				case 6:
					echo 'Hist&oacute;ria';
					break;
				case 7:
					echo 'L&iacute;ngua Estrangeira';
					break;
				case 8:
					if ($line['prof_segmento'] == 'FI') {
						echo 'L&iacute;ngua Portuguesa Fund. I';
					}
					elseif ($line['prof_segmento'] == 'FII') {
						echo 'L&iacute;ngua Portuguesa Fund. II';
					}
					break;
				case 9:
					if ($line['prof_segmento'] == 'FI') {
						echo 'Matem&aacute;tica Fund. I';
					}
					elseif ($line['prof_segmento'] == 'FII') {
						echo 'Matem&aacute;tica Fund. II';
					}
					break;
			}
		}
		else {
			echo '---------';
		}
	}
	elseif ($line['categoria'] == 'G') {
		echo '---------';
	}
}

function print_segmento($line) {
	if ($line['categoria'] == 'P') {
		switch ($line['prof_segmento']) {
			case 'EIC':
				echo 'Educa&ccedil;&atilde;o Infantil: Creche';
				break;
			case 'EIP':
				echo 'Educa&ccedil;&atilde;o Infantil: Pre-Escola';
				break;				
			case 'FI':
				echo 'Ensino Fundamental I';
				break;
			case 'FII':
				echo 'Ensino Fundamental II';
				break;
			case 'EM':
				echo 'Ensino M&eacute;dio';
				break;
		}
	}
	elseif ($line['categoria'] == 'G') {
		$first = true;
		if ($line['seg_edu_inf'] == 1) {
			if ($first == false) { echo ', '; } else { $first = false; }
			echo 'Educa&ccedil;&atilde;o Infantil';
		}
		if ($line['seg_edu_fun_i'] == 1) {
			if ($first == false) { echo ', '; } else { $first = false; }
			echo 'Ensino Fundamental I';
		}
		if ($line['seg_edu_fun_ii'] == 1) {
			if ($first == false) { echo ', '; } else { $first = false; }
			echo 'Ensino Fundamental II';
		}
		if ($line['seg_edu_med'] == 1) {
			if ($first == false) { echo ', '; } else { $first = false; }
			echo 'Ensino M&eacute;dio';
		}
	}
}

function print_status($line) {
	switch ($line['inscricao_status']) {
		case 0:
			echo 'N&atilde;o impresso';
			break;
		case 1:
			echo 'Ficha-impressa';
			break;
		case 2:
			echo 'Trabalho-impresso';
			break;
		case 3:
			echo 'N&atilde;o selecionado';
			break;
		case 4:
			echo 'Desclassificado';
			break;
		case 5:
			echo 'Pr&eacute;-selecionado';
			break;
		case 6:
			echo 'Em avalia&ccedil;&atilde;o';
			break;
		case 7:
			echo 'Finalista';
			break;
		case 8:
			echo 'Vencedor';
			break;
		case 9:
			echo 'Desativado';
			break;
		case 10:
			echo 'Premiado';
			break;			
	}
}



function print_status_novo($id_status) {

	switch ($id_status) {
		case 0:
			echo 'N&atilde;o impresso';
			break;
		case 1:
			echo 'Ficha-impressa';
			break;
		case 2:
			echo 'Trabalho-impresso';
			break;
		case 3:
			echo 'N&atilde;o selecionado';
			break;
		case 4:
			echo 'Desclassificado';
			break;
		case 5:
			echo 'Pr&eacute;-selecionado';
			break;
		case 6:
			echo 'Em avalia&ccedil;&atilde;o';
			break;
		case 7:
			echo 'Finalista';
			break;
		case 8:
			echo 'Vencedor';
			break;
		case 9:
			echo 'Desativado';
			break;
		case 10:
			echo 'Premiado';
			break;			
	}
}




function print_data_impresso($line, $vw_status) {
	switch ($line['inscricao_status']) {
		case 1:
		case 2:
			echo pretty_print_data($vw_status['data_revisao']);
			break;
		default:
			echo 'N&atilde;o impresso';
			break;
	}
}

function print_ultima_atualizacao($line) {
	if ( isset($line['data_revisao']) ) {
		echo utf8_encode($line['nome_usuario']) . ' ';
		pretty_print_data_barra($line['data_revisao']);
	}
	else {
		echo 'nunca atualizado';
	}
}

function print_sexo($line) {
	switch ($line['sexo']) {
		case 'M':
			echo 'Masculino';
			break;
		case 'F':
			echo 'Feminino';
			break;
	}
}

function print_faixa_etaria($line) {
	switch ($line['faixa_etaria']) {
		case 1:
			echo 'At&eacute; 20 anos';
			break;
		case 2:
			echo 'de 21 a 30 anos';
			break;
		case 3:
			echo 'de 31 a 40 anos';
			break;
		case 4:
			echo 'de 41 a 50 anos';
			break;
		case 5:
			echo 'de 51 a 60 anos';
			break;
		case 6:
			echo 'Acima de 60 anos';
			break;
	}
}

function print_trabalho_faixa_etaria($line) {
	if ($line['categoria'] == 'P') {
		$faixa_etaria = utf8_encode($line['prof_faixa_etaria']);
	}
	elseif ($line['categoria'] == 'G') {
		$faixa_etaria = '---------';
	}
	echo $faixa_etaria;
	/*
	switch ($faixa_etaria) {
		case 1:
			echo 'At&eacute; 20 anos';
			break;
		case 2:
			echo 'de 21 a 30 anos';
			break;
		case 3:
			echo 'de 31 a 40 anos';
			break;
		case 4:
			echo 'de 41 a 50 anos';
			break;
		case 5:
			echo 'de 51 a 60 anos';
			break;
		case 6:
			echo 'Acima de 60 anos';
			break;
	}
	*/
}

function print_trabalho_faixa_etaria_no_utf($line) {
	if ($line['categoria'] == 'P') {
		$faixa_etaria = $line['prof_faixa_etaria'];
	}
	elseif ($line['categoria'] == 'G') {
		$faixa_etaria = '---------';
	}
	echo $faixa_etaria;
	/*
	switch ($faixa_etaria) {
		case 1:
			echo 'At&eacute; 20 anos';
			break;
		case 2:
			echo 'de 21 a 30 anos';
			break;
		case 3:
			echo 'de 31 a 40 anos';
			break;
		case 4:
			echo 'de 41 a 50 anos';
			break;
		case 5:
			echo 'de 51 a 60 anos';
			break;
		case 6:
			echo 'Acima de 60 anos';
			break;
	}
	*/
}

function print_trabalho_titulo($line) {
	if ($line['categoria'] == 'P') {
		echo utf8_encode($line['prof_titulo']);
	}
	elseif ($line['categoria'] == 'G') {
		echo utf8_encode($line['titulo']);
	}
}

function print_trabalho_titulo_no_utf($line) {
	if ($line['categoria'] == 'P') {
		echo $line['prof_titulo'];
	}
	elseif ($line['categoria'] == 'G') {
		echo $line['titulo'];
	}
}

function print_trabalho_ano_turma($line) {
	if ($line['categoria'] == 'P') {
		echo utf8_encode($line['prof_ano_turma']);
	}
	elseif ($line['categoria'] == 'G') {
		echo '---------';
	}
}

function print_trabalho_ano_turma_no_utf($line) {
	if ($line['categoria'] == 'P') {
		echo $line['prof_ano_turma'];
	}
	elseif ($line['categoria'] == 'G') {
		echo '---------';
	}
}

function print_trabalho_ano_trabalho($line) {
	if ($line['categoria'] == 'P') {
		echo $line['prof_ano_trabalho'];
	}
	elseif ($line['categoria'] == 'G') {
		echo $line['ano_trabalho'];
	}
}

function print_trabalho_numero_alunos($line) {
	if ($line['categoria'] == 'P') {
		echo $line['prof_numero_alunos'];
	}
	elseif ($line['categoria'] == 'G') {
		echo $line['numero_alunos'];
	}
}

function print_trabalho_duracao($line) {
	if ($line['categoria'] == 'P') {
		echo utf8_encode($line['prof_duracao']);
	}
	elseif ($line['categoria'] == 'G') {
		echo utf8_encode($line['duracao']);
	}
}

function print_trabalho_duracao_no_utf($line) {
	if ($line['categoria'] == 'P') {
		echo $line['prof_duracao'];
	}
	elseif ($line['categoria'] == 'G') {
		echo $line['duracao'];
	}
}

function print_trabalho_necessidades($line) {
	if ($line['categoria'] == 'P') {
		$nece = $line['prof_nece_especial'];
	}
	elseif ($line['categoria'] == 'G') {
		$nece = $line['nece_especial'];
	}
	
	switch ($nece) {
		case 0:
			echo 'N&atilde;o';
			break;
		case 1:
			echo 'Sim';
			break;
	}
}

function print_fonte($line) {
	switch ($line['fonte']) {
		case 1:
			echo 'Revista NOVA ESCOLA';
			break;
		case 2:
			echo 'Revista GEST&Atilde;O ESCOLAR';
			break;
		case 3:
			echo 'Outras revistas';
			break;
		case 4:
			echo 'Site NOVA ESCOLA';
			break;
		case 5:
			echo 'Outros sites';
			break;
		case 6:
			echo 'R&aacute;dio';
			break;
		case 7:
			echo 'E-mail marketing';
			break;
		case 8:
			echo 'Secretaria Municipal de Educa&ccedil;&atilde;o';
			break;
		case 9:
			echo 'Secretaria Estadual de Educa&ccedil;&atilde;o';
			break;
		case 10:
			echo 'Orkut';
			break;
		case 11:
			echo 'Facebook';
			break;
		case 12:
			echo 'Twitter';
			break;
		case 13: // Outros
			echo utf8_encode($line['fonte_outro']);
			break;
	}
}

function print_fonte_no_utf($line) {
	switch ($line['fonte']) {
		case 1:
			echo 'Revista NOVA ESCOLA';
			break;
		case 2:
			echo 'Revista GEST&Atilde;O ESCOLAR';
			break;
		case 3:
			echo 'Outras revistas';
			break;
		case 4:
			echo 'Site NOVA ESCOLA';
			break;
		case 5:
			echo 'Outros sites';
			break;
		case 6:
			echo 'R&aacute;dio';
			break;
		case 7:
			echo 'E-mail marketing';
			break;
		case 8:
			echo 'Secretaria Municipal de Educa&ccedil;&atilde;o';
			break;
		case 9:
			echo 'Secretaria Estadual de Educa&ccedil;&atilde;o';
			break;
		case 10:
			echo 'Orkut';
			break;
		case 11:
			echo 'Facebook';
			break;
		case 12:
			echo 'Twitter';
			break;
		case 13: // Outros
			echo $line['fonte_outro'];
			break;
	}
}

function print_escola_categoria($line) {
	switch ($line['esc_categoria']) {
		case 1:
			echo 'P&uacute;blica';
			break;
		case 2:
			echo 'Particular';
			break;
		case 3:
			echo 'Comunit&aacute;ria';
			break;
		case 4:
			echo 'Particular Filantr&oacute;pica';
			break;
	}
}

function print_escola_localizacao($line) {
	switch ($line['esc_localizacao']) {
		case 'U':
			echo 'Urbana';
			break;
		case 'R':
			echo 'Rural';
			break;
	}
}

function print_formacao($line) {
	switch ($line['formacao']) {
		case 'NM':
			echo 'Ensino M&eacute;dio';
			break;
		case 'SI':
			echo 'Superior Incompleto';
			break;
		case 'SC':
			echo 'Superior Completo';
			break;
		case 'PG':
			echo 'P&oacute;s-Gradua&ccedil;&atilde;o';
			break;
	}
}

function print_ideb_escola($line) {
	$ideb = (string) $line['ideb_escola'];
	$ideb = str_replace('.', ',', $ideb);
	
	if ($ideb == '0') {
		$ideb = '0,0';
	}
	
	echo $ideb;
}

function print_ideb_municipio($line) {
	$ideb = (string) $line['ideb_municipio'];
	$ideb = str_replace('.', ',', $ideb);
	
	if ($ideb == '0') {
		$ideb = '0,0';
	}
	
	echo $ideb;
}

?>