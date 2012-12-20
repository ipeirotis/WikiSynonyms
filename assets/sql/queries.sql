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
