<?php

require_once('config.php');





$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error());

mysql_select_db($db_name);


$sql=
"ALTER TABLE klient
ADD UNIQUE (Telefon)";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());



?>