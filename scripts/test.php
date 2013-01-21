<?php 

if ($_GET['term']) {
//  die(urlencode($bones->request('term')));
  $term = strip_tags(trim($_GET['term']));
  $synoms = Application::getSynonyms($term);
  header('Content-type: application/json', true, $synoms['http']);
  echo json_encode($synoms);
  die();
} else {
  header('Content-type: application/json', true, 300);
  die(
    json_encode(array(
      'http' => 300,
      'message' => 'No term to search',
    ))
  );
}