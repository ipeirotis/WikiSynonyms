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

  static function getSynonyms($key = null)
  {
    self::doConnect();
    $synoms = array();
    $data = array();
    if ($key) {
      $key = str_replace(' ', '_', $key);

      $query = sprintf("SELECT * FROM page_relation WHERE (stitle = '%s' OR ttitle = '%s') AND snamespace = 0 AND tnamespace = 0", $key, $key);
      $result = mysql_query($query);

      while ($row = mysql_fetch_assoc($result)) {
        $data[] = $row;
      }
    }
    self::doClose();

    $new_bpages = array();
    foreach ($data as $d) {
      if ($d['stitle'] == $key) {
        $new_bpages[] = $d['tid'];
        $synoms[] = str_replace('_', ' ', $d['ttitle']);
      } else {
        $synoms[] = str_replace('_', ' ', $d['stitle']);
      }
    }
    if (!empty($new_bpages)) {
      self::doConnect();
      $query2 = "SELECT * FROM page_relation WHERE tid IN (" . implode(',', $new_bpages) . ")";
      $result2 = mysql_query($query2);

      while ($row2 = mysql_fetch_assoc($result2)) {
        $synoms[] = str_replace('_', ' ', $row2['stitle']);
        $synoms[] = str_replace('_', ' ', $row2['ttitle']);
      }
      self::doClose();
    }


    return array_unique($synoms);
  }

}