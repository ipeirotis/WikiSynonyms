<?php

$data = array(
  'synonyms' => array(),
  'total' => 0,
);
if (isset($_REQUEST['term'])) {
  $term = strip_tags(trim($_REQUEST['term']));
  $synoms = Application::getSynonyms($term);
  $data['synonyms'] = array_values($synoms);
  $data['total'] = count($synoms);
}
header('Content-type: application/json');
echo json_encode($data);
die();