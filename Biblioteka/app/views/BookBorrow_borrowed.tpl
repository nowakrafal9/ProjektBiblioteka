{extends file = "main_template.tpl"}

{block name=content}
    
    <section style = "padding-top: 1em; padding-bottom: 0;">
        
        {include file="messages.tpl"}

        <a href="{url action = 'borrowedList'}" class="button primary">Powrót</a>
        
    </section>  
        
{/block}



