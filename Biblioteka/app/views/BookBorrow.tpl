{extends file = "main_template.tpl"}

{block name=content}
    
    {if {$pageMode} == "bookBorrowed"}
        <section style = "padding-top: 1em; padding-bottom: 0;">
            <h3>Wypożyczono książkę</h3>
            
            <a href="{url action = 'borrowedList'}" class="button primary">Powrót</a>
        </section>  
    {/if}
    
        
        
    {if {$pageMode} == "selectBorrower"}
        <section style = "padding-top: 1em; padding-bottom: 0;">
            <div class="row">                    
                <div class="col-6 col-12-small">
                    <h3>Wyszukaj książkę:</h3> 
                    <form>
                        <div class="row gtr-uniform">
                            <div class="col-4 col-12-xsmall">
                                <strong>Kod książki:</strong>
                                <input type="text" name="id_book" id="id_book" value="{$id_book}" placeholder="Id książke" disabled="">
                            </div>

                            <div class="col-8 col-12-xsmall">
                                <strong>Tytuł:</strong>
                                <input type="text" name="title" id="title" value="{$title}" placeholder="Tytuł" disabled>
                            </div>
                        </div>
                    </form>
                </div>
                            
                <div class="col-6 col-12-small">
                    <h3>Wyszukaj czytelnika:</h3> 
                    <form>
                        <div class="row gtr-uniform">
                            <div class="col-6 col-12-xsmall">
                                <strong>Imię:</strong>
                                <input type="text" name="name" id="name" value="{$searchForm->name}" placeholder="Imie">
                            </div>

                            <div class="col-6 col-12-xsmall">
                                <strong>Nazwisko:</strong>
                                <input type="text" name="surname" id="surnamee" value="{$searchForm->surname}" placeholder="Nazwisko">
                            </div>

                            <div class="col-6 col-12-xsmall">
                                <strong>Kod czytelnika:</strong>
                                <input type="text" name="id_reader" id="id_reader" value="{$searchForm->id_reader}" placeholder="Kod czytelnika">
                            </div>

                            <div class="col-12">
                                <input type="submit" value="Szukaj" class="primary">
                                <a href="{url action = 'bookBorrow'}/{$id_book}" class="button">Wyczyść filtr</a>
                            </div>  
                        </div>
                    </form>
                </div>
                
            </div>
        </section>
        
        <section style = "padding-top: 1em; padding-bottom: 0;">
            {if {$formSent} == 1}
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
                                    <td style="width: 10%" ><center><a href="{url action = 'bookBorrow'}/{$id_book}/{$r['id_borrower']}" class="button small">Wypożycz</a></center></td>  
                                </tr>
                            {/strip}
                            {/foreach}
                        </tbody>
                    </table>
                {else}
                    <h3>Brak szukanych czytelników.</h3>
                {/if}
            {/if}
        </section>
    {/if}
        
        
        
    {if {$pageMode} == "selectBook"}
        <section style = "padding-top: 1em; padding-bottom: 4.3em;">
            <div class="row">       
                <div class="col-6 col-12-small">
                    <h3>Wyszukaj książkę:</h3> 
                    <form>
                        <div class="row gtr-uniform">
                            <div class="col-4 col-12-xsmall">
                                <strong>Kod książki:</strong>
                                <input type="text" name="id_book" id="id_book" value="{$searchForm->id_book}" placeholder="Id książki">
                            </div>

                            <div class="col-8 col-12-xsmall">
                                <strong>Tytuł:</strong>
                                <input type="text" name="title" id="title" value="{$searchForm->title}" placeholder="Tytuł">
                            </div>

                            <div class="col-12">
                                <input type="submit" value="Szukaj" class="primary">
                                <a href="{url action = 'bookBorrow'}" class="button">Wyczyść filtr</a>
                            </div>  
                        </div>
                    </form>
                </div>

                <div class="col-6 col-12-small">
                    <h3>Wyszukaj czytelnika:</h3> 
                    <form>
                        <div class="row gtr-uniform">
                            <div class="col-6 col-12-xsmall">
                                <strong>Imię:</strong>
                                <input type="text" name="name" id="name" value="" placeholder="Imie" disabled>
                            </div>

                            <div class="col-6 col-12-xsmall">
                                <strong>Nazwisko:</strong>
                                <input type="text" name="surname" id="surnamee" value="" placeholder="Nazwisko" disabled>
                            </div>

                            <div class="col-6 col-12-xsmall">
                                <strong>Kod czytelnika:</strong>
                                <input type="text" name="id_reader" id="id_reader" value="" placeholder="Kod czytelnika" disabled>
                            </div>
                        </div>
                    </form>
                </div>      
            </div>
        </section>
        
        <section style = "padding-top: 1em; padding-bottom: 0;">
            {if {$formSent} == 1}
                {if {$numRecords} > 0}
                    <table class="alt">
                        <thead>
                            <tr>
                                <th style="width: 15%">Id książki</th>
                                <th style="width: 75%">Tytuł</th>
                                <th style="width: 10%"> </th>
                            </tr>
                        </thead>

                        <tbody>
                            {foreach $records as $r}
                            {strip}
                                <tr>
                                    <td style="width: 15%">{$r["id_book"]}</td> 
                                    <td style="width: 75%">{$r["title"]}</td>  
                                    <td style="width: 10%" ><center><a href="{url action = 'bookBorrow'}/{$r["id_book"]}" class="button small">Wypożycz</a></center></td>  
                                </tr>
                            {/strip}
                            {/foreach}
                        </tbody>
                    </table>
                {else}
                    <h3>Brak szukanych książek.</h3>
                {/if}
            {/if}
        </section>
    {/if}
{/block}



