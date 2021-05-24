{extends file = "main_template.tpl"}

{block name=content}
    <section style = "padding-top: 1em; padding-bottom: 0;">
        <div class="row">                    
            <div class="col-6 col-12-small">
                {if {$pageMode} == "readerEdit"}
                    <h3>Edytuj czytelnika</h3> 
                {/if}
                {if {$pageMode} == "readerAdd"}
                    <h3>Dodaj czytelnika</h3> 
                {/if}
                <form action="{url action = "readerSave"}" method="post">
                    <div class="row gtr-uniform">
                        <div class="col-6 col-12-xsmall">
                            <strong>Imię:</strong>
                            <input type="text" name="name" id="name" value="{$form->name}" placeholder="Imię">
                        </div>

                        <div class="col-6 col-12-xsmall">
                            <strong>Nazwisko:</strong>
                            <input type="text" name="surname" id="surname" value="{$form->surname}" placeholder="Nazwisko">
                        </div>
                        
                        <div class="col-8 col-12-xsmall">
                            <strong>Miasto:</strong>
                            <input type="text" name="city" id="city" value="{$form->city}" placeholder="Miasto">
                        </div>
                        
                        <div class="col-4 col-12-xsmall">
                            <strong>Kod pocztowy:</strong>
                            <input type="text" name="postalCode" id="postalCode" value="{$form->postalCode}" placeholder="Kod pocztowy">
                        </div>
                        
                        <div class="col-12 col-12-xsmall">
                            <strong>Adres zamieszkania:</strong>
                            <input type="text" name="address" id="address" value="{$form->address}" placeholder="Adres zamieszkania">
                        </div>
                        
                        <div class="col-4 col-12-xsmall">
                            <strong>Numer telefonu:</strong>
                            <input type="text" name="phoneNumber" id="phoneNumber" value="{$form->phoneNumber}" placeholder="Numer telefonu">
                        </div>
                        
                        <div class="col-8 col-12-xsmall">
                            <strong>E-mail:</strong>
                            <input type="text" name="email" id="email" value="{$form->email}" placeholder="Email (niewymagane)">
                        </div>
                        
                        <div class="col-12">
                            {if {$pageMode} == "readerEdit"}
                                <input type="submit" value="Edytuj" class="primary">
                                <a href="{url action = 'readerInfo'}/{$form->id_borrower}" class="button">Powrót</a>
                            {/if}
                            {if {$pageMode} == "readerAdd"}
                                <input type="submit" value="Dodaj" class="primary">
                                <a href="{url action = 'readerList'}" class="button">Powrót</a>
                            {/if}
                        </div>  
                            
                        
                    </div>  
                    <input type="hidden" name="id_borrower" value="{$form->id_borrower}">
                </form>
            </div>                         
        </div>
    </section>
                            
    <section style = "padding-top: 1em; padding-bottom: 0;">
        {include file = "messages.tpl"}
    </section>
{/block}