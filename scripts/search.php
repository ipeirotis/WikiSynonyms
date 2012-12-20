<?php

if (isset($_POST['term']) || isset($_REQUEST['term'])) {
  $term = $_POST['term'] ? strip_tags(trim($_POST['term'])) : strip_tags(trim($_REQUEST['term']));
  $synoms = Application::getSynonyms($term);
  $bones->set('synonyms', $synoms);
  $bones->set('term', $term);
  $bones->render('search');
}
else{
  $bones->render('search');
}

