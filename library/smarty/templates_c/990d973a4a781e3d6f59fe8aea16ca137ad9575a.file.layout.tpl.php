<?php /* Smarty version Smarty-3.1.8, created on 2012-12-18 19:31:25
         compiled from "/Applications/MAMP/htdocs/wikiSyno/templates/layout.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4782113924fb5255032f7c1-94989029%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '990d973a4a781e3d6f59fe8aea16ca137ad9575a' => 
    array (
      0 => '/Applications/MAMP/htdocs/wikiSyno/templates/layout.tpl',
      1 => 1355851883,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4782113924fb5255032f7c1-94989029',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb5255033d941_44398836',
  'variables' => 
  array (
    'action' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fb5255033d941_44398836')) {function content_4fb5255033d941_44398836($_smarty_tpl) {?><!DOCTYPE html>
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
          <li class="<?php if (!$_smarty_tpl->tpl_vars['action']->value||$_smarty_tpl->tpl_vars['action']->value=='default'){?>active<?php }?>"><a href="./">Home</a></li>
          <li class="<?php if ($_smarty_tpl->tpl_vars['action']->value=='search'){?>active<?php }?>"><a href="./search">Search</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">API</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
        <h3 class="muted"><a class="muted" href="./">Wiki<span class="highlight">Synonyms</span></a></h3>
      </div>

      <hr>
      <div id="main">
      <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

      </div>
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
<?php }} ?>