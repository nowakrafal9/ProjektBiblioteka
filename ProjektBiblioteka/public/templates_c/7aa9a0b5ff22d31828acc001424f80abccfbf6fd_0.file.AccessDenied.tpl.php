<?php
/* Smarty version 3.1.34-dev-7, created on 2021-05-14 10:32:35
  from 'D:\xampp\htdocs\pliki\ProjektBiblioteka\app\views\AccessDenied.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_609e35a3695f94_49519681',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7aa9a0b5ff22d31828acc001424f80abccfbf6fd' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pliki\\ProjektBiblioteka\\app\\views\\AccessDenied.tpl',
      1 => 1620981151,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_609e35a3695f94_49519681 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_771164612609e35a36951a2_97907415', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "main_template.tpl");
}
/* {block 'content'} */
class Block_771164612609e35a36951a2_97907415 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_771164612609e35a36951a2_97907415',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <!-- Section -->
            <section>
                Nie masz uprawnień do przeglądania tej strony.
            </section>    
<?php
}
}
/* {/block 'content'} */
}
