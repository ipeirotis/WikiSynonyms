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

  static function moveValueByIndex(array $array, $from = null, $to = null)
  {
    if (null === $from) {
      $from = count($array) - 1;
    }

    if (!isset($array[$from])) {
      throw new Exception("Offset $from does not exist");
    }

    if (array_keys($array) != range(0, count($array) - 1)) {
      throw new Exception("Invalid array keys");
    }

    $value = $array[$from];
    unset($array[$from]);

    if (null === $to) {
      array_push($array, $value);
    } else {
      $tail = array_splice($array, $to);
      array_push($array, $value);
      $array = array_merge($array, $tail);
    }

    return $array;
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

  static function getOdeskSkills($term = null)
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

  static function checkOdeskSkillsByTerm($term = null)
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

  static function checkOdeskSkillsByTerms($terms = array())
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
            'message' => 'Very bad query???',
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
          $synoms = array(str_replace('_', ' ', $data2[0]['ttitle']));
          $query2 = "SELECT * FROM page_relation WHERE tid = '" . $data2[0]['tid'] . "'";
          self::doConnect();
          $result2 = mysql_query($query2);
          while ($row2 = mysql_fetch_assoc($result2)) {
            $synoms[] = str_replace('_', ' ', $row2['stitle']);
          }
          self::doClose();
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
        $synoms = array(str_replace('_', ' ', $data[0]['ttitle']));
        $query_s = "SELECT * FROM page_relation WHERE tid = '" . $data[0]['tid'] . "'";
        self::doConnect();
        $result_s = mysql_query($query_s);
        while ($row_s = mysql_fetch_assoc($result_s)) {
          $synoms[] = str_replace('_', ' ', $row_s['stitle']);
        }
        self::doClose();
        return array(
            'http' => 200,
            'message' => 'success',
            'terms' => $synoms
          );
      }
    }
  }

}