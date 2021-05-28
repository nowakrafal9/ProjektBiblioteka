{extends file = "main_template.tpl"}

{block name = "content"}
    <section style="padding-top: 1em; padding-bottom: 1em">

        <h3 class="content">{$r["name"]}, {$r["surname"]} [<a href='{url action = "employeeEdit"}/{$r["id_employee"]}' style='color:#9a9a9a'>Edytuj</a>]</h3>   
        <p>
            <strong>Kod pracownika:</strong> {$r["employee_code"]} 
        </p>
        <p>
            <strong>Login:</strong> {$r["login"]} <br/>             
            <strong>Hasło:</strong> {$r["password"]} <br/>
        </p>
        <p>
            <strong>Uprawnienia:</strong> {$r["role"]} <br/>
            <strong>Stan konta:</strong> {if {$r["active"]} == 1}Aktywne{else}Wyłączone{/if} <br/>
        </p>

    </section> 

    <section style="padding-top: 1em; padding-bottom: 1em">

        <a href="{url action = 'employeeList'}" class="button primary">Powrót</a>

    </section> 
{/block}