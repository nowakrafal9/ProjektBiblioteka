<?php
/* Smarty version 3.1.34-dev-7, created on 2021-05-14 18:21:32
  from 'D:\xampp\htdocs\pliki\ProjektBiblioteka\app\views\ReaderList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_609ea38c38fef1_78335921',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '501b100d9a065651bf8beb26de56ac96dbc51460' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pliki\\ProjektBiblioteka\\app\\views\\ReaderList.tpl',
      1 => 1621009291,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_609ea38c38fef1_78335921 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_265063895609ea38c3837e5_17420483', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "main_template.tpl");
}
/* {block 'content'} */
class Block_265063895609ea38c3837e5_17420483 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_265063895609ea38c3837e5_17420483',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <section style = "padding-top: 1em; padding-bottom: 0;">
        <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
readerList">
            
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="person_id" id="person_id" value="<?php echo $_smarty_tpl->tpl_vars['searchForm']->value->id;?>
" placeholder="Id czytelnika" />
                </div>	
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="name" id="name" value="<?php echo $_smarty_tpl->tpl_vars['searchForm']->value->name;?>
" placeholder="Imię" />
                </div>						
                <div class="col-3 col-3-xsmall">
                    <input type="text" name="surname" id="surname" value="<?php echo $_smarty_tpl->tpl_vars['searchForm']->value->surname;?>
" placeholder="Nazwisko" />
                </div>    						
            </div>
                
            <input type="submit" value="Szukaj" class="primary">
            <a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
readerList" class="button">Wyczyść filtr</a>
        </form>    
    </section>
    
    <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">
    <table class="alt">
        <thead>
            <tr>
                <th>Id czytelnika</th>
                <th>Nazwisko</th>
                <th>Imię</th>         
            </tr>
        </thead>

        <tbody>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['records']->value, 'r');
$_smarty_tpl->tpl_vars['r']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->do_else = false;
?>
            <tr><td><?php echo $_smarty_tpl->tpl_vars['r']->value["id_borrower"];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['r']->value["surname"];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['r']->value["name"];?>
</td><td><center><a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
readerList" class="button small">Informacje</a></center></td></tr>
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
