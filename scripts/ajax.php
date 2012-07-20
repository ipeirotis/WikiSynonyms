<?php

function prettyPrint($json)
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

$data = array(
  'synonyms' => array(),
  'disambiguations' => array(),
  'total' => 0,
);
if (isset($_REQUEST['term'])) {
  $term = strip_tags(trim($_REQUEST['term']));
  $synoms = Application::getSynonyms($term);
  $data['synonyms'] = array_values($synoms['synoms']);
  $data['disambiguations'] = $synoms['disambiguations'];
  $data['odesk'] = $synoms['odesk'];
  $data['total'] = count($synoms['synoms']) + count($synoms['disambiguations']) + count($synoms['odesk']);
  if (count($synoms['disambiguations'])) {
    foreach ($synoms['disambiguations'] as $disambiguation) {
      $data['total'] = $data['total'] + count($disambiguation);
    }
  }
}
if (isset($_REQUEST['pretty_print']) && $_REQUEST['pretty_print'] == true) {
  echo '<pre>';
  echo prettyPrint(json_encode($data));
  echo '</pre>';
  die();
}
header('Content-type: application/json');
echo json_encode($data);
die();