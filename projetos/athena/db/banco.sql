/*
	Script de Criaçao do Banco de Dados Athenas

           Revisado em : 07/02/2008 por Jaydson Gomes
	Ultima Atualizaçao em : 13/02/2008 ás 21:00 por Jaydson Gomes
*/


-- Tabelas do Sistema
create sequence agencia_seq;
create table tb_agencia (
	pk_agencia int8 default nextval('agencia_seq') not null primary key,
	s_nome varchar(80) not null,
	dt_update date default now(),
	md5_registro varchar(4800)
);

create sequence grupo_seq;
create table tb_grupo (
	pk_grupo int8 default nextval('grupo_seq') not null primary key,
	fk_agencia int8 not null,
	dt_update date default now(),
	s_label varchar(20) unique,
	s_obs text,
	foreign key (fk_agencia) references tb_agencia
);

create sequence tipo_contrato_func_seq;
create table tb_tipo_contrato_func (
	pk_tipo_contrato int8 default nextval('tipo_contrato_func_seq') not null primary key,
	s_label varchar(90)
);

create sequence tipo_telefone_seq;
create table tb_tipo_telefone (
	s_tipo_telefone varchar(255) not null unique primary key
);

create sequence estado_civil_seq;
create table tb_estado_civil
(
	pk_estado_civil int8 not null default nextval('estado_civil_seq') primary key,
	s_estado_civil varchar(32),
	bl_status char(1) default '1'
);

create sequence cep_seq;
create table tb_cep
(
	pk_cep int8 default nextval('cep_seq') primary key,
	s_logradouro varchar (255),
	s_bairro varchar (255),
	s_cidade varchar (255),
	s_estado_sigla char (2),
	c_tipo_endereco char(1),
	s_estado_nome varchar (255),
	s_pais varchar (255),
	s_cep char(9),
	s_complemento char(255),
	bl_caixa_postal char(1)
);

create sequence dados_pessoais_seq;
create table tb_dados_pessoais
(
	pk_dados_pessoais int8 default nextval('dados_pessoais_seq') primary key,
	s_usuario varchar(80),
	bl_status int2 default 1,
	dt_update date default now(),
	c_sexo char(2),
	web_site varchar (200),
	vfk_usuario int8,
	txt_obs text
); 

create sequence cep_dados_pessoais_seq;
create table tb_cep_dados_pessoais
(
	pk_cep_dados_pessoais int8 default nextval('cep_dados_pessoais_seq') primary key,
	fk_dados_pessoais int8,
	fk_cep int8,
	s_num char(8),
	foreign key (fk_dados_pessoais) references tb_dados_pessoais,
	foreign key (fk_cep) references tb_cep
);

create sequence usuario_seq;
create table tb_usuario
(
	pk_usuario int8 not null default nextval('usuario_seq'),
	dt_update date default now(),
	s_login varchar(20),
	s_senha varchar(40),
	bl_senha char(1),
	bl_cliente int2 default 0,
	bl_tipo_pessoa char(1),
	CONSTRAINT tb_usuario_pkey primary key (pk_usuario)
);

create sequence agencia_usuario_seq;
create table tb_agencia_usuario
(
	pk_agencia_usuario int8 not null default nextval('agencia_usuario_seq') primary key,
	fk_agencia int8,
	fk_usuario int8, -- dados pessoais, ligado indiretamente aos dados pessoais do cliente juridico cadastrado
	foreign key (fk_agencia) references tb_agencia,
	foreign key (fk_usuario) references tb_usuario
);

create sequence usuario_grupo_seq;
create table tb_usuario_grupo (
	pk_usuario_grupo int8 default nextval('usuario_grupo_seq') not null primary key,
	fk_usuario int8 not null,
	fk_grupo int8 not null,
	foreign key (fk_usuario) references tb_usuario,
	foreign key (fk_grupo) references tb_grupo
);

create sequence tipo_permissao_seq;
create table tb_tipo_permissao(
	pk_tipo_permissao int8 default nextval('tipo_permissao_seq') not null primary key,
	s_titulo varchar(160)
);	

create sequence permissao_seq;
create table tb_permissao(
	pk_permissao int8 default nextval('permissao_seq') not null primary key,
	fk_tipo_permissao int8 not null,
	s_titulo varchar(160),
	foreign key (fk_tipo_permissao) references tb_tipo_permissao
);

create sequence grupo_permissao_seq;
create table tb_grupo_permissao(
	pk_grupo_permissao int8 default nextval('grupo_permissao_seq') not null primary key,
	fk_permissao int8 not null,
	fk_grupo int8 not null,
	foreign key (fk_permissao) references tb_permissao,
	foreign key (fk_grupo) references tb_grupo
);

create sequence email_seq;
create table tb_email 
(
	pk_email int8 default nextval('email_seq') not null primary key,
	s_email varchar(255),
	fk_dados_pessoais int8,
	foreign key (fk_dados_pessoais) references tb_dados_pessoais
);

