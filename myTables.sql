--
-- Core of the wiki: each page has an entry here which identifies
-- it by title and contains some essential metadata.
--
CREATE TABLE /*_*/page (
  -- Unique identifier number. The page_id will be preserved across
  -- edits and rename operations, but not deletions and recreations.
  page_id int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,

  -- A page name is broken into a namespace and a title.
  -- The namespace keys are UI-language-independent constants,
  -- defined in includes/Defines.php
  page_namespace int NOT NULL,

  -- The rest of the title, as text.
  -- Spaces are transformed into underscores in title storage.
  page_title varchar(255) binary NOT NULL,

  -- Comma-separated set of permission keys indicating who
  -- can move or edit the page.
  page_restrictions tinyblob NOT NULL,

  -- Number of times this page has been viewed.
  page_counter bigint unsigned NOT NULL default 0,

  -- 1 indicates the article is a redirect.
  page_is_redirect tinyint unsigned NOT NULL default 0,

  -- 1 indicates this is a new entry, with only one edit.
  -- Not all pages with one edit are new pages.
  page_is_new tinyint unsigned NOT NULL default 0,

  -- Random value between 0 and 1, used for Special:Randompage
  page_random real unsigned NOT NULL,

  -- This timestamp is updated whenever the page changes in
  -- a way requiring it to be re-rendered, invalidating caches.
  -- Aside from editing this includes permission changes,
  -- creation or deletion of linked pages, and alteration
  -- of contained templates.
  page_touched binary(14) NOT NULL default '',

  -- Handy key to revision.rev_id of the current revision.
  -- This may be 0 during page creation, but that shouldn't
  -- happen outside of a transaction... hopefully.
  page_latest int unsigned NOT NULL,

  -- Uncompressed length in bytes of the page's current source text.
  page_len int unsigned NOT NULL
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/name_title ON /*_*/page (page_namespace,page_title);
CREATE INDEX /*i*/page_random ON /*_*/page (page_random);
CREATE INDEX /*i*/page_len ON /*_*/page (page_len);
CREATE INDEX /*i*/page_redirect_namespace_len ON /*_*/page (page_is_redirect, page_namespace, page_len);


-- For each redirect, this table contains exactly one row defining its target
CREATE TABLE /*_*/redirect (
  -- Key to the page_id of the redirect page
  rd_from int unsigned NOT NULL default 0 PRIMARY KEY,

  -- Key to page_namespace/page_title of the target page.
  -- The target page may or may not exist, and due to renames
  -- and deletions may refer to different page records as time
  -- goes by.
  rd_namespace int NOT NULL default 0,
  rd_title varchar(255) binary NOT NULL default '',
  rd_interwiki varchar(32) default NULL,
  rd_fragment varchar(255) binary default NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/rd_ns_title ON /*_*/redirect (rd_namespace,rd_title,rd_from);





--==============================--

CREATE TABLE page_relation (
  sid int unsigned NOT NULL default 0,
  tid int unsigned NOT NULL default 0,
  snamespace int NOT NULL,
  tnamespace int NOT NULL,
  stitle varchar(255) binary NOT NULL,
  ttitle varchar(255) binary NOT NULL,
  PRIMARY KEY (sid, tid)
) CHARACTER SET utf8 COLLATE utf8_general_ci;



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

-- 
-- SELECT *
-- INTO page_relation o
-- FROM (
-- SELECT s.rd_from as sid, t.page_id as tid, p.page_namespace as snamespace, t.page_namespace as tnamespace, p.page_title as stitle, t.page_title as ttitle 
-- FROM redirect s 
-- JOIN page p ON (s.rd_from = p.page_id)
-- JOIN page t ON (s.rd_namespace = t.page_namespace AND s.rd_title = t.page_title)
-- )



--TEST DATA --

INSERT INTO `page` (`page_id`, `page_namespace`, `page_title`, `page_is_redirect`) VALUES
(1, 0, 'UK', 1),
(2, 0, 'UnitedKindom', 1),
(3, 0, 'Gbr', 1),
(4, 0, 'United_Kindom', 0),
(5, 0, 'GB', 1),
(6, 0, 'Car', 1),
(7, 0, 'Automobile', 0);


INSERT INTO `redirect` (`rd_from`, `rd_namespace`, `rd_title`) VALUES
(6, 0, 'Car'),
(3, 0, 'Gbr'),
(5, 0, 'GB'),
(1, 0, 'UK'),
(2, 0, 'United_Kindom');



SELECT p.page_id FROM page p JOIN page_relation pr ON (p.page_id = pr.tid) WHERE p.page_is_redirect = 1;



CREATE INDEX ix_sid ON page_relation (sid)
  
CREATE INDEX ix_tid ON page_relation (tid)