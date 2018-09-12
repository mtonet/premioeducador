function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function inscritoLogin(email, senha) {
	jQuery.ajax({
		url: 'ajax-inscricao.php?action=login&email=' + email.val() + '&senha=' + senha.val(),
		success: function(data) {
			var inscricao = jQuery.parseJSON(data);
			if (inscricao.status == 'ok') {
				email.css({'border-color': 'green'});
				email.css({'background-color': 'white'});
				email.css({'color': '#555'});
				
				senha.css({'border-color': 'green'});
				senha.css({'background-color': 'white'});
				senha.css({'color': '#555'});
				
				var ultimoPasso = parseInt(inscricao.ultimo_passo);
				if (ultimoPasso == 7) {
					alert('Seu cadastro já foi finalizado e não será mais possível fazer alterações.');
				}
				else if (ultimoPasso == 0) {
					location.href = Site.url + 'confirma.php';
				}
				else {
					location.href = Site.url + 'pass' + ultimoPasso + '.php';
				}
			}
			else {
				if (inscricao.email != 'ok') {
					email.css({'border-color': 'red'});
					email.css({'background-color': 'red'});
					email.css({'color': 'white'});
				}
				else {
					email.css({'border-color': 'green'});
					email.css({'background-color': 'white'});
					email.css({'color': '#555'});
				}
				if (inscricao.senha != 'ok') {
					senha.css({'border-color': 'red'});
					senha.css({'background-color': 'red'});
					senha.css({'color': 'white'});
				}
				else {
					senha.css({'border-color': 'green'});
					senha.css({'background-color': 'white'});
					senha.css({'color': '#555'});
				}
			}
		}
	});
}

function inscritoLogout() {
	jQuery.ajax({
		url: 'ajax-inscricao.php?action=logout',
		success: function(data) {
			inscricao = jQuery.parseJSON(data);
			if (inscricao.status == 'ok') {
				location.href = Site.url;
			}
		}
	});
}

function inscritoSignup(email, senha, confirmarSenha, cpf) {
	if ( email.val().length > 0 && validateEmail(email.val()) && senha.val().length > 0 && senha.val() == confirmarSenha.val() && cpf.val().length > 0 ) {
		senha.css({'border-color': 'green'});
		senha.css({'background-color': 'white'});
		senha.css({'color': '#555'});
		
		confirmarSenha.css({'border-color': 'green'});
		confirmarSenha.css({'background-color': 'white'});
		confirmarSenha.css({'color': '#555'});

		jQuery.ajax({
			url: 'ajax-inscricao.php?action=signup&email=' + email.val() + '&senha=' + senha.val() + '&cpf=' + cpf.val(),
			success: function(data) {
				var inscricao = jQuery.parseJSON(data);
				if (inscricao.status == 'ok') {
					email.css({'border-color': 'green'});
					email.css({'background-color': 'white'});
					email.css({'color': '#555'});
					
					senha.css({'border-color': 'green'});
					senha.css({'background-color': 'white'});
					senha.css({'color': '#555'});
					
					location.href = Site.url + 'confirma.php';
				}
				else {
					if (inscricao.cpf == 'invalid') {
						cpf.css({'border-color': 'red'});
						cpf.css({'background-color': 'red'});
						cpf.css({'color': 'white'});
						$('#box-invalid').css({'display': 'block'});
					}
					else {
						$('#box-invalid').css({'display': 'none'});
						if (inscricao.email != 'ok') {
							email.css({'border-color': 'red'});
							email.css({'background-color': 'red'});
							email.css({'color': 'white'});
							$('#box-existent').css({'display': 'block'});
						}
						else {
							email.css({'border-color': 'green'});
							email.css({'background-color': 'white'});
							email.css({'color': '#555'});
							$('#box-existent').css({'display': 'none'});
						}
					}
				}
			}
		});
	}
	else {
		if (senha.val().length < 1) {
			senha.css({'border-color': 'red'});
			senha.css({'background-color': 'red'});
			senha.css({'color': 'white'});
		}
		else {
			senha.css({'border-color': 'green'});
			senha.css({'background-color': 'white'});
			senha.css({'color': '#555'});
			
			confirmarSenha.css({'border-color': 'red'});
			confirmarSenha.css({'background-color': 'white'});
			confirmarSenha.css({'color': '#555'});
		}

		if ( email.val().length < 1 || !validateEmail(email.val()) ) {
			email.css({'border-color': 'red'});
			email.css({'background-color': 'red'});
			email.css({'color': 'white'});
		}
		
		if (cpf.val().length < 1) {
			cpf.css({'border-color': 'red'});
			cpf.css({'background-color': 'red'});
			cpf.css({'color': 'white'});
		}
	}
}

