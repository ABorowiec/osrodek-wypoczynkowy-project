<?php

require_once('config.php');

$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error());

mysql_select_db($db_name);

$sql="
CREATE PROCEDURE Nowa_rezerwacja (IN Dom varchar(30), IN Imie varchar(20), IN Nazwisko VARCHAR(50), IN Tel int(9), IN Ilosc_dni int(11), IN ID_zamowienia int(10) UNSIGNED)
BEGIN
DECLARE zarezerwowany INT (1) UNSIGNED DEFAULT 1;
DECLARE id_domku INT(10) UNSIGNED DEFAULT 0;
DECLARE id_klienta INT(10) UNSIGNED DEFAULT 0;
DECLARE cena_domku INT(10) UNSIGNED DEFAULT 0;
DECLARE promocja_domku INT(10) UNSIGNED DEFAULT 0;



SELECT ID INTO id_domku FROM domek WHERE Nazwa=Dom;
SELECT ID INTO id_klienta FROM klient WHERE Telefon=Tel;
SELECT ID INTO id_domku FROM domek WHERE Nazwa=Dom;
SELECT Cena INTO cena_domku FROM domek WHERE ID=id_domku;
SELECT Znizka INTO promocja_domku FROM promocja WHERE ID_domek=id_domku;

DELETE from zamowienia WHERE ID=ID_zamowienia;
REPLACE INTO klient (Imie, Nazwisko, Telefon) VALUES (Imie, Nazwisko, Tel);
UPDATE Domek SET Rezerwacja=zarezerwowany WHERE Nazwa=Dom;
INSERT INTO rezerwacja (ID_klient, ID_domek, Kwota, Ilosc_dni) VALUES (id_klienta, id_domku, ((Ilosc_dni*cena_domku)-(Ilosc_dni*promocja_domku)), Ilosc_dni);


END";
// SELECT ID FROM domek WHERE Nazwa='Domek';
// usuń z tabeli zamówienia
// dodaj do tabeli klienci
// dodaj do tabeli rezerwacje
//INSERT INTO rezerwacja (ID_klient, ID_domek, Kwota, Ilosc_dni) VALUES ((SELECT ID FROM klient WHERE Telefon=Telefon), (SELECT ID FROM domek WHERE Nazwa=Domek), (Ilosc_dni*(SELECT Cena FROM domek WHERE ID=id_domku))-(Ilosc_dni*(SELECT Znizka FROM promocja WHERE ID_domek=id_domku)), Ilosc_dni);
//INSERT INTO rezerwacja (ID_klient, ID_domek, Kwota, Ilosc_dni) VALUES ((1, 2, 200, 3);
// INSERT INTO rezerwacja (ID_klient, ID_domek, Kwota, Ilosc_dni) VALUES ((SELECT ID FROM klient WHERE Telefon=Telefon), (SELECT ID FROM domek WHERE Nazwa=Domek), (Ilosc_dni*(SELECT Cena FROM Domek WHERE ID=(SELECT ID FROM domek WHERE Nazwa=Domek)))-(Ilosc_dni*(SELECT Znizka FROM Promocja WHERE ID_domek=(SELECT ID FROM domek WHERE Nazwa=Domek))), Ilosc_dni);


$results=mysql_query($sql) or die ('Wykonanie procedury nie powodło sie. Błąd:' .mysql_error());

?>