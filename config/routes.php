<?php
//homepage
get('/', 'home');

//search
get('/search', 'search');
post('/search', 'search');

//api
get('/api', 'api');
get('/api/:term', 'api');
