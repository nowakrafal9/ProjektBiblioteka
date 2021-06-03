{extends file = "main_template.tpl"}

{block name=content}
    
    <section style="padding-top: 1em; padding-bottom: 1em">

        <form method="post" action="{url action = 'bookList'}">
             <div class="row gtr-uniform" style="padding-bottom:0.75em">
                 <div class="col-12">
                     <input type="text" name="title" id="title" value="{$searchForm->title}" placeholder="Tytuł szukanej książki" />
                 </div>							
             </div>
             <input type="submit" value="Szukaj" class="primary">
             <a href="{url action = 'bookList'}" class="button">Wyczyść filtr</a>
         </form>

    </section>

    <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">

        {if {$numRecords} > 0}
            <table class="default">
                <tbody>
                    {foreach $records as $r}
                    {strip}
                        <tr>
                            <td style="width: 90%">{$r["title"]}</td>
                            <td style="width: 10%"><center><a href="{url action = 'bookInfo'}/{$r['id_book']}" class="button small">Informacje</a></center></td>
                        </tr>
                    {/strip}
                    {/foreach}
                </tbody>
            </table>
                
            <form method="post">
                {if {$searchForm->title}}
                    <input type="hidden" name="title" value="{$searchForm->title}">
                {/if}
     
                <center>
                    <button class="primary" formaction="{url action = "bookList" p = 1}" {if {$page}==1}disabled{/if}> &lt;&lt; </button>
                    <button class="primary" formaction="{url action = "bookList" p = {$page-1}}" {if {$page-1}==0}disabled{/if}> &lt; </button>
                    <span style="margin:5%">Strona {$page} z {$lastPage-1}</span>
                    <button class="primary" formaction="{url action = "bookList" p = {$page+1}}" {if {$page+1}=={$lastPage}}disabled{/if}> &gt; </button>
                    <button class="primary" formaction="{url action = "bookList" p = {$lastPage-1}}" {if {$page}=={$lastPage-1}}disabled{/if}> &gt;&gt; </button>
                </center>
            </form>
        {else}
            <h4>Nie znaleziono szukanych tytułów w bibliotece.</h4>
        {/if}

    </section>
            
{/block}