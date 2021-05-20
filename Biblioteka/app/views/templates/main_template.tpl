<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
    <head>
        <title>Bibliotekos</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="{$conf->app_url}/css/main.css" />
    </head>
    <body class="is-preload">
        
        <!-- Wrapper -->
        <div id="wrapper">
            
            <!-- Main -->
            <div id="main">
                <div class="inner">

                    <!-- Header -->
                    <header id="header">
                        <a href="{url action = 'main'}" class="logo"><strong>Biblioteka im. Włodzimierza Lenina</strong></a>
                        Zalogowany użytkownik: {$user->login}
                    </header>
                    {block name = "content"} Domyślna treść strony {/block}                 
                </div>
            </div>
                
            <!-- Sidebar -->
            <div id="sidebar">
                <div class="inner">
                    <!-- Menu -->          
                    <nav id="menu">
                        <header class="major">
                                <h2>Menu</h2>
                        </header>
                        <ul>
                            <li><a href="{url action = 'main'}">Strona główna</a></li>
                            <li><a href="{url action = 'readerList'}">Lista czytelników</a></li>
                            <li><a href="{url action = 'bookList'}">Informacje o książce</a></li>
                            <li><a href="{url action = 'borrowedList'}">Wypożyczone książki</a></li>
                            <li><a href="{url action = 'bookStock'}">Lista książek</a></li>   
                        </ul>
                    </nav>
                           
                    <nav id="menu">
                        <ul>
                            <li><a href="{url action = 'logout'}">Wyloguj</a></li>
                        </ul>
                    </nav>
                        
                    <!-- Footer -->
                    <footer id="footer">
                        <p class="copyright">&copy; Untitled. All rights reserved. Demo Images: <a href="https://unsplash.com">Unsplash</a>. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
                    </footer>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="{$conf->app_url}/js/jquery.min.js"></script>
        <script src="{$conf->app_url}/js/browser.min.js"></script>
        <script src="{$conf->app_url}/js/breakpoints.min.js"></script>
        <script src="{$conf->app_url}/js/util.js"></script>
        <script src="{$conf->app_url}/js/main.js"></script>
    </body>
</html>