<?php
/* Smarty version 3.1.34-dev-7, created on 2021-05-14 17:13:56
  from 'D:\xampp\htdocs\pliki\ProjektBiblioteka\app\views\BookInfo.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_609e93b444f7d5_07598302',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6b0dadd335e0ffe38e905048aa6ac38126bc4507' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pliki\\ProjektBiblioteka\\app\\views\\BookInfo.tpl',
      1 => 1621005166,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_609e93b444f7d5_07598302 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_779535804609e93b4442772_46928966', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "main_template.tpl");
}
/* {block 'content'} */
class Block_779535804609e93b4442772_46928966 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_779535804609e93b4442772_46928966',
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
             <a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
bookInfo" class="button">Wyczyść filtr</a>
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
            <tr><td><a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
bookInfoDetails/<?php echo $_smarty_tpl->tpl_vars['r']->value['id_book'];?>
"><?php echo $_smarty_tpl->tpl_vars['r']->value["title"];?>
</a></td></tr>
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
