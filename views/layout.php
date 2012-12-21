<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>WikiSynonyms</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>

    <!-- Le styles -->
    <link href="<?php echo $this->make_route('/public/css/bootstrap.css')?>" rel="stylesheet"/>
    <link href="<?php echo $this->make_route('/public/css/main.css')?>" rel="stylesheet"/>
    
    <!-- javascript
    ================================================== -->
    <script type="text/javascript" src="<?php echo $this->make_route('/public/js/jquery.js') ?>"></script>
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li class="<?php echo $this->is_active_route('/') ? 'active' : '' ?>"><a href="<?php echo $this->make_route('/') ?>">Home</a></li>
          <li class="<?php echo $this->is_active_route('/search') ? 'active' : '' ?>"><a href="<?php echo $this->make_route('/search') ?>">Search</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">API</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
        <h3 class="muted"><a class="muted" href="<?php echo $this->make_route('/') ?>">Wiki<span class="highlight">Synonyms</span></a></h3>
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
