wikiSyno
========

Build a synonym table from Wikipedia
------------------------------------

1. Download a Wikipedia dump using the instructions at http://en.wikipedia.org/wiki/Wikipedia:Database_download and store it in a MySQL database.

2. The Wikipedia is stored in a relational database, using the following schema. http://www.mediawiki.org/wiki/Manual:Database_layout  We are only interested in two tables: "Page" and "Redirect" (see the lower right part of the schema). You can find the necessary files at http://dumps.wikimedia.org/enwiki/latest/ which allow you to download each table individually.

The documentation for the redirect table is at http://www.mediawiki.org/wiki/Manual:Redirect_table
The SQL file for creating the redirect table in a MySQL database is at http://dumps.wikimedia.org/enwiki/latest/enwiki-latest-redirect.sql.gz
It is a 75Mb compressed file (~250Mb uncompressed)

The documentation for the page table is at http://www.mediawiki.org/wiki/Manual:Page_table
The SQL file for creating the page table in a MySQL database is at http://dumps.wikimedia.org/enwiki/latest/enwiki-latest-page.sql.gz
It is a 860Mb compressed file (~2.5Gb uncompressed)

3. Create a MySQL database with these two tables.

4. Using the redirect table, and the page table, we want a two column output that lists which page redirects to which. We need:
a. The page_id of the "from" page [from the "redirect" table]
b. The namespace and title of the "from" page [taken from the "page" table]
c. The namespace and title of the "to" page [taken from the "redirect" table]
d. The page_id of the "to" page (to which the page redirects) [taken from the "page" table]

5. Using the table created in Step 4, we want to have web service that:
a. takes as input a term
b. checks if the term exists in Wikipedia (as title either for a page or for a redirect)
b1. if it does not exist, returns an empty response, potentially with an error message
c. if the terms exists as a page/redirect, checks if it is a base page or a redirect page
c1. if it is a redirect page, find the base page that this term redirects to and then perform step 5 again until finding a base page
d. using the base page title, return as synonyms all the terms that redirect *to* this base page

[Required component: The Steps 1-3 should be "almost automated". This means that there should be a script that we can run every month that fetches the new data from Wikipedia and updates the tables with the newest available data]

