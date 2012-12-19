<?php /* Smarty version Smarty-3.1.8, created on 2012-12-18 19:26:11
         compiled from "/Applications/MAMP/htdocs/wikiSyno/templates/search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11972050554fb5255025bd15-65704614%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05edad7aea543bf7adba79fa167d0d87766df58c' => 
    array (
      0 => '/Applications/MAMP/htdocs/wikiSyno/templates/search.tpl',
      1 => 1355851561,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11972050554fb5255025bd15-65704614',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb52550326256_10200669',
  'variables' => 
  array (
    'term' => 0,
    'synonyms' => 0,
    'synonym' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fb52550326256_10200669')) {function content_4fb52550326256_10200669($_smarty_tpl) {?><div id="newsletter">
  <div class="container">
    <h3 class="title">
      WikiSynonyms is a <u>reliable platform</u> to search synonyms.</span>
    </h3>
    <h4 class="pitch">
      <span class="muted">Please enter a term or a phrase you want to search synonyms for:</span>
    </h4>
    <form action="./search" method="POST">
      <input id="term" name="term" type="text" <?php if ($_smarty_tpl->tpl_vars['term']->value){?>value="<?php echo $_smarty_tpl->tpl_vars['term']->value;?>
"<?php }?>><input class="btn btn-subscribe btn-xlarge" type="submit" value="Search">
    </form>
  </div>
</div>
<?php if ($_smarty_tpl->tpl_vars['synonyms']->value){?>
<div id="results" class="container">
  <?php if ($_smarty_tpl->tpl_vars['synonyms']->value['http']!=200){?>
    <?php if ($_smarty_tpl->tpl_vars['synonyms']->value['http']==204){?>
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Error!</strong> <?php echo $_smarty_tpl->tpl_vars['synonyms']->value['message'];?>

    </div>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['synonyms']->value['http']==300){?>
    <div class="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Warning!</strong> <?php echo $_smarty_tpl->tpl_vars['synonyms']->value['message'];?>

    </div>
    <?php }?>
  <?php }else{ ?>
  <h4>Synonyms:</h4>
  <?php }?>
  <hr/>
  <ol>
    <?php  $_smarty_tpl->tpl_vars['synonym'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['synonym']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['synonyms']->value['terms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['synonym']->key => $_smarty_tpl->tpl_vars['synonym']->value){
$_smarty_tpl->tpl_vars['synonym']->_loop = true;
?>
    <li>
      <?php echo $_smarty_tpl->tpl_vars['synonym']->value;?>

    </li>
    <?php } ?>
  </ol>

</div>
<?php }?><?php }} ?>