CREATE TABLE /*_*/odesk_skills (
  skill varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL PRIMARY KEY,
  pretty_name varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  external_link varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  description TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  wikipedia_page_id int NULL DEFAULT NULL,
  freebase_machine_id varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
)
DEFAULT CHARSET=utf8
COLLATE = utf8_general_ci;

CREATE INDEX /*i*/os_pretty_name ON /*_*/odesk_skills (pretty_name);
