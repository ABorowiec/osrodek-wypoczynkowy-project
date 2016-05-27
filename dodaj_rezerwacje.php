<?php

require_once('config.php');

$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error());

mysql_select_db($db_name);

$sql="
CREATE PROCEDURE Nowa_rezerwacja (IN Domek varchar(30), IN Imie varchar(20), IN Nazwisko VARCHAR(50), IN Telefon int(9), IN Ilosc_dni int(11), IN ID int)
BEGIN
DECLARE zarezerwowany INT DEFAULT 1;
DECLARE id_domku INT UNSIGNED DEFAULT 0;

SELECT ID INTO id_domku FROM domek WHERE Nazwa=Domek;

DELETE from zamowienia WHERE ID=ID;
INSERT IGNORE INTO klient (Imie, Nazwisko, Telefon) VALUES (Imie, Nazwisko, Telefon);
UPDATE Domek SET Rezerwacja=zarezerwowany WHERE Nazwa=Domek;
INSERT INTO rezerwacja (ID_klient, ID_domek, Kwota, Ilosc_dni) VALUES ((SELECT ID FROM klient WHERE Telefon=Telefon), (SELECT ID FROM domek WHERE Nazwa=Domek), (Ilosc_dni*(SELECT Cena FROM domek WHERE id_domku=ID))-(Ilosc_dni*(SELECT Znizka FROM promocja WHERE id_domku=ID_domek)), Ilosc_dni);

END";
// SELECT ID FROM domek WHERE Nazwa='Domek';
// usuń z tabeli zamówienia
// dodaj do tabeli klienci
// dodaj do tabeli rezerwacje
// INSERT INTO rezerwacja (ID_klient, ID_domek, Kwota, Ilosc_dni) VALUES ((SELECT ID FROM klient WHERE Telefon=Telefon), (SELECT ID FROM domek WHERE Nazwa=Domek), (Ilosc_dni*(SELECT Cena FROM Domek WHERE ID=(SELECT ID FROM domek WHERE Nazwa=Domek)))-(Ilosc_dni*(SELECT Znizka FROM Promocja WHERE ID_domek=(SELECT ID FROM domek WHERE Nazwa=Domek))), Ilosc_dni);


$results=mysql_query($sql) or die ('Wykonanie procedury nie powodło sie. Błąd:' .mysql_error());

?>