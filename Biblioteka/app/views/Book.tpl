{extends file = "main_template.tpl"}

{block name=content}
    
    {if {$pageMode} == "bookList"}
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
            {else}
                <h4>Brak tytułów w bibliotece.</h4>
            {/if}
        </section>
    {/if}
    
        
        
    {if {$pageMode} == "bookInfo"}
        <section style="padding-top: 1em; padding-bottom: 1em">
           {foreach $records as $r}
                <h3 class="content">{$r["title"]} </h3>   
                <p>
                    Autor: {$r["name"]} {$r["surname"]} <br/>             
                    Wydawnictwo: {$r["publisher"]} <br/>
                    Gatunek: {$r["genre"]} <br/>
                    Ilość stron: {$r["pages"]} <br/>
                </p>
            {/foreach}
        </section> 
    
        <section style="padding-top: 1em; padding-bottom: 1em">
            <a href="{url action = 'bookList'}" class="button primary">Powrót</a>
        </section> 
    {/if}
        
{/block}