<?php

$data = array(
  'synonyms' => array(),
  'total' => 0,
);
if (isset($_REQUEST['term'])) {
  $term = strip_tags(trim($_REQUEST['term']));
  $synoms = Application::getSynonyms($term);
  $data['synonyms'] = array_values($synoms['synoms']);
  $data['disambiguations'] = $synoms['disambiguations'];
  $data['total'] = count($synoms['synoms'])+count($synoms['disambiguations']);
  foreach ($synoms['disambiguations'] as $disambiguation) {
    $data['total'] = $data['total'] + count($disambiguation);
  }
}
header('Content-type: application/json');
echo json_encode($data);
die();