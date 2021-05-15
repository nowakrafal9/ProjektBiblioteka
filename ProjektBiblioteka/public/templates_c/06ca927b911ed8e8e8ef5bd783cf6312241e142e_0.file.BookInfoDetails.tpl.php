<?php
/* Smarty version 3.1.34-dev-7, created on 2021-05-14 17:23:38
  from 'D:\xampp\htdocs\pliki\ProjektBiblioteka\app\views\BookInfoDetails.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_609e95fae0c036_74301720',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '06ca927b911ed8e8e8ef5bd783cf6312241e142e' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pliki\\ProjektBiblioteka\\app\\views\\BookInfoDetails.tpl',
      1 => 1621005816,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_609e95fae0c036_74301720 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_221722079609e95fae02bd5_20353504', 'content');
?>


<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "main_template.tpl");
}
/* {block 'content'} */
class Block_221722079609e95fae02bd5_20353504 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_221722079609e95fae02bd5_20353504',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <section style="padding-top: 1em; padding-bottom: 1em">
       <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['records']->value, 'r');
$_smarty_tpl->tpl_vars['r']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->do_else = false;
?>
            <h3 class="content"><?php echo $_smarty_tpl->tpl_vars['r']->value["title"];?>
 </h3>          
            Autor: <?php echo $_smarty_tpl->tpl_vars['r']->value["author"];?>
 <br/>             
            Wydawnictwo: <?php echo $_smarty_tpl->tpl_vars['r']->value["publisher"];?>
 <br/>
            Gatunek: <?php echo $_smarty_tpl->tpl_vars['r']->value["genre"];?>
 <br/>
            Ilość stron: <?php echo $_smarty_tpl->tpl_vars['r']->value["pages"];?>
 <br/> <br/>
            
            Placeholder na krótki opis książki.
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </section>
<?php
}
}
/* {/block 'content'} */
}
