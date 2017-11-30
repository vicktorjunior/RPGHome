
/* Drop Tables */

DROP TABLE IF EXISTS personagens;
DROP TABLE IF EXISTS classes;
DROP TABLE IF EXISTS partidas;
DROP TABLE IF EXISTS missoes;
DROP TABLE IF EXISTS mapas;
DROP TABLE IF EXISTS monstros;
DROP TABLE IF EXISTS usuarios;




/* Create Tables */

CREATE TABLE classes
(
	id_classe serial NOT NULL,
	nome_classe text NOT NULL UNIQUE,
	historia text NOT NULL,
	PRIMARY KEY (id_classe)
) WITHOUT OIDS;


CREATE TABLE mapas
(
	id_mapa serial NOT NULL,
	nome_mapa text NOT NULL UNIQUE,
	tipo_terreno text NOT NULL,
	PRIMARY KEY (id_mapa)
) WITHOUT OIDS;


CREATE TABLE missoes
(
	id_missao serial NOT NULL,
	nome_missao text NOT NULL UNIQUE,
	qtd_personagens int NOT NULL,
	descricao text NOT NULL UNIQUE,
	id_mapa int NOT NULL,
	PRIMARY KEY (id_missao)
) WITHOUT OIDS;


CREATE TABLE monstros
(
	id_monstro serial NOT NULL,
	nome_monstro text NOT NULL UNIQUE,
	qtd_experiencia int NOT NULL,
	PRIMARY KEY (id_monstro)
) WITHOUT OIDS;


CREATE TABLE partidas
(
	id_partida serial NOT NULL,
	nome_partida text NOT NULL,
	data_inicio_partida timestamp NOT NULL,
	data_final_partida timestamp,
	id_missao int NOT NULL,
	PRIMARY KEY (id_partida)
) WITHOUT OIDS;


CREATE TABLE personagens
(
	id_personagem serial NOT NULL,
	nome_personagem text NOT NULL UNIQUE,
	nivel text NOT NULL,
	experiencia text NOT NULL,
	defesa text NOT NULL,
	stamina text NOT NULL,
	vida text NOT NULL,
	mana text NOT NULL,
	forca text NOT NULL,
	agilidade text NOT NULL,
	inteligencia text NOT NULL,
	vontade text NOT NULL,
	id_usuario int NOT NULL,
	id_classe int NOT NULL,
	PRIMARY KEY (id_personagem)
) WITHOUT OIDS;


CREATE TABLE usuarios
(
	id_usuario serial NOT NULL,
	usuario text NOT NULL UNIQUE,
	senha text NOT NULL,
	email text NOT NULL,
	PRIMARY KEY (id_usuario)
) WITHOUT OIDS;



/* Create Foreign Keys */

ALTER TABLE personagens
	ADD FOREIGN KEY (id_classe)
	REFERENCES classes (id_classe)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE missoes
	ADD FOREIGN KEY (id_mapa)
	REFERENCES mapas (id_mapa)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE partidas
	ADD FOREIGN KEY (id_missao)
	REFERENCES missoes (id_missao)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE personagens
	ADD FOREIGN KEY (id_usuario)
	REFERENCES usuarios (id_usuario)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;



