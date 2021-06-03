{extends file = "main_template.tpl"}

{block name = "content"}
    
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
        {if {$user->role}=="Administrator"}
            <p>
                <a href="{url action = 'readerAdd'}" class="button primary icon solid fa-plus">Dodaj czytelnika</a>
            </p>
        {/if}

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
            <h4>Brak znalezionych czytelników.</h4>
        {/if}

    </section>

{/block}