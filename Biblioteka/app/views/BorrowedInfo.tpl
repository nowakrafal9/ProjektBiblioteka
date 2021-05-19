{extends file = "main_template.tpl"}

{block name=content}
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
{/block}