{extends file = "main_template.tpl"}

{block name=content} 
    
    <section style = "padding-top: 1em; padding-bottom: 0;">
        
        <div class="row">                    
            <div class="col-6 col-12-small">
                <h3>Dodaj książkę</h3> 
                <form action="{url action = "bookSave"}" method="post">
                    <div class="row gtr-uniform">
                        <div class="col-4 col-12-xsmall">
                            <strong>Kod książki:</strong>
                            <input type="text" name="id_book" id="id_book" value="{$form->id_book}" placeholder="Id książki">
                        </div>

                        <div class="col-8 col-12-xsmall">
                            <strong>Kod tytułu:</strong>
                            <input type="text" name="book_code" id="book_code" value="{$form->book_code}" placeholder="Kod tytułu">
                        </div>
                        
                        <div class="col-12">
                            <input type="submit" value="Dodaj" class="primary">
                            <a href="{url action = 'bookStock'}" class="button">Powrót</a>
                        </div>  
                    </div>  
                </form>
            </div>                         
        </div>
                        
    </section>
                        
    {include file="messages.tpl"}
    
{/block}