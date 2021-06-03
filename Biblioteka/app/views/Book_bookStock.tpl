{extends file = "main_template.tpl"}

{block name=content}
   
    <section style = "padding-top: 1em; padding-bottom: 0;">

        <form method="post" action="{url action = 'bookStock'}">          
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="book_code" id="book_code" value="{$searchForm->book_code}" placeholder="Kod książki" />
                </div>	

                <div class="col-6 col-5-xsmal">
                    <input type="text" name="title" id="title" value="{$searchForm->title}" placeholder="Tytuł" />
                </div>	

                <div class="col-3">
                    <select name="borrowed" id="borrowed">
                        <option value="" selected disabled hidden>Wszystkie</option>
                        <option value="0" {if isset($searchForm->borrowed) and $searchForm->borrowed==0}selected{/if}>Niewypożyczone</option>
                        <option value="1" {if isset($searchForm->borrowed) and $searchForm->borrowed==1}selected{/if}>Wypożyczone</option>
                    </select>
                </div>
            </div>

            <input type="submit" value="Szukaj" class="primary">
            <a href="{url action = 'bookStock'}" class="button">Wyczyść filtr</a>
        </form> 
         <p>
            <a href="{url action = 'bookAdd'}" class="button primary icon solid fa-plus">Dodaj książkę</a>
        </p>
    </section>

    <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">

        {if {$numRecords > 0}}
            <table class="alt">
                <thead>
                    <tr>
                        <th style="width: 10%">Kod książki</th>
                        <th style="width: 60%">Tytuł</th>
                        <th style="width: 15%">Status</th>    
                        <th style="width: 15%"></th>  
                    </tr>
                </thead>

                <tbody>
                    {foreach $records as $r}
                    {strip}
                        <tr>
                            <td style="width: 10%">{$r["id_book"]}</td> 
                            <td style="width: 60%">{$r["title"]}</td>
                            <td style="width: 15%">{if {$r["borrowed"]} == "0"}Niewypożyczona{else}Wypożyczona{/if}</td>   
                            <td style="width: 15%">
                                {if {$r["borrowed"]} == "0"}
                                    <center><a href="{url action = 'bookDelete'}/{$r["id_book"]}" class="button small">Usuń</a></center>
                                {else}
                                    <center><span class="button small disabled">Usuń</span></center>
                                {/if}
                            </td> 

                        </tr>
                    {/strip}
                    {/foreach}
                </tbody>
            </table>
                
            <form method="post">
            {if {$searchForm->book_code}}
                <input type="hidden" name="book_code" value="{$searchForm->book_code}">
            {/if}
            {if {$searchForm->title}}
                <input type="hidden" name="title" value="{$searchForm->title}">
            {/if}
            {if {$searchForm->borrowed}}
                <input type="hidden" name="borrowed" value="{$searchForm->borrowed}">
            {/if}

            <center>
                <button class="primary" formaction="{url action = "readerList" p = 1}" {if {$page}==1}disabled{/if}> &lt;&lt; </button>
                <button class="primary" formaction="{url action = "bookStock" p = 1}" {if {$page}==1}disabled{/if}> &lt;&lt; </button>
                <button class="primary" formaction="{url action = "bookStock" p = {$page-1}}" {if {$page-1}==0}disabled{/if}> &lt; </button>
                <span style="margin:5%">Strona {$page} z {$lastPage-1}</span>
                <button class="primary" formaction="{url action = "bookStock" p = {$page+1}}" {if {$page+1}=={$lastPage}}disabled{/if}> &gt; </button>
                <button class="primary" formaction="{url action = "readerList" p = {$lastPage-1}}" {if {$page}=={$lastPage-1}}disabled{/if}> &gt;&gt; </button>
            </center>
            </form>
        {else}
            <h4>Brak książek w bibliotece</h4>
        {/if}

    </section>
          
    {include file = "messages.tpl"}
{/block}