create sequence telefone_seq;
create table tb_telefone
(
	pk_telefone int8 default nextval('telefone_seq') not null primary key,
	s_ddd char(3),
	s_numero varchar(255),
	fk_tipo_telefone varchar(255),
	foreign key(fk_tipo_telefone) references tb_tipo_telefone
);

create sequence telefone_usuario_seq;
create table tb_telefone_usuario
(
  pk_telefone_usuario int8 default nextval('telefone_usuario_seq') primary key,
  fk_dados_pessoais int8,
  fk_telefone int8,
  foreign key (fk_dados_pessoais) references tb_dados_pessoais,
  foreign key (fk_telefone) references tb_telefone
);


create sequence load_seq;
create table tb_load (
	pk_load int8 default nextval('load_seq') not null primary key,
	fk_usuario int8 not null,
	s_table_id varchar(69),
	s_title varchar(400),
	s_url varchar(2048),
	s_conf varchar(1024),
	s_pos varchar(15),
	s_tam varchar(15),
	i_zindex int,
	s_padrao char(3),
	foreign key (fk_usuario) references tb_usuario
);

create sequence atalho_seq;
create table tb_atalho (
	pk_atalho int8 default nextval('atalho_seq') not null primary key,
	fk_usuario int8 not null,
	s_titulo varchar(90),
	s_img_src varchar(1024),
	s_table_id varchar(69),
	s_title varchar(400),
	s_url varchar(2048),
	s_conf varchar(1024),
	s_tam varchar(15),
	i_left int4,
	i_top int4,
	foreign key (fk_usuario) references tb_usuario
);

create sequence agenda_grupo_seq;
create table tb_agenda_grupo
(
	pk_agenda_grupo int8 default nextval('agenda_grupo_seq') not null primary key,
	s_grupo_nome varchar(80) not null,
	s_descricao varchar(1024),
	vfk_usuario int8
);

create sequence agenda_evento_seq;
create table tb_agenda_evento
(
	pk_agenda_evento int8 default nextval('agenda_evento_seq') not null primary key,
	s_titulo varchar(40),
	fk_usuario int8,
	txt_descricao text,
	dt_data_ini date,
	dt_data_fin date,
	hr_hora_ini time,
	hr_hora_fin time,
	s_privacidade char(1) default 'I',
	dt_update date default now(),
	foreign key (fk_usuario) references tb_usuario
);

create sequence dados_pessoais_agenda_grupo_seq;
create table tb_dados_pessoais_agenda_grupo
(
	pk_dados_pessoais_grupo_agenda int8 default nextval('dados_pessoais_agenda_grupo_seq') not null primary key,
	fk_dados_pessoais int8,
	fk_agenda_grupo int8,
	s_privacidade char(1),
	foreign key (fk_agenda_grupo) references tb_agenda_grupo,
	foreign key (fk_dados_pessoais) references tb_dados_pessoais
);

create sequence beneficio_seq;
create table tb_beneficio
(
	pk_beneficio int8 not null default nextval('beneficio_seq') primary key,
	s_nome varchar(255)
);

create sequence funcionario_beneficio_seq;
create table tb_funcionario_beneficio
(
	pk_funcionario_beneficio int8 not null default nextval('funcionario_beneficio_seq') primary key,
	fk_usuario int8 not null,
	fk_beneficio int8 not null,
	fl_valor float,
	foreign key (fk_usuario) references tb_usuario,
	foreign key (fk_beneficio) references tb_beneficio
);

create sequence grau_instrucao_seq;
create table tb_grau_instrucao
(
	pk_grau_instrucao int8 not null default nextval('grau_instrucao_seq') primary key,
	s_grau_instrucao varchar(100)
);

create sequence departamento_seq;
create table tb_departamento
(
	pk_departamento int8 not null default nextval('departamento_seq') primary key,
	s_departamento varchar(100)
);

create sequence cargo_seq;
create table tb_cargo
(
	pk_cargo int8 not null default nextval('cargo_seq') primary key,
	s_cargo varchar(100)
);

create sequence banco_seq;
create table tb_banco
(
	pk_banco int8 not null default nextval('banco_seq') primary key,
	s_banco varchar(100)
);

create sequence dependencia_seq;
create table tb_dependencia
(
	pk_dependencia int8 not null default nextval('dependencia_seq') primary key,
	s_nome_tipo varchar(100)
);

create sequence dependente_seq;
create table tb_dependente
(
	pk_dependente int8 not null default nextval('dependente_seq') primary key,
	s_nome varchar(100)
);

create sequence funcionario_dependente_seq;
create table tb_funcionario_dependente
(
	pk_funcionario_dependente int8 not null default nextval('funcionario_dependente_seq') primary key,
	fk_dependencia int8 not null,
	fk_dependente int8 not null,
	foreign key (fk_dependencia) references tb_dependencia
);

