{extends file = "main_template.tpl"}

{block name=content}
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
{/block}

