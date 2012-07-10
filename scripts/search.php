<?php

if ($_POST['submit']) {
  $term = strip_tags(trim($_POST['term']));
  $errors = array();
  if (!$term) {
    $errors['term'] = 'Term can not be empty!';
  } else if (strlen($term) < 2) {
    $errors['term'] = 'Term has to be 2 characters and more!';
  } else if (strlen($term) > 255) {
    $errors['term'] = 'Term can not be more than 255 characters!';
  }

  $smarty->assign('values', $_POST);
  if ($errors) {
    $smarty->assign('errors', $errors);
  } else {
    $synoms = Application::getSynonyms($term);
    $total = count($synoms['synoms']) + count($synoms['disambiguations']);
    if (count($synoms['disambiguations'])) {
      foreach ($synoms['disambiguations'] as $disambiguation) {
        $total = $total + count($disambiguation);
      }
    }
    $smarty->assign('synonyms', $synoms['synoms']);
    $smarty->assign('disambiguations', $synoms['disambiguations']);
    $smarty->assign('total', $total);
  }
}

$content = $smarty->fetch('search.tpl');