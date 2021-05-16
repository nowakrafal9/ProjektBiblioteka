{extends file = "main_template.tpl"}

{block name=content}
    <section style = "padding-top: 1em; padding-bottom: 0;">
        <form method="post" action="{$conf->action_url}readerList">
            
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="person_id" id="person_id" value="" placeholder="Id czytelnika" />
                </div>	
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="name" id="name" value="" placeholder="Imię" />
                </div>						
                <div class="col-3 col-3-xsmall">
                    <input type="text" name="surname" id="surname" value="" placeholder="Nazwisko" />
                </div>    						
            </div>
                
            <input type="submit" value="Szukaj" class="primary">
            <a href="{$conf->action_url}borrowedBooks" class="button">Wyczyść filtr</a>
        </form>    
    </section>
    
    <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">
    <table class="alt">
        <thead>
            <tr>
                <th style="width: 10%">Kod książki</th>
                <th style="width: 10%">Kod czytelnika</th>
                <th style="width: 20%">Data wypożyczenia</th>    
                <th style="width: 20%">Data oddania</th>  
                <th style="width: 20%">Status wypożyczenia</th>  
            </tr>
        </thead>

        <tbody>
            {foreach $records as $r}
            {strip}
                <tr>
                    <td style="width: 10%">{$r["book_code"]}</td> 
                    <td style="width: 10%">{$r["id_borrower"]}</td>
                    <td style="width: 15%">{$r["borrow_date"]}</td>   
                    <td style="width: 15%">{$r["return_date"]}</td> 
                    {if {$dateToday} > {$r["return_date"]}}
                        <td style="width: 10%; background-color: #f56a6a;"><strong>Po terminie!</strong></td>
                    {else}
                        <td style="width: 10%">OK</td>
                    {/if}
                    <td style="width: 10%"><center><a href="{$conf->action_url}borrowedBooksInfo" class="button small">Szczegóły</a></center></td> 
                </tr>
            {/strip}
            {/foreach}
        </tbody>
    </table>
    </section>
{/block}
