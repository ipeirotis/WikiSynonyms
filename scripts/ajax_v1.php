<?php

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
  echo Helper::prettyPrint(json_encode($data));
  echo '</pre>';
  die();
}
header('Content-type: application/json');
echo json_encode($data);
die();