[Optional component: Check for disambiguation pages, using the "category" table in Wikipedia, and marking as disambiguation pages all pages within http://en.wikipedia.org/wiki/Category:Disambiguation_pages You will need to fetch a the extra necessary tables from http://dumps.wikimedia.org/enwiki/latest/ ]

[Optional component: Restrict the entries in the page table to be only entries for which we know to be an "oDesk skill" and we have a Wikipedia page. We will provide you with the dictionary of skills that we use within oDesk] 

Expand the Wikipedia Synonyms service as follows:
-------------------------------------------------

* Check for disambiguation pages, using the "category" table in Wikipedia, and marking as disambiguation pages all pages within http://en.wikipedia.org/wiki/Category:Disambiguation_pages You will need to fetch a the extra necessary tables from http://dumps.wikimedia.org/enwiki/latest/

* Import an "oDesk Skill" table and allow people to query and find synonyms for oDesk Skills (same service as the usual one, but restricted only to oDesk skills for querying). We will provide you with the dictionary of skills that we use within oDesk.

* Examine how we can best use the StackExchange API, to get synonyms and related tags. For example, for Java, we get back the following synonyms: https://api.stackexchange.com/2.0/tags/%7Bjava%7D/synonyms?order=desc&sort=creation&site=stackoverflow Documentation at https://api.stackexchange.com/docs/synonyms-by-tags

* Use Google Cloud SQL to store the tables and use Google App Engine to create the service.

* Check in Google App Engine whether it is possible to automate the downloading of the gzipped SQL files from Wikipedia, and automate their execution every month or so.

* Create a short public documentation of the service, using GitHub pages for hosting

Build
=====

<b> Steps 1-3:</b>
-------------------------------------------------------------------------------------------------------------------------------

<pre>
curl http://dumps.wikimedia.org/enwiki/latest/enwiki-latest-page.sql.gz -o page.sql.gz
gunzip page.sql.gz

curl http://dumps.wikimedia.org/enwiki/latest/enwiki-latest-redirect.sql.gz -o redirect.sql.gz
gunzip redirect.sql.gz

mysql --host=... --user=... --pass=... ipeirotis &lt; redirect.sql

mysql --host=... --user=... --pass=... ipeirotis &lt; page.sql
</pre>

These commands take approximately 2 hours to execute on Amazon RDS/MySQL (5 minutes for redirect.sql, two hours for page.sql), using the db.m2.4xlarge instance class. The tables are big, and you will need at least 10Gb free (preferably more, for peace of mind). Expect 6-7M entries in the redirect table and 27-30M entries for the page table.

Step 4: After you have a db you create the table described in No 4:
-------------------------------------------------------------------------------------------------------------------------------

<pre>
CREATE TABLE page_relation (
  sid int unsigned NOT NULL default 0,
  tid int unsigned NOT NULL default 0,
  snamespace int NOT NULL,
  tnamespace int NOT NULL,
  stitle varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  ttitle varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (sid, tid)
) 
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
</pre>

and after that you can populate that

<pre>INSERT IGNORE INTO page_relation
SELECT s.rd_from as sid, 
      t.page_id as tid, 
      p.page_namespace as snamespace,
      t.page_namespace as tnamespace, 
      p.page_title as stitle, 
      t.page_title as ttitle 
FROM redirect s 
JOIN page p ON (s.rd_from = p.page_id)
JOIN page t ON (s.rd_namespace = t.page_namespace AND s.rd_title = t.page_title)</pre>

This query will need approximately an hour to execute and the table will have 6M-7M entries. 

Since the queries will be executed mainly on that table, once you create the page_relation table, you will want to create indexes on all attributes

<pre>
CREATE INDEX ix_stitle ON ipeirotis.page_relation (stitle)

CREATE INDEX ix_ttitle ON ipeirotis.page_relation (ttitle)

CREATE INDEX ix_sid ON ipeirotis.page_relation (sid)
  
CREATE INDEX ix_tid ON ipeirotis.page_relation (tid)
</pre>

<b>Note!!!</b>

We do not need to worry about chains of redirects. The query

<pre>
SELECT
  sid,
	tid,
	snamespace,
	tnamespace,
	stitle,
	ttitle
FROM
	page_relation WHERE tid IN (SELECT sid FROM page_relation);
</pre>

returns very few results, which are already fixed in the actual Wikipedia (so there seems to be an automatic process that fixes that part)


Step 5: For this part of the project we created a mini platform with 2 actions (search and ajax).
-------------------------------------------------------------------------------------------------------------------------------

Search action implements a graphical representation of the search results whereas Ajax performs as service an return a json encoded data set.

A. Search

By visiting project/index.php you are asked to enter a term to search and if synonyms found they are return as an ordered list.

B. Ajax

By visiting project/index.php?action=ajax&term=OUR TERM the search results are returned as a json encoded array 
<pre>
{synonyms:[],total:NUM}
</pre>

The search is done by to queries (if needed) and 1 iteration of the first query results:

<pre>
SELECT * FROM page_relation WHERE (stitle = 'TERM' OR ttitle = 'TERM') AND snamespace = 0 AND tnamespace = 0;

SELECT * FROM page_relation WHERE tid IN ARRAY_OF_BASE_PAGE_IDS_FROM_ITERATION;
</pre>


Step 6: Enhancement: We added a feature to search disambiguation pages so we add extra synonyms when searching for a keyword.
-------------------------------------------------------------------------------------------------------------------------------
We use 1 query to determine if a page is a disambiguous one and if it is an extra one to fetch those page links.

<b>Determine if disambiguation:</b>

<pre>
SELECT categorylinks.cl_to 
FROM page 
JOIN categorylinks 
ON categorylinks.cl_from = page.page_id 
WHERE page.page_namespace = 0 AND page.page_title = 'OUR_PAGE_TITLE';
</pre>

<b>Fetch disambiguation page links:</b>

<pre>
SELECT * FROM pagelinks WHERE pl_namespace = 0 AND  pl_from = 'DISAMBIGUATION_PAGE_ID';
</pre>

thus we have a change in our service (ajax)
we now get a json encoded array result like this:
<pre>
{synonyms:[], disambiguation:[], total:NUM}
</pre>

~~<b>TODO: Enhance queries on 6 for faster results.</b>~~

<b>NEW!!! determine if disambiguation:</b>

<pre>
SELECT page.page_title as page, GROUP_CONCAT(categorylinks.cl_to) as categories 
FROM page 
JOIN categorylinks 
ON categorylinks.cl_from = page.page_id 
WHERE page.page_namespace = 0 AND page.page_title IN --ARRAY_OF_PAGES-- GROUP BY page.page_title;
</pre>

Step 7: Enhancement: Integrating with oDesk skills. (return extra ones that matches our query from the odesk skill table)
-------------------------------------------------------------------------------------------------------------------------------
<pre>
SELECT * FROM odesk_skills WHERE skill IN --ARRAY_OF_SYNONYMS_RETURNED_IN_STEP_5--
</pre>