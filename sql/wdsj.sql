CREATE TABLE doc_type(
       doc_type_id INTEGER unique not null,
       doc_type CHAR(255) unique not null,
       PRIMARY KEY (doc_type_id)
);

INSERT INTO doc_type VALUES(1,'IUGONET');
INSERT INTO doc_type VALUES(2,'JaLC');
INSERT INTO doc_type VALUES(3,'XHTML');

--

CREATE TABLE doc(
       doi_suffix CHAR(255) UNIQUE NOT NULL,	
       version INTEGER NOT NULL,
       user_id INTEGER NOT NULL,
       doc_type_id INTEGER NOT NULL,
       document TEXT NOT NULL,
       PRIMARY KEY (doi_suffix, version, user_id, doc_type_id),
       FOREIGN KEY (doc_type_id) REFERENCES doc_type(doc_type_id)
);

/*
CREATE TABLE iugonet(
       doi_suffix CHAR(255) UNIQUE NOT NULL,
       version INTEGER NOT NULL,
       user_id INTEGER NOT NULL,
       metadata TEXT NOT NULL,
       PRIMARY KEY (doi_suffix, version, user_id)
);

INSERT INTO iugonet VALUE('A1',1,'C1','D1');
INSERT INTO iugonet VALUE('A2',2,'C2','D2');

--

CREATE TABLE jalc(

       doi_suffix CHAR(255) UNIQUE NOT NULL,
       version INTEGER NOT NULL,
       user_id INTEGER NOT NULL,
       metadata TEXT NOT NULL,
       PRIMARY KEY (doi_suffix, version, user_id)
);

INSERT INTO jalc VALUE('E1',1,'G1','H1');
INSERT INTO jalc VALUE('E2',2,'G2','H2');

--

CREATE TABLE html(
       doi_suffix CHAR(255) UNIQUE NOT NULL,
       version INTEGER NOT NULL,
       user_id INTEGER NOT NULL,
       html TEXT NOT NULL,
       PRIMARY KEY (doi_suffix, version, user_id)
);

INSERT INTO html VALUE('I1',1,'K1','L1');
INSERT INTO html VALUE('I2',2,'K2','L2');

--
*/