<?php

$pageview = ROOT . '/views/page/' . $bones->request('page_name') . '.php';

if(file_exists($pageview)) {
  $bones->render('page/' . $bones->request('page_name'));
} else {
  $bones->error404();
}
