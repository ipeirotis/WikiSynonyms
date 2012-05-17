<?php /* Smarty version Smarty-3.1.8, created on 2012-05-17 17:54:24
         compiled from "/Applications/MAMP/htdocs/wikiSyno/templates/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15390007124fb511207ef031-83119617%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6816e3f635932711cce8eae6bc1f4f2a82933ccb' => 
    array (
      0 => '/Applications/MAMP/htdocs/wikiSyno/templates/form.tpl',
      1 => 1337266462,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15390007124fb511207ef031-83119617',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb51120836310_93019786',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fb51120836310_93019786')) {function content_4fb51120836310_93019786($_smarty_tpl) {?><div>
  <form action="./index.php?action=synonyms" method="post">
    <input type="text" name="key" value=""/>
    <button type="submit">Search</button>
  </form>
</div><?php }} ?>