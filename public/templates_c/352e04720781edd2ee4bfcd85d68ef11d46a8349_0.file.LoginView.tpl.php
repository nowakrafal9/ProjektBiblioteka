<?php
/* Smarty version 3.1.34-dev-7, created on 2021-05-14 11:42:02
  from 'D:\xampp\htdocs\pliki\ProjektBiblioteka\app\views\LoginView.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_609e45eaeea517_03250805',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '352e04720781edd2ee4bfcd85d68ef11d46a8349' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pliki\\ProjektBiblioteka\\app\\views\\LoginView.tpl',
      1 => 1620985320,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_609e45eaeea517_03250805 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_755283847609e45eaedfaf7_57944361', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "login_template.tpl");
}
/* {block 'content'} */
class Block_755283847609e45eaedfaf7_57944361 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_755283847609e45eaedfaf7_57944361',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <section>
        <h3>Zaloguj się aby kontynuować:</h3>
        <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
login">
            
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="login" id="login" value="" placeholder="Login" />
                </div>						
            </div>          
            
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                    <div class="col-3 col-3-xsmall">
                        <input type="password" name="pass" id="pass" value="" placeholder="Password" />
                    </div>    						
            </div>
            
            <input type="submit" value="Zaloguj się" class="primary"">
        </form>  
        
        <?php if ($_smarty_tpl->tpl_vars['msgs']->value->isMessage()) {?>
            <ul>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['msgs']->value->getMessages(), 'msg');
$_smarty_tpl->tpl_vars['msg']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['msg']->value) {
$_smarty_tpl->tpl_vars['msg']->do_else = false;
?>
                    <strong style="color:#f56a6a"><li><?php echo $_smarty_tpl->tpl_vars['msg']->value->text;?>
</li></strong>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </ul>
        <?php }?>
    </section>
<?php
}
}
/* {/block 'content'} */
}
