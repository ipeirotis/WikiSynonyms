<?php

if (isset($_REQUEST['term'])) {
  $term = strip_tags(trim($_REQUEST['term']));
  $synoms = Application::getSynonyms($term);
  header('Content-type: application/json', true, $synoms['http']);
  echo json_encode($synoms);
  die();
} else {
  header('Content-type: application/json', true, 204);
  die(
    json_encode(array(
      'http' => 204,
      'message' => 'No term to search',
    ))
  );
}