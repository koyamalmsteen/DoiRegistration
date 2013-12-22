CREATE TABLE jalc(

       doi_suffix INTEGER UNIQUE NOT NULL,
       version INTEGER NOT NULL,
       user_id INTEGER NOT NULL,
       metadata TEXT NOT NULL,
       PRIMARY KEY (doi_suffix, version, user_id)
);

INSERT INTO jalc VALUE(1,1,'A1','B1');
INSERT INTO jalc VALUE(2,2,'A2','B2');
INSERT INTO jalc VALUE(3,3,'A3','B3');
INSERT INTO jalc VALUE(4,4,'A4','B4');

--

CREATE TABLE iugonet(
       doi_suffix INTEGER UNIQUE NOT NULL,
       version INTEGER NOT NULL,
       user_id INTEGER NOT NULL,
       metadata TEXT NOT NULL,
       PRIMARY KEY (doi_suffix, version, user_id)
);

INSERT INTO iugonet VALUE(1,1,'C1','D1');
INSERT INTO iugonet VALUE(2,2,'C2','D2');
INSERT INTO iugonet VALUE(3,3,'C3','D3');
INSERT INTO iugonet VALUE(4,4,'C4','D4');

--

CREATE TABLE html(
       doi_suffix INTEGER UNIQUE NOT NULL,
       version INTEGER NOT NULL,
       user_id INTEGER NOT NULL,
       html TEXT NOT NULL,
       PRIMARY KEY (doi_suffix, version, user_id)
);

INSERT INTO landingPage VALUE(1,1,'E1','F1');
INSERT INTO landingPage VALUE(2,2,'E2','F2');
INSERT INTO landingPage VALUE(3,3,'E3','F3');
INSERT INTO landingPage VALUE(4,4,'E4','F4');

--

-- CREATE TRIGGER trigger_iugonet_insert AFTER INSERT ON tbl_name FOR EACH ROW trigger_stmt
-- CREATE TRIGGER trigger_iugonet_update AFTER UPDATE ON tbl_name FOR EACH ROW trigger_stmt
-- CREATE TRIGGER trigger_iugonet_delete AFTER DELETE ON tbl_name FOR EACH ROW trigger_stmt

--

-- CREATE FUNCTION iugonet2jalc 
-- CREATE FUNCTION iugonet2html 