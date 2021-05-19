{extends file = "main_template.tpl"}

{block name = "content"}
    
    {if {$pageMode} == "borrowedList"}
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
                                <td style="width: 10%"><center><a href="{url action = 'borrowedInfo'}/{$r["id_book"]}" class="button small">Oddaj</a></center></td> 
                            </tr>
                        {/strip}
                        {/foreach}
                    </tbody>
                </table>
            {else}
                <h4>Brak wypożyczonych książek.</h4>
            {/if}
        </section>
    {/if}
    
    {if {$pageMode} == "borrowedInfo"}
        <section style="padding-top: 1em; padding-bottom: 1em">
            {foreach $records as $r}
                <div class="row">
                    <div class="col-6 col-12-small">
                        <h3>Wypożyczona książka</h3>
                        <strong>Kod książki:</strong> {$r["id_book"]} <br/>
                        <strong>Tytuł książki:</strong> {$r["title"]} <br/>
                        <strong>Data wypożyczenia:</strong> {$r["borrow_date"]} <br/>
                        <strong>Data oddania:</strong> {$r["return_date"]} <br/>
                        <strong>Pozostały czas: </strong> Do zrobienia <br/>
                    </div>

                    <div class="col-6 col-12-small">
                        <h3>Dane czytelnika</h3>
                        <strong>Kod czytelnika:</strong> {$r["id_borrower"]} <br/>
                        <strong>Imie:</strong> {$r["name"]} <br/>
                        <strong>Nazwisko:</strong> {$r["surname"]} <br/>
                        <strong>Nr telefonu:</strong> {$r["phone_number"]} <br/>
                    </div>
                </div>
            {/foreach}
        </section>
    
        <section style="padding-top: 1em; padding-bottom: 1em">
            <h4>Czy na pewno chcesz zwrócić książkę?</h4>
                <a href="{url action = 'borrowedReturn'}/{$id_book}" class="button primary small">Zwróć</a>
                <a href="{url action = 'borrowedList'}" class="button small">Powrót</a>
        </section>
    {/if}
{/block}