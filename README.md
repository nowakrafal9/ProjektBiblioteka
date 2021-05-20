## ProjektBiblioteka
* Temat: Aplikacja przeznaczona dla biblioteki
* Diagram bazy: 
   
[!Diagram](./baza%20danych/Diagram.png)
  
### Omówienie założeń projektu:  
Aplikacja jest skierowana dla bibliotek w celu usprawnienia systemu wypożyczania książek. Pracownicy biblioteki mają dostęp do takich informacji jak:  
-- sprawdzenie informacji o książce(m.in. autor, wydawca oraz gatunek) w celu znalezienia jej w odpowiednim dziale \
-- sprawdzenie informacji o czytelnikach zarejestrowanych w bibliotece celem kontaktu z nimi \
-- sprawdzenie informacji o wszystkich książkach będących w posiadaniu przez filie biblioteki w której pracuje \
-- sprawdzenie informacji o wypożyczonych książkach oraz terminach ich wypożyczenia/oddania

Aplikacja jest zabezpieczona przed nieupoważnionym dostępem poprzez wymóg zalogowania się przez pracownika. Hasło dla wybranego loginu są przechowywane w bazie danych (patrz diagram, sekcja "***Login info***"). Wszystkie loginy są unikatowe i są kombinacją liter imienia i nazwiska pracownika oraz cyfr (np. Jan Kowalski - jankow1). Poszczególne konta pracowników mają podział na role. Obecnie są to: \
-- ***Pracownicy*** - głównie wykonują operacje wypożyczenia książek, sprawdzenia statusu wypożyczenia oraz kontaktu z czytelnikiem w przypadku nie oddania książki w terminie \
-- ***Administratorzy*** - posiadają możliwości takie same jak zwykli pracownicy. Dodatkowo mają uprawnienia do modyfikacji informacji o kontach pracowników (dodanie nowych, usunięcie starych) oraz modyfikacji informacji o czytelnikach zarejestrowanych w bibliotece.

Sekcja ***"Book info"*** w bazie danych przechowuje informacje o książkach. Mamy tam tabele: \
-- ***"author info"*** - tabela zawierająca informacje o autorze - jego nazwisko i imie oraz 6 znakowy kod identyfikujący go w systemie (3 pierwsze litery imienia i nazwiska) \
-- ***"genre"*** - tabela zawierająca nazwy gatunków książek \
-- ***"publisher"*** - tabela zawierająca nazwy wydawców których książki znajdują się w bibliotece \
-- ***"book info"*** - tabela zawierająca informacje o poszczególnych tytułach występujących w bibliotece

Sekcja ***"Borrower info"*** w bazie danych przechowuje informacje o czytelnikach zarejestrowanych w bibliotece. Informacje tam zawarte są podstawowymi danymi kontaktowymi z czytelnikiem.

Sekcja ***"Borrowed books info"*** w bazie danych składa się z dwóch tabel: \
-- ***"book stock"*** - tabela ta zawiera informacje o wszystkich książkach należących do biblioteki. Możemy tam znaleźć informacje o odpowiednim kodzie identyfikującym książkę, jej tytule oraz o statusie wypożyczenia \
-- ***"borrowed books"*** - tabela zawierająca informacje o książkach wypożyczonych przez czytelników oraz terminów wypożyczenia oraz oddania
