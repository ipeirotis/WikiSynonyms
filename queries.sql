SELECT s.rd_from as sid, t.page_id as tid, p.page_namespace as snamespace, t.page_namespace as tnamespace, p.page_title as stitle, t.page_title as ttitle 
FROM redirect s 
JOIN page p ON (s.rd_from = p.page_id)
JOIN page t ON (s.rd_namespace = t.page_namespace AND s.rd_title = t.page_title)
WHERE 1


INSERT IGNORE INTO page_relation
SELECT s.rd_from as sid, t.page_id as tid, p.page_namespace as snamespace, t.page_namespace as tnamespace, p.page_title as stitle, t.page_title as ttitle 
FROM redirect s 
JOIN page p ON (s.rd_from = p.page_id)
JOIN page t ON (s.rd_namespace = t.page_namespace AND s.rd_title = t.page_title)
WHERE 1


SELECT p.page_id FROM page p JOIN page_relation pr ON (p.page_id = pr.tid) WHERE p.page_is_redirect = 1;


CREATE INDEX ix_sid ON page_relation (sid)
  
CREATE INDEX ix_tid ON page_relation (tid)

ALTER TABLE page_relation ADD stitle_cs varchar(255);
ALTER TABLE page_relation MODIFY
    stitle_cs VARCHAR(255)
      CHARACTER SET latin1
      COLLATE latin1_general_cs;

UPDATE page_relation SET stitle_cs = stitle;
CREATE INDEX ix_stitle_cs ON DB_NAME.page_relation (stitle_cs);

ALTER TABLE page_relation ADD ttitle_cs varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs;
ALTER TABLE page_relation MODIFY
    ttitle_cs VARCHAR(255)
      CHARACTER SET latin1
      COLLATE latin1_general_cs;

UPDATE page_relation SET ttitle_cs = ttitle;
CREATE INDEX ix_ttitle_cs ON DB_NAME.page_relation (ttitle_cs);