{extends file = "main_template.tpl"}

{block name=content}
            <section>
                <div class="features">
                    <article onclick="location='{$conf->action_url}readerList'" onmouseover="this.style.backgroundColor='#F4F4F4'" onmouseout="this.style.backgroundColor=''" style = "cursor: pointer; ">
                        <span class="icon solid fa-user"></span>
                        <div class="content">
                            <h3>Lista czytelników</h3>
                            <p>Sprawdź dane czytelników zarejestrowanych w NASZEJ bibliotece</p>
                        </div>
                    </article>

                    <article onclick="location='{$conf->action_url}bookInfo'" onmouseover="this.style.backgroundColor='#F4F4F4'" onmouseout="this.style.backgroundColor=''" style = "cursor: pointer; ">
                        <span class="icon solid fa-book-open"></span>
                        <div class="content">
                            <h3>Informacja o książkach</h3>
                            <p>Sprawdź informacje o szukanej książce</p>
                        </div>
                    </article>

                    <article onclick="location='{$conf->action_url}opcja3'" onmouseover="this.style.backgroundColor='#F4F4F4'" onmouseout="this.style.backgroundColor=''" style = "cursor: pointer; ">
                        <span class="icon solid fa-book-reader"></span>
                        <div class="content">
                            <h3>Wypożyczone książki</h3>
                            <p>Wypożycz książki, sprawdź które książki są obecnie wypożyczone oraz kiedy mijają ich terminy wypożyczeń</p>
                        </div>
                    </article>

                    <article onclick="location='{$conf->action_url}opcja4'" onmouseover="this.style.backgroundColor='#F4F4F4'" onmouseout="this.style.backgroundColor=''" style = "cursor: pointer; ">
                        <span class="icon solid fa-building"></span>
                        <div class="content">
                            <h3>Lista książek</h3>
                            <p>Sprawdź liste wszysktich książek będących własnością biblioteki</p>
                        </div>
                    </article>
                </div>
            </section>    
{/block}