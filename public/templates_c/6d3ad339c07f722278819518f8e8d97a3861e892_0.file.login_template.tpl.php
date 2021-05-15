<?php
/* Smarty version 3.1.34-dev-7, created on 2021-05-14 11:44:46
  from 'D:\xampp\htdocs\pliki\ProjektBiblioteka\app\views\templates\login_template.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_609e468ed06098_46214251',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6d3ad339c07f722278819518f8e8d97a3861e892' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pliki\\ProjektBiblioteka\\app\\views\\templates\\login_template.tpl',
      1 => 1620985484,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_609e468ed06098_46214251 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
    <head>
        <title>Bibliotekos</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/css/main.css" />
    </head>
    <body class="is-preload">
        
        <!-- Wrapper -->
        <div id="wrapper">
            
            <!-- Main -->
            <div id="main">
                <div class="inner">

                    <!-- Header -->
                    <header id="header">
                        <strong class="logo" style="color: #3d4449">Biblioteka im. Włodzimierza Lenina</strong>
                    </header>
                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2072691565609e468ed038c2_46122280', "content");
?>
                 
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/jquery.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/browser.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/breakpoints.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/util.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['conf']->value->app_url;?>
/js/main.js"><?php echo '</script'; ?>
>
    </body>
</html>
<?php }
/* {block "content"} */
class Block_2072691565609e468ed038c2_46122280 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_2072691565609e468ed038c2_46122280',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 Domyślna treść strony <?php
}
}
/* {/block "content"} */
}
