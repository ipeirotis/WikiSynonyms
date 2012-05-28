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
  static function moveValueByIndex( array $array, $from=null, $to=null )
  {
    if ( null === $from )
    {
      $from = count( $array ) - 1;
    }

    if ( !isset( $array[$from] ) )
    {
      throw new Exception( "Offset $from does not exist" );
    }

    if ( array_keys( $array ) != range( 0, count( $array ) - 1 ) )
    {
      throw new Exception( "Invalid array keys" );
    }

    $value = $array[$from];
    unset( $array[$from] );

    if ( null === $to )
    {
      array_push( $array, $value );
    } else {
      $tail = array_splice( $array, $to );
      array_push( $array, $value );
      $array = array_merge( $array, $tail );
    }

    return $array;
  }

  static function getSynonyms($key = null)
  {
    self::doConnect();
    $temp_synoms = array();
    $synoms = array();
    $data = array();
    $data2 = array();
    if ($key) {
      
      $key = str_replace(' ', '_', ucwords($key));

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
      }
      if (!in_array(str_replace('_', ' ', $d['stitle']), $temp_synoms)){
        $temp_synoms[] = str_replace('_', ' ', $d['stitle']);
        $synoms[] = array(
          'term' => str_replace('_', ' ', $d['stitle']),
          'is_primary' => 0,
        );
      }  
      if (!in_array(str_replace('_', ' ', $d['ttitle']), $temp_synoms)){
        $temp_synoms[] = str_replace('_', ' ', $d['ttitle']);
        $synoms[] = array(
          'term' => str_replace('_', ' ', $d['ttitle']),
          'is_primary' => 1,
        );
      }
    }
    if (!empty($new_bpages)) {
      self::doConnect();
      $query2 = "SELECT * FROM page_relation WHERE tid IN (" . implode(',', $new_bpages) . ")";
      $result2 = mysql_query($query2);

      while ($row2 = mysql_fetch_assoc($result2)) {
        $data2[] = $row2;
        if (!in_array(str_replace('_', ' ', $row2['stitle']), $temp_synoms)){
          $temp_synoms[] = str_replace('_', ' ', $row2['stitle']);
          $synoms[] = array(
            'term' => str_replace('_', ' ', $row2['stitle']),
            'is_primary' => 0,
          );
        }  
        if (!in_array(str_replace('_', ' ', $row2['ttitle']), $temp_synoms)){
          $temp_synoms[] = str_replace('_', ' ', $row2['ttitle']);
          $synoms[] = array(
            'term' => str_replace('_', ' ', $row2['ttitle']),
            'is_primary' => 1,
          );
        }
      }
      self::doClose();
    }
    
    if ((in_array($key, $data) || in_array($key, $data2)) && !in_array($key, $synoms)) {
      array_unshift($synoms, array(
          'term' => str_replace('_', ' ', $key),
          'is_primary' => 1,
        )
      );

    } 
    
    foreach ($synoms as $key => $synom) {
      if ($synom['is_primary'] == 1) {
        $synoms = self::moveValueByIndex($synoms, $key, 0);
        break;
      }
    }


    return $synoms;
  }

}