create sequence ferias_seq;
create table tb_ferias
(
	pk_ferias int8 not null default nextval('ferias_seq') primary key,
	dt_inicial date,
	dt_final date,
	fk_usuario int8 not null,
	foreign key (fk_usuario) references tb_usuario
);

create sequence banco_operacao_seq;

create table tb_banco_operacao
(
	pk_operacao int8 default nextval('banco_operacao_seq') not null primary key,
	s_operacao varchar(80)
);

create sequence funcionario_seq;
create table tb_funcionario
(
	pk_funcionario int8 not null default nextval('funcionario_seq') primary key,
	fk_usuario int8 not null,
	bl_deficiencia_fisica char(1),
	s_deficiencia_fisica varchar(200),
	s_rg varchar(10),
	dt_rg_data date,
	s_rg_orgao_emissor varchar(20),
	s_cnpj varchar(18), /* contem RG, CNPJ E CPF  SAO DIFERENTES das tabelas de pessoas fisica, e juridica*/
	s_cpf varchar(14),
	s_ctps varchar(14),
	s_serie_ctps varchar(14),
	s_uf_ctps varchar(2),
	s_data_ctps date,
	s_pis_pasep varchar(18),
	s_cnh varchar(11),
	s_tipo_cnh varchar(3),
	s_tit_eleitoral varchar(12),
	s_zona_tit_eleitoral varchar(5),
	s_secao_tit_eleitoral varchar(5),
	s_num_reservista varchar(15),
	s_serie_reservista varchar(15),
	s_categoria_reservista varchar(15),
	fk_grau_instrucao int8,
	s_foto_url varchar(2048),
	fk_departamento int8 not null,
	fk_cargo int8 not null,
	dt_admicao date,
	dt_demissao date,
	vfk_banco int8,
	vfk_operacao int8,
	s_conta varchar(12),
	s_agencia varchar(12),
	s_pai varchar(255),
	s_mae varchar(255),
	s_obs text,
	foreign key (fk_usuario) references tb_usuario,
	foreign key (fk_grau_instrucao) references tb_grau_instrucao,
	foreign key (fk_departamento) references tb_departamento,
	foreign key (fk_cargo) references tb_cargo
);

create sequence alteracoes_seq;
create table tb_alteracoes
(
	pk_processo int8 default nextval('alteracoes_seq') not null primary key,
	fk_usuario int8 not null,
	s_titulo varchar(80),
	txt_alteracao text,
	tmp_hora time,
	dt_criacao date,
	foreign key (fk_usuario) references tb_usuario
);

create sequence logs_seq;
create table tb_logs
(
	pk_logs int8 default nextval('logs_seq') not null primary key,
	fk_usuario int8 not null,
	s_obs varchar(200),
	tmp_hora time default now(),
	dt_login date default now(),
	s_ip varchar(20),
	bl_movimento varchar(3) default 'in',
	foreign key (fk_usuario) references tb_usuario
);

-- Tabelas referentes a proccessos
create sequence pasta_seq;
create table tb_pasta
(
	pk_pasta int8 default nextval('pasta_seq') not null primary key,
	fk_usuario int8 not null,
	s_nome varchar(120),
	dt_update date default now(),
	vfk_pasta_pai int8,  -- vfk -> virtual foreign key, uma FK que nao é referenciada por indices	//	only for a test
	dt_criacao date,
	foreign key (fk_usuario) references tb_usuario
);

-- Status do Processo
create sequence status_processo_seq;
create table tb_status_processo 
(
	pk_status_processo int8 not null default nextval('status_processo_seq') primary key,
	s_nome varchar(255) not null,
	s_descricao varchar(1024)
);

-- Escritorio Associado
create sequence escritorio_associado_seq;
create table tb_escritorio_associado
(
	pk_escritorio_associado int8 not null default nextval('escritorio_associado_seq') primary key,
	s_nome varchar(255) not null,
	s_descricao varchar(1024)
);

--Tipo da Açao
create sequence tipo_acao_seq;
create table tb_tipo_acao
(
  pk_tipo_acao int8 not null default nextval('tipo_acao_seq') primary key ,
  s_nome varchar(255) not null,
  s_descricao varchar(1024)
);

-- Instancia do Processo
create sequence instancia_processo_seq;
create table tb_instancia_processo
(
	pk_instancia_processo int8 not null default nextval('instancia_processo_seq') primary key,
	s_nome varchar(255) not null,
	s_descricao varchar(1024)
);

create sequence natureza_acao_seq;
create table tb_natureza_acao
(
	  pk_natureza_acao int8 not null default nextval('natureza_acao_seq') primary key,
	  s_nome varchar(255) not null,
	  s_descricao varchar(1024)
);

create sequence orgao_judicial_seq;
create table tb_orgao_judicial
(
	  pk_orgao_judicial int8 not null default nextval('orgao_judicial_seq') primary key,
	  s_nome varchar(255) not null,
	  s_localidade varchar(255) not null,
	  s_numero varchar(255) not null,
	  s_vara varchar(255) not null
);

