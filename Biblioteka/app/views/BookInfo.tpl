{extends file = "main_template.tpl"}

{block name=content}
    <section style="padding-top: 1em; padding-bottom: 1em">
       <form method="post" action="{$conf->action_url}bookInfo">
            
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-12">
                    <input type="text" name="title" id="title" value="{$searchForm->title}" placeholder="Tytuł szukanej książki" />
                </div>							
            </div>
                
            <input type="submit" value="Szukaj" class="primary">
             <a href="{$conf->action_url}bookInfo" class="button">Wyczyść filtr</a>
        </form>
    </section>
    
    <section class="table-wrapper" style = "padding-top: 1em; padding-bottom: 1em">
    <table class="default">
        <tbody>
            {foreach $records as $r}
            {strip}
                <tr>
                    <td>{$r["title"]}</td>
                    <td><center><a href="{$conf->action_url}bookInfoDetails/{$r['id_book']}" class="button small">Informacje</a></center></td>
                </tr>
            {/strip}
            {/foreach}
        </tbody>
    </table>
    </section>
{/block}
