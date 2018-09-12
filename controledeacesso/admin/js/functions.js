function usuarioLogin(email, senha) {

	jQuery.ajax({
		url: 'ajax-usuario.php?action=login&email=' + email.val() + '&senha=' + senha.val(),
		success: function(data) {
			var usuario = jQuery.parseJSON(data);
			if (usuario.status == 'ok') {
				email.css({'border-color': 'green'});
				email.css({'background-color': 'white'});
				email.css({'color': '#555'});
				
				senha.css({'border-color': 'green'});
				senha.css({'background-color': 'white'});
				senha.css({'color': '#555'});
				
				location.href = Site.url + 'controledeacesso/admin/dados-cadastrais.php';
			}
			else {
				if (usuario.email != 'ok') {
					email.css({'border-color': 'red'});
					email.css({'background-color': 'red'});
					email.css({'color': 'white'});
				}
				else {
					email.css({'border-color': 'green'});
					email.css({'background-color': 'white'});
					email.css({'color': '#555'});
				}
				if (usuario.senha != 'ok') {
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

function usuarioLogout() {
	jQuery.ajax({
		url: Site.url+'/controledeacesso/admin/ajax-usuario.php?action=logout',
		success: function(data) {
			usuario = jQuery.parseJSON(data);
			if (usuario.status == 'ok') {
				location.href = Site.url;
			}
		}
	});
}

$(document).ready( function() {
	$('#login').submit( function(event) {
		event.preventDefault();
		
		var email = $('#input-email');
		var senha = $('#input-senha');
		
		usuarioLogin(email, senha);
	});
	
	$('#sair-usuario').click( function() {
		usuarioLogout();
	});
	
	$('#signup').click( function() {
		location.href = Site.url + 'controledeacesso/admin/cadastro-usuarios.php';
	});

	$('#lista-usuarios').click( function(e) {
		e.preventDefault();
		location.href = Site.url + 'controledeacesso/admin/lista-usuarios.php?paginaAtual=';
	});
	
	$('#lista-inscritos').click( function(e) {
		e.preventDefault();
		location.href = Site.url + 'controledeacesso/admin/lista-inscritos.php?paginaAtual=';
	});
	
	$('#lista-relatorios').click( function(e) {
		e.preventDefault();		
		location.href = Site.url + 'controledeacesso/admin/relatorios.php';
	});

	$('#lista-controle').click( function(e) {
		e.preventDefault();
		location.href = Site.url + 'controledeacesso/admin/dados-cadastrais.php';
	});
	
	$('#gerar-excel').click( function(event) {
		event.preventDefault();
		$('#type').val('');
		$('#planilha').submit();
	});
	
	$('#gerar-excel-xlsx').click( function(event) {
		event.preventDefault();
		$('#type').val('1');
		$('#planilha').submit();
	});
	
	$('#select-como').change( function() {
		if ( $(this).val() == '13' ) {
			$('#tr-como-outro').css({'display': 'table-row'});
		}
		else {
			$('#tr-como-outro').css({'display': 'none'});
		}
	});
	
	$('#segmento').change( function() {
		if ( $(this).val() == 'EI' || $(this).val() == 'EM' ) {
			$('#disciplina').attr('disabled', 'disabled');
			$('#disciplina').val('0');
		}
		else {
			$('#disciplina').removeAttr('disabled');
		}
		
		if ( $(this).val() == 'EM' ) {
			$('#categoria').attr('disabled', 'disabled');
			$('#categoria').val('G');
		}
		else {
			$('#categoria').removeAttr('disabled');
		}
		
		if ( $(this).val() == 'FI' ) {
			$('#portugues').html('Língua Portuguesa Fund. I');
			$('#matematica').html('Matemática Fund. I');
		}
		else if ( $(this).val() == 'FII' ) {
			$('#portugues').html('Língua Portuguesa Fund. II');
			$('#matematica').html('Matemática Fund. II');
		}
		else if ( $(this).val() == '0' ) {
			$('#portugues').html('Língua Portuguesa Fund.');
			$('#matematica').html('Matemática Fund.');
		}
	});
	
	$('#atuacao').change( function() {
		if ( $(this).val() != '0' ) {
			$('#categoria').attr('disabled', 'disabled');
			$('#categoria').val('G');
		}
		else {
			$('#categoria').removeAttr('disabled');
		}
	});
	
	$('#categoria').change( function() {
		if ( $(this).val() == 'P' ) {
			$('#atuacao').attr('disabled', 'disabled');
			$('#atuacao').val('0');
		}
		else {
			$('#atuacao').removeAttr('disabled');
		}
	});

    $('#origem').change(function(){
        var origem = $('#origem').find('option').filter(':selected').text();
        var vip = $('#vip').find('option').filter(':selected').text();
        if(vip == 'Sim'){vip = 'V';}else{vip = 'N';}

        $.get("functions.php", { cdg: "gr", origem: origem, vip: vip }, function(data){
            $('#codigo').val(data);
            $('#codigo').attr('readonly','true');
        });
    })

    $('#vip').change(function(){
        var origem = $('#origem').find('option').filter(':selected').text();
        var vip = $('#vip').find('option').filter(':selected').text();
        if(vip == 'Sim'){vip = 'V';}else{vip = 'N';}

        $.get("functions.php", { cdg: "gr", origem: origem, vip: vip }, function(data){
            $('#codigo').val(data);
            $('#codigo').attr('readonly','true');
        });
    })
});