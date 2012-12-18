<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>WikiSynonyms</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>

    <!-- Le styles -->
    <link href="resources/css/bootstrap.css" rel="stylesheet"/>
    <link href="resources/css/main.css" rel="stylesheet"/>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="resources/ico/apple-touch-icon-144-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="resources/ico/apple-touch-icon-114-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="resources/ico/apple-touch-icon-72-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" href="resources/ico/apple-touch-icon-57-precomposed.png"/>
    <link rel="shortcut icon" href="resources/ico/favicon.png"/>
  </head>

  <body>

    <div class="container">

      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li class="{if !$action || $action == 'default'}active{/if}"><a href="./">Home</a></li>
          <li class="{if $action == 'search'}active{/if}"><a href="./?action=search">Search</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">API</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
        <h3 class="muted"><a class="muted" href="./">Wiki<span class="highlight">Synonyms</span></a></h3>
      </div>

      <hr>

      {$content}

      <hr/>

      <div class="footer">
        <p>&copy; 2012</p>
      </div>

    </div> 
    <!-- /container -->

    <!-- javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="resources/js/jquery.js"></script>
    <script src="resources/js/bootstrap-min.js"></script>
    <script src="resources/js/application.js"></script>
  </body>
</html>
