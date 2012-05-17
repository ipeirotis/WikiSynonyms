<?php /* Smarty version Smarty-3.1.8, created on 2012-05-17 18:19:33
         compiled from "/Applications/MAMP/htdocs/wikiSyno/templates/synonyms.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1634061804fb516cdb2b4b3-09149113%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '095cadac22bfdda19f4d7a45dbe2c75d58cd9b71' => 
    array (
      0 => '/Applications/MAMP/htdocs/wikiSyno/templates/synonyms.tpl',
      1 => 1337267967,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1634061804fb516cdb2b4b3-09149113',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb516cdbb1f61_71504349',
  'variables' => 
  array (
    'total' => 0,
    'synonyms' => 0,
    'synonym' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fb516cdbb1f61_71504349')) {function content_4fb516cdbb1f61_71504349($_smarty_tpl) {?>



<div>
  <form action="./index.php?action=synonyms" method="post">
    <input type="text" name="term" value=""/>
    <button type="submit">Search</button>
  </form>
</div>

<br/>
<br/>
<br/>

<?php if ($_smarty_tpl->tpl_vars['total']->value>0){?>
Total: <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 <br/>
<ol>
  <?php  $_smarty_tpl->tpl_vars['synonym'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['synonym']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['synonyms']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['synonym']->key => $_smarty_tpl->tpl_vars['synonym']->value){
$_smarty_tpl->tpl_vars['synonym']->_loop = true;
?>
  <li>
    <?php echo $_smarty_tpl->tpl_vars['synonym']->value;?>

  </li>
  <?php } ?>
</ol>
<?php }?><?php }} ?>