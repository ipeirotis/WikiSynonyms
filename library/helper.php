<?php

class Helper
{

  static public function printErrors($errors, $format = 'break')
  {
    $output = '';

    switch ($format) {
      case 'list':
        $output .= '<ul>';
        foreach ($errors as $error) {
          $output .= '<li>' . $error . '</li>';
        }
        $output .= '</ul>';
        break;
      default:
        foreach ($errors as $error) {
          $output .= $error . '<br/>';
        }
    }
    return $output;
  }

  static public function makeBitlyUrl($url, $login, $appkey, $format = 'txt')
  {
    //create the URL
    $connectURL = 'http://api.bit.ly/v3/shorten?login=' . $login . '&apiKey=' . $appkey . '&uri=' . urlencode($url) . '&format=' . $format;
    return self::curl_get_result($connectURL);
  }

  static public function isXmlHttpRequest()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      return true;
    }
    return false;
  }

  static public function curl_get_result($url, $type = null, $host = null)
  {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if (curl_exec($ch) === false) {
      die('ERROR: ' . curl_error($ch));
    }

    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
  }

  static public function prettyPrint($json)
  {

    $result = '';
    $pos = 0;
    $strLen = strlen($json);
    $indentStr = '  ';
    $newLine = "\n";
    $prevChar = '';
    $outOfQuotes = true;

    for ($i = 0; $i <= $strLen; $i++) {

      // Grab the next character in the string.
      $char = substr($json, $i, 1);

      // Are we inside a quoted string?
      if ($char == '"' && $prevChar != '\\') {
        $outOfQuotes = !$outOfQuotes;

        // If this character is the end of an element, 
        // output a new line and indent the next line.
      } else if (($char == '}' || $char == ']') && $outOfQuotes) {
        $result .= $newLine;
        $pos--;
        for ($j = 0; $j < $pos; $j++) {
          $result .= $indentStr;
        }
      }

      // Add the character to the result string.
      $result .= $char;

      // If the last character was the beginning of an element, 
      // output a new line and indent the next line.
      if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
        $result .= $newLine;
        if ($char == '{' || $char == '[') {
          $pos++;
        }

        for ($j = 0; $j < $pos; $j++) {
          $result .= $indentStr;
        }
      }

      $prevChar = $char;
    }

    return $result;
  }

}