<?php /* Smarty version Smarty-3.1.8, created on 2012-05-17 18:37:33
         compiled from "/Applications/MAMP/htdocs/wikiSyno/templates/search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16577752324fb51b3d8eb703-44572924%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05edad7aea543bf7adba79fa167d0d87766df58c' => 
    array (
      0 => '/Applications/MAMP/htdocs/wikiSyno/templates/search.tpl',
      1 => 1337269024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16577752324fb51b3d8eb703-44572924',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'errors' => 0,
    'error' => 0,
    'values' => 0,
    'total' => 0,
    'synonyms' => 0,
    'synonym' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb51b3d9fab52_42971141',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fb51b3d9fab52_42971141')) {function content_4fb51b3d9fab52_42971141($_smarty_tpl) {?><div>
  <?php if ($_smarty_tpl->tpl_vars['errors']->value){?>
  <ul class="error_list">
      <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
$_smarty_tpl->tpl_vars['error']->_loop = true;
?>
      <li><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li>
      <?php } ?>
  </ul>
  <?php }?>
  <form action="./index.php?action=search" method="post">
    <input type="hidden" name="submit" value="1"/>
    <input type="text" name="term" value="<?php echo $_smarty_tpl->tpl_vars['values']->value['term'];?>
"/>
    <button type="submit">Search</button>
  </form>
</div>

<br/>
<br/>
<br/>

<?php if ($_smarty_tpl->tpl_vars['values']->value['term']){?>
<strong><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</strong> synonym(s) has been found for term <strong><?php echo $_smarty_tpl->tpl_vars['values']->value['term'];?>
</strong>:<br/>
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