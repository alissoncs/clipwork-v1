-- Cria a base de dados

CREATE DATABASE clipwork;
use clipwork;



-- Tabela usuário:
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `sobrenome` varchar(255),
  `email` varchar(255),
  `senha` varchar(100),
  `ativo` int(1),
  `email_notificacao` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- Inserção
INSERT INTO `usuario` (`nome`,`sobrenome`,`email`,`senha`)
VALUES ('Alisson','Carvalho', 'webalissoncs@gmail.com','6116afedcb0bc31083935c1c262ff4c9');

-- Tabela Projeto
CREATE TABLE IF NOT EXISTS `projeto` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`idusuario` int(11) NOT NULL,
	`nome` varchar(255) NOT NULL,
	`assunto` varchar(255),
	`descricao` text,
	`idtipo` int(11),
	`data` date,
	`atualizacao` date,

	-- informacoes adicionais
	`titulocompleto` text,
	`subtitulo` text,
	`entidade` text,
	`curso` text,
	`autores` text,
	`orientador` text,
	`coorientador` text,
	`cidade` varchar(255),
	`natureza` text,

	`resumo` text,
	`resumo_outra_lingua` text,
	`autosalvar` tinyint(1) NOT NULL DEFAULT 1,

	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `projeto` ADD CONSTRAINT `fk_projeto_usuario` FOREIGN KEY ( `idusuario` ) REFERENCES `usuario` ( `id` ) ;

-- Tabela Usuario incluido
CREATE TABLE IF NOT EXISTS `inclusao` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`idprojeto` int(11) NOT NULL,
	`idusuario` int(11) NOT NULL,

	`aceito` int(11) NOT NULL DEFAULT 0,

	-- permissoes
	`comentario` tinyint(1) NOT NULL DEFAULT 0,
	`referencia` tinyint(1) NOT NULL DEFAULT 0,
	`anexo` tinyint(1) NOT NULL DEFAULT 0,
	`pdf` tinyint(1) NOT NULL DEFAULT 0,
	`notas` tinyint(1) NOT NULL DEFAULT 0,
	`topico` tinyint(1) NOT NULL DEFAULT 0,

	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

	
	ALTER TABLE `inclusao` ADD CONSTRAINT `fk_projetoid`
	FOREIGN KEY ( `idprojeto` ) REFERENCES `projeto` ( `id` ) ;

	ALTER TABLE `inclusao` ADD CONSTRAINT `fk_usuarioid`
	FOREIGN KEY ( `idusuario` ) REFERENCES `usuario` ( `id` ) ;

-- Cria tabela notas -->  
CREATE TABLE IF NOT EXISTS `notas` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`idprojeto` int(11),
	`idusuario` int(11), 
	`assunto` varchar(255),
	`texto` text,
	`data` date,
	`hora` time,
	`ativo` int(1) NOT NULL,
	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
	ALTER TABLE `notas` ADD CONSTRAINT `fk_notas_projeto`
	FOREIGN KEY ( `idprojeto` ) REFERENCES `projeto` ( `id` ) ;
	ALTER TABLE `notas` ADD CONSTRAINT `fk_notas_usuario`
	FOREIGN KEY ( `idusuario` ) REFERENCES `usuario` ( `id` ) ;

-- cria tabela topico
CREATE TABLE IF NOT EXISTS `topico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprojeto` int(11) NOT NULL,
  `titulo` text,
  `html` text,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `idpai` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_topico_projeto` (`idprojeto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

	ALTER TABLE `topico` ADD CONSTRAINT `fk_topico_projeto`
	FOREIGN KEY (`idprojeto`) REFERENCES `projeto` (`id`);


CREATE TABLE IF NOT EXISTS `referencia`(
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`idprojeto` int(11) NOT NULL,
	`tipo` varchar(100),
	`titulo` text,

	`nomeautor1` varchar(200),
	`sobrenomeautor1` varchar(200),
	`nomeautor2` varchar(200),
	`sobrenomeautor2` varchar(200), 
		`maisautores` int(1),

	`url` text,
	`dataacesso` varchar(50),

	`editora` varchar(200),
	`edicao` varchar(10),
	`datalancamento` varchar(200),
	`local` varchar(250),
	`traducao` varchar(255),
	`paginalivro` varchar(100),

	`artigocaderno` text,

	`html` text,
	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
	ALTER TABLE `referencia` ADD CONSTRAINT `fk_ref_projeto`
	FOREIGN KEY ( `idprojeto` ) REFERENCES `projeto` ( `id` ) ;

CREATE TABLE IF NOT EXISTS `anexo` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`idprojeto` int(11) NOT NULL,
	`titulo` text,
	`html` text,
	`ordem` int(11),
	`tipo` varchar(50),
	PRIMARY KEY (`id`)
);
	ALTER TABLE `anexo` ADD CONSTRAINT `fk_anexo_projeto`
	FOREIGN KEY ( `idprojeto` ) REFERENCES `projeto` ( `id` ) ;

-- Tabela comentários
CREATE TABLE IF NOT EXISTS `comentario` (
	`id` int(11) AUTO_INCREMENT,
	`idusuario` int(11),
	`idprojeto` int(11) NOT NULL,
	`nomeusuario` varchar(200),
	`hora` time,
	`data` date,
	`titulo` varchar(200),
	`html` text,
	`referencia` varchar(200),
	`visibilidade` int(1),
	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

	ALTER TABLE `comentario` ADD CONSTRAINT `fk_comentario_projeto`
	FOREIGN KEY ( `idprojeto` ) REFERENCES `projeto` ( `id` ) ;

	ALTER TABLE `comentario` ADD CONSTRAINT `fk_comentario_usuario`
	FOREIGN KEY ( `idusuario` ) REFERENCES `usuario` ( `id` ) ;

CREATE TABLE IF NOT EXISTS `log_projeto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprojeto` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Log de projeto' AUTO_INCREMENT=1 ;

-- Tabelas de log __ CONTROLE 
CREATE TABLE IF NOT EXISTS `controle_login` (
	`id` int(11) AUTO_INCREMENT,
	`idusuario` int(11),
	`nomeusuario` varchar(200),
	`emailusuario` varchar(250),
	`hora` time,
	`data` date,
	`ip` varchar(100),
	`navegador` varchar(100),
	`so` varchar(100)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


	-- VISUALIZA COMENTARIO
	CREATE TABLE IF NOT EXISTS `visualiza_comentario` (
		`idcomentario` int(11) NOT NULL,
		`idusuario` int(11) NOT NULL
		);
	ALTER TABLE `visualiza_comentario` ADD CONSTRAINT `fkcomentario_c`
	FOREIGN KEY ( `idcomentario` ) REFERENCES `comentario` ( `id` ) ;

	ALTER TABLE `visualiza_comentario` ADD CONSTRAINT `fkcomentariousuario`
	FOREIGN KEY ( `idusuario` ) REFERENCES `usuario` ( `id` ) ;



DELIMITER $$
CREATE TRIGGER `deleta_projeto`
BEFORE DELETE
ON `projeto` 
FOR EACH ROW
	BEGIN
		DELETE FROM `topico` WHERE idprojeto = OLD.id;
		DELETE FROM `anexo` WHERE idprojeto = OLD.id;
		DELETE FROM `notas` WHERE idprojeto = OLD.id;
		DELETE FROM `comentario` WHERE idprojeto = OLD.id;
		DELETE FROM `inclusao` WHERE idprojeto = OLD.id;
		DELETE FROM `referencia` WHERE idprojeto = OLD.id;
	END$$

DELIMITER ;

	drop trigger `deleta_projeto`;