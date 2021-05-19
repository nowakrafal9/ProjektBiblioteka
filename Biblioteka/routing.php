<?php

use core\App;
use core\Utils;

App::getRouter()->setDefaultRoute('main'); #default action
App::getRouter()->setLoginRoute('login'); #action to forward if no permissions

Utils::addRoute('main', 'MainCtrl', ['Pracownik', "Administrator"]);

Utils::addRoute('login', 'LoginCtrl');
Utils::addRoute('logout', 'LoginCtrl');

Utils::addRoute('readerList', 'ReaderListCtrl', ['Pracownik', "Administrator"]);
Utils::addRoute('readerInfo', 'ReaderListCtrl', ['Pracownik', "Administrator"]);

Utils::addRoute('bookList', 'BookInfoCtrl', ['Pracownik', "Administrator"]);
Utils::addRoute('bookInfo', 'BookInfoCtrl', ['Pracownik', "Administrator"]);

Utils::addRoute('bookStock', 'BookStockCtrl', ['Pracownik', "Administrator"]);

Utils::addRoute('borrowedList', 'BorrowedBooksCtrl', ['Pracownik', "Administrator"]);
Utils::addRoute('borrowedInfo', 'BorrowedBooksCtrl', ['Pracownik', "Administrator"]);
Utils::addRoute('borrowedReturn', 'BorrowedBooksCtrl', ['Pracownik', "Administrator"]);