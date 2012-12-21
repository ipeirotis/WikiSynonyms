<?php
//homepage
get('/', 'home');

//search
get('/search', 'search');
post('/search', 'search');

//api
get('/api', 'api');
get('/api/:term', 'api');

//pages
get('/page/:page_name', 'page');

//experimental

get('/produce/odesk/csv', 'odesk-skills-to-csv');