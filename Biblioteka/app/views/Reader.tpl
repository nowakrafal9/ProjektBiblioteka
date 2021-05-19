{extends file = "main_template.tpl"}

{block name = "content"}
    
    {if {$pageMode} == "readerList"}
        <section style = "padding-top: 1em; padding-bottom: 0;">
            <form method="post" action="{url action = 'readerList'}">

                <div class="row gtr-uniform" style="padding-bottom:0.75em">
                    <div class="col-3 col-5-xsmal">
                        <input type="text" name="id_reader" id="id_reader" value="{$searchForm->id_reader}" placeholder="Id czytelnika" />
                    </div>	
                    <div class="col-3 col-5-xsmal">
                        <input type="text" name="name" id="name" value="{$searchForm->name}" placeholder="Imię" />
                    </div>						
                    <div class="col-3 col-3-xsmall">
                        <input type="text" name="surname" id="surname" value="{$searchForm->surname}" placeholder="Nazwisko" />
                    </div>    						
                </div>

                <input type="submit" value="Szukaj" class="primary">
                <a href="{url action = 'readerList'}" class="button">Wyczyść filtr</a>
            </form>    
        </section>

        <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">
            {if {$numRecords} > 0}
                <table class="alt">
                    <thead>
                        <tr>
                            <th style="width: 10%">Id czytelnika</th>
                            <th style="width: 40%">Nazwisko</th>
                            <th style="width: 40%">Imię</th>  
                            <th style="width: 10%"> </th>
                        </tr>
                    </thead>

                    <tbody>
                        {foreach $records as $r}
                        {strip}
                            <tr>
                                <td style="width: 10%">{$r["id_borrower"]}</td> 
                                <td style="width: 40%">{$r["surname"]}</td>
                                <td style="width: 40%">{$r["name"]}</td>      
                                <td style="width: 10%" ><center><a href="{url action = 'readerInfo'}/{$r['id_borrower']}" class="button small">Informacje</a></center></td>  
                            </tr>
                        {/strip}
                        {/foreach}
                    </tbody>
                </table>
            {else}
                <h4>Brak zarejestrowanych czytelników.</h4>
            {/if}
        </section>
    {/if}

    
    
    {if {$pageMode} == "readerInfo"}
        <section style="padding-top: 1em; padding-bottom: 1em">    
            <h3>{$readerName}, {$readerSurname}</h3>
            <div class="row">       
                <div class="col-6 col-12-small">
                    {foreach $records1 as $r}
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
                    {/foreach}
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
                            {foreach $records2 as $r}
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
    {/if}
        
{/block}