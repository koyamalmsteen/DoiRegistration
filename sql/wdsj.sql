CREATE TABLE iugonet(
       doi_suffix CHAR(255) UNIQUE NOT NULL,
       version INTEGER NOT NULL,
       user_id INTEGER NOT NULL,
       metadata TEXT NOT NULL,
       PRIMARY KEY (doi_suffix, version, user_id)
);

INSERT INTO iugonet VALUE('A1',1,'C1','D1');
INSERT INTO iugonet VALUE('A2',2,'C2','D2');
INSERT INTO iugonet VALUE('A3',3,'C3','D3');

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
INSERT INTO jalc VALUE('E3',3,'G3','H3');

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
INSERT INTO html VALUE('I3',3,'K3','L3');

--

-- CREATE TRIGGER trigger_iugonet_insert AFTER INSERT ON tbl_name FOR EACH ROW trigger_stmt
-- CREATE TRIGGER trigger_iugonet_update AFTER UPDATE ON tbl_name FOR EACH ROW trigger_stmt
-- CREATE TRIGGER trigger_iugonet_delete AFTER DELETE ON tbl_name FOR EACH ROW trigger_stmt

--

-- CREATE FUNCTION iugonet2jalc 
-- CREATE FUNCTION iugonet2html 