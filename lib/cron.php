<?php

class Cron
{
  public static $_fails = 60;
  
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
  
  static function fetchOdeskSkill($skill) 
  {
    $response = file_get_contents('http://www.odesk.com/api/profiles/v1/metadata/skills/' . urlencode($skill) . '.json');
    $response_header = $http_response_header;
    if ($response_header[0] == 'HTTP/1.0 400 Bad Request') {
      echo $skill . ' Failed' . "\n";
      return false;
    }
    if ($response_header[0] != 'HTTP/1.0 200 OK') {
      self::$_fails;
      echo $skill . ' Fail : sleep for ' . self::$_fails . ' seconds' . "\n";
      sleep(self::$_fails);
      $response = self::fetchOdeskSkill($skill);
    }
    return $response;
  }
  
  /**
   * Function refreshOdeskSkills
   *
   * Produces SQL file with all the inserts for oDesk skills table (odesk_skills)
   *
   * @param int stop Number in which we might need the iteration to stop. 
   * @param boolean force Boolean parameter if we need to force/sleep the iteration to avoid throttling from odesk server. 
   * @return void
   */
  static function refreshOdeskSkills($force = false, $stop = null)
  {
    try {
      $odesk_skills = json_decode(file_get_contents('http://www.odesk.com/api/profiles/v1/metadata/skills.json'));
      $skills = $odesk_skills->skills;

      $query = 'TRUNCATE TABLE ipeirotis.odesk_skills;' . "\n";
      
      $query .= 'INSERT INTO odesk_skills (skill, pretty_name, external_link, description, wikipedia_page_id) VALUES ' . "\n";
      $i = 0;
      $count = $stop ? $stop : count($skills);
      foreach ($skills as $k => $skill) {
        $response = self::fetchOdeskSkill($skill);
        if (!$response) {
          continue;
        }
        echo $skill . ' OK ' . "\n";
        $skill_data = json_decode($response);
        $query .= sprintf("('%s', '%s', '%s', '%s', %s)", mysql_real_escape_string($skill_data->skill->skill), mysql_real_escape_string($skill_data->skill->pretty_name), $skill_data->skill->external_link ? mysql_real_escape_string($skill_data->skill->external_link) : '', $skill_data->skill->description ? mysql_real_escape_string($skill_data->skill->description) : '', 0
        );
        $i++;
        if ($i >= $count) {
          $query .= ";";
          break;
        } else {
          $query .= ",\n";
        }
      }
      $fp = fopen(dirname(dirname(__FILE__)) . '/web/assets/cron_p/odesk-skills.sql', 'w');
      fwrite($fp, $query);
      fclose($fp);
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  static function cleanUpOdeskSkills()
  {
    $data = array();
    try {
      $odesk_skills = json_decode(file_get_contents('http://www.odesk.com/api/profiles/v1/metadata/skills.json'));
      $skills = $odesk_skills->skills;

      self::doConnect();

      $query = sprintf("SELECT skill FROM odesk_skills WHERE skill NOT IN ('%s')", implode("','", $skills));

      $result = mysql_query($query);

      if ($result) {
        while ($row = mysql_fetch_assoc($result)) {
          $data[] = $row['skill'];
        }
      }
      self::doClose();
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
    try {
      if (count($data) > 0) {
        self::doConnect();
        $d_query = sprintf("DELETE FROM odesk_skills WHERE skill IN ('%s')", implode("','", $data));
        $result = mysql_query($d_query);
        if (!$result) {
          echo "DELETE failed: $d_query<br />" .
          mysql_error() . "<br /><br />";
        } else {
          echo "Delete success:<br />" .
            count($data) . ' items deleted: ' . implode(", ", $data) . '<br />' .
            $d_query
          ;
        }
        self::doClose();
      } else {
        echo 'Nothing to clean up.';
      }
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

}