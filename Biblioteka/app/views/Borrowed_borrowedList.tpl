{extends file = "main_template.tpl"}

{block name=content}
    
    <section style = "padding-top: 1em; padding-bottom: 0;">

        <form method="post" action="{url action = 'borrowedList'}">

            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="id_book" id="id_book" value="{$searchForm->id_book}" placeholder="Kod książki" />
                </div>	

                <div class="col-3 col-5-xsmal">
                    <input type="text" name="id_reader" id="id_reader" value="{$searchForm->id_reader}" placeholder="Kod czytelnika" />
                </div>	

                <div class="col-3">
                    <select name="status" id="status">
                        <option value="" selected disabled hidden>Status</option>
                        <option value="0" {if isset($searchForm->status) and $searchForm->status==0}selected{/if}>Po terminie</option>
                        <option value="1" {if isset($searchForm->status) and $searchForm->status==1}selected{/if}>W terminie</option>
                    </select>
                </div>   	
            </div>

            <input type="submit" value="Szukaj" class="primary">
            <a href="{url action = 'borrowedList'}" class="button">Wyczyść filtr</a>
        </form>    

        <p>
            <a href="{url action = 'bookBorrow'}" class="button primary icon solid fa-plus">Wypożycz książkę</a>
        </p>

    </section>

    <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">

        {if {$numRecords} > 0}
            <table class="alt">
                <thead>
                    <tr>
                        <th style="width: 10%">Kod książki</th>
                        <th style="width: 10%">Kod czytelnika</th>  
                        <th style="width: 15%">Data wypożyczenia</th> 
                        <th style="width: 15%">Data oddania</th>  
                        <th style="width: 10%"> </th>
                    </tr>
                </thead>

                <tbody>
                    {foreach $records as $r}
                    {strip}
                        <tr>
                            <td style="width: 10%">{$r["id_book"]}</td> 
                            <td style="width: 10%">{$r["id_borrower"]}</td> 
                            <td style="width: 15%">{$r["borrow_date"]}</td> 
                            {if {$dateToday} > {$r["return_date"]}}
                                <td style="width: 15%; background-color: #f56a6a;"><strong>{$r["return_date"]}</strong></td>
                            {else}
                                <td style="width: 15%">{$r["return_date"]}</td>
                            {/if}
                            <td style="width: 10%"><center><a href="{url action = 'borrowedReturn'}/{$r["id_book"]}" class="button small">Oddaj</a></center></td> 
                        </tr>
                    {/strip}
                    {/foreach}
                </tbody>
            </table>
        {else}
            <h4>Brak wypożyczonych książek.</h4>
        {/if}

    </section>
            
{/block}