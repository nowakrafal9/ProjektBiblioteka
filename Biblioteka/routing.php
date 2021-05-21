<?php

use core\App;
use core\Utils;

App::getRouter()->setDefaultRoute('main'); #default action
App::getRouter()->setLoginRoute('login'); #action to forward if no permissions

Utils::addRoute('main', 'MainCtrl', ['Pracownik', "Administrator"]);

Utils::addRoute('login', 'LoginCtrl');
Utils::addRoute('logout', 'LoginCtrl');

Utils::addRoute('readerList', 'ReaderCtrl', ['Pracownik', "Administrator"]);
Utils::addRoute('readerInfo', 'ReaderCtrl', ['Pracownik', "Administrator"]);

Utils::addRoute('bookList', 'BookCtrl', ['Pracownik', "Administrator"]);
Utils::addRoute('bookInfo', 'BookCtrl', ['Pracownik', "Administrator"]);
Utils::addRoute('bookStock', 'BookCtrl', ['Pracownik', "Administrator"]);

Utils::addRoute('borrowedList', 'BorrowedBooksCtrl', ['Pracownik', "Administrator"]);
Utils::addRoute('borrowedReturn', 'BorrowedBooksCtrl', ['Pracownik', "Administrator"]);
Utils::addRoute('bookBorrow', 'BorrowedBooksCtrl', ['Pracownik', "Administrator"]);
Utils::addRoute('bookReturn', 'BorrowedBooksCtrl', ['Pracownik', "Administrator"]);