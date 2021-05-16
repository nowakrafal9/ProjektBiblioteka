{extends file = "main_template.tpl"}

{block name=content}
    <section style="padding-top: 1em; padding-bottom: 1em">
       {foreach $records as $r}
            <h3 class="content">{$r["name"]}, {$r["surname"]}  </h3>
            
            <h4>Miejsce zamieszkania:</h4>
            <p>
                Miasto: {$r["city"]} <br/>             
                Adres: {$r["address"]} <br/>
            </p>
            
            <h4>Dane kontaktowe:</h4>
            <p>
                Telefon: {$r["phone_number"]} <br/>             
                Email: {if {$r["email"]} == ""}Brak{else}{$r["email"]}{/if} <br/>
            </p>
        {/foreach}
       
        <a href="{$conf->action_url}readerList" class="button primary">Powrót</a>
    </section>
{/block}


