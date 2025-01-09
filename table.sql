-- table 1
CREATE TABLE tbl_empresa (
    id_empresa INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_empresa)
);

-- table 2
CREATE TABLE tbl_conta_pagar(
    id_conta_pagar INT NOT NULL AUTO_INCREMENT,
    valor DECIMAL(10,2) NOT NULL ,
    data_pagar DATE NOT NULL,
    pago TINYINT DEFAULT 0,
    id_empresa INT NOT NULL,
    PRIMARY KEY (id_conta_pagar),
    FOREIGN KEY (id_empresa) REFERENCES tbl_empresa(id_empresa) ON DELETE CASCADE
);