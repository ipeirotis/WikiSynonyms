<?php

if (isset($_POST['term'])) {
  $term = strip_tags(trim($_POST['term']));
  $synoms = Application::getSynonymsV2($term);
  header('Content-type: application/json', true, $synoms['http']);
  echo json_encode($synoms);
  die();
} else {
  $content = $smarty->fetch('search.tpl');
}
