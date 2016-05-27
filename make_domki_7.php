<?php

require_once('config.php');





$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error());

mysql_select_db($db_name);


// ALTER TABLE `table1` 
// DROP FOREIGN KEY `fk_name`;
// ALTER TABLE `table1`  
// ADD CONSTRAINT `fk_name` FOREIGN KEY (`fk_table2_id`) REFERENCES `table2` (`t2`) ON DELETE CASCADE ON UPDATE CASCADE;  

// promocja rezerwacja usterka zamowienia

$sql="ALTER TABLE rezerwacja 
DROP FOREIGN KEY rezerwacja_ibfk_1";

$results=mysql_query($sql) or die ('Rezerwacja DROP Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql="ALTER TABLE rezerwacja  
ADD CONSTRAINT rezerwacja_ibfk_1 FOREIGN KEY (ID_domek) REFERENCES domek (ID) ON DELETE NO ACTION ON UPDATE NO ACTION";

$sql="ALTER TABLE rezerwacja 
DROP FOREIGN KEY rezerwacja_ibfk_2";

$results=mysql_query($sql) or die ('Rezerwacja DROP Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());


$sql="ALTER TABLE rezerwacja  
ADD CONSTRAINT rezerwacja_ibfk_2 FOREIGN KEY (ID_domek) REFERENCES domek (ID) ON DELETE NO ACTION ON UPDATE NO ACTION";


$results=mysql_query($sql) or die ('Rezerwacja ADD Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql="ALTER TABLE promocja
DROP FOREIGN KEY promocja_ibfk_1";

$results=mysql_query($sql) or die ('promocja DROP Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql="ALTER TABLE promocja
ADD  CONSTRAINT promocja_ibfk_1 FOREIGN KEY (ID_domek) REFERENCES domek (ID) ON DELETE NO ACTION ON UPDATE NO ACTION";

$results=mysql_query($sql) or die ('promocja ADD Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql="ALTER TABLE usterka
DROP FOREIGN KEY usterka_ibfk_1";

$results=mysql_query($sql) or die ('usterka DROP Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql="ALTER TABLE usterka
ADD CONSTRAINT usterka_ibfk_1 FOREIGN KEY (ID_domek) REFERENCES domek (ID) ON DELETE NO ACTION ON UPDATE NO ACTION";

$results=mysql_query($sql) or die ('usterka ADD Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql="ALTER TABLE zamowienia
DROP FOREIGN KEY zamowienia_ibfk_1";

$results=mysql_query($sql) or die ('zamowienia DROP Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql="ALTER TABLE zamowienia  
ADD  CONSTRAINT zamowienia_ibfk_1 FOREIGN KEY (ID_Domek) REFERENCES domek (ID) ON DELETE NO ACTION ON UPDATE NO ACTION";

$results=mysql_query($sql) or die ('zamowienia ADD Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

// $sql=""

// $results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

// $sql=""

// $results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

// $sql=""

// $results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

// $sql=""

// $results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

// $sql=""

// $results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
?>