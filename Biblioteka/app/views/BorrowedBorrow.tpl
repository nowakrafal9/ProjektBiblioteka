{extends file = "main_template.tpl"}

{block name=content}
    
    {if {$pageMode} == "bookBorrowed"}
        <section style = "padding-top: 1em; padding-bottom: 0;">
            Wypożyczono książkę
        </section>  
    {/if}
    
        
        
    {if {$pageMode} == "selectBorrower"}
        <section style = "padding-top: 1em; padding-bottom: 0;">
            <div class="row">       
                <div class="col-6 col-12-small">
                    <h3>Informacje o książce:</h3>
                    {$id_book}, {$book_code}, {$title}
                </div>

                <div class="col-6 col-12-small">
                    <h3>Wyszukaj czytelnika:</h3> 
                    <form>
                        <div class="row gtr-uniform">
                            <div class="col-6 col-12-xsmall">
                                <input type="text" name="name" id="name" value="{$searchForm->name}" placeholder="Imie">
                            </div>

                            <div class="col-6 col-12-xsmall">
                                <input type="text" name="surname" id="surnamee" value="{$searchForm->surname}" placeholder="Nazwisko">
                            </div>

                            <div class="col-6 col-12-xsmall">
                                <input type="text" name="id_reader" id="id_reader" value="{$searchForm->id_reader}" placeholder="Kod czytelnika">
                            </div>

                            <div class="col-12">
                                <input type="submit" value="Szukaj" class="primary">
                                <a href="{url action = 'borrowedBorrow'}/{$id_book}" class="button">Wyczyść filtr</a>
                            </div>  
                        </div>
                    </form>
                </div>
                
            </div>
        </section>
        
        <section style = "padding-top: 1em; padding-bottom: 0;">
            {if {$formSent} == 1}
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
                                <td style="width: 10%" ><center><a href="{url action = 'borrowedBorrow'}/{$id_book}/{$r['id_borrower']}" class="button small">Wypożycz</a></center></td>  
                            </tr>
                        {/strip}
                        {/foreach}
                    </tbody>
                </table>
            {/if}
        </section>
    {/if}
{/block}



