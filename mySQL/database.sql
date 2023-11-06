DROP DATABASE IF EXISTS eleicao;

CREATE DATABASE IF NOT EXISTS eleicao;

USE eleicao;

CREATE TABLE
    IF NOT EXISTS candidatos (
        id INT NOT NULL AUTO_INCREMENT,
        numero_candidato INT NOT NULL,
        nome_candidato VARCHAR(255) NOT NULL,
        votos INT NOT NULL DEFAULT 0,
        PRIMARY KEY (id)
    );

CREATE TABLE
    IF NOT EXISTS votantes (
        id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    );

CREATE TABLE
    IF NOT EXISTS estudantes (
        id INT NOT NULL AUTO_INCREMENT,
        nome_estudante VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        senha VARCHAR(64) NOT NULL,
        PRIMARY KEY (id)
    );

INSERT INTO
    estudantes (id, nome_estudante, email, senha)
VALUES
    (1, 'admin', 'admin@aluno.ifsp.edu.br', 'admin'),
    (
        2,
        'Matheus',
        'matheus.ginebro@aluno.ifsp.edu.br',
        'M4th3us@'
    );

INSERT INTO
    candidatos (numero_candidato, nome_candidato)
VALUES
    (1, 'Camargo'),
    (2, 'João'),
    (3, 'Victor Hugo'),
    (4, 'Vicente Santos');

select
    *
from
    candidatos;

select
    *
from
    votantes;

select
    *
from
    estudantes;