create sequence fase_seq;
create table tb_fase
(
	  pk_fase int8 not null default nextval('fase_seq') primary key,
	  s_nome varchar(255) not null
);

create sequence probabilidade_exito_seq;
create table tb_probabilidade_exito
(
	  pk_probabilidade int8 not null default nextval('probabilidade_exito_seq') primary key,
	  s_nome varchar(255) not null
);

create sequence pos_cliente_seq;
create table tb_pos_cliente
(
	  pk_pos_cliente int8 not null default nextval('pos_cliente_seq') primary key,
	  s_nome varchar(255) not null
);

create sequence rito_seq;
create table tb_rito
(
  pk_rito int8 not null default nextval('rito_seq') primary key,
  s_nome varchar(255) not null,
  s_descricao varchar(1024)
);

create sequence posicao_processual_seq;
create table tb_posicao_processual
(
  pk_posicao_processual int8 not null default nextval('posicao_processual_seq') primary key,
  s_nome varchar(255) not null
) ;

create sequence processo_seq;
create table tb_processo
(
	pk_processo int8 default nextval('processo_seq') not null primary key,
	s_nome varchar(80),
	s_numero_original varchar(80),
	s_numero_atual varchar(80),
	f_valor_causa float,
	f_valor_envolvido float,
	s_comentario text,
	dt_update date default now(),
	dt_criacao date default now(),
	dt_data_distribuicao date,
	dt_data_encerramento date,
	dt_data_protocolo date,
	fk_pos_cliente int8,
	fk_fase int8,
	fk_criador int8,
	fk_status int8,
	fk_natureza_acao int8,
	fk_orgao_judicial int8,
	fk_escritorio_associado int8,
	fk_advogado_responsavel int8,
	fk_instancia_processo int8,
	fk_rito int8,
	fk_probabilidade_exito int8,
	vfk_user_atualizacao int8,  
	foreign key (fk_pos_cliente) references tb_pos_cliente,
	foreign key (fk_fase) references tb_fase,
	foreign key (fk_criador) references tb_usuario,
	foreign key (fk_status) references tb_status_processo,
	foreign key (fk_orgao_judicial) references tb_orgao_judicial,
	foreign key (fk_advogado_responsavel) references tb_dados_pessoais,
	foreign key (fk_escritorio_associado) references tb_escritorio_associado,
	foreign key (fk_instancia_processo) references tb_instancia_processo,
	foreign key (fk_natureza_acao) references tb_natureza_acao,
	foreign key (fk_rito) references tb_rito,
	foreign key (fk_probabilidade_exito) references tb_probabilidade_exito
);

create sequence processo_parte_contraria_seq;
create table tb_processo_parte_contraria
(
	pk_processo_parte_contraria int8 default nextval('processo_parte_contraria_seq') not null primary key,
	fk_processo int8 not null,
	fk_parte_contraria int8 not null,	
	foreign key (fk_processo) references tb_processo,
	foreign key (fk_parte_contraria) references tb_dados_pessoais
);


create sequence mov_processo_seq;
create table tb_mov_processo
(
	pk_mov_processo int8 default nextval('mov_processo_seq') not null primary key,
	fk_processo int8 not null,
	dt_data date,
	s_texto varchar(700),
	foreign key (fk_processo) references tb_processo
);

create sequence processo_pasta_seq;
create table tb_processo_pasta
(
	pk_processo_pasta int8 default nextval('processo_pasta_seq') not null primary key,
	fk_processo int8 not null,
	fk_pasta int8 not null,
	foreign key (fk_processo) references tb_processo,
	foreign key (fk_pasta) references tb_pasta
);

create sequence ramo_atividade_seq;
create table tb_ramo_atividade
(
	pk_ramo_atividade int8 not null default nextval('ramo_atividade_seq') primary key,
	s_nome varchar(100),
	s_descricao varchar (255)
);

--PESSOA FISICA

create sequence pess_fisica_seq;
create table tb_pess_fisica
(
	pk_pes_fisica int8 not null default nextval('pess_fisica_seq') primary key,
	fk_dados_pessoais int8 not null,
	cpf varchar(14) not null,
	fk_estado_civil int8 not null,
	s_conjuge varchar(255),
	s_rg varchar(10),
	s_profissao varchar(255),
	s_nascionalidade varchar(40),
	dt_nascimento date,
	foreign key (fk_dados_pessoais) references tb_dados_pessoais,
	foreign key (fk_estado_civil) references tb_estado_civil
);

-- PESSOA JURIDICA

create sequence pess_juridica_seq;
create table tb_pess_juridica
(
    pk_pes_juridica int8 not null default nextval('pess_juridica_seq') primary key,
	fk_dados_pessoais int8 not null,
	razao_social varchar (100) not null,
	nome_fantasia varchar (100) not null,
	inscr_estadual varchar (50),
	inscr_municipal varchar (50),
	cnpj varchar(18) not null,
	fk_ramo_atividade int8,
	vfk_responsavel int8,
	foreign key (fk_ramo_atividade) references tb_ramo_atividade,
	foreign key (fk_dados_pessoais) references tb_dados_pessoais
);

