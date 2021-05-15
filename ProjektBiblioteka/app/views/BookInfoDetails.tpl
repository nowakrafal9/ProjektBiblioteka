{extends file = "main_template.tpl"}

{block name=content}
    <section style="padding-top: 1em; padding-bottom: 1em">
       {foreach $records as $r}
            <h3 class="content">{$r["title"]} </h3>          
            Autor: {$r["author"]} <br/>             
            Wydawnictwo: {$r["publisher"]} <br/>
            Gatunek: {$r["genre"]} <br/>
            Ilość stron: {$r["pages"]} <br/> <br/>
            
            Placeholder na krótki opis książki.
        {/foreach}
    </section>
{/block}

