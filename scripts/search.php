<?php

if (isset($_POST['term']) || isset($_REQUEST['term'])) {
  $term = $_POST['term'] ? strip_tags(trim($_POST['term'])) : strip_tags(trim($_REQUEST['term']));
  $synoms = Application::getSynonyms($term);
  
  $smarty->assign('synonyms', $synoms);
  $smarty->assign('term', $term);
}
$content = $smarty->fetch('search.tpl');

