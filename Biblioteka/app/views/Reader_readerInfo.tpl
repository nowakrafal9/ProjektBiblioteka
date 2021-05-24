{extends file = "main_template.tpl"}

{block name = "content"}
    
    <section style="padding-top: 1em; padding-bottom: 1em">    

        <h3>{$r["name"]}, {$r["surname"]} {if {$user->role}=="Administrator"} [<a href='{url action = "readerEdit"}/{$r["id_borrower"]}' style='color:#9a9a9a'>Edytuj</a>] {/if}</h3> 
        <div class="row">       
            <div class="col-6 col-12-small">
                <h3>Dane kontaktowe: </h3>
                <p>
                    <strong>Miasto:</strong> {$r["city"]} <br/> 
                    <strong>Adres:</strong> {$r["address"]} <br/>
                    <strong>Kod pocztowy:</strong> {$r["postal_code"]} <br/>      
                </p>
                <p>
                    <strong>Telefon:</strong> {$r["phone_number"]} <br/>             
                    <strong>Email:</strong> {if {$r["email"]} == ""}Brak{else}{$r["email"]}{/if} <br/>
                </p>
            </div>

            <div class="col-6 col-12-small">
                <h3>Wypożyczone książki:</h3>
                {if {$numRecords} > 0}
                    <table class="alt">
                        <thead>
                            <tr>
                                <th style="width: 20%">Kod książki</th>
                                <th style="width: 60%">Tytuł</th>
                                <th style="width: 20%">Data zwrotu</th>       
                            </tr>
                        </thead>
                        {foreach $records as $r}
                            {strip}
                                <tr>
                                    <td style="width: 20%">{$r["id_book"]}</td> 
                                    <td style="width: 60%">{$r["title"]}</td> 
                                    {if {$dateToday} > {$r["return_date"]}}
                                        <td style="width: 20%; background-color: #f56a6a;"><strong>{$r["return_date"]}</strong></td>
                                    {else}
                                        <td style="width: 20%">{$r["return_date"]}</td>
                                    {/if}    
                                </tr>
                            {/strip}
                        {/foreach}
                    </table>
                {else}
                    <h4>Brak wypożyczonych książek</h4>
                {/if}                  
            </div>
        </div>

    </section>

    <section style="padding-top: 1em; padding-bottom: 1em">

        <a href="{url action = 'readerList'}" class="button primary">Powrót</a>

    </section>
        
{/block}