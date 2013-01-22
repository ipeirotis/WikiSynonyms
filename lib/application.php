<?php

class Application
{

  static function doConnect()
  {
    mysql_connect(DB_HOST, DB_USER, DB_PASS);
    @mysql_select_db(DB_CATALOG) or die("Unable to select database");
    $query = "SET NAMES 'utf8'";
    mysql_query($query);
  }

  static function doClose()
  {
    mysql_close();
  }

  static function getAllOdeskSkillsWithExternalLink()
  {
    $data = array();

    self::doConnect();

    $query = "SELECT * FROM odesk_skills WHERE external_link != ''";

    $result = mysql_query($query);

    if ($result) {
      while ($row = mysql_fetch_assoc($result)) {
        $data[] = $row;
      }
    }

    self::doClose();

    return $data;
  }

  static function getAllOdeskSkills()
  {
    $data = array();

    self::doConnect();

    $query = "SELECT * FROM odesk_skills WHERE 1";

    $result = mysql_query($query);

    if ($result) {
      while ($row = mysql_fetch_assoc($result)) {
        $data[] = $row;
      }
    }

    self::doClose();

    return $data;
  }

  static function getOdeskSkillsByTerm($term = null)
  {
    if (!$term) {
      return null;
    }

    $data = array();

    self::doConnect();

    $query = sprintf("SELECT * FROM odesk_skills WHERE skill = ('%s')", str_replace('_', '-', $term));

    $result = mysql_query($query);

    if ($result) {
      while ($row = mysql_fetch_assoc($result)) {
        $data[] = $row;
      }
    }

    self::doClose();

    return $data;
  }

  static function getOdeskSkillsByTerms($terms = array())
  {
    if (!$terms || empty($terms)) {
      return null;
    }

    $data = array();

    self::doConnect();

    $query = sprintf("SELECT * FROM odesk_skills WHERE skill IN ('%s')", str_replace('_', '-', implode("','", $terms)));

    $result = mysql_query($query);

    if ($result) {
      while ($row = mysql_fetch_assoc($result)) {
        $data[] = $row;
      }
    }

    self::doClose();

    return $data;
  }
  
  static function isOdeskSkill($term)
  {
    if (!$term) {
      return null;
    }

    $data = array();

    self::doConnect();

    $query = sprintf("SELECT * FROM odesk_skills WHERE external_link = '%s'", 'http://en.wikipedia.org/wiki/' . str_replace(' ', '_', $term));
    $result = mysql_query($query);
    $rows = mysql_num_rows($result);
    self::doClose();
    if ($rows > 0) {
      return true;
    }
    return false;
  }

  static function getOdeskSkillsWithExternalLinksIn($terms=array())
  {
    if (!$terms || empty($terms)) {
      return null;
    }
    $data = array();
    $terms_q_array = array();
    foreach ($terms as $term) {
      $terms_q_array[] = 'http://en.wikipedia.org/wiki/' . str_replace(' ', '_', $term['term']);
    }
    
    $query = sprintf("SELECT * FROM odesk_skills WHERE external_link IN ('%s')", implode("','", $terms_q_array));
//    die($query);
    $result = mysql_query($query);
    if ($result) {
      while ($row = mysql_fetch_assoc($result)) {
        $data[] = str_replace('http://en.wikipedia.org/wiki/', '', $row['external_link']);
      }
    }
    self::doClose();
    return $data;
  }

