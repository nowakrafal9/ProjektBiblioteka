{extends file = "main_template.tpl"}

{block name=content}
    <section style = "padding-top: 1em; padding-bottom: 0;">
        <form method="post" action="{$conf->action_url}readerList">
            
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="person_id" id="person_id" value="{$searchForm->id}" placeholder="Id czytelnika" />
                </div>	
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="name" id="name" value="{$searchForm->name}" placeholder="Imię" />
                </div>						
                <div class="col-3 col-3-xsmall">
                    <input type="text" name="surname" id="surname" value="{$searchForm->surname}" placeholder="Nazwisko" />
                </div>    						
            </div>
                
            <input type="submit" value="Szukaj" class="primary">
            <a href="{$conf->action_url}readerList" class="button">Wyczyść filtr</a>
        </form>    
    </section>
    
    <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">
    <table class="alt">
        <thead>
            <tr>
                <th style="width: 10%">Id czytelnika</th>
                <th style="width: 40%">Nazwisko</th>
                <th style="width: 40%">Imię</th>         
            </tr>
        </thead>

        <tbody>
            {foreach $records as $r}
            {strip}
                <tr>
                    <td style="width: 10%">{$r["id_borrower"]}</td> 
                    <td style="width: 40%">{$r["surname"]}</td>
                    <td style="width: 40%">{$r["name"]}</td>      
                    <td style="width: 10%" ><center><a href="{$conf->action_url}readerInfo/{$r['id_borrower']}" class="button small">Informacje</a></center></td>  
                </tr>
            {/strip}
            {/foreach}
        </tbody>
    </table>
    </section>
{/block}
