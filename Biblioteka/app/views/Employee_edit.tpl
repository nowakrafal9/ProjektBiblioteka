{extends file = "main_template.tpl"}

{block name=content}
    
    <section style = "padding-top: 1em; padding-bottom: 0;">
        
        <div class="row">                    
            <div class="col-6 col-12-small">
                <h3>Edycja/dodanie pracownika</h3> 

                <form action="{url action = "employeeSave"}" method="post">
                    <div class="row gtr-uniform">
                        <div class="col-5 col-12-xsmall">
                            <strong>Imię:</strong>
                            <input type="text" name="name" id="name" value="{$form->name}" placeholder="Imię">
                        </div>

                        <div class="col-5 col-12-xsmall">
                            <strong>Nazwisko:</strong>
                            <input type="text" name="surname" id="surname" value="{$form->surname}" placeholder="Nazwisko">
                        </div>
                        
                        <div class="col-5 col-12-xsmall">
                            <strong>Kod pracownika:</strong>
                            <input type="text" name="employee_code" id="employee_code" value="{$form->employee_code}" placeholder="Kod pracownika">
                        </div>
                        <div class="col-7 col-12-xsmall"> </div>
                        
                        <div class="col-5 col-12-xsmall">
                            <strong>Login:</strong>
                            <input type="text" name="login" id="login" value="{$form->login}" placeholder="Login">
                        </div>
                        
                        <div class="col-5 col-12-xsmall">
                            <strong>Hasło:</strong>
                            <input type="text" name="password" id="password" value="{$form->password}" placeholder="Hasło">
                        </div>
                        
                        <div class="col-5 col-12-small">
                            <strong>Rola:</strong>
                            <select name="role" id="role">
                                <option value="Pracownik" {if isset($form->role) and $form->role=="Pracownik"}selected{/if}>Pracownik</option>
                                <option value="Administrator" {if isset($form->role) and $form->role=="Administrator"}selected{/if}>Administrator</option>
                            </select>
                        </div>
                        
                        <div class="col-12 col-12-small">
                                <input type="checkbox" id="active" name="active" value="1" {if isset($form->active) and $form->active == 1}checked{/if}>
                                <label for="active">Konto aktywne</label>
                        </div>
                            
                        <div class="col-12">
                            <input type="submit" value="Zapisz" class="primary">
                            {if {$pageMode} == "employeeEdit"}   
                                <a href="{url action = 'employeeInfo'}/{$form->id_employee}" class="button">Powrót</a>
                            {else}
                                <a href="{url action = 'employeeList'}" class="button">Powrót</a>
                            {/if}
                        </div>                     
                    </div>  
                    <input type="hidden" name="id_employee" value="{$form->id_employee}">
                </form>
            </div>                         
        </div>
                
    </section>
                            
    <section style = "padding-top: 1em; padding-bottom: 0;">
        
        {include file = "messages.tpl"}
        
    </section>
        
{/block}
