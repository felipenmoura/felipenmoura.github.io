
create sequence agencia_seq;

create table tb_agencia (
	pk_agencia int8 default nextval('agencia_seq') not null primary key,
	s_nome varchar(80) not null,
	dt_update date default now()
			);

create sequence grupo_seq;

create table tb_grupo (
	pk_grupo int8 default nextval('grupo_seq') not null primary key,
	fk_agencia int8 not null,
	dt_update date default now(),
	s_label varchar(20) unique,
	foreign key (fk_agencia) references tb_agencia
			);

create sequence usuario_seq;

create sequence estado_civil_seq;
create table tb_estado_civil
(
	pk_estado_civil int8 not null default nextval('estado_civil_seq') primary key,
	s_estado_civil varchar(32),
	bl_status char(1) default '1'
);

CREATE TABLE tb_usuario
(
  pk_usuario int8 NOT NULL DEFAULT nextval('usuario_seq'::regclass),
  s_usuario varchar(80),
  dt_update date DEFAULT now(),
  s_login varchar(20),
  s_senha varchar(40),
  bl_status int2 DEFAULT 1,
  bl_cliente int2 DEFAULT 0,
  bl_tipo_pessoa char(1),
  c_sexo char(2), -- Sexo do usuario
  CONSTRAINT tb_usuario_pkey PRIMARY KEY (pk_usuario)
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

create sequence endereco_seq;

create table tb_endereco (
	pk_endereco int8 default nextval('endereco_seq') not null primary key,
	fk_usuario int8 not null,
	s_rua varchar(80) ,
	s_complemento varchar(80),
	i_numero int,
	s_bairro varchar(80),
	s_cidade varchar(80),
	s_uf char(2),
	dt_update date default now(),
	foreign key(fk_usuario) references tb_usuario
			);
create sequence contato_seq;

create table tb_contato (
	pk_contato int8 default nextval('contato_seq') not null primary key,
	fk_usuario int8 not null,
	s_mail1 varchar(80),
	s_mail2 varchar(80),
	s_fone_res varchar(25),
	s_fone_com varchar(25),
	s_fone_cel varchar(25),
	s_ref_nome varchar(80),
	s_ref_fone varchar(25),
	s_website varchar(120),
	dt_update date default now(),
	foreign key(fk_usuario) references tb_usuario
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

create sequence agenda_grupo_seq;

create table tb_agenda_grupo
(
	pk_agenda_grupo int8 default nextval('agenda_grupo_seq') not null primary key,
	s_grupo_nome varchar(80) not null,
	s_descricao varchar(1024),
	fk_usuario int8,
	foreign key(fk_usuario) references tb_usuario
);

create sequence agenda_contatos_seq;

create table tb_agenda_contatos
(
	pk_contato int8 default nextval('agenda_contatos_seq') not null primary key,
	fk_agenda_grupo int8 not null,
	s_nome varchar(120),
	s_email_1 varchar(160),
	s_email_2 varchar(160),
	s_telefone_1 varchar(15),
	s_telefone_2 varchar(15),
	s_telefone_3 varchar(15),
	s_endereco varchar(160),
	s_nro varchar(9),
	s_complemento varchar(40),
	s_cidade varchar(60),
	s_bairro varchar(60),
	s_estado varchar(2),
	s_pais varchar(40),
	s_obs text,
	s_privacidade char(1) default 'I',
	foreign key(fk_agenda_grupo) references tb_agenda_grupo
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

CREATE SEQUENCE cep_seq;
CREATE TABLE tb_cep
(
  pk_cep int8 DEFAULT NEXTVAL('cep_seq') PRIMARY KEY,
  s_logradouro VARCHAR (255),
  s_bairro VARCHAR (255),
  s_cidade VARCHAR (255),
  s_estado_sigla CHAR (2),
  s_estado_nome VARCHAR (255),
  s_pais VARCHAR (255),
  s_cep CHAR(9)
)

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

create table tb_processos
(
	pk_processos int8 default nextval('processos_seq') not null primary key,
	fk_pasta int8 not null,
	s_nome varchar(80),
	dt_update date default now(),
	dt_criacao date,
	fk_criador int8,
	i_user_atualizacao int8,
	foreign key (fk_pasta) references tb_pasta
);

--PESSOA FISICA
CREATE SEQUENCE pess_fisica_seq;
CREATE TABLE tb_pess_fisica
(
  pk_pes_fisica int8 NOT NULL DEFAULT nextval('pess_fisica_seq') primary key,
  fk_usuario int8 NOT NULL,
  cpf varchar(14) NOT NULL,
  ddd_principal integer NOT NULL,
  telefone_principal varchar(40) NOT NULL,
  ddd_cel integer NOT NULL,
  num_celular varchar (40),
  endereco varchar (40),
  bairro varchar (40), 
  numero varchar (40),
  complemento varchar (200),		
  cep varchar (15),
  cidade varchar (50),
  uf varchar (2),
  pais varchar (50),	
  email_1 varchar(80),
  email_2 varchar (80),
  fk_estado_civil int8 not null,
  foreign key (fk_usuario) references tb_usuario
  foreign key (fk_estado_civil) references tb_estado_civil
);

-- PESSOA JURIDICA

CREATE SEQUENCE pess_juridica_seq;
CREATE TABLE tb_pess_juridica
(
  pk_pes_juridica int8 NOT NULL DEFAULT nextval('pess_juridica_seq') primary key,
  fk_usuario int8 NOT NULL,
  razao_social varchar (100) NOT NULL,
  nome_fantasia varchar (100) NOT NULL,
  inscr_estadual varchar (50),
  inscr_municipal varchar (50),
  cnpj varchar(14) NOT NULL,
  ramo_atividade varchar (100) ,
  ddd_principal integer NOT NULL,
  telefone_principal varchar(40) NOT NULL,
  ddd_secundario integer NOT NULL,
  num_secundario varchar (40),
  web_site varchar (200),
  endereco varchar (40),
  bairro varchar (40), 
  numero varchar (40),
  complemento varchar (200),		
  cep varchar (15),
  cidade varchar (50),
  uf varchar (2),
  pais varchar (50),	
  email_1 varchar(80),
  email_2 varchar (80),
  foreign key (fk_usuario) references tb_usuario
);

-- FUNCIONARIO
CREATE SEQUENCE funcionario_seq;
CREATE TABLE tb_funcionario
(
  pk_funcionario int8 NOT NULL DEFAULT nextval('funcionario_seq') primary key,
  fk_usuario int8 NOT NULL,
  foreign key (fk_usuario) references tb_usuario
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

CREATE TRIGGER usuario_agenda AFTER INSERT ON tb_usuario
  FOR EACH ROW EXECUTE PROCEDURE func_usuario_agenda_grupo();

CREATE or replace FUNCTION func_usuario_end_cont() RETURNS trigger AS $usuarioData$
  begin
	insert into tb_endereco (fk_usuario) values (NEW.pk_usuario);
	insert into tb_contato (fk_usuario) values (NEW.pk_usuario);
	return new;
  end;
$usuarioData$ language plpgsql;

CREATE TRIGGER usuario_data AFTER INSERT ON tb_usuario
  FOR EACH ROW EXECUTE PROCEDURE func_usuario_end_cont();

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

insert into tb_agencia (s_nome) values ('Marcio Pletz Advogados');

insert into tb_usuario (pk_usuario, s_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa, c_sexo) values (1, 'Marcio Pletz','marcio','1234', 0, 'J', 'm');
insert into tb_usuario (pk_usuario, s_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa, c_sexo) values (2, 'Felipe Nascimento de Moura','felipe','1234', 0, 'F', 'm');
insert into tb_usuario (pk_usuario, s_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa, c_sexo) values (3, 'Jaydson Nascimento Gomes','jay','1234', 0, 'F', 'm');
insert into tb_usuario (pk_usuario, s_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa, c_sexo) values (4, 'Jonathan Nascimento Bach','jon','1234', 0, 'F', 'm');
insert into tb_usuario (pk_usuario, s_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa, c_sexo) values (5, 'F2J - Desenvolvimento WEB','f2j','123456', 0, 'J', NULL);
insert into tb_usuario (pk_usuario, s_usuario,s_login,s_senha, bl_cliente, bl_tipo_pessoa, c_sexo) values (6, 'Carolina','carolina','1234', 0, 'F', 'm');

insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (1, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (2, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (3, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (4, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (5, 1);
insert into tb_usuario_grupo (fk_usuario, fk_grupo) values (6, 1);

select setval ('usuario_grupo_seq', 7);
select setval ('usuario_seq', 7);

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

insert into tb_estado_civil (s_estado_civil) values ('Solteiro(a)');
insert into tb_estado_civil (s_estado_civil) values ('Casado(a)');
insert into tb_estado_civil (s_estado_civil) values ('Viúvo(a)');
insert into tb_estado_civil (s_estado_civil) values ('Divorciado(a)');
insert into tb_estado_civil (s_estado_civil) values ('Separado(a)');
insert into tb_estado_civil (s_estado_civil) values ('Marital');

insert into tb_permissao (pk_permissao,s_titulo) values (1, 'Cadastrar e editar novo usuário');
insert into tb_permissao (pk_permissao,s_titulo) values (2, 'Cadastrar e editar novo cliente');
insert into tb_permissao (pk_permissao,s_titulo) values (3, 'Cadastrar e editar dados de processos');
insert into tb_permissao (pk_permissao,s_titulo) values (4, 'Gerenciar pastas');
insert into tb_permissao (pk_permissao,s_titulo) values (5, 'Gerenciar grupos de usuários');
insert into tb_permissao (pk_permissao,s_titulo) values (6, 'Excluir usuário');
insert into tb_permissao (pk_permissao,s_titulo) values (7, 'Excluir cliente');
insert into tb_permissao (pk_permissao,s_titulo) values (8, 'Calculadora');
insert into tb_permissao (pk_permissao,s_titulo) values (9, 'Calendário');

/*
insert into tb_grupo_permissao (fk_permissao, fk_grupo) values (8, 5);
*/

