{extends file = "main_template.tpl"}

{block name = "content"}
    
    <section style = "padding-top: 1em; padding-bottom: 0;">

        <form method="post" action="{url action = 'employeeList'}">

            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="login" id="login" value="" placeholder="Login" />
                </div>	
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="name" id="name" value="" placeholder="Imię" />
                </div>						
                <div class="col-3 col-3-xsmall">
                    <input type="text" name="surname" id="surname" value="" placeholder="Nazwisko" />
                </div>    						
            </div>

            <input type="submit" value="Szukaj" class="primary">
            <a href="{url action = 'employeeList'}" class="button">Wyczyść filtr</a>
        </form> 
        <p>
            <a href="{url action = 'employeeAdd'}" class="button primary icon solid fa-plus">Dodaj pracownika</a>
        </p>

    </section>

    <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">

        {if {$numRecords} > 0}
            <table class="alt">
                <thead>
                    <tr>
                        <th style="width: 20%">Login</th>
                        <th style="width: 35%">Imię</th>
                        <th style="width: 35%">Nazwisko</th>  
                        <th style="width: 10%"> </th>
                    </tr>
                </thead>

                <tbody>
                    {foreach $records as $r}
                    {strip}
                        {if $r["active"] == 1}
                        <tr>
                        {else}
                        <tr style="color: red">
                        {/if}
                            <td style="width: 20%">{$r["login"]}</td> 
                            <td style="width: 35%">{$r["name"]}</td>
                            <td style="width: 35%">{$r["surname"]}</td>      
                            <td style="width: 10%" ><center><a href="{url action = 'employeeInfo'}/{$r["id_employee"]}" class="button small">Informacje</a></center></td>  
                        </tr>   
                    {/strip}
                    {/foreach}
                </tbody>
            </table>
        {else}
            <h4>Brak szukanych pracowników.</h4>
        {/if}

    </section>
            
{/block}
