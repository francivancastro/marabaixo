create schema global;

CREATE SEQUENCE global.arquivo_tipo_id_arquivo_tipo_seq_1;

CREATE TABLE global.arquivo_tipo (
                id_arquivo_tipo INTEGER NOT NULL DEFAULT nextval('global.arquivo_tipo_id_arquivo_tipo_seq_1'),
                mime_type VARCHAR(100) NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                extensao VARCHAR(10) NOT NULL,
                CONSTRAINT arquivo_tipo_pk PRIMARY KEY (id_arquivo_tipo)
);


ALTER SEQUENCE global.arquivo_tipo_id_arquivo_tipo_seq_1 OWNED BY global.arquivo_tipo.id_arquivo_tipo;

CREATE SEQUENCE global.arquivo_id_arquivo_seq;

CREATE TABLE global.arquivo (
                id_arquivo INTEGER NOT NULL DEFAULT nextval('global.arquivo_id_arquivo_seq'),
                id_arquivo_tipo INTEGER NOT NULL,
                legenda VARCHAR(100) NOT NULL,
                nome_original VARCHAR(100) NOT NULL,
                tamanho INTEGER NOT NULL,
                data_upload DATE NOT NULL,
                hora_upload TIME NOT NULL,
                CONSTRAINT arquivo_pk PRIMARY KEY (id_arquivo)
);


ALTER SEQUENCE global.arquivo_id_arquivo_seq OWNED BY global.arquivo.id_arquivo;

CREATE SEQUENCE global.menu_id_menu_seq;

CREATE TABLE global.menu (
                id_menu INTEGER NOT NULL DEFAULT nextval('global.menu_id_menu_seq'),
                id_menu_superior INTEGER,
                controller VARCHAR(100),
                action VARCHAR(100),
                descricao VARCHAR NOT NULL,
                CONSTRAINT id_menu PRIMARY KEY (id_menu)
);


ALTER SEQUENCE global.menu_id_menu_seq OWNED BY global.menu.id_menu;

CREATE SEQUENCE global.pais_id_pais_seq_1;

CREATE TABLE global.pais (
                id_pais INTEGER NOT NULL DEFAULT nextval('global.pais_id_pais_seq_1'),
                codigo VARCHAR(20) NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                CONSTRAINT id_pais PRIMARY KEY (id_pais)
);


ALTER SEQUENCE global.pais_id_pais_seq_1 OWNED BY global.pais.id_pais;

CREATE SEQUENCE global.controller_id_controller_seq;

CREATE TABLE global.controller (
                id_controller INTEGER NOT NULL DEFAULT nextval('global.controller_id_controller_seq'),
                controller VARCHAR(100) NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                status CHAR(1) NOT NULL,
                CONSTRAINT id_controller PRIMARY KEY (id_controller)
);
COMMENT ON COLUMN global.controller.status IS 'A - ATIVO
I - INATIVO';


ALTER SEQUENCE global.controller_id_controller_seq OWNED BY global.controller.id_controller;

CREATE SEQUENCE global.controller_action_id_controller_action_seq;

CREATE TABLE global.controller_action (
                id_controller_action INTEGER NOT NULL DEFAULT nextval('global.controller_action_id_controller_action_seq'),
                id_controller INTEGER NOT NULL,
                action VARCHAR(100) NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                CONSTRAINT id_controller_action PRIMARY KEY (id_controller_action)
);


ALTER SEQUENCE global.controller_action_id_controller_action_seq OWNED BY global.controller_action.id_controller_action;

CREATE SEQUENCE global.componente_id_componente_seq;

CREATE TABLE global.componente (
                id_componente INTEGER NOT NULL DEFAULT nextval('global.componente_id_componente_seq'),
                descricao VARCHAR(100) NOT NULL,
                CONSTRAINT id_componente PRIMARY KEY (id_componente)
);


ALTER SEQUENCE global.componente_id_componente_seq OWNED BY global.componente.id_componente;

CREATE TABLE global.componente_controller (
                id_componente INTEGER NOT NULL,
                id_controller INTEGER NOT NULL,
                CONSTRAINT componente_controller_pk PRIMARY KEY (id_componente, id_controller)
);


CREATE SEQUENCE global.grupo_id_grupo_seq;

CREATE TABLE global.grupo (
                id_grupo INTEGER NOT NULL DEFAULT nextval('global.grupo_id_grupo_seq'),
                chave VARCHAR(20) NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                admin CHAR(1) NOT NULL,
                status CHAR(1) NOT NULL,
                CONSTRAINT id_grupo PRIMARY KEY (id_grupo)
);
COMMENT ON COLUMN global.grupo.admin IS 'S - SIM
N - NÃO';
COMMENT ON COLUMN global.grupo.status IS 'A - ATIVO
I - INATIVO';


