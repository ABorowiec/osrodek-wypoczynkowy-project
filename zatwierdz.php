<?php
session_start(); //dołącz plik z ustawieniami
require_once('config.php'); //wystartuj sesję
?>

<html>
<head>
<META NAME="robots" CONTENT="noindex, nofollow">
<link rel="shortcut icon" href="dane\favicon.ico">
<link rel="Stylesheet" type="text/css" href="dane\style.css" />
</head>
<body>
<div id=site>
<div id=mainsite style ="width: 850px; top: 100px; left: 100px; position: absolute; border: 1px; border-style: solid; border-color: #ffffff;">

<?php

if(isset($_SESSION['zalogowany'])) //jeśli zalogowany...
{
	$level = $_SESSION['level'];
	$user = $_SESSION['username']; //...pobierz zienne sesyjne

	//$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
	//mysql_select_db($db_name);
	//$level_z_bazy = mysql_query("SELECT level FROM users WHERE username = '$user'");

	if ($level == 1 or 2 or 3 or 4 or 5 or 6) //jeśli użytkownik ma odpowiednie uprawnienia
	{
		
		function walidacja_wartosci($walidowana_kolumna, $warunek_walidowana_kolumna, $warunek_walidowana_wartosc, $nazwa_tabeli) // funkcja do skonczenia
		[ //TU ZROBIĆ to co skomentowane pod spodem
		
		  
		
		// http://php.net/manual/en/function.sizeof.php
		
		// If your array is "huge"

		// It is reccomended to set a variable first for this case:

		// THIS->

		// $max = sizeof($huge_array);
		// for($i = 0; $i < $max;$i++)
		// {
		// code...
		// }

		// IS QUICKER THEN->

		// for($i = 0; $i < sizeof($huge_array);$i++)
		// {
		// code...
		// }
		
		
		//if (count ($warunek_walidowana_kolumna) == count($warunek_walidowana_wartosc))
		
		
			//$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			// mysql_select_db($db_name);
		
			// $ilosc_walidacji = sizeof($warunek_walidowana_kolumna);
		
			//
			// $i = 0;
			// while ($i <= $ilosc_walidacji) {
				//	$where_warunek.=$warunek_walidowana_kolumna."=".warunek_walidowana_wartosc;
				//  $i++;
		
					//if $i == $ilosc_walidacji
					//{$where_warunek.=" AND "}	
			// }
			//wyechuj kwerendę
			// //foreach ($wartosci as $key => $value)
			//{
			//	$where_pole.=
			//	$where_wartosc.=
			// 
			// 
			//}
			// $sql = ""; warunek do linii 130, 152 i 171 SELECT walidowana_kolumna FROM $nazwa_tabeli WHERE $where_warunek
			// $result = mysql_query($sql);
			// $l = mysql_num_rows ($result);
			// 
		
		]
		
		function baza($wartosci, $nazwa_str_do_powrotu, $nazwa_tabeli, $nazwy_kolumn, $typ_komendy)
		{
			
			// wartosci to wartosci przekazywane z tablicy POST wpisywane do bazy w podane nazwy kolumn
			// nazwa_str_do_powrotu to nazwa strony php do powrotu z zatwierdz.php
			// nazwa_tabeli to nazwa tabeli
			// nazwy_kolumn to nazwy kolumn tabeli w bazie
			// typ_komendy 1-INSERT,  2-UPDATE, 3-DELETE
			
			// odczytanie rodzaju submit z tablicy POST
			
			//print_r($nazwy_kolumn);
			
			//print_r($wartosci);

			//foreach ($wartosci as $key => $value)
			//echo $key."=".$value."<br/>";
			
				//if(($key = array_search('', $messages)) !== false) {
					//unset($messages[$key]);
				//}	
			
			
			if (array_key_exists('submit', $wartosci)) {
				echo "The 'submit' element is in the array";
				unset($wartosci['submit']);
			}
			
			$columns = implode(", ",($nazwy_kolumn));
			$values  = implode(", ",($wartosci));
			
			echo"<br/><br/>";
			
			echo $columns;
			
			echo"<br/><br/>";
			
			echo $values;
			
			
			// $connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			// mysql_select_db($db_name);
			// if (mysql_num_rows(mysql_query...)
			// $sql = "";
			// mysql_query($sql);
			
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
			// if (mysql_num_rows(mysql_query...)
			
			if ($typ_komendy == 1) {
				//if(mysql_num_rows(mysql_query("SELECT Nazwa FROM domek WHERE Nazwa = '$nazwa_domku'")) > 0) //jeśli taki rekord istanieje
				if(mysql_num_rows(mysql_query...) //TU ROBIĆ
				{
				
					
					echo "Taki wpis już istnieje w bazie...<br>";
	
					echo "<a href='domki.php'>Wróć</a>";
					header( 'refresh: 5; url=domki.php' );
					
				}
				else
				{	
					
					
					$sql = "";	//TU ROBIĆ
					$results=mysql_query($sql);
				
				}
				
				
			} elseif ($typ_komendy == 2) {
				//if(mysql_num_rows(mysql_query("SELECT Nazwa FROM domek WHERE Nazwa = '$nazwa_domku' && Opis = '$opis_domku' && Cena= $cena_domku ")) > 0) // jeśli istnieje w bazie
				if(mysql_num_rows(mysql_query...) //TU ROBIĆ
				{
					echo "Taki wpis już istnieje w bazie lub nie zeedytowano wpisu...<br>";
					
					echo "<a href='".$nazwa_str_do_powrotu."'>Wróć</a>";
					header( 'refresh: 5; url='.$nazwa_str_do_powrotu);
					
					
				}
				else
				{	
					
					$sql = "";	//TU ROBIĆ
					$results=mysql_query($sql);
					
				}
			
			} elseif ($typ_komendy == 3) {
				//if (mysql_num_rows(mysql_query("SELECT * FROM domek WHERE Nazwa = '$nazwa_domku' AND Rezerwacja = 1 ")) == 0) //jeśli domek nie jest zakwaterowany...
				if(mysql_num_rows(mysql_query...)  //TU ROBIĆ
				{
					
					echo "Nie można usunąć wpisu...";
					echo "<a href='".$nazwa_str_do_powrotu."'>Wróć</a>";
				
				}
				else
				{
					
					
					$sql = ""; //TU ROBIĆ
					$results=mysql_query($sql);
				
				}
			}
			
			
			//$results=mysql_query($sql);
		
		if ( $results )
				{
					echo "<a href='".$nazwa_str_do_powrotu."'>Wróć</a>";
					header( 'refresh: 5; url='.$nazwa_str_do_powrotu);
				}
		}
		
		$nazwy_kolumn = array("Nazwa", "Cena", "Opis");
		
	baza ($_POST, domki.php, domek, $nazwy_kolumn, 1);
	}
	else
	{
		echo "<b>Nieodpowiednie uprawnienia. Zostaniesz przekierowany w ciągu 5 sekund...</b>";
		header('Refresh: 5; url=domki_panel_glowny.php'); // przekieruj po 5 sek.	
	}

}
else
{
	echo "<div id=login style='margin-top: 100px;'><br/>";
	echo "<h2 style='text-align: center; margin-top: 10px;'>Nie zalogowany. Zaloguj się!</h2>";
	echo "</div>";
	header('Location: index.php');
}

?>

<!--
<div style='bottom: 75px; left: 350px; position: absolute; text-align: center;'>
<a href='index.html'>Powrót na stronę główną</a>
</div>
-->

</div>
</div>
</body>
</html>