function inscritoForget(cpf) {
	if ( cpf.val().length > 0 ) {
		$('#next-pass').attr('disabled', 'disabled');
		jQuery.ajax({
			url: 'ajax-inscricao.php?action=forget&cpf=' + cpf.val(),
			success: function(data) {
				var inscricao = jQuery.parseJSON(data);
				if (inscricao.status == 'ok') {
					cpf.css({'border-color': 'green'});
					cpf.css({'background-color': 'white'});
					cpf.css({'color': '#555'});
					
					//location.href = Site.url + 'esqueci.php';
					alert("Você receberá sua nova senha no e-mail cadastrado.");
				}
				else {
					if (inscricao.cpf == 'invalid' || inscricao.cpf == 'inexistent') {
						cpf.css({'border-color': 'red'});
						cpf.css({'background-color': 'red'});
						cpf.css({'color': 'white'});
						$('#box-invalid').css({'display': 'block'});
					}
				}
				$('#next-pass').removeAttr('disabled');
			}
		});
	}
	else {
		if (cpf.val().length < 1) {
			cpf.css({'border-color': 'red'});
			cpf.css({'background-color': 'red'});
			cpf.css({'color': 'white'});
		}
	}
}

function getEndereco() {
	jQuery.ajax({
		url: 'ajax-cep.php?cep=' + $('#input-cep').val(),
		success: function(data) {
			buscaEnd = jQuery.parseJSON(data);
			if (buscaEnd.status == 'ok') {
				$('#input-cep').css({'border-color': 'green'});
				$('#input-cep').css({'background-color': 'white'});
				$('#input-cep').css({'color': '#555'});
				
				$('#input-endereco').val(buscaEnd.logradouro);
				$('#input-bairro').val(buscaEnd.bairro);
				$('#input-cidade').val(buscaEnd.cidade);
				$('#select-estado').val(buscaEnd.uf);
			}
			else {
				$('#input-cep').val('');
				
				$('#input-cep').css({'border-color': 'red'});
				$('#input-cep').css({'background-color': 'red'});
				$('#input-cep').css({'color': 'white'});
				
				$('#box-invalido').css({'display': 'inline'});
			}
			$('#box-carregando').css({'display': 'none'});
			$('#input-endereco').removeAttr('disabled');
			$('#input-bairro').removeAttr('disabled');
			$('#input-cidade').removeAttr('disabled');
			$('#select-estado').removeAttr('disabled');
		}
	});
}

