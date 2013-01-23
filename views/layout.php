<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>WikiSynonyms</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>

    <!-- Le styles -->
    <link href="<?php echo $this->make_route('/css/bootstrap.css')?>" rel="stylesheet"/>
    <link href="<?php echo $this->make_route('/css/font-awesome.min.css')?>" rel="stylesheet"/>
    <link href="<?php echo $this->make_route('/css/fontello.css')?>" rel="stylesheet"/>
    <link href="<?php echo $this->make_route('/css/main.css')?>" rel="stylesheet"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo $this->make_route('/css/font-awesome-ie7.min.css')?>">
    <link rel="stylesheet" href="<?php echo $this->make_route('/css/fontello-ie7.css')?>">
    <![endif]-->
    <!-- javascript
    ================================================== -->
    <script type="text/javascript" src="<?php echo $this->make_route('/js/jquery.js') ?>"></script>
    <script type="text/javascript" src="<?php echo $this->make_route('/js/bootstrap.js') ?>"></script>
    <script type="text/javascript" src="<?php echo $this->make_route('/js/application.js') ?>"></script>
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <div class="masthead">
        <?php if ($this->render_menu()) : ?>
        <ul class="nav nav-pills pull-right">
          <li class="<?php echo $this->is_active_route('/') ? 'active' : '' ?>"><a href="<?php echo $this->make_route('/') ?>">Home</a></li>
          <li class="<?php echo $this->is_active_route('/search') ? 'active' : '' ?>"><a href="<?php echo $this->make_route('/search') ?>">Search</a></li>
          <li class="<?php echo $this->is_active_route('/page/about') ? 'active' : '' ?>"><a href="<?php echo $this->make_route('/page/about') ?>">About</a></li>
          <li class="<?php echo $this->is_active_route('/page/api') ? 'active' : '' ?>"><a href="<?php echo $this->make_route('/page/api') ?>">API</a></li>
          <li class="<?php echo $this->is_active_route('/page/contacts') ? 'active' : '' ?>"><a href="<?php echo $this->make_route('/page/contacts') ?>">Contact</a></li>
        </ul>
        <?php endif; ?>
        <h3 class="muted"><a class="muted" href="<?php echo $this->make_route('/') ?>"><span style="font-weight: 100;letter-spacing: 3px;font-family:'Times'">Wiki</span><span class="highlight">Synonyms</span></a></h3>
      </div>

      <hr>
      <div id="main">
      <?php include($this->content); ?>
      </div>
      <hr/>

      <div class="footer">
        <p>&copy; 2012</p>
      </div>

    </div> 
    <!-- /container -->
  </body>
</html>
