{extends file = "main_template.tpl"}

{block name=content}
    <section style = "padding-top: 1em; padding-bottom: 0;">
        <form method="post" action="{url action = 'borrowedList'}">
            
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="id_book" id="id_book" value="" placeholder="Kod książki" />
                </div>	
                
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="id_book" id="id_book" value="" placeholder="Kod czytelnika" />
                </div>	
                
                <div class="col-3">
                    <select name="status" id="status">
                        <option value="" selected disabled hidden>Status</option>
                        <option value="0" {if isset($searchForm->borrowed) and $searchForm->borrowed==0}selected{/if}>Po terminie</option>
                        <option value="1" {if isset($searchForm->borrowed) and $searchForm->borrowed==1}selected{/if}>OK</option>
                    </select>
                </div>   	
            </div>
                
            <input type="submit" value="Szukaj" class="primary">
            <a href="{url action = 'borrowedList'}" class="button">Wyczyść filtr</a>
        </form>    
    </section>
    
    <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">
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
                    <td style="width: 10%"><center><a href="{url action = 'borrowedInfo'}/{$r["id_book"]}" class="button small">Szczegóły</a></center></td> 
                </tr>
            {/strip}
            {/foreach}
        </tbody>
    </table>
    </section>
{/block}
