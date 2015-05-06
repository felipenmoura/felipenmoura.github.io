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

CREATE SEQUENCE cep_seq;
CREATE TABLE tb_cep
(
  pk_cep int8 DEFAULT NEXTVAL('cep_seq') PRIMARY KEY,
  s_logradouro VARCHAR (255),
  s_bairro VARCHAR (255),
  s_cidade VARCHAR (255),
  s_estado_sigla CHAR (2),
  c_tipo_endereco char(1),
  s_estado_nome VARCHAR (255),
  s_pais VARCHAR (255),
  s_cep CHAR(9),
  s_complemento char(255),
  bl_caixa_postal char(1)
);

CREATE SEQUENCE dados_pessoais_seq;
CREATE TABLE tb_dados_pessoais
(
  pk_dados_pessoais int8 DEFAULT NEXTVAL('dados_pessoais_seq') PRIMARY KEY,
  s_usuario varchar(80),
  bl_status int2 DEFAULT 1,
  dt_update date DEFAULT now(),
  c_sexo char(2),
  web_site varchar (200),
  vfk_usuario int8,
  txt_obs text
); 

CREATE SEQUENCE cep_dados_pessoais_seq;
CREATE TABLE tb_cep_dados_pessoais
(
  pk_cep_dados_pessoais int8 DEFAULT NEXTVAL('cep_dados_pessoais_seq') PRIMARY KEY,
  fk_dados_pessoais int8,
  fk_cep int8,
  s_num char(8),
  FOREIGN KEY (fk_dados_pessoais) REFERENCES tb_dados_pessoais,
  FOREIGN KEY (fk_cep) REFERENCES tb_cep
);

create sequence usuario_seq;
CREATE TABLE tb_usuario
(
  pk_usuario int8 NOT NULL DEFAULT nextval('usuario_seq'),
  dt_update date DEFAULT now(),
  s_login varchar(20),
  s_senha varchar(40),
  bl_senha char(1),
  bl_cliente int2 DEFAULT 0,
  bl_tipo_pessoa char(1),
  CONSTRAINT tb_usuario_pkey PRIMARY KEY (pk_usuario)
);