create sequence filial_dados_pessoais_seq;
create table tb_filial_dados_pessoais -- TABELA QUE LIGA DADOS PESSOAIS, A DADOS PESSOAIS LINKANDO POR CONTATOS JURIDICOS NAO CLIENTES
(
	pk_filial_dados_pessoais int8 not null default nextval('filial_dados_pessoais_seq') primary key,
	fk_dados_pessoais int8,
	vfk_filial int8, -- dados pessoais, ligado indiretamente aos dados pessoais do cliente juridico cadastrado
	foreign key (fk_dados_pessoais) references tb_dados_pessoais
);

create sequence contatos_empresa_seq;
create table tb_contatos_empresa -- TABELA QUE LIGA DADOS PESSOAIS, A DADOS PESSOAIS LINKANDO POR CONTATOS fisicos, para que sejam contatos da empresa
(
	pk_contatos_empresa int8 not null default nextval('contatos_empresa_seq') primary key,
	fk_dados_pessoais int8,
	vfk_contato int8, -- dados pessoais, ligado indiretamente aos dados pessoais do cliente juridico cadastrado
	foreign key (fk_dados_pessoais) references tb_dados_pessoais
);

-- FUNCIONARIO
create sequence colaborador_contrato_tipo_seq;
create table tb_colaborador_contrato_tipo
(
	pk_tipo_contrato int8 not null default nextval('colaborador_contrato_tipo_seq') primary key,
	s_nome varchar(90)
);

create sequence colaborador_seq; 
create table tb_colaborador
(
	pk_colaborador int8 not null default nextval('colaborador_seq') primary key,
	fk_tipo_contrato int8,
	fk_usuario int8 not null,
	foreign key (fk_usuario) references tb_usuario,
	foreign key (fk_tipo_contrato) references tb_colaborador_contrato_tipo
);

create sequence onibus_empresa_seq;
create table tb_onibus_empresa
(
	pk_onibus_empresa int8 not null default nextval('onibus_empresa_seq') primary key,
	s_nome varchar(90)
);

create sequence onibus_seq;
create table tb_onibus
(
	pk_onibus int8 not null default nextval('onibus_seq') primary key,
	s_nome varchar(240),
	fl_valor float4 default 0.00,
	fk_onibus_empresa int8 not null,
	foreign key (fk_onibus_empresa) references tb_onibus_empresa
);

create sequence onibus_colaborador_seq;
create table  tb_onibus_colaborador
(
	fk_colaborador int8 not null,
	fk_onibus int8 not null,
	foreign key (fk_colaborador) references tb_colaborador,
	foreign key (fk_onibus) references tb_onibus,
	primary key (fk_colaborador, fk_onibus)
);

-- TRIGGERS AND FUNCTIONS
/*
create or replace FUNCTION func_usuario_agenda_grupo() RETURNS trigger AS $usuario_agenda$
  BEGIN
	IF (NEW.bl_cliente <> 1)
	  THEN
		insert into tb_agenda_grupo (s_grupo_nome, fk_usuario) values ('Individuais', NEW.pk_usuario);
	END IF;
	return new;
  END;
$usuario_agenda$ language plpgsql;

create or replace FUNCTION func_agencia_data() RETURNS trigger AS $agenciaData$
  begin
	insert into tb_grupo (pk_grupo, fk_agencia,s_label) values (1, NEW.pk_agencia,'Administradores');
	insert into tb_grupo (pk_grupo, fk_agencia,s_label) values (2, NEW.pk_agencia,'Geral');
	return new;
  end;
$agenciaData$ language plpgsql;

create TRIGGER agencia_data AFTER insert ON tb_agencia
  FOR EACH ROW EXECUTE PROCEDURE func_agencia_data();
*/

--select setval ('grupo_seq', 5);

--	MENSAGENS

create sequence mensagem_seq;

create table tb_mensagem
(
	pk_msg int8 not null primary key default nextval('mensagem_seq'),
	s_msg varchar(2048),
	s_titulo varchar(100),
	dt_time timestamp default now(),
	fk_sender int8 not null,
	FOREIGN KEY (fk_sender) references tb_usuario
);

create sequence mensagem_usuario_seq;

create table tb_mensagem_usuario
(
	pk_mensagem_usuario int8 not null primary key default nextval('mensagem_usuario_seq'),
	fk_msg int8 not null,
	fk_usuario int8 not null,
	bl_lida smallint default 0,
	FOREIGN KEY (fk_usuario) references tb_usuario,
	FOREIGN KEY (fk_msg) references tb_mensagem
);

--	Circulares

create sequence circulares_seq;

create table tb_circulares
(
	pk_circular int8 not null primary key default nextval('circulares_seq'),
	s_circular varchar(2048),
	s_titulo varchar(100),
	dt_time timestamp default now(),
	fk_sender int8 not null,
	bl_status int2 DEFAULT 1,
	FOREIGN KEY (fk_sender) references tb_usuario
);

