{extends file = "main_template.tpl"}

{block name=content}
    
    <section style="padding-top: 1em; padding-bottom: 1em">

        <h3 class="content">{$book["title"]}</h3>   
        <p>
            <strong>Kod tytułu:</strong> {$book["book_code"]}
        </p>
        <p>
            <strong>Autor:</strong> {$book["name"]} {$book["surname"]} <br/>             
            <strong>Wydawnictwo:</strong> {$book["publisher"] } <br/>
            <strong>Gatunek:</strong> {$book["genre"] } <br/>
            <strong>Ilość stron:</strong> {$book["pages"]} <br/>
        </p>
        <p>
            <strong>Ilość egzemplarzy:</strong> {$allBooks}<br/>
            <strong>Wypożyczone:</strong> {$borrowedBooks}<br/>
            <strong>W bibliotece:</strong> {{$allBooks}-{$borrowedBooks}}<br/>
        </p>

    </section> 

    <section style="padding-top: 1em; padding-bottom: 1em">

        <a href="{url action = 'bookList'}" class="button primary">Powrót</a>

    </section> 

{/block}