CREATE SEQUENCE agencia_usuario_seq;
CREATE TABLE tb_agencia_usuario
(
  pk_agencia_usuario int8 NOT NULL DEFAULT nextval('agencia_usuario_seq') primary key,
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

create sequence permissao_seq;

create table tb_permissao(
	pk_permissao int8 default nextval('permissao_seq') not null primary key,
	s_titulo varchar(160)
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
	s_email VARCHAR(255),
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
	FOREIGN KEY(fk_tipo_telefone) REFERENCES tb_tipo_telefone
);

CREATE SEQUENCE telefone_usuario_seq;
CREATE TABLE tb_telefone_usuario
(
  pk_telefone_usuario int8 DEFAULT NEXTVAL('telefone_usuario_seq') PRIMARY KEY,
  fk_dados_pessoais int8,
  fk_telefone int8,
  FOREIGN KEY (fk_dados_pessoais) REFERENCES tb_dados_pessoais,
  FOREIGN KEY (fk_telefone) REFERENCES tb_telefone
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
	s_nome varchar(90),
	s_img_src varchar(1024),
	s_js_command varchar(2048),
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
	FOREIGN KEY (fk_agenda_grupo) references tb_agenda_grupo,
	FOREIGN KEY (fk_dados_pessoais) references tb_dados_pessoais
);


/* 26/01/2008   18:50*/

create sequence beneficio_seq;
create table tb_beneficio
(
	pk_beneficio int8 NOT NULL DEFAULT nextval('beneficio_seq') PRIMARY KEY,
	s_nome varchar(255)
);

create sequence funcionario_beneficio_seq;
create table tb_funcionario_beneficio
(
	pk_funcionario_beneficio int8 NOT NULL DEFAULT nextval('funcionario_beneficio_seq') PRIMARY KEY,
	fk_usuario int8 not null,
	fk_beneficio int8 not null,
	fl_valor float,
	FOREIGN KEY (fk_usuario) references tb_usuario,
	FOREIGN KEY (fk_beneficio) references tb_beneficio
);

create sequence grau_instrucao_seq;
create table tb_grau_instrucao
(
	pk_grau_instrucao int8 NOT NULL DEFAULT nextval('grau_instrucao_seq') PRIMARY KEY,
	s_grau_instrucao varchar(100)
);

create sequence departamento_seq;
create table tb_departamento
(
	pk_departamento int8 NOT NULL DEFAULT nextval('departamento_seq') PRIMARY KEY,
	s_departamento varchar(100)
);

create sequence cargo_seq;
create table tb_cargo
(
	pk_cargo int8 NOT NULL DEFAULT nextval('cargo_seq') PRIMARY KEY,
	s_cargo varchar(100)
);

create sequence banco_seq;
create table tb_banco
(
	pk_banco int8 NOT NULL DEFAULT nextval('banco_seq') PRIMARY KEY,
	s_banco varchar(100)
);

create sequence dependencia_seq;
create table tb_dependencia
(
	pk_dependencia int8 NOT NULL DEFAULT nextval('dependencia_seq') PRIMARY KEY,
	s_nome_tipo varchar(100)
);

create sequence dependente_seq;
create table tb_dependente
(
	pk_dependente int8 NOT NULL DEFAULT nextval('dependente_seq') PRIMARY KEY,
	s_nome varchar(100),
	fk_dependencia int8 not null,
	FOREIGN KEY (fk_dependencia) references tb_dependencia
);

create sequence ferias_seq;
create table tb_ferias
(
	pk_ferias int8 NOT NULL DEFAULT nextval('ferias_seq') PRIMARY KEY,
	dt_inicial date,
	dt_final date,
	fk_usuario int8 not null,
	FOREIGN KEY (fk_usuario) references tb_usuario
);

create sequence funcionario_seq;
CREATE TABLE tb_funcionario
(
  pk_funcionario int8 NOT NULL DEFAULT nextval('funcionario_seq') PRIMARY KEY,
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
  fk_banco int8 not null,
  s_operacao varchar(12),
  s_conta varchar(12),
  s_agencia varchar(12),
  s_pai varchar(255),
  s_mae varchar(255),]
  s_obs text,
  fk_dependente int8 not null,
  FOREIGN KEY (fk_dependente) references tb_dependente,
  FOREIGN KEY (fk_banco) references tb_banco,
  FOREIGN KEY (fk_usuario) references tb_usuario,
  FOREIGN KEY (fk_grau_instrucao) references tb_grau_instrucao,
  FOREIGN KEY (fk_departamento) references tb_departamento,
  FOREIGN KEY (fk_cargo) references tb_cargo
);


/**/


create sequence alteracoes_seq;

