
    {if $msgs->isError()}
        <section style="padding-top: 1em; padding-bottom: 1em">
            <ul>
                {foreach $msgs->getMessages() as $msg}
                    {strip}
                        <strong style="color:#f56a6a"><li>{$msg->text}</li></strong>
                    {/strip}
                {/foreach}
            </ul>
        </section>
    {/if}

    {if $msgs->isInfo()}
        <section style="padding-top: 1em; padding-bottom: 1em">
            <ul>
                {strip}
                    {foreach $msgs->getMessages() as $msg}
                        <strong style="color:gray"> <li>{$msg->text}</li> </strong>
                    {/foreach}
                {strip}
            </ul>
        </section>
    {/if}
