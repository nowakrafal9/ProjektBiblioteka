<?php
/* Smarty version 3.1.34-dev-7, created on 2021-05-14 15:48:33
  from 'D:\xampp\htdocs\pliki\ProjektBiblioteka\app\views\Main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_609e7fb1069414_82211877',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '080546efc1b582fd5f74f6ca1f947cb2b8425a07' => 
    array (
      0 => 'D:\\xampp\\htdocs\\pliki\\ProjektBiblioteka\\app\\views\\Main.tpl',
      1 => 1620999839,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_609e7fb1069414_82211877 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_946214095609e7fb0c9b3d4_10431339', 'content');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "main_template.tpl");
}
/* {block 'content'} */
class Block_946214095609e7fb0c9b3d4_10431339 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_946214095609e7fb0c9b3d4_10431339',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <section>
                <div class="features">
                    <article onclick="location='<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
readerList'" onmouseover="this.style.backgroundColor='#F4F4F4'" onmouseout="this.style.backgroundColor=''" style = "cursor: pointer; ">
                        <span class="icon solid fa-user"></span>
                        <div class="content">
                            <h3>Lista czytelników</h3>
                            <p>Sprawdź dane czytelników zarejestrowanych w NASZEJ bibliotece</p>
                        </div>
                    </article>

                    <article onclick="location='<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
bookInfo'" onmouseover="this.style.backgroundColor='#F4F4F4'" onmouseout="this.style.backgroundColor=''" style = "cursor: pointer; ">
                        <span class="icon solid fa-book-open"></span>
                        <div class="content">
                            <h3>Informacja o książkach</h3>
                            <p>Sprawdź informacje o szukanej książce</p>
                        </div>
                    </article>

                    <article onclick="location='<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
opcja3'" onmouseover="this.style.backgroundColor='#F4F4F4'" onmouseout="this.style.backgroundColor=''" style = "cursor: pointer; ">
                        <span class="icon solid fa-book-reader"></span>
                        <div class="content">
                            <h3>Wypożyczone książki</h3>
                            <p>Wypożycz książki, sprawdź które książki są obecnie wypożyczone oraz kiedy mijają ich terminy wypożyczeń</p>
                        </div>
                    </article>

                    <article onclick="location='<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
opcja4'" onmouseover="this.style.backgroundColor='#F4F4F4'" onmouseout="this.style.backgroundColor=''" style = "cursor: pointer; ">
                        <span class="icon solid fa-building"></span>
                        <div class="content">
                            <h3>Lista książek</h3>
                            <p>Sprawdź liste wszysktich książek będących własnością biblioteki</p>
                        </div>
                    </article>
                </div>
            </section>    
<?php
}
}
/* {/block 'content'} */
}