create sequence circular_grupo_seq;

create table tb_circular_grupo
(
	pk_circular_grupo int8 not null primary key default nextval('circular_grupo_seq'),
	fk_circular int8 not null,
	fk_grupo int8 not null,
	FOREIGN KEY (fk_grupo) references tb_grupo,
	FOREIGN KEY (fk_circular) references tb_circulares
);

--	Opções marcadas

create sequence opcao_marcada_seq;

create table tb_opcao_marcada
(
	pk_opcao_marcada int8 not null primary key default nextval('opcao_marcada_seq'),
	s_tabela varchar(150),
	s_campo varchar(150),
	s_valor_campo varchar(150),
	fk_usuario int8,
	FOREIGN KEY (fk_usuario) references tb_usuario
);

--COMMIT TRANSACTION;



-- I N S E R T S

--Agencia
insert into tb_agencia (pk_agencia, s_nome) values (1, 'Marcio Pletz Advogados');
insert into tb_usuario (s_login,s_senha, bl_cliente, bl_tipo_pessoa) values ('marcio','1234', 0, 'J');
insert into tb_agencia_usuario (fk_usuario, fk_agencia) values (1, 1);

--Grupo
insert into tb_grupo (fk_agencia,s_label) values (1,'Administradores');
insert into tb_grupo (fk_agencia,s_label) values (1,'Geral');

--Estado Civil
insert into tb_estado_civil (s_estado_civil) values ('Solteiro(a)');
insert into tb_estado_civil (s_estado_civil) values ('Casado(a)');
insert into tb_estado_civil (s_estado_civil) values ('Viúvo(a)');
insert into tb_estado_civil (s_estado_civil) values ('Divorciado(a)');
insert into tb_estado_civil (s_estado_civil) values ('Separado(a)');
insert into tb_estado_civil (s_estado_civil) values ('Marital');

--Ramo Atividade
insert into tb_ramo_atividade (s_nome,s_descricao) values ('Desenvolvimento WEB','');
insert into tb_ramo_atividade (s_nome,s_descricao) values ('Educação','');
insert into tb_ramo_atividade (s_nome,s_descricao) values ('Construção Civil','');
insert into tb_ramo_atividade (s_nome,s_descricao) values ('Agronegócios','');

--Usuarios Padrao
insert into tb_usuario (s_login,s_senha, bl_cliente, bl_tipo_pessoa) values ('felipe','1234', 0, 'F');
insert into tb_usuario (s_login,s_senha, bl_cliente, bl_tipo_pessoa) values ('jay','1234', 0, 'F');
insert into tb_usuario (s_login,s_senha, bl_cliente, bl_tipo_pessoa) values ('jon','1234', 0, 'F');
insert into tb_usuario (s_login,s_senha, bl_cliente, bl_tipo_pessoa) values ('f2j','123456', 0, 'J');
insert into tb_usuario (s_login,s_senha, bl_cliente, bl_tipo_pessoa) values ('carolina','1234', 0, 'F');
insert into tb_dados_pessoais (s_usuario,vfk_usuario,c_sexo) values ('Márcio Pletz',1,'M');
insert into tb_dados_pessoais (s_usuario,vfk_usuario,c_sexo) values ('Felipe Moura',2,'M');
insert into tb_dados_pessoais (s_usuario,vfk_usuario,c_sexo) values ('Jaydson Gomes',3,'M');
insert into tb_dados_pessoais (s_usuario,vfk_usuario,c_sexo) values ('Jonathan Bach',4,'M');
insert into tb_dados_pessoais (s_usuario,vfk_usuario) values ('F2J WEB',5);
insert into tb_dados_pessoais (s_usuario,vfk_usuario,c_sexo) values ('Carolina',6,'F');
insert into tb_pess_fisica (fk_dados_pessoais,cpf,fk_estado_civil) values (1,'0203654184',1);
insert into tb_pess_fisica (fk_dados_pessoais,cpf,fk_estado_civil) values (2,'4455544184',1);
insert into tb_pess_fisica (fk_dados_pessoais,cpf,fk_estado_civil) values (3,'4958544184',1);
insert into tb_pess_fisica (fk_dados_pessoais,cpf,fk_estado_civil) values (4,'4958500004',1);
insert into tb_pess_fisica (fk_dados_pessoais,cpf,fk_estado_civil,s_conjuge) values (6,'0055225115',2,'Joao da Silva');
insert into tb_pess_juridica (fk_dados_pessoais,cnpj,razao_social,nome_fantasia,inscr_estadual,inscr_municipal,fk_ramo_atividade) values (5,'6545487081','F2J WEB','F2J','1215','5345',1);

--Grupo
--insert into tb_grupo (fk_agencia,s_label) values (1,'Administradores');
--insert into tb_grupo (fk_agencia,s_label) values (1,'Geral');