$(document).ready( function() {

	jQuery('input').keydown( function(e) {	
		if (e.keyCode == 13) {
			e.preventDefault();
		}
	});

	//$('.gestor-group').hide();
	$('#login-signup').css({'display': 'block'});
	$('#pass4-form').css({'display': 'block'});
	
	$('#login-signup').submit( function(event) {
		event.preventDefault();
		
		var email = $('#input-email');
		var senha = $('#input-senha');
		var confirmarSenha = $('#input-confirmar-senha');
		var cpf = $('#input-cpf');
		
		if ( $('#radio-login:checked').length > 0 ) {
			inscritoLogin(email, senha);
		}
		else if ( $('#radio-signup:checked').length > 0 ) {
			inscritoSignup(email, senha, confirmarSenha, cpf);
		}
		else {
			inscritoForget(cpf);
		}
	});
	
	$('#radio-signup').click( function() {
		$('.control-group:not(.basic-options)').hide();
		$('.signup-group').show();
		$('#checkbox-regulamento').attr('checked', false);
		$('#next-pass').attr('disabled', 'disabled');
	});
	
	$('#radio-login').click( function() {
		$('.control-group:not(.basic-options)').hide();
		$('.login-group').show();
		$('#next-pass').removeAttr('disabled');
	});

	$('#radio-forget').click( function() {
		$('.control-group:not(.basic-options)').hide();
		$('.forget-group').show();
		$('#next-pass').removeAttr('disabled');
	});
	
	$('#checkbox-regulamento').click( function() {
		if ( $('#next-pass').attr('disabled') == 'disabled' ) {
			$('#next-pass').removeAttr('disabled');
		}
		else {
			$('#next-pass').attr('disabled', 'disabled');
		}
	});
	
	$('#sair-inscrito').click( function(event) {
		event.preventDefault();
		if (Site.ultimo_passo != 6) {
			inscritoLogout();
		}
		else {
			location.href = "pass6.php";
		}
	});
	
	$('#radio-categoria-p').click( function() {
		$('#necessidades-label').html('Na sua turma há alunos com necessidades educacionais especiais (Transtorno Global do Desenvolvimento, Deficiência ou Altas Habilidades)? (*)');
		$('.control-group').css({'display': 'block'});
		//$('.professor-group').show();
		$('.gestor-group').hide();
	});
	
	$('#radio-categoria-g').click( function() {
		$('#necessidades-label').html('Nas turmas envolvidas há alunos com necessidades educacionais especiais (Transtorno Global do Desenvolvimento, Deficiência ou Altas Habilidades)? (*)');
		$('.control-group').css({'display': 'block'});
		//$('.gestor-group').show();
		$('.professor-group').hide();
	});
	
	$('#pass6-button').click( function(event) {
		event.preventDefault();
		location.href = Site.url + 'pass6.php';
	});
	
	$('#input-cep').blur( function(event) {
		event.preventDefault();
		if ($('#input-cep').val() == '') {
			$('#input-cep').css({'border-color': 'red'});
			$('#input-cep').css({'background-color': 'red'});
			$('#input-cep').css({'color': 'white'});
		}
		else {
			$('#box-invalido').css({'display': 'none'});
			$('#box-carregando').css({'display': 'inline'});
			
			$('#input-endereco').attr('disabled', 'disabled');
			$('#input-bairro').attr('disabled', 'disabled');
			$('#input-cidade').attr('disabled', 'disabled');
			$('#select-estado').attr('disabled', 'disabled');
			
			getEndereco();
		}
	});
	
	if ( $('#login-signup').length > 0 ) {
		$('#input-cpf').mask('99999999999'); // $('#input-cpf').mask('999.999.999-99');
	}
	
	if ( $('#pass1-form').length > 0 ) {
		$('#input-cep').mask('99999999'); // $('#input-cep').mask('99999-999');
		$('#input-numero').mask('9?99999');
		//$('#input-complemento').mask('?***');
		$('#input-telefone').mask('(99) 9999-9999');
		//$('#input-rg').mask('999999999'); // $('#input-rg').mask('99.999.999-9');
		$('#input-orgao').mask('aaa?aa');
		$('#input-celular').mask('99-999999?9?99'); // $('#input-celular').mask('?(99) 9999-9999');
		
		$('#select-como').change( function() {
			if ( $(this).val() == '13' ) {
				$('#div-como-outro').css({'display': 'block'});
			}
			else {
				$('#div-como-outro').css({'display': 'none'});
			}
		});
	}
	
	if ( $('#pass2-form').length > 0 ) {
		$('#input-ideb-escola').mask('?9,9');
		$('#input-ideb-municipio').mask('?9,9');
		$('#input-cep').mask('99999999'); // $('#input-cep').mask('99999-999');
		$('#input-numero').mask('9?99999');
		//$('#input-complemento').mask('?***');
		$('#input-telefone').mask('99-99999?9?99'); // $('#input-telefone').mask('(99) 9999-9999');
		//$('#input-fax').mask('9999999999'); // $('#input-fax').mask('(99) 9999-9999');
	}
	
	if ( $('#pass3-form').length > 0 ) {
		$('#input-conclusao').mask('9999');
	}
	
	if ( $('#pass4-form').length > 0 ) {
		//$('#input-ano').mask('9999');
		$('#input-numero').mask('9?999');
		$('#input-ano-trabalho').mask('9999');
	}
	
	$('#pass1-form').submit( function(event) {
		event.preventDefault();
		var valid = true;
		
		var nome = $('#input-nome');
		var cep = $('#input-cep');
		var endereco = $('#input-endereco');
		var numero = $('#input-numero');
		var bairro = $('#input-bairro');
		var cidade = $('#input-cidade');
		var telefone = $('#input-telefone');
		var celular = $('#input-celular');
		var rg = $('#input-rg');
		var orgao = $('#input-orgao');

		if ( nome.val() == '') {
			nome.css({'border-color': 'red'});
			nome.css({'background-color': 'red'});
			nome.css({'color': 'white'});
			nome.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			nome.css({'border-color': 'green'});
			nome.css({'background-color': 'white'});
			nome.css({'color': '#555'});
			nome.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( cep.val() == '' ) {
			cep.css({'border-color': 'red'});
			cep.css({'background-color': 'red'});
			cep.css({'color': 'white'});
			cep.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			cep.css({'border-color': 'green'});
			cep.css({'background-color': 'white'});
			cep.css({'color': '#555'});
			cep.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( endereco.val() == '') {
			endereco.css({'border-color': 'red'});
			endereco.css({'background-color': 'red'});
			endereco.css({'color': 'white'});
			endereco.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			endereco.css({'border-color': 'green'});
			endereco.css({'background-color': 'white'});
			endereco.css({'color': '#555'});
			endereco.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( numero.val() == '') {
			numero.css({'border-color': 'red'});
			numero.css({'background-color': 'red'});
			numero.css({'color': 'white'});
			numero.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			numero.css({'border-color': 'green'});
			numero.css({'background-color': 'white'});
			numero.css({'color': '#555'});
			numero.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( bairro.val() == '') {
			bairro.css({'border-color': 'red'});
			bairro.css({'background-color': 'red'});
			bairro.css({'color': 'white'});
			bairro.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			bairro.css({'border-color': 'green'});
			bairro.css({'background-color': 'white'});
			bairro.css({'color': '#555'});
			bairro.parent().find('.box-obrigatorio').css({'display': 'none'});
		}

		if ( cidade.val() == '') {
			cidade.css({'border-color': 'red'});
			cidade.css({'background-color': 'red'});
			cidade.css({'color': 'white'});
			cidade.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			cidade.css({'border-color': 'green'});
			cidade.css({'background-color': 'white'});
			cidade.css({'color': '#555'});
			cidade.parent().find('.box-obrigatorio').css({'display': 'none'});
		}

		atual=0;
		anterior=0;
		validado=true;
		tTelefone = telefone.val().replace('-','');
		tTelefone = tTelefone.replace(' ','');
		tTelefone = tTelefone.replace('(','');
		tTelefone = tTelefone.replace(')','');
		tTelefone = tTelefone.replace('-','');

		for (var x=0; x < tTelefone.toString().length; x++) {

			if(x==0){
				anterior = tTelefone.toString().substring(x,x+1);
			}

			atual = tTelefone.toString().substring(x,x+1);

			if(anterior != atual){
				validado = true;
				break;
			}else
				{
					anterior = atual;
					validado=false;
				}
		};
		
		if ( telefone.val() == '' || validado==false) {
			telefone.css({'border-color': 'red'});
			telefone.css({'background-color': 'red'});
			telefone.css({'color': 'white'});
			telefone.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			telefone.css({'border-color': 'green'});
			telefone.css({'background-color': 'white'});
			telefone.css({'color': '#555'});
			telefone.parent().find('.box-obrigatorio').css({'display': 'none'});
		}

		atual=0;
		anterior=0;
		validado=true;
		tTelefone = celular.val().replace('-','');
		tTelefone = tTelefone.replace(' ','');
		tTelefone = tTelefone.replace('(','');
		tTelefone = tTelefone .replace(')','');
		tTelefone = tTelefone.replace('-','');

		for (var x=0; x < tTelefone.toString().length; x++) {

			if(x==0){
				anterior = tTelefone.toString().substring(x,x+1);
			}

			atual = tTelefone.toString().substring(x,x+1);

			if(anterior != atual){
				validado = true;
				break;
			}else
				{
					anterior = atual;
					validado=false;
				}
		};
			
		if (celular.val() == '' || validado==false) {
			celular.css({'border-color': 'red'});
			celular.css({'background-color': 'red'});
			celular.css({'color': 'white'});
			celular.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			celular.css({'border-color': 'green'});
			celular.css({'background-color': 'white'});
			celular.css({'color': '#555'});
			celular.parent().find('.box-obrigatorio').css({'display': 'none'});
		}

		atual=0;
		anterior=0;
		validado=true;
		trg = rg.val().replace('-','');
		trg = trg.replace('-','');

		for (var x=0; x < trg.toString().length; x++) {

			if(x==0){
				anterior = trg.toString().substring(x,x+1);
			}

			atual = trg.toString().substring(x,x+1);

			if(anterior != atual){
				validado = true;
				break;
			}else
				{
					anterior = atual;
					validado=false;
				}
		};
			
		if ( rg.val() == '' || validado==false) {
			rg.css({'border-color': 'red'});
			rg.css({'background-color': 'red'});
			rg.css({'color': 'white'});
			rg.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			rg.css({'border-color': 'green'});
			rg.css({'background-color': 'white'});
			rg.css({'color': '#555'});
			rg.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( orgao.val() == '') {
			orgao.css({'border-color': 'red'});
			orgao.css({'background-color': 'red'});
			orgao.css({'color': 'white'});
			orgao.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			orgao.css({'border-color': 'green'});
			orgao.css({'background-color': 'white'});
			orgao.css({'color': '#555'});
			orgao.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		var faixaEtaria = $('#select-idade');
		var estado = $('#select-estado');
		var comoConheceu = $('#select-como');
		
		if ( faixaEtaria.val() == '') {
			faixaEtaria.css({'border-color': 'red'});
			faixaEtaria.css({'background-color': 'red'});
			faixaEtaria.css({'color': 'white'});
			faixaEtaria.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			faixaEtaria.css({'border-color': 'green'});
			faixaEtaria.css({'background-color': 'white'});
			faixaEtaria.css({'color': '#555'});
			faixaEtaria.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( estado.val() == '') {
			estado.css({'border-color': 'red'});
			estado.css({'background-color': 'red'});
			estado.css({'color': 'white'});
			estado.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			estado.css({'border-color': 'green'});
			estado.css({'background-color': 'white'});
			estado.css({'color': '#555'});
			estado.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( comoConheceu.val() == '') {
			comoConheceu.css({'border-color': 'red'});
			comoConheceu.css({'background-color': 'red'});
			comoConheceu.css({'color': 'white'});
			comoConheceu.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			comoConheceu.css({'border-color': 'green'});
			comoConheceu.css({'background-color': 'white'});
			comoConheceu.css({'color': '#555'});
			comoConheceu.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( $('#input-sexo-m:checked').length == 0 && $('#input-sexo-f:checked').length == 0 ) {
			$('#sexo-area').css({'border': 'solid thin red'});
			$('#input-sexo-m').parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			$('#sexo-area').css({'border-color': 'green'});
			$('#input-sexo-m').parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if (valid) {
			this.submit();
		}
	});
	
	$('#pass2-form').submit( function(event) {
		event.preventDefault();
		var valid = true;
		
		var nome = $('#input-nome');
		var cep = $('#input-cep');
		var endereco = $('#input-endereco');
		var numero = $('#input-numero');
		var bairro = $('#input-bairro');
		var cidade = $('#input-cidade');
		var telefone = $('#input-telefone');
		var email = $('#input-email');
		var cargo = $('#input-cargo');
		
		if ( nome.val() == '') {
			nome.css({'border-color': 'red'});
			nome.css({'background-color': 'red'});
			nome.css({'color': 'white'});
			nome.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			nome.css({'border-color': 'green'});
			nome.css({'background-color': 'white'});
			nome.css({'color': '#555'});
			nome.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( cep.val() == '') {
			cep.css({'border-color': 'red'});
			cep.css({'background-color': 'red'});
			cep.css({'color': 'white'});
			cep.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			cep.css({'border-color': 'green'});
			cep.css({'background-color': 'white'});
			cep.css({'color': '#555'});
			cep.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( endereco.val() == '') {
			endereco.css({'border-color': 'red'});
			endereco.css({'background-color': 'red'});
			endereco.css({'color': 'white'});
			endereco.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			endereco.css({'border-color': 'green'});
			endereco.css({'background-color': 'white'});
			endereco.css({'color': '#555'});
			endereco.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( numero.val() == '') {
			numero.css({'border-color': 'red'});
			numero.css({'background-color': 'red'});
			numero.css({'color': 'white'});
			numero.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			numero.css({'border-color': 'green'});
			numero.css({'background-color': 'white'});
			numero.css({'color': '#555'});
			numero.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( bairro.val() == '') {
			bairro.css({'border-color': 'red'});
			bairro.css({'background-color': 'red'});
			bairro.css({'color': 'white'});
			bairro.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			bairro.css({'border-color': 'green'});
			bairro.css({'background-color': 'white'});
			bairro.css({'color': '#555'});
			bairro.parent().find('.box-obrigatorio').css({'display': 'none'});
		}

		if ( cidade.val() == '') {
			cidade.css({'border-color': 'red'});
			cidade.css({'background-color': 'red'});
			cidade.css({'color': 'white'});
			cidade.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			cidade.css({'border-color': 'green'});
			cidade.css({'background-color': 'white'});
			cidade.css({'color': '#555'});
			cidade.parent().find('.box-obrigatorio').css({'display': 'none'});
		}

		atual=0;
		anterior=0;
		validado=true;
		tTelefone = telefone.val().replace('-','');
		tTelefone = tTelefone.replace(' ','');
		tTelefone = tTelefone.replace('(','');
		tTelefone = tTelefone.replace(')','');
		tTelefone = tTelefone.replace('-','');

		for (var x=0; x < tTelefone.toString().length; x++) {

			if(x==0){
				anterior = tTelefone.toString().substring(x,x+1);
			}

			atual = tTelefone.toString().substring(x,x+1);

			if(anterior != atual){
				validado = true;
				break;
			}else
				{
					anterior = atual;
					validado=false;
				}
		};
		
		if ( telefone.val() == '' || validado==false) {
			telefone.css({'border-color': 'red'});
			telefone.css({'background-color': 'red'});
			telefone.css({'color': 'white'});
			telefone.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			telefone.css({'border-color': 'green'});
			telefone.css({'background-color': 'white'});
			telefone.css({'color': '#555'});
			telefone.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( email.val() == '' || !validateEmail(email.val()) ) {
			email.css({'border-color': 'red'});
			email.css({'background-color': 'red'});
			email.css({'color': 'white'});
			email.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			email.css({'border-color': 'green'});
			email.css({'background-color': 'white'});
			email.css({'color': '#555'});
			email.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( cargo.val() == '') {
			cargo.css({'border-color': 'red'});
			cargo.css({'background-color': 'red'});
			cargo.css({'color': 'white'});
			cargo.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			cargo.css({'border-color': 'green'});
			cargo.css({'background-color': 'white'});
			cargo.css({'color': '#555'});
			cargo.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		var categoria = $('#select-categoria');
		var localizacao = $('#select-localizacao');
		var estado = $('#select-estado');
		
		if ( categoria.val() == '') {
			categoria.css({'border-color': 'red'});
			categoria.css({'background-color': 'red'});
			categoria.css({'color': 'white'});
			categoria.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			categoria.css({'border-color': 'green'});
			categoria.css({'background-color': 'white'});
			categoria.css({'color': '#555'});
			categoria.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( localizacao.val() == '') {
			localizacao.css({'border-color': 'red'});
			localizacao.css({'background-color': 'red'});
			localizacao.css({'color': 'white'});
			localizacao.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			localizacao.css({'border-color': 'green'});
			localizacao.css({'background-color': 'white'});
			localizacao.css({'color': '#555'});
			localizacao.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( estado.val() == '') {
			estado.css({'border-color': 'red'});
			estado.css({'background-color': 'red'});
			estado.css({'color': 'white'});
			estado.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			estado.css({'border-color': 'green'});
			estado.css({'background-color': 'white'});
			estado.css({'color': '#555'});
			estado.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if (valid) {
			this.submit();
		}
	});
	
	$('#pass3-form').submit( function(event) {
		event.preventDefault();
		var valid = true;

		var formacao = $('#select-formacao');
		var anoConclusao = $('#input-conclusao');
		
		if ( formacao.val() == '') {
			formacao.css({'border-color': 'red'});
			formacao.css({'background-color': 'red'});
			formacao.css({'color': 'white'});
			formacao.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			formacao.css({'border-color': 'green'});
			formacao.css({'background-color': 'white'});
			formacao.css({'color': '#555'});
			formacao.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if (anoConclusao.val().length > 0 && parseInt(anoConclusao.val()) > 2013) {
			anoConclusao.css({'border-color': 'red'});
			anoConclusao.css({'background-color': 'red'});
			anoConclusao.css({'color': 'white'});
			anoConclusao.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			anoConclusao.css({'border-color': 'green'});
			anoConclusao.css({'background-color': 'white'});
			anoConclusao.css({'color': '#555'});
			anoConclusao.parent().find('.box-obrigatorio').css({'display': 'none'});
		}

		if (valid) {
			this.submit();
		}
	});
	
	$('#pass4-form').submit( function(event) {
		event.preventDefault();
		var valid = true;
		
		if ( $('#radio-categoria-p:checked').length > 0 ) {
			if ( $('#input-segmento-professor-ei:checked').length > 0 || $('#input-segmento-professor-fi:checked').length > 0 ||
				 $('#input-segmento-professor-fii:checked').length > 0 || $('#input-segmento-professor-em:checked').length > 0 ) {
				 
				$('#segmento-professor-area').css({'border': 'thin solid green'});
				$('#input-segmento-professor-fii').parent().find('.box-obrigatorio').css({'display': 'none'});
			}
			else {
				$('#segmento-professor-area').css({'border': 'thin solid red'});
				$('#input-segmento-professor-fii').parent().find('.box-obrigatorio').css({'display': 'inline'});
				valid = false;
			}
			
			if ( $('#input-segmento-professor-fi:checked').length > 0 || $('#input-segmento-professor-fii:checked').length > 0 ) {
				
				var disciplina = $('#select-disciplina');
				if ( disciplina.val() == '') {
					disciplina.css({'border-color': 'red'});
					disciplina.css({'background-color': 'red'});
					disciplina.css({'color': 'white'});
					disciplina.parent().find('.box-obrigatorio').css({'display': 'inline'});
					valid = false;
				}
				else {
					disciplina.css({'border-color': 'green'});
					disciplina.css({'background-color': 'white'});
					disciplina.css({'color': '#555'});
					disciplina.parent().find('.box-obrigatorio').css({'display': 'none'});
				}
			}
			
			var ano = $('#input-ano');
			var idade = $('#input-idade');

			if ( ano.val() == '') {
				ano.css({'border-color': 'red'});
				ano.css({'background-color': 'red'});
				ano.css({'color': 'white'});
				ano.parent().find('.box-obrigatorio').css({'display': 'inline'});
				valid = false;
			}
			else {
				ano.css({'border-color': 'green'});
				ano.css({'background-color': 'white'});
				ano.css({'color': '#555'});
				ano.parent().find('.box-obrigatorio').css({'display': 'none'});
			}

			if ( idade.val() == '') {
				idade.css({'border-color': 'red'});
				idade.css({'background-color': 'red'});
				idade.css({'color': 'white'});
				idade.parent().find('.box-obrigatorio').css({'display': 'inline'});
				valid = false;
			}
			else {
				idade.css({'border-color': 'green'});
				idade.css({'background-color': 'white'});
				idade.css({'color': '#555'});
				idade.parent().find('.box-obrigatorio').css({'display': 'none'});
			}
		}
		else {
			if ( $('#input-segmento-gestor-ei:checked').length > 0 || $('#input-segmento-gestor-fi:checked').length > 0 ||
				 $('#input-segmento-gestor-fii:checked').length > 0 || $('#input-segmento-gestor-em:checked').length > 0 ) {
				$('#segmento-gestor-area').css({'border': 'thin solid green'});
				$('#input-segmento-gestor-fii').parent().find('.box-obrigatorio').css({'display': 'none'});
			}
			else {
				$('#segmento-gestor-area').css({'border': 'thin solid red'});
				$('#input-segmento-gestor-fii').parent().find('.box-obrigatorio').css({'display': 'inline'});
				valid = false;
			}
			
			if ( $('#input-atuacao-d:checked').length > 0 || $('#input-atuacao-c:checked').length > 0 || $('#input-atuacao-o:checked').length > 0 ) {
				$('#atuacao-area').css({'border': 'thin solid green'});
				$('#input-atuacao-d').parent().find('.box-obrigatorio').css({'display': 'none'});
			}
			else {
				$('#atuacao-area').css({'border': 'thin solid red'});
				$('#input-atuacao-d').parent().find('.box-obrigatorio').css({'display': 'inline'});
				valid = false;
			}
		}
		
		var titulo = $('#input-titulo');
		var numero = $('#input-numero');
		var duracao = $('#input-duracao');
		var anoTrabalho = $('#input-ano-trabalho');
		
		if ( titulo.val() == '') {
			titulo.css({'border-color': 'red'});
			titulo.css({'background-color': 'red'});
			titulo.css({'color': 'white'});
			titulo.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			titulo.css({'border-color': 'green'});
			titulo.css({'background-color': 'white'});
			titulo.css({'color': '#555'});
			titulo.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( numero.val() == '') {
			numero.css({'border-color': 'red'});
			numero.css({'background-color': 'red'});
			numero.css({'color': 'white'});
			numero.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			numero.css({'border-color': 'green'});
			numero.css({'background-color': 'white'});
			numero.css({'color': '#555'});
			numero.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		if ( duracao.val() == '') {
			duracao.css({'border-color': 'red'});
			duracao.css({'background-color': 'red'});
			duracao.css({'color': 'white'});
			duracao.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			duracao.css({'border-color': 'green'});
			duracao.css({'background-color': 'white'});
			duracao.css({'color': '#555'});
			duracao.parent().find('.box-obrigatorio').css({'display': 'none'});
		}

		if ( anoTrabalho.val() == '' ) {
			anoTrabalho.css({'border-color': 'red'});
			anoTrabalho.css({'background-color': 'red'});
			anoTrabalho.css({'color': 'white'});
			anoTrabalho.parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		else {
			anoTrabalho.css({'border-color': 'green'});
			anoTrabalho.css({'background-color': 'white'});
			anoTrabalho.css({'color': '#555'});
			anoTrabalho.parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		
		//if ( anoTrabalho.val() != '' && parseInt(anoTrabalho.val()) < 2012 || parseInt(anoTrabalho.val()) > 2012) {
			console.log(anoTrabalho);
		if ( anoTrabalho.val() != '' && (parseInt(anoTrabalho.val()) < 2012 || parseInt(anoTrabalho.val()) > 2014)) {
			anoTrabalho.css({'border-color': 'red'});
			anoTrabalho.css({'background-color': 'red'});
			anoTrabalho.css({'color': 'white'});
			anoTrabalho.parent().find('.subtexto').css({'color': 'red'});
			valid = false;
		}
		else {
			anoTrabalho.css({'border-color': 'green'});
			anoTrabalho.css({'background-color': 'white'});
			anoTrabalho.css({'color': '#555'});
			anoTrabalho.parent().find('.subtexto').css({'color': '#555'});
		}
		
		if ( $('#input-necessidades-s:checked').length > 0 || $('#input-necessidades-n:checked').length > 0 ) {
			$('#necessidades-area').css({'border': 'thin solid green'});
			$('#input-necessidades-s').parent().find('.box-obrigatorio').css({'display': 'none'});
		}
		else {
			$('#necessidades-area').css({'border': 'thin solid red'});
			$('#input-necessidades-s').parent().find('.box-obrigatorio').css({'display': 'inline'});
			valid = false;
		}
		
		if (valid) {
			this.submit();
		}
	});
	
	$('#pass5-form').submit( function(event) {
		event.preventDefault();
		var valid = true;

		var input = $('#input01');
		var fileName = input.val().split("\\");
		fileName = fileName[fileName.length - 1];
		
		if ( fileName == '' || fileName.length > 100 ) {
			alert("Erro: nome do arquivo muito grande.");
			input.css({'border-color': 'red'});
			input.css({'background-color': 'red'});
			input.css({'color': 'white'});
			valid = false;
		}
		else {
			input.css({'border-color': 'green'});
			input.css({'background-color': 'white'});
			input.css({'color': '#555'});
		}

		if (valid) {
			this.submit();
		}
	});
	
	$('#input-segmento-professor-ei').click( function() {
		$('#select-disciplina').attr('disabled', 'disabled');
	});
	
	$('#input-segmento-professor-fi').click( function() {
													  
		jQuery('#alfabetizaca').show();
		$('#portugues').html('Língua Portuguesa');
		$('#matematica').html('Matemática');
		$('#select-disciplina').removeAttr('disabled');
	});
	
	$('#input-segmento-professor-fii').click( function() {
													   
		jQuery('#alfabetizaca').hide();
		jQuery('#alfabetizaca').remove();
		$('#portugues').html('Língua Portuguesa');
		$('#matematica').html('Matemática');
		$('#select-disciplina').removeAttr('disabled');
	});
});