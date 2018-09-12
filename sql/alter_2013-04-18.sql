ALTER TABLE trabalho ADD status INTEGER DEFAULT NULL;


CREATE OR REPLACE VIEW vw_inscrito AS
	SELECT  (SELECT s.status FROM inscricao_status s WHERE s.inscrito_id=ins.id ORDER BY s.id DESC LIMIT 1) AS inscricao_status,
			ins.id, ins.status_ativo, ins.ultimo_passo, ins.data_inscricao, ins.inscricao, ins.email, ins.cpf, ins.senha, ins.status, ins.categoria,
			cad.inscrito_id, cad.data_envio, cad.nome, cad.sexo, cad.faixa_etaria, cad.cep, cad.endereco, cad.numero, cad.complemento, cad.bairro, cad.cidade, cad.estado, cad.telefone, cad.celular, cad.rg, cad.orgao_emissor, cad.fonte, cad.fonte_outro,
			aca.formacao, aca.instituto, aca.curso, aca.cidade AS aca_cidade, aca.estado AS aca_estado, aca.conclusao,
			esc.nome AS esc_nome, esc.ideb_escola AS esc_ideb_escola, esc.ideb_municipio AS esc_ideb_municipio, esc.categoria AS esc_categoria, esc.localizacao AS esc_localizacao, esc.cep AS esc_cep, esc.endereco AS esc_endereco, esc.numero AS esc_numero, esc.complemento AS esc_complemento, esc.bairro AS esc_bairro, esc.cidade AS esc_cidade, esc.estado AS esc_estado, esc.email AS esc_email, esc.telefone AS esc_telefone, esc.fax AS esc_fax, esc.cargo AS esc_cargo,
			nome_arquivo, tipo, tamanho, trab.status as trabalho_status,
			ges.seg_edu_inf, ges.seg_edu_fun_i, ges.seg_edu_fun_ii, ges.seg_edu_med, ges.atuacao, ges.titulo, ges.numero_alunos, ges.duracao, ges.ano_trabalho, ges.nece_especial ,
			prof.segmento AS prof_segmento, prof.disciplina AS prof_disciplina, prof.titulo AS prof_titulo, prof.ano_turma_char AS prof_ano_turma, prof.faixa_etaria_char AS prof_faixa_etaria, prof.numero_alunos AS prof_numero_alunos, prof.duracao AS prof_duracao , prof.ano_trabalho AS prof_ano_trabalho, prof.nece_especial AS prof_nece_especial
		FROM inscrito ins
		INNER JOIN dados_cadastrais cad ON cad.inscrito_id = ins.id
		INNER JOIN dados_academicos aca ON aca.inscrito_id = ins.id
		INNER JOIN escola esc ON esc.inscrito_id = ins.id
		INNER JOIN trabalho trab ON trab.inscrito_id = ins.id
		LEFT JOIN dados_gestor ges ON ges.inscrito_id = ins.id
		LEFT JOIN dados_professor prof ON prof.inscrito_id = ins.id;


CREATE OR REPLACE VIEW vw_inscrito_nao_finalizado AS
	SELECT  (SELECT s.status FROM inscricao_status s WHERE s.inscrito_id=ins.id ORDER BY s.id DESC LIMIT 1) AS inscricao_status,
			ins.id, ins.status_ativo, ins.ultimo_passo, ins.data_inscricao, ins.inscricao, ins.email, ins.cpf, ins.senha, ins.status, ins.categoria,
			cad.inscrito_id, cad.data_envio, cad.nome, cad.sexo, cad.faixa_etaria, cad.cep, cad.endereco, cad.numero, cad.complemento, cad.bairro, cad.cidade, cad.estado, cad.telefone, cad.celular, cad.rg, cad.orgao_emissor, cad.fonte, cad.fonte_outro,
			aca.formacao, aca.instituto, aca.curso, aca.cidade AS aca_cidade, aca.estado AS aca_estado, aca.conclusao,
			esc.nome AS esc_nome, esc.ideb_escola AS esc_ideb_escola, esc.ideb_municipio AS esc_ideb_municipio, esc.categoria AS esc_categoria, esc.localizacao AS esc_localizacao, esc.cep AS esc_cep, esc.endereco AS esc_endereco, esc.numero AS esc_numero, esc.complemento AS esc_complemento, esc.bairro AS esc_bairro, esc.cidade AS esc_cidade, esc.estado AS esc_estado, esc.email AS esc_email, esc.telefone AS esc_telefone, esc.fax AS esc_fax, esc.cargo AS esc_cargo,
			nome_arquivo, tipo, tamanho, trab.status as trabalho_status,
			ges.seg_edu_inf, ges.seg_edu_fun_i, ges.seg_edu_fun_ii, ges.seg_edu_med, ges.atuacao, ges.titulo, ges.numero_alunos, ges.duracao, ges.ano_trabalho, ges.nece_especial ,
			prof.segmento AS prof_segmento, prof.disciplina AS prof_disciplina, prof.titulo AS prof_titulo, prof.ano_turma_char AS prof_ano_turma, prof.faixa_etaria_char AS prof_faixa_etaria, prof.numero_alunos AS prof_numero_alunos, prof.duracao AS prof_duracao , prof.ano_trabalho AS prof_ano_trabalho, prof.nece_especial AS prof_nece_especial
		FROM inscrito ins
		LEFT JOIN dados_cadastrais cad ON cad.inscrito_id = ins.id
		LEFT JOIN dados_academicos aca ON aca.inscrito_id = ins.id
		LEFT JOIN escola esc ON esc.inscrito_id = ins.id
		LEFT JOIN trabalho trab ON trab.inscrito_id = ins.id
		LEFT JOIN dados_gestor ges ON ges.inscrito_id = ins.id
		LEFT JOIN dados_professor prof ON prof.inscrito_id = ins.id;