  /**
   * Function getDisambiguationLinks
   *
   * Get all the page links of a disambiguation page. 
   *
   * @param int disambiguation page id of which to get the links. 
   * @return array Returns array of page titles. If none found it returns NULL
   */
  static function getDisambiguationLinks($id = null)
  {
    if (!$id) {
      return null;
    }
    self::doConnect();

    $query = "SELECT * FROM pagelinks WHERE pl_namespace = 0 AND  pl_from = '" . $id . "'";

    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result)) {
      $data[] = str_replace('_', ' ', $row['pl_title']);
    }
    self::doClose();

    if (!empty($data)) {
      return $data;
    }
    return null;
  }

  /**
   * Function checkDisambiguation
   *
   * Checkes a page by title if belongs to disambiguation pages category. 
   *
   * @param string page title to check if it is disambiguation pages. 
   * @return int 0: not a disambiguation page, 1:a disambiguation page, 2: Unprintworthy redirect
   */
  static function checkDisambiguation($key = null)
  {
    $out = 0;
    if (!$key) {
      return;
    }
    $key = str_replace(' ', '_', $key);
    $data = array();

    self::doConnect();

    $query = "SELECT categorylinks.cl_to FROM page JOIN categorylinks ON categorylinks.cl_from = page.page_id WHERE page.page_namespace = 0 AND page.page_title = '" . $key . "'";

    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result)) {
      $data[] = $row['cl_to'];
    }

    self::doClose();
    foreach ($data as $v => $category) {
      if ($category == 'Disambiguation_pages') {
        $out = 1;
      }

      if ($category == 'Unprintworthy_redirects') {
        $out = 2;
      }
    }
    return $out;
  }

  /**
   * Function checkDisambiguations
   *
   * Checkes if array of page titles are disambiguation pages. 
   *
   * @param array keys Array of page titles to check if they are disambiguation pages. 
   * @return array Pages that are disambiguation pages.
   */
  static function checkDisambiguations($keys = array())
  {
    $out = 0;
    if (!$keys || empty($keys)) {
      return;
    }
    foreach ($keys as $key => $value) {
      $keys[$key] = (string) str_replace(' ', '_', $value);
    }
    $data = array();

    self::doConnect();
    $k = implode("', '", $keys);
    $query = "SELECT page.page_title as page, GROUP_CONCAT(categorylinks.cl_to) as categories FROM page JOIN categorylinks ON categorylinks.cl_from = page.page_id WHERE page.page_namespace = 0 AND page.page_title IN ('" . $k . "') GROUP BY page.page_title";

    $results = mysql_query($query);
    if ($results) {
      while ($row = mysql_fetch_assoc($results)) {
        $data[$row['page']] = explode(',', $row['categories']);
      }
    }

    self::doClose();

    foreach ($data as $d => $categories) {
      if (in_array('Unprintworthy_redirects', $categories)) {
        continue;
      }
      if (!in_array('Disambiguation_pages', $categories)) {
        unset($data[$d]);
      }
    }
    return $data;
  }

  /**
   * Function getSynonyms
   *
   * 1. Issue case-insensitive query
   *
   * 1a. If 1 entry returned, keep it, proceed to step 3
   * 1b. If n>1 entries returned
   *  1b.a If only one entry is a non-redirect,
   *  keep it, proceed to step 3
   *  1b.b If more than one non-redirects, proceed to Step 2
   * 1c. If no matching entries, return a 204 HTTP code (No content)
   *  and a correcsponding message
   *  
   * 2. Issue a case-sensitive query, and fetch the matching term.
   * // We follow this step only if there are more than 1 matches in Step 1
   * // We expect to either have one exact match, or no matches
   * 2a. If no matching terms, return a 300 HTTP code (multiple choices) and the
   *     appropriate json, with the multiple entries from Step 1, and a warning message
   *     "Multiple matches found because of ambiguous capitalization of the query.
   *     Please query again with one of the returned terms"
   * 2b. If matching term, keep it, proceed to Step 3
   *
   * 3. At this step, we have a single candidate term to use.
   *
   * 3a. If the term is a disambiguation page, return 300 HTTP code (multiple choices)
   * and the appropriate json with the entries that appear in the disambiguation page
   * and a warning message: "The entry is a disambiguation page in Wikipedia. Please query again with one of the returned terms."
   *
   * 3b. If the term is a redirect, then replace term with the redirect term, and repeat Step 3
   *
   * 3c. If the term is not a redirect, find all the redirect terms that lead to it, and return the terms that redirect to it as synonyms.
   * Return the term as the canonical form in the JSON
   *
   * @param string key A string to search synonyms for 
   * @return array 
   * @example array('http'=>200, 'message'=>'success', 'terms'=>array('term1', 'term2', ...)) the terms are the synonyms
   * @example array('http'=>300, 'message'=>'Error in capitalization/disambiguation', 'terms'=>array('term1', 'term2',...)) the terms are suggetion to search again
   * @example array('http'=>204, 'message'=>'No content') No terms found/Error occured
   */
  static function getSynonyms($key = null)
  {
    $data = array();
    $data2 = array();
    if (!$key) {
      return array(
        'http' => 204,
        'message' => 'No term to search',
      );
    }
    $key = str_replace(' ', '_', $key);
    $query_ci = sprintf("SELECT * FROM page_relation WHERE (stitle = '%s' OR ttitle = '%s') AND (snamespace = 0) AND (tnamespace = 0 OR tnamespace = 14) GROUP BY tid ", $key, $key);
    $query_cs = sprintf("SELECT * FROM page_relation WHERE (stitle_cs = '%s' OR ttitle_cs = '%s') AND (snamespace = 0) AND (tnamespace = 0 OR tnamespace = 14) GROUP BY tid ", $key, $key);
    self::doConnect();
    $result1 = mysql_query($query_ci);
    while ($row = mysql_fetch_assoc($result1)) {
      $data[] = $row;
    }
    self::doClose();
    if (count($data) > 1) {
      self::doConnect();
      $result = mysql_query($query_cs);
      while ($row = mysql_fetch_assoc($result)) {
        $data2[] = $row;
      }
      self::doClose();
      if (count($data2) > 1) {
        return array(
          'http' => 204,
          'message' => 'Bad query.',
        );
      } elseif (count($data2) < 1) {
        $terms = array();
        foreach ($data as $term) {
          $terms[] = str_replace('_', ' ', $term['ttitle']);
        }
        return array(
          'http' => 300,
          'message' => 'Multiple matches found because of ambiguous capitalization of the query. Please query again with one of the returned terms',
          'terms' => $terms
        );
      } else {
        if (self::checkDisambiguation(str_replace('_', ' ', $data2[0]['ttitle']))) {
          return array(
            'http' => 300,
            'message' => 'The entry is a disambiguation page in Wikipedia. Please query again with one of the returned terms',
            'terms' => self::getDisambiguationLinks($data2[0]['tid'])
          );
        } else {
          $synoms = array(array(
              'term' => str_replace('_', ' ', $data2[0]['ttitle']),
              'canonical' => 1
            ));
          $query_s = "SELECT * FROM page_relation WHERE tid = '" . $data2[0]['tid'] . "'";
          self::doConnect();
          $result_s = mysql_query($query_s);
          while ($row_s = mysql_fetch_assoc($result_s)) {
            $synoms[] = array(
              'term' => str_replace('_', ' ', $row_s['stitle']),
              'canonical' => 0,
            );
          }
          self::doClose();
          $oskills = self::getOdeskSkillsWithExternalLinksIn($synoms);
          foreach ($synoms as $key => $synom) {
            if (in_array(str_replace(' ', '_', $synom['term']), $oskills)) {
              $synoms[$key]['oskill'] = 1;
            } else {
              $synoms[$key]['oskill'] = 0;
            }
          }
          return array(
            'http' => 200,
            'message' => 'success',
            'terms' => $synoms
          );
        }
      }
    } elseif (count($data) < 1) {
      return array(
        'http' => 204,
        'message' => 'no content'
      );
    } else {
      if (self::checkDisambiguation($data[0]['ttitle'])) {
        return array(
          'http' => 300,
          'message' => 'The entry is a disambiguation page in Wikipedia. Please query again with one of the returned terms',
          'terms' => self::getDisambiguationLinks($data[0]['tid'])
        );
      } else {
        $synoms = array(array(
            'term' => str_replace('_', ' ', $data[0]['ttitle']),
            'canonical' => 1
          ));
        $query_s = "SELECT * FROM page_relation WHERE tid = '" . $data[0]['tid'] . "'";
        self::doConnect();
        $result_s = mysql_query($query_s);
        while ($row_s = mysql_fetch_assoc($result_s)) {
          $synoms[] = array(
            'term' => str_replace('_', ' ', $row_s['stitle']),
            'canonical' => 0,
          );
        }
        self::doClose();
        $oskills = self::getOdeskSkillsWithExternalLinksIn($synoms);
        foreach ($synoms as $key => $synom) {
          if (in_array(str_replace(' ', '_', $synom['term']), $oskills)) {
            $synoms[$key]['oskill'] = 1;
          } else {
            $synoms[$key]['oskill'] = 0;
          }
        }
        return array(
          'http' => 200,
          'message' => 'success',
          'terms' => $synoms
        );
      }
    }
  }

}