ALTER SEQUENCE global.grupo_id_grupo_seq OWNED BY global.grupo.id_grupo;

CREATE TABLE global.permissao (
                id_controller_action INTEGER NOT NULL,
                id_grupo INTEGER NOT NULL,
                CONSTRAINT pk_permissao PRIMARY KEY (id_controller_action, id_grupo)
);


CREATE SEQUENCE global.nacionalidade_id_nacionalidade_seq_1;

CREATE TABLE global.nacionalidade (
                id_nacionalidade INTEGER NOT NULL DEFAULT nextval('global.nacionalidade_id_nacionalidade_seq_1'),
                chave VARCHAR(20) NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                CONSTRAINT id_nacionalidade PRIMARY KEY (id_nacionalidade)
);
COMMENT ON TABLE global.nacionalidade IS 'BR - BRASILEIRO
BN - BRASILEIRO NATURALIZADO
ES - ESTRANGEIRO';


ALTER SEQUENCE global.nacionalidade_id_nacionalidade_seq_1 OWNED BY global.nacionalidade.id_nacionalidade;

CREATE SEQUENCE global.pessoa_id_pessoa_seq;

CREATE TABLE global.pessoa (
                id_pessoa INTEGER NOT NULL DEFAULT nextval('global.pessoa_id_pessoa_seq'),
                tipo CHAR(2) NOT NULL,
                email VARCHAR(100) NOT NULL,
                CONSTRAINT id_pessoa PRIMARY KEY (id_pessoa)
);
COMMENT ON COLUMN global.pessoa.tipo IS 'PF - PESSOA FÍSICA
PJ - PESSOA JURÍDICA';


ALTER SEQUENCE global.pessoa_id_pessoa_seq OWNED BY global.pessoa.id_pessoa;

CREATE SEQUENCE global.pessoa_juridica_id_pessoa_juridica_seq_1;

CREATE TABLE global.pessoa_juridica (
                id_pessoa_juridica INTEGER NOT NULL DEFAULT nextval('global.pessoa_juridica_id_pessoa_juridica_seq_1'),
                id_pessoa INTEGER NOT NULL,
                cnpj VARCHAR(20) NOT NULL,
                sigla VARCHAR(20) NOT NULL,
                razao_social VARCHAR(100) NOT NULL,
                nome_fantasia VARCHAR(100) NOT NULL,
                id_arquivo_logo INTEGER,
                CONSTRAINT pessoa_juridica_pk PRIMARY KEY (id_pessoa_juridica)
);


ALTER SEQUENCE global.pessoa_juridica_id_pessoa_juridica_seq_1 OWNED BY global.pessoa_juridica.id_pessoa_juridica;

CREATE SEQUENCE global.config_id_config_seq;

CREATE TABLE global.config (
                id_config INTEGER NOT NULL DEFAULT nextval('global.config_id_config_seq'),
                sistema_nome VARCHAR(100) NOT NULL,
                sistema_sigla VARCHAR(20) NOT NULL,
                id_pessoa_juridica INTEGER NOT NULL,
                id_arquivo_logo INTEGER,
                CONSTRAINT id_config PRIMARY KEY (id_config)
);


ALTER SEQUENCE global.config_id_config_seq OWNED BY global.config.id_config;

CREATE SEQUENCE global.config_smtp_id_config_smtp_seq;

CREATE TABLE global.config_smtp (
                id_config_smtp INTEGER NOT NULL DEFAULT nextval('global.config_smtp_id_config_smtp_seq'),
                id_config INTEGER NOT NULL,
                email VARCHAR(100) NOT NULL,
                host VARCHAR(100) NOT NULL,
                port VARCHAR(10) NOT NULL,
                username VARCHAR(100) NOT NULL,
                password VARCHAR(100) NOT NULL,
                CONSTRAINT id_config_smtp PRIMARY KEY (id_config_smtp)
);


ALTER SEQUENCE global.config_smtp_id_config_smtp_seq OWNED BY global.config_smtp.id_config_smtp;

CREATE SEQUENCE global.pessoa_fisica_id_pessoa_fisica_seq_1;

CREATE TABLE global.pessoa_fisica (
                id_pessoa_fisica INTEGER NOT NULL DEFAULT nextval('global.pessoa_fisica_id_pessoa_fisica_seq_1'),
                id_nacionalidade INTEGER NOT NULL,
                id_pessoa INTEGER NOT NULL,
                cpf VARCHAR(11),
                passaporte VARCHAR(30),
                nome VARCHAR(100) NOT NULL,
                data_nascimento DATE NOT NULL,
                id_pais INTEGER NOT NULL,
                CONSTRAINT id_pessoa_fisica PRIMARY KEY (id_pessoa_fisica)
);


