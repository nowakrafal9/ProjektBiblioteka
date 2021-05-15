<?php
/* Smarty version 3.1.34-dev-7, created on 2021-05-14 15:57:53
  from 'D:\xampp\htdocs\pliki\ProjektBiblioteka\app\views\BookInfoSearch.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_609e81e1e2ac15_36061705',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '44247feee659e06a77add7d8c2d5be61f7e05a7c' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pliki\\ProjektBiblioteka\\app\\views\\BookInfoSearch.tpl',
      1 => 1621000670,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_609e81e1e2ac15_36061705 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1551363516609e81e1e21dd3_18113980', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "main_template.tpl");
}
/* {block 'content'} */
class Block_1551363516609e81e1e21dd3_18113980 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_1551363516609e81e1e21dd3_18113980',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <section style="padding-top: 1em; padding-bottom: 1em">
       <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
bookInfo">
            
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-12">
                    <input type="text" name="title" id="title" value="<?php echo $_smarty_tpl->tpl_vars['searchForm']->value->title;?>
" placeholder="Tytuł szukanej książki" />
                </div>							
            </div>
                
            <input type="submit" value="Szukaj" class="primary">
            <input type="reset" value="Wyczyść" class="button">
        </form>
    </section>
    
    <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">
    <table class="default">
        <tbody>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['records']->value, 'r');
$_smarty_tpl->tpl_vars['r']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->do_else = false;
?>
            <tr><td><?php echo $_smarty_tpl->tpl_vars['r']->value["title"];?>
</td></tr>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
    </section>
<?php
}
}
/* {/block 'content'} */
}
