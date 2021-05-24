{extends file = "main_template.tpl"}

{block name=content}
    
    <section style="padding-top: 1em; padding-bottom: 1em">

        <div class="row">
            <div class="col-6 col-12-small">
                <h3>Wypożyczona książka</h3>
                <strong>Kod książki:</strong> {$book["id_book"]} <br/>
                <strong>Tytuł książki:</strong> {$book["title"]} <br/>
                <strong>Data wypożyczenia:</strong> {$book["borrow_date"]} <br/>
                <strong>Data oddania:</strong> {$book["return_date"]} <br/>
                {if {$afterDeadline} == 'no'}
                    <strong>Pozostały czas: </strong> {$timeLeft}<br/>
                {else}
                    <strong>Po terminie: </strong> {$timeLeft}<br/>
                {/if} 
            </div>

            <div class="col-6 col-12-small">
                <h3>Dane czytelnika</h3>
                <strong>Kod czytelnika:</strong> {$reader["id_borrower"]} <br/>
                <strong>Imie:</strong> {$reader["name"]} <br/>
                <strong>Nazwisko:</strong> {$reader["surname"]} <br/>
                <strong>Nr telefonu:</strong> {$reader["phone_number"]} <br/>
            </div>
        </div>

    </section>

    <section style="padding-top: 1em; padding-bottom: 1em">

        <h4>Czy na pewno chcesz zwrócić książkę?</h4>
        <a href="{url action = 'bookReturn'}/{$book["id_book"]}" class="button primary small">Zwróć</a>
        <a href="{url action = 'borrowedList'}" class="button small">Powrót</a>

    </section>
        
{/block}