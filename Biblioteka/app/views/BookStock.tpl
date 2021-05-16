{extends file = "main_template.tpl"}

{block name=content}
    <section style = "padding-top: 1em; padding-bottom: 0;">
        <form method="post" action="{$conf->action_url}bookStock">
            
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="book_code" id="book_code" value="{$searchForm->book_code}" placeholder="Kod książki" />
                </div>	
                <div class="col-6 col-5-xsmal">
                    <input type="text" name="title" id="title" value="{$searchForm->title}" placeholder="Tytuł" />
                </div>	
                <div class="col-3">
                    <select name="borrowed" id="borrowed">
                        <option value="" selected disabled hidden>Wszystkie</option>
                        <option value="0" {if isset($searchForm->borrowed) and $searchForm->borrowed==0}selected{/if}>Niewypożyczone</option>
                        <option value="1" {if isset($searchForm->borrowed) and $searchForm->borrowed==1}selected{/if}>Wypożyczone</option>
                    </select>
                </div>
            </div>
                
            <input type="submit" value="Szukaj" class="primary">
            <a href="{$conf->action_url}bookStock" class="button">Wyczyść filtr</a>
        </form>    
    </section>
    
    <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">
    <table class="alt">
        <thead>
            <tr>
                <th style="width: 10%">Kod książki</th>
                <th style="width: 70%">Tytuł</th>
                <th style="width: 10%">Status</th>    
                <th style="width: 10%"></th>  
            </tr>
        </thead>

        <tbody>
            {foreach $records as $r}
            {strip}
                <tr>
                    <td style="width: 10%">{$r["book_code"]}</td> 
                    <td style="width: 70%">{$r["title"]}</td>
                    <td style="width: 10%">{if {$r["borrowed"]} == "0"}Niewypożyczona{else}Wypożyczona{/if}</td>   
                    <td style="width: 10%">
                        {if {$r["borrowed"]} == "0"}
                            <center><a href="#" class="button small">Wypożycz</a></center>
                        {else}
                            <center><a href="#" class="button small">Oddaj</a></center>
                        {/if}
                    </td> 
                    
                </tr>
            {/strip}
            {/foreach}
        </tbody>
    </table>
    </section>
{/block}
