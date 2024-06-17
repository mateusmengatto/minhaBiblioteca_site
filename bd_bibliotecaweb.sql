CREATE DATABASE bibliotecaweb;
USE bibliotecaweb;


CREATE TABLE Usuario (
    userId integer AUTO_INCREMENT PRIMARY KEY,
    userName varchar(50) UNIQUE,
    email varchar (100) UNIQUE, -- Email should be unique
    senha char (60),
    nome varchar (100),
    funcao integer
);

CREATE TABLE Livro (
    bookId integer PRIMARY KEY,
    titulo varchar (200),
    autor varchar(50),
    editora varchar(50),
    dataPubli date,
    ISBN char (13) UNIQUE,-- ISBN should be unique
    capa text,
    arquivo text
);

CREATE TABLE Favoritos (
    FK_bookId integer,
    FK_userId integer,
    PRIMARY KEY (FK_bookId, FK_userId),
    FOREIGN KEY (FK_bookId) REFERENCES Livro (bookId),  -- Foreign key for Livro
    FOREIGN KEY (FK_userId) REFERENCES Usuario (userId)  -- Foreign key for Usuario
);

--CREATE TABLE Comentarios (
--	comentarioId integer PRIMARY KEY,
--   FK_bookId integer,
--    FK_userId integer,
--    comentario varchar (500),
--   dataHora date,
--   FOREIGN KEY (FK_bookId) REFERENCES Livro (bookId),  -- Foreign key for Livro
--    FOREIGN KEY (FK_userId) REFERENCES Usuario (userId)  -- Foreign key for Usuario
--);

--CREATE TABLE Categorias (
--    categId integer PRIMARY KEY,
--    categoria varchar (50) UNIQUE -- Category should be unique
--);

--CREATE TABLE CategoriaLivro (
--    FK_categId integer,
--    FK_bookId integer,
--    PRIMARY KEY (FK_categId, FK_bookId),
--    FOREIGN KEY (FK_categId) REFERENCES Categorias (categId),  -- Foreign key for Categorias
--    FOREIGN KEY (FK_bookId) REFERENCES Livro (bookId)   -- Foreign key for Livro
--);


--CREATE TABLE Avaliacoes (
--    avaliacaoId INT NOT NULL AUTO_INCREMENT,
--    FK_bookId INT,
--    FK_userId INT,
--    avaliacao INT,
--    dataHoraAvaliacao DATETIME,
--    PRIMARY KEY (avaliacaoId),
--    FOREIGN KEY (FK_bookId) REFERENCES Livro (bookId),
--    FOREIGN KEY (FK_userId) REFERENCES Usuario (userId)
-- );
