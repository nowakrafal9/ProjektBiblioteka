{extends file = "main_template.tpl"}

{block name=content}
    <section style="padding-top: 1em; padding-bottom: 1em">
       {foreach $records1 as $r}
            <h3 class="content">{$r["name"]}, {$r["surname"]}  </h3>
            
            <h4>Miejsce zamieszkania:</h4>
            <p>
                Miasto: {$r["city"]} <br/> 
                Kod pocztowy: {$r["postal_code"]} <br/>    
                Adres: {$r["address"]} <br/>
            </p>
            
            <h4>Dane kontaktowe:</h4>
            <p>
                Telefon: {$r["phone_number"]} <br/>             
                Email: {if {$r["email"]} == ""}Brak{else}{$r["email"]}{/if} <br/>
            </p>
        {/foreach}
    </section>
        
    <section style="padding-top: 1em; padding-bottom: 1em">
        <h4>Wypożyczone książki:</h4>
        
        {if {$numRecords} > 0}
        <table class="alt">
            <thead>
                <tr>
                    <th style="width: 15%">Kod książki</th>
                    <th style="width: 50%">Tytuł</th>
                    <th style="width: 20%">Data zwrotu</th>       
                    <th style="width: 15%"></th>  
                </tr>
            </thead>

            {foreach $records2 as $r}
                {strip}
                    <tr>
                        <td style="width: 10%">{$r["id_book"]}</td> 
                        <td style="width: 50%">{$r["title"]}</td> 
                        {if {$dateToday} > {$r["return_date"]}}
                            <td style="width: 20%; background-color: #f56a6a;">{$r["return_date"]}</td>
                        {else}
                            <td style="width: 20%">{$r["return_date"]}</td>
                        {/if}    
                        <td style="width: 10%"><center><a href="{$conf->action_url}borrowedBooksInfo" class="button small">Szczegóły</a></center></td>
                    </tr>
                {/strip}
            {/foreach}
        </table>
        {else}
            <h4>Brak wypożyczonych książek.</h4>
        {/if}
    </section>
        
    <section style="padding-top: 1em; padding-bottom: 1em">
              <a href="{$conf->action_url}readerList" class="button primary">Powrót</a>
    </section>
{/block}