ALTER SEQUENCE global.pessoa_fisica_id_pessoa_fisica_seq_1 OWNED BY global.pessoa_fisica.id_pessoa_fisica;

CREATE SEQUENCE global.usuario_id_usuario_seq;

CREATE TABLE global.usuario (
                id_usuario INTEGER NOT NULL DEFAULT nextval('global.usuario_id_usuario_seq'),
                id_pessoa_fisica INTEGER NOT NULL,
                senha VARCHAR(100) NOT NULL,
                status CHAR(1) NOT NULL,
                CONSTRAINT id_usuario PRIMARY KEY (id_usuario)
);
COMMENT ON COLUMN global.usuario.status IS 'A - ATIVO
I - INATIVO';


ALTER SEQUENCE global.usuario_id_usuario_seq OWNED BY global.usuario.id_usuario;

CREATE TABLE global.usuario_grupo (
                id_grupo INTEGER NOT NULL,
                id_usuario INTEGER NOT NULL,
                CONSTRAINT pk_usuario_grupo PRIMARY KEY (id_grupo, id_usuario)
);


ALTER TABLE global.arquivo ADD CONSTRAINT arquivo_tipo_arquivo_fk
FOREIGN KEY (id_arquivo_tipo)
REFERENCES global.arquivo_tipo (id_arquivo_tipo)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.config ADD CONSTRAINT arquivo_config_fk
FOREIGN KEY (id_arquivo_logo)
REFERENCES global.arquivo (id_arquivo)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.pessoa_juridica ADD CONSTRAINT arquivo_pessoa_juridica_fk
FOREIGN KEY (id_arquivo_logo)
REFERENCES global.arquivo (id_arquivo)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.menu ADD CONSTRAINT menu_menu_fk
FOREIGN KEY (id_menu_superior)
REFERENCES global.menu (id_menu)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.pessoa_fisica ADD CONSTRAINT pais_pessoa_fisica_fk
FOREIGN KEY (id_pais)
REFERENCES global.pais (id_pais)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.controller_action ADD CONSTRAINT controller_controller_action_fk
FOREIGN KEY (id_controller)
REFERENCES global.controller (id_controller)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.componente_controller ADD CONSTRAINT controller_componente_controller_fk
FOREIGN KEY (id_controller)
REFERENCES global.controller (id_controller)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.permissao ADD CONSTRAINT controller_action_permissao_fk
FOREIGN KEY (id_controller_action)
REFERENCES global.controller_action (id_controller_action)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.componente_controller ADD CONSTRAINT componente_componente_controller_fk
FOREIGN KEY (id_componente)
REFERENCES global.componente (id_componente)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.usuario_grupo ADD CONSTRAINT grupo_usuario_grupo_fk
FOREIGN KEY (id_grupo)
REFERENCES global.grupo (id_grupo)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.permissao ADD CONSTRAINT grupo_permissao_fk
FOREIGN KEY (id_grupo)
REFERENCES global.grupo (id_grupo)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.pessoa_fisica ADD CONSTRAINT nacionalidade_pessoa_fisica_fk
FOREIGN KEY (id_nacionalidade)
REFERENCES global.nacionalidade (id_nacionalidade)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.pessoa_fisica ADD CONSTRAINT pessoa_pessoa_fisica_fk
FOREIGN KEY (id_pessoa)
REFERENCES global.pessoa (id_pessoa)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.pessoa_juridica ADD CONSTRAINT pessoa_pessoa_juridica_fk
FOREIGN KEY (id_pessoa)
REFERENCES global.pessoa (id_pessoa)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.config ADD CONSTRAINT pessoa_juridica_config_fk
FOREIGN KEY (id_pessoa_juridica)
REFERENCES global.pessoa_juridica (id_pessoa_juridica)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.config_smtp ADD CONSTRAINT config_config_smtp_fk
FOREIGN KEY (id_config)
REFERENCES global.config (id_config)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.usuario ADD CONSTRAINT pessoa_fisica_usuario_fk
FOREIGN KEY (id_pessoa_fisica)
REFERENCES global.pessoa_fisica (id_pessoa_fisica)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE global.usuario_grupo ADD CONSTRAINT usuario_usuario_grupo_fk
FOREIGN KEY (id_usuario)
REFERENCES global.usuario (id_usuario)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;
