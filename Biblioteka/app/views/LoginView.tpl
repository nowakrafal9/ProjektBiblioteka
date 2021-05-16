{extends file = "login_template.tpl"}

{block name=content}
    <section>
        <h3>Zaloguj się aby kontynuować:</h3>
        <form method="post" action="{$conf->action_url}login">
            
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                <div class="col-3 col-5-xsmal">
                    <input type="text" name="login" id="login" value="" placeholder="Login" />
                </div>						
            </div>          
            
            <div class="row gtr-uniform" style="padding-bottom:0.75em">
                    <div class="col-3 col-3-xsmall">
                        <input type="password" name="pass" id="pass" value="" placeholder="Password" />
                    </div>    						
            </div>
            
            <input type="submit" value="Zaloguj się" class="primary"">
        </form>  
        
        {if $msgs->isMessage()}
            <ul>
                {foreach $msgs->getMessages() as $msg}
                    {strip}
                        <strong style="color:#f56a6a"><li>{$msg->text}</li></strong>
                    {/strip}
                {/foreach}
            </ul>
        {/if}
    </section>
{/block}