--Usuario Grupo
insert into tb_agenda_grupo (s_grupo_nome, s_descricao) values ('Geral', 'Grupo destinado a contatos gerais, e de acesso público');

insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (1, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (2, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (3, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (4, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (5, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (6, 1);
select setval ('usuario_grupo_seq', 7); -- Para a sequencia iniciar em 7 
select setval ('usuario_seq', 7);       -- Para a sequencia iniciar em 7   

--Tipo Telefone
insert into tb_tipo_telefone(s_tipo_telefone) values ('Comercial');
insert into tb_tipo_telefone(s_tipo_telefone) values ('Residencial');
insert into tb_tipo_telefone(s_tipo_telefone) values ('Celular');
insert into tb_tipo_telefone(s_tipo_telefone) values ('Fax');

--Contrato Funcionario
insert into tb_tipo_contrato_func (s_label) values('Efetivo');
insert into tb_tipo_contrato_func (s_label) values('Estagiário');

--Departamento
insert into tb_departamento (s_departamento) VALUES ('RH');
insert into tb_departamento (s_departamento) VALUES ('Financeiro');
insert into tb_departamento (s_departamento) VALUES ('CPD');
insert into tb_departamento (s_departamento) VALUES ('Comercial');
insert into tb_departamento (s_departamento) VALUES ('Produção');

--Cargo
insert into tb_cargo (s_cargo) VALUES ('Gerente');
insert into tb_cargo (s_cargo) VALUES ('Acessor');
insert into tb_cargo (s_cargo) VALUES ('Supervisor');
insert into tb_cargo (s_cargo) VALUES ('Atendente');
insert into tb_cargo (s_cargo) VALUES ('Técnico');

--Banco Operaçao
insert into tb_banco_operacao (s_operacao) values ('Conta Poupança');
insert into tb_banco_operacao (s_operacao) values ('Conta Corrente');
insert into tb_banco_operacao (s_operacao) values ('Conta Universitário');
insert into tb_banco_operacao (s_operacao) values ('Conta Salário');

--Grau Instruçao
insert into tb_grau_instrucao (s_grau_instrucao) values ('Ensino Fundamental Completo');
insert into tb_grau_instrucao (s_grau_instrucao) values ('Ensino Fundamental Incompleto');
insert into tb_grau_instrucao (s_grau_instrucao) values ('Ensino Médio Completo');
insert into tb_grau_instrucao (s_grau_instrucao) values ('Ensino Médio Incompleto');
insert into tb_grau_instrucao (s_grau_instrucao) values ('Terceiro grau Completo');
insert into tb_grau_instrucao (s_grau_instrucao) values ('Terceiro grau Incompleto');

--Dependencia
insert into tb_dependencia (s_nome_tipo) values ('Filho(a)');
insert into tb_dependencia (s_nome_tipo) values ('Cônjuge');
insert into tb_dependencia (s_nome_tipo) values ('Mãe/Pai');

--Beneficios
insert into tb_beneficio (s_nome) values ('Salario');
insert into tb_beneficio (s_nome) values ('Transporte');
insert into tb_beneficio (s_nome) values ('Alimentação');
insert into tb_beneficio (s_nome) values ('Bolsa Auxílio');
insert into tb_beneficio (s_nome) values ('Auxílio Universitário');

--processo
/* insert into tb_processo_nome_interno (s_nome_interno,s_descricao) values ('trab','Trabalhista');		VERIFICAR AQUI
insert into tb_processo_nome_interno (s_nome_interno,s_descricao) values ('jud','Judicial'); */
insert into tb_status_processo (s_nome,s_descricao) values ('Ativo','Processo Ativo');
insert into tb_status_processo (s_nome,s_descricao) values ('Suspenso','Processo Suspenso');
insert into tb_status_processo (s_nome,s_descricao) values ('Baixado','Processo Baixado');
insert into tb_status_processo (s_nome,s_descricao) values ('Encerrado','Processo Encerrado');
insert into tb_escritorio_associado (s_nome,s_descricao) values ('Escritorio1','Escritorio1');
insert into tb_escritorio_associado (s_nome,s_descricao) values ('Escritorio2','Escritorio2');
insert into tb_instancia_processo (s_nome,s_descricao) values ('Instancia1','Instancia1');
insert into tb_instancia_processo (s_nome,s_descricao) values ('Instancia2','Instancia2');

--PERMISSÃO
--13/02/2008

insert into tb_tipo_permissao(s_titulo) values ('Processos');
insert into tb_tipo_permissao(s_titulo) values ('Clientes');
insert into tb_tipo_permissao(s_titulo) values ('Contatos');
insert into tb_tipo_permissao(s_titulo) values ('Filiais');
insert into tb_tipo_permissao(s_titulo) values ('Funcionários');
insert into tb_tipo_permissao(s_titulo) values ('Componentes');
insert into tb_tipo_permissao(s_titulo) values ('Permissões');
insert into tb_tipo_permissao(s_titulo) values ('Relatórios');
insert into tb_tipo_permissao(s_titulo) values ('Gerencia');
insert into tb_tipo_permissao(s_titulo) values ('Ferramentas');



--Processos
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (1,'Cadastrar Novo Processo');  		-- Codigo Permissao 1  | Tipo 1
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (1,'Gerenciar Processos');      		-- Codigo Permissao 2 | Tipo 1
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (1,'Pesquisar Processos');      		-- Codigo Permissao 3 | Tipo 1
	--Pastas
	insert into tb_permissao (fk_tipo_permissao,s_titulo) values (1,'Cadastrar Nova Pasta'); 		-- Codigo Permissao 4 | Tipo 1
	insert into tb_permissao (fk_tipo_permissao,s_titulo) values (1,'Gerenciar Pastas');     		-- Codigo Permissao 5 | Tipo 1
	insert into tb_permissao (fk_tipo_permissao,s_titulo) values (1,'Pesquisar Pastas');     		-- Codigo Permissao 6 | Tipo 1

--Clientes
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (2,'Cadastrar Novo Cliente');   		-- Codigo Permissao 7 | Tipo 2
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (2,'Gerenciar Clientes');		 		-- Codigo Permissao 8 | Tipo 2
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (2,'Pesquisar Clientes');			 	-- Codigo Permissao 9 | Tipo 2
	--Contatos
		insert into tb_permissao (fk_tipo_permissao,s_titulo) values (3,'Cadastrar Novo Contato');  -- Codigo Permissao 10 | Tipo 3
		insert into tb_permissao (fk_tipo_permissao,s_titulo) values (3,'Gerenciar Contatos');      -- Codigo Permissao 11 | Tipo 3
		insert into tb_permissao (fk_tipo_permissao,s_titulo) values (3,'Pesquisar Contatos');      -- Codigo Permissao 12 | Tipo 3
	--Filiais
		insert into tb_permissao (fk_tipo_permissao,s_titulo) values (4,'Cadastrar Nova Filial');   -- Codigo Permissao 13 | Tipo 4
		insert into tb_permissao (fk_tipo_permissao,s_titulo) values (4,'Gerenciar Filiais');       -- Codigo Permissao 14 | Tipo 4
		insert into tb_permissao (fk_tipo_permissao,s_titulo) values (4,'Pesquisar Filiais');       -- Codigo Permissao 15 | Tipo 4

--RH
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (5,'Cadastrar Novo Funcionário');      -- Codigo Permissao 16 | Tipo 5
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (5,'Gerenciar Funcionários');			-- Codigo Permissao 17 | Tipo 5
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (5,'Pesquisar Funcionários');			-- Codigo Permissao 18 | Tipo 5
	--Grupo de usuarios
	insert into tb_permissao (fk_tipo_permissao,s_titulo) values (5,'Cadastrar Novo Grupo de Funcionários'); -- Codigo Permissao 19 | Tipo 5

--Gerenciar
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (6,'Gerenciar Componentes');           -- Codigo Permissao 20 | Tipo 6
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (7,'Gerenciar Permissões');			-- Codigo Permissao 21 | Tipo 7
	--Relatorios
		insert into tb_permissao (fk_tipo_permissao,s_titulo) values (8,'Exibir Relatórios');		-- Codigo Permissao 22 | Tipo 8
		insert into tb_permissao (fk_tipo_permissao,s_titulo) values (8,'Gerar Relatórios');		-- Codigo Permissao 23 | Tipo 8
		insert into tb_permissao (fk_tipo_permissao,s_titulo) values (8,'Modelos de Relatórios');   -- Codigo Permissao 24 | Tipo 8
		
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (9,'Exibir Logs');						-- Codigo Permissao 25 | Tipo 9
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (9,'Usuários Logados');				-- Codigo Permissao 26 | Tipo 9

---Ferramentas
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (10,'Pesquisa Avançada');				-- Codigo Permissao 27 | Tipo 10
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (10,'Calculadora');					-- Codigo Permissao 28 | Tipo 10
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (10,'Calendário');						-- Codigo Permissao 29 | Tipo 10
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (10,'Agenda de eventos');				-- Codigo Permissao 30 | Tipo 10
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (10,'Agenda de contatos');  			-- Codigo Permissao 31 | Tipo 10
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (10,'Mensagens');						-- Codigo Permissao 32 | Tipo 10
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (10,'Circulares');						-- Codigo Permissao 33 | Tipo 10
insert into tb_permissao (fk_tipo_permissao,s_titulo) values (10,'Opções');							-- Codigo Permissao 34 | Tipo 10

--Permissões dos Grupos
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (1,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (2,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (3,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (4,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (5,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (6,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (7,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (8,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (9,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (10,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (11,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (12,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (13,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (14,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (15,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (16,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (17,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (18,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (19,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (20,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (21,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (22,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (23,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (24,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (25,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (26,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (27,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (28,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (29,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (30,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (31,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (32,1);
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (33,1);

