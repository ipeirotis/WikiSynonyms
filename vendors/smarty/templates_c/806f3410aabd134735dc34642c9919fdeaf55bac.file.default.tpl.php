<?php /* Smarty version Smarty-3.1.8, created on 2012-12-18 19:28:36
         compiled from "/Applications/MAMP/htdocs/wikiSyno/templates/default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:140418711150d04e8748bb78-11365825%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '806f3410aabd134735dc34642c9919fdeaf55bac' => 
    array (
      0 => '/Applications/MAMP/htdocs/wikiSyno/templates/default.tpl',
      1 => 1355851715,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '140418711150d04e8748bb78-11365825',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_50d04e874d2df6_20748775',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50d04e874d2df6_20748775')) {function content_50d04e874d2df6_20748775($_smarty_tpl) {?><div class="jumbotron">
  <h1>Search for Synonyms<br/>via Wikipedia!</h1>
  <p class="lead">
    Using Mediawiki's structure for wikipedia pages, you can search for term's or phrase's synonyms. <br/>
    We also provide an API for third party applications/services to use.
  </p>
  <a class="btn btn-large btn-success" href="./?action=search">Search now</a>
</div><?php }} ?>