create table tb_alteracoes
(
	pk_processos int8 default nextval('alteracoes_seq') not null primary key,
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

/*
	inicio das tabelas referentes aos proccessos
*/

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


/*
create sequence subpasta_seq;

create table tb_subpasta
(
	pk_pasta int8 default nextval('subpasta_seq') not null primary key,
	s_nome varchar(40),
	fk_pasta int8,
	--fk_subpasta int8,
	dt_criacao timestamp default now(),
	ref_icone varchar(260) default('img/default.gif'),
	s_obs text,
	foreign key (fk_pasta) references tb_pasta
);
*/
create sequence processos_seq;

create table tb_processo
(
	pk_processos int8 default nextval('processos_seq') not null primary key,
	s_nome varchar(80),
	fk_cliente int8,
	dt_update date default now(),
	dt_criacao date,
	fk_criador int8,
	i_user_atualizacao int8,
	foreign key (fk_pasta) references tb_pasta
);

create sequence banco_operacao_seq;

create table tb_banco_operacao
(
	pk_operacao int8 default nextval('banco_operacao_seq') not null primary key,
	s_operacao varchar(80)
);

CREATE SEQUENCE ramo_atividade_seq;
CREATE TABLE tb_ramo_atividade
(
	pk_ramo_atividade int8 NOT NULL DEFAULT nextval('ramo_atividade_seq') primary key,
	s_nome varchar(100),
	s_descricao varchar (255)
);

--PESSOA FISICA

CREATE SEQUENCE pess_fisica_seq;
CREATE TABLE tb_pess_fisica
(
  pk_pes_fisica int8 NOT NULL DEFAULT nextval('pess_fisica_seq') primary key,
  fk_dados_pessoais int8 NOT NULL,
  cpf varchar(14) NOT NULL,
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

CREATE SEQUENCE pess_juridica_seq;
CREATE TABLE tb_pess_juridica
(
  pk_pes_juridica int8 NOT NULL DEFAULT nextval('pess_juridica_seq') primary key,
  fk_dados_pessoais int8 NOT NULL,
  razao_social varchar (100) NOT NULL,
  nome_fantasia varchar (100) NOT NULL,
  inscr_estadual varchar (50),
  inscr_municipal varchar (50),
  cnpj varchar(18) NOT NULL,
  fk_ramo_atividade int8,
  vfk_responsavel int8,
  foreign key (fk_ramo_atividade) references tb_ramo_atividade,
  foreign key (fk_dados_pessoais) references tb_dados_pessoais
);

CREATE SEQUENCE filial_dados_pessoais_seq;
CREATE TABLE tb_filial_dados_pessoais -- TABELA QUE LIGA DADOS PESSOAIS, A DADOS PESSOAIS LINKANDO POR CONTATOS JURIDICOS NAO CLIENTES
(
  pk_filial_dados_pessoais int8 NOT NULL DEFAULT nextval('filial_dados_pessoais_seq') primary key,
  fk_dados_pessoais int8,
  vfk_filial int8, -- dados pessoais, ligado indiretamente aos dados pessoais do cliente juridico cadastrado
  foreign key (fk_dados_pessoais) references tb_dados_pessoais
);

CREATE SEQUENCE contatos_empresa_seq;
CREATE TABLE tb_contatos_empresa -- TABELA QUE LIGA DADOS PESSOAIS, A DADOS PESSOAIS LINKANDO POR CONTATOS fisicos, para que sejam contatos da empresa
(
  pk_contatos_empresa int8 NOT NULL DEFAULT nextval('contatos_empresa_seq') primary key,
  fk_dados_pessoais int8,
  vfk_contato int8, -- dados pessoais, ligado indiretamente aos dados pessoais do cliente juridico cadastrado
  foreign key (fk_dados_pessoais) references tb_dados_pessoais
);

-- FUNCIONARIO

CREATE SEQUENCE colaborador_contrato_tipo_seq;
CREATE TABLE tb_colaborador_contrato_tipo
(
  pk_tipo_contrato int8 NOT NULL DEFAULT nextval('colaborador_contrato_tipo_seq') primary key,
  s_nome varchar(90)
);

CREATE SEQUENCE colaborador_seq; 
CREATE TABLE tb_colaborador
(
  pk_colaborador int8 NOT NULL DEFAULT nextval('colaborador_seq') primary key,
  fk_tipo_contrato int8,
  fk_usuario int8 NOT NULL,
  foreign key (fk_usuario) references tb_usuario,
  foreign key (fk_tipo_contrato) references tb_colaborador_contrato_tipo
);

CREATE SEQUENCE onibus_empresa_seq;
CREATE TABLE tb_onibus_empresa
(
  pk_onibus_empresa int8 NOT NULL DEFAULT nextval('onibus_empresa_seq') primary key,
  s_nome varchar(90)
);

CREATE SEQUENCE onibus_seq;
CREATE TABLE tb_onibus
(
  pk_onibus int8 NOT NULL DEFAULT nextval('onibus_seq') primary key,
  s_nome varchar(240),
  fl_valor float4 default 0.00,
  fk_onibus_empresa int8 NOT NULL,
  foreign key (fk_onibus_empresa) references tb_onibus_empresa
);

CREATE SEQUENCE onibus_colaborador_seq;
CREATE TABLE  tb_onibus_colaborador
(
  fk_colaborador int8 NOT NULL,
  fk_onibus int8 NOT NULL,
  foreign key (fk_colaborador) references tb_colaborador,
  foreign key (fk_onibus) references tb_onibus,
  primary key (fk_colaborador, fk_onibus)
);

--------------------------------------------------------------------------------------------------------------------------------------------------------
--                            22/10/2007               Jaydson Gomes
--------------------------------------------------------------------------------------------------------------------------------------------------------
-- Posicao Processual
create sequence posicao_processual_seq;
create table tb_posicao_processual 
	(
		pk_posicao_processual int8 NOT NULL DEFAULT nextval('posicao_processual_seq') primary key,
		s_nome varchar(255) not null
	);

-- Nome Interno do Processo
create sequence processo_nome_interno_seq;
create table tb_processo_nome_interno 
	(
		pk_processo_nome_interno int8 NOT NULL DEFAULT nextval('processo_nome_interno_seq') primary key,
		s_nome_interno varchar(255) not null,
		s_descricao varchar(1024)
	);
			
insert into tb_processo_nome_interno (s_nome_interno,s_descricao) values ('trab','Trabalhista');
insert into tb_processo_nome_interno (s_nome_interno,s_descricao) values ('jud','Judicial');

-- Status do Processo
create sequence status_processo_seq;
create table tb_status_processo 
	(
		pk_status_processo int8 NOT NULL DEFAULT nextval('status_processo_seq') primary key,
		s_nome varchar(255) not null,
		s_descricao varchar(1024)
	);
	
insert into tb_status_processo (s_nome,s_descricao) values ('Ativo','Processo Ativo');
insert into tb_status_processo (s_nome,s_descricao) values ('Suspenso','Processo Suspenso');
insert into tb_status_processo (s_nome,s_descricao) values ('Baixado','Processo Baixado');
insert into tb_status_processo (s_nome,s_descricao) values ('Encerrado','Processo Encerrado');
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--                            23/10/2007               Jaydson Gomes
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Escritorio Associado
create sequence escritorio_associado_seq;
create table tb_escritorio_associado
	(
		pk_escritorio_associado int8 NOT NULL DEFAULT nextval('escritorio_associado_seq') primary key,
		s_nome varchar(255) not null,
		s_descricao varchar(1024)
	);
	
insert into tb_escritorio_associado (s_nome,s_descricao) values ('Escritorio1','Escritorio1');
insert into tb_escritorio_associado (s_nome,s_descricao) values ('Escritorio2','Escritorio2');

-- Instancia do Processo
create sequence instancia_processo_seq;
create table tb_instancia_processo
	(
		pk_instancia_processo int8 NOT NULL DEFAULT nextval('instancia_processo_seq') primary key,
		s_nome varchar(255) not null,
		s_descricao varchar(1024)
	);

insert into tb_instancia_processo (s_nome,s_descricao) values ('Instancia1','Instancia1');
insert into tb_instancia_processo (s_nome,s_descricao) values ('Instancia2','Instancia2');
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

create sequence processo_pasta_seq;

create table tb_processo_pasta (
	pk_processo_pasta int8 default nextval('processo_pasta_seq') not null primary key,
	fk_processo int8 not null,
	fk_pasta int8 not null,
	foreign key (fk_processo) references tb_processos,
	foreign key (fk_pasta) references tb_pasta
			);


-- criando trigers e functions

CREATE or replace FUNCTION func_usuario_agenda_grupo() RETURNS trigger AS $usuario_agenda$
  BEGIN
	IF (NEW.bl_cliente <> 1)
	  THEN
		insert into tb_agenda_grupo (s_grupo_nome, fk_usuario) values ('Individuais', NEW.pk_usuario);
	END IF;
	return new;
  END;
$usuario_agenda$ language plpgsql;

CREATE or replace FUNCTION func_agencia_data() RETURNS trigger AS $agenciaData$
  begin
	insert into tb_grupo (pk_grupo, fk_agencia,s_label) values (1, NEW.pk_agencia,'Administradores');
	insert into tb_grupo (pk_grupo, fk_agencia,s_label) values (2, NEW.pk_agencia,'Geral');
	return new;
  end;
$agenciaData$ language plpgsql;

CREATE TRIGGER agencia_data AFTER INSERT ON tb_agencia
  FOR EACH ROW EXECUTE PROCEDURE func_agencia_data();

select setval ('grupo_seq', 5);
  
--COMMIT TRANSACTION;

insert into tb_agencia (pk_agencia, s_nome) values (1, 'Marcio Pletz Advogados');
insert into tb_usuario (pk_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa) values (1,'marcio','1234', 0, 'J');
insert into tb_agencia_usuario (fk_usuario, fk_agencia) values (1, 1);

insert into tb_estado_civil (s_estado_civil) values ('Solteiro(a)');
insert into tb_estado_civil (s_estado_civil) values ('Casado(a)');
insert into tb_estado_civil (s_estado_civil) values ('Viúvo(a)');
insert into tb_estado_civil (s_estado_civil) values ('Divorciado(a)');
insert into tb_estado_civil (s_estado_civil) values ('Separado(a)');
insert into tb_estado_civil (s_estado_civil) values ('Marital');

insert into tb_usuario (pk_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa) values (2,'felipe','1234', 0, 'F');
insert into tb_usuario (pk_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa) values (3,'jay','1234', 0, 'F');
insert into tb_usuario (pk_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa) values (4,'jon','1234', 0, 'F');
insert into tb_usuario (pk_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa) values (5,'f2j','123456', 0, 'J');
insert into tb_usuario (pk_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa) values (6,'carolina','1234', 0, 'F');

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
/*insert into tb_pess_fisica (fk_dados_pessoais,cpf,fk_estado_civil) values (5,'4584444404',1);*/
insert into tb_pess_fisica (fk_dados_pessoais,cpf,fk_estado_civil,s_conjuge) values (6,'0055225115',2,'Joao da Silva');

insert into tb_ramo_atividade (s_nome,s_descricao) values ('Desenvolvimento WEB','');
insert into tb_ramo_atividade (s_nome,s_descricao) values ('Educação','');
insert into tb_ramo_atividade (s_nome,s_descricao) values ('Construção Civil','');
insert into tb_ramo_atividade (s_nome,s_descricao) values ('Agronegócios','');

insert into tb_pess_juridica (fk_dados_pessoais,cnpj,razao_social,nome_fantasia,inscr_estadual,inscr_municipal,fk_ramo_atividade) values (5,'6545487081','F2J WEB','F2J','1215','5345',1);

insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (1, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (2, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (3, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (4, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (5, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (6, 1);

select setval ('usuario_grupo_seq', 7);
select setval ('usuario_seq', 7);

insert into tb_tipo_telefone(s_tipo_telefone) values ('Comercial');
insert into tb_tipo_telefone(s_tipo_telefone) values ('Residencial');
insert into tb_tipo_telefone(s_tipo_telefone) values ('Celular');
insert into tb_tipo_telefone(s_tipo_telefone) values ('Fax');

insert into tb_tipo_contrato_func (s_label) values('Efetivo');
insert into tb_tipo_contrato_func (s_label) values('Estagiário');

INSERT into tb_departamento (s_departamento) VALUES ('RH');
INSERT into tb_departamento (s_departamento) VALUES ('Financeiro');
INSERT into tb_departamento (s_departamento) VALUES ('CPD');
INSERT into tb_departamento (s_departamento) VALUES ('Comercial');
INSERT into tb_departamento (s_departamento) VALUES ('Produção');


INSERT into tb_cargo (s_cargo) VALUES ('Gerente');
INSERT into tb_cargo (s_cargo) VALUES ('Acessor');
INSERT into tb_cargo (s_cargo) VALUES ('Supervisor');
INSERT into tb_cargo (s_cargo) VALUES ('Atendente');
INSERT into tb_cargo (s_cargo) VALUES ('Técnico');

insert into tb_banco_operacao (s_operacao) values ('Conta Poupança');
insert into tb_banco_operacao (s_operacao) values ('Conta Corrente');
insert into tb_banco_operacao (s_operacao) values ('Conta Universitário');
insert into tb_banco_operacao (s_operacao) values ('Conta Salário');

insert into tb_grau_instrucao (s_grau_instrucao) values ('Ensino Fundamental Completo');
insert into tb_grau_instrucao (s_grau_instrucao) values ('Ensino Fundamental Incompleto');
insert into tb_grau_instrucao (s_grau_instrucao) values ('Ensino Médio Completo');
insert into tb_grau_instrucao (s_grau_instrucao) values ('Ensino Médio Incompleto');
insert into tb_grau_instrucao (s_grau_instrucao) values ('Terceiro grau Completo');
insert into tb_grau_instrucao (s_grau_instrucao) values ('Terceiro grau Incompleto');

insert into tb_dependencia (s_nome_tipo) values ('Filho(a)');
insert into tb_dependencia (s_nome_tipo) values ('Cônjuge');
insert into tb_dependencia (s_nome_tipo) values ('Mãe/Pae');

insert into tb_beneficio (s_nome) values ('Salario');
insert into tb_beneficio (s_nome) values ('Transporte');
insert into tb_beneficio (s_nome) values ('Alimentação');
insert into tb_beneficio (s_nome) values ('Bolsa Auxílio');
insert into tb_beneficio (s_nome) values ('Auxílio Universitário');

/*
insert into tb_permissao (s_titulo) values ('Cadastrar e editar novo usuário');
insert into tb_permissao (s_titulo) values ('Cadastrar e editar novo cliente');
insert into tb_permissao (s_titulo) values ('Cadastrar e editar dados de processos');
insert into tb_permissao (s_titulo) values ('Gerenciar pastas');
insert into tb_permissao (s_titulo) values ('Gerenciar grupos de usuários');
insert into tb_permissao (s_titulo) values ('Excluir usuário');
insert into tb_permissao (s_titulo) values ('Excluir cliente');
insert into tb_permissao (s_titulo) values ('Calculadora');
insert into tb_permissao (s_titulo) values ('Calendário');
*/

/*
delete from tb_endereco;
delete from tb_contato;
delete from tb_agenda_grupo;
delete from tb_processos;
delete from tb_pasta;
delete from tb_load;
delete from tb_pess_fisica;
delete from tb_pess_juridica;
delete from tb_usuario;
*/



insert into tb_permissao (pk_permissao,s_titulo) values (1, 'Cadastrar e editar novo usuário');
insert into tb_permissao (pk_permissao,s_titulo) values (2, 'Cadastrar e editar novo cliente');
insert into tb_permissao (pk_permissao,s_titulo) values (3, 'Cadastrar e editar dados de processos');
insert into tb_permissao (pk_permissao,s_titulo) values (4, 'Gerenciar pastas');
insert into tb_permissao (pk_permissao,s_titulo) values (5, 'Gerenciar grupos de usuários');
insert into tb_permissao (pk_permissao,s_titulo) values (6, 'Excluir usuário');
insert into tb_permissao (pk_permissao,s_titulo) values (7, 'Excluir cliente');
insert into tb_permissao (pk_permissao,s_titulo) values (8, 'Calculadora');
insert into tb_permissao (pk_permissao,s_titulo) values (9, 'Calendário');

insert into tb_agenda_grupo (s_grupo_nome, s_descricao) values ('Geral', 'Grupo destinado a contatos gerais, e de acesso público');

/*
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (8, 5);
*/

/*
Tabelas a serem criadas - PROCESSO
Sigla_Processo
Status_Processo
Escritorio_Associado
Instancia do Processo
*/



