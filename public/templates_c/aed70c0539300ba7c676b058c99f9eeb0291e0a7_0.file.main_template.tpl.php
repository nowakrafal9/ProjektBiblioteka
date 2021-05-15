<?php
/* Smarty version 3.1.34-dev-7, created on 2021-05-14 15:48:33
  from 'D:\xampp\htdocs\pliki\ProjektBiblioteka\app\views\templates\main_template.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_609e7fb1448282_54659000',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aed70c0539300ba7c676b058c99f9eeb0291e0a7' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pliki\\ProjektBiblioteka\\app\\views\\templates\\main_template.tpl',
      1 => 1620999828,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_609e7fb1448282_54659000 (Smarty_Internal_Template $_smarty_tpl) {
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
                        <a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
main" class="logo"><strong>Biblioteka im. Włodzimierza Lenina</strong></a>
                        Zalogowany użytkownik: <?php echo $_smarty_tpl->tpl_vars['user']->value->login;?>

                    </header>
                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1239416406609e7fb1443881_84807328', "content");
?>
                 
                </div>
            </div>
                
            <!-- Sidebar -->
            <div id="sidebar">
                <div class="inner">
                    <!-- Menu -->          
                    <nav id="menu">
                        <header class="major">
                                <h2>Menu</h2>
                        </header>
                        <ul>
                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
main">Strona główna</a></li>
                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
readerList">Lista czytelników</a></li>
                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
bookInfo">Informacje o książce</a></li>
                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
opcja3">Wypożyczone książki</a></li>
                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
opcja4">Lista książek</a></li>   
                        </ul>
                    </nav>
                           
                    <nav id="menu">
                        <ul>
                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
logout">Wyloguj</a></li>
                        </ul>
                    </nav>
                        
                    <!-- Footer -->
                    <footer id="footer">
                        <p class="copyright">&copy; Untitled. All rights reserved. Demo Images: <a href="https://unsplash.com">Unsplash</a>. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
                    </footer>
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
</html><?php }
/* {block "content"} */
class Block_1239416406609e7fb1443881_84807328 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_1239416406609e7fb1443881_84807328',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 Domyślna treść strony <?php
}
}
/* {/block "content"} */
}
