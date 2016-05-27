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
// formularz - domki.php linia 261, 311, 359
if(isset($_SESSION['zalogowany'])) //jeśli zalogowany...
{
	$level = $_SESSION['level'];
	$user = $_SESSION['username']; //...pobierz zienne sesyjne

	//$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
	//mysql_select_db($db_name);
	//$level_z_bazy = mysql_query("SELECT level FROM users WHERE username = '$user'");

	if ($level == 1 or 2 or 3 or 4 or 5 or 6) //jeśli użytkownik ma odpowiednie uprawnienia
	{
		if (isset($_POST['submit'])) //jeśli wysłano formularz z pliku .php)		
		{
			
			print_r($_POST);
			echo"<br/><br/>";
			echo"<br/><br/>";
			
		function walidacja_wartosci($nazwy_tabel, $kolumny, $warunki) // funkcja do skonczenia return walidacja prawda/fałsz i przekaz to do funkcji baza
		{ //TU ZROBIĆ to co skomentowane pod spodem
		
			// foreach ($array as $item) 
			// {
			// echo "$item\n";
			// }
		
			
			//$ilosc_tabel = count($nazwy_tabel);
		
			foreach ($nazwy_tabel as $tabela) 
			{
			$komenda_tabele.=$tabela;
				
				if (next($nazwy_tabel)==true)
				{
					$komenda_tabele.=", ";
				}
			}
			
			
			//$ilosc_kolumn = count($kolumny);
			
			foreach ($kolumny as $kolumna) 
			{
			$komenda_kolumny.=$kolumna;
				
			if (next($kolumny)==true)
				{
					$komenda_kolumny.=", ";
				}
			}
			
		
			//$ilosc_warunkow = count($warunki);
			
			// stary foreach
			
			// foreach ($warunki as $kolumna => $warunek)
			// {
				// $komenda_warunki.=$kolumna."=".$warunek;
				
				// if (next($warunki)==true)
				// {
				
				// $komenda_warunki.=" AND ";
				// }
				
			// }
			
			
			
			foreach ($warunki as $warunek)
			{
				$komenda_warunki.=$warunek;
				
				if (next($warunki)==true)
				{
				
				$komenda_warunki.=" AND ";
				}
				
			}
			
			echo "SELECT ".$komenda_kolumny." FROM ".$komenda_tabele." WHERE ".$komenda_warunki."<br/>"; // wpisac ta komende do bazy
			
		}
		
		function baza($wartosci, $nazwa_str_do_powrotu, $nazwy_tabel, $nazwy_kolumn, $typ_komendy, $warunki, $wyswietlany_komunikat, $walidacja)
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
				echo"<br/><br/>";
				//print_r($wartosci);
				var_dump($wartosci);
				echo"<br/><br/>";
			}
			
			//$columns = implode(", ",($nazwy_kolumn));
			//$values  = implode(", ",($wartosci));
			
			// foreach ($wartosci as $nazwa_pola => $wartosci_tabela) 
			// {
			// $values.=$wartosci_tabela;
				
				// if (next($wartosci)==true)
				// {
					// $values.=", ";
				// }
			// }
			
			$i=count($wartosci);
			$p = 1;
			
			echo"<br/><br/>";
			$oo=sizeof($wartosci, 0);
			echo "Ilość wierszy w post: ".$oo;
			echo"<br/><br/>";
			
			echo $wyswietlany_komunikat;
			
			echo"<br/><br/>";
			echo"<br/><br/>";
			
			foreach ($nazwy_tabel as $tabela) 
			{
			$komenda_tabele.=$tabela;
				
				if (next($nazwy_tabel)==true)
				{
					$komenda_tabele.=", ";
				}
			}
			
			
			foreach ($wartosci as $nazwa_pola => $wartosci_tabela) 
			{
			
			$values.=$wartosci_tabela;
			$p++;
				if ($p<=$i)
				{
					$values.=", ";
				}
			}
			
			foreach ($nazwy_kolumn as $kolumny_tabela) 
			{
			$columns.=$kolumny_tabela;
				
				if (next($nazwy_kolumn)==true)
				{
					$columns.=", ";
				}
			}
			
			foreach ($warunki as $warunek)
			{
				$komenda_warunki.=$warunek;
				
				if (next($warunki)==true)
				{
				
				$komenda_warunki.=" AND ";
				}
				
			}
			
			foreach (array_combine($nazwy_kolumn, $wartosci) as $kolumny_tabela => $wartosci_tabela )
			{
				$komenda_update.=$kolumny_tabela."=".$wartosci_tabela;
				
				if (next (array_combine($nazwy_kolumn, $wartosci))==true)
				{
				
				$komenda_update.=", ";
				}
				
			}
			
			
			
			echo"<br/><br/>";
			
			echo $columns;
			
			echo"<br/><br/>";
			
			echo $values;
			
			echo"<br/><br/>";
			
			//INSERT INTO $nazwy_tabel ($kolumna1, $kolumna2, $kolumna3) VALUES ('$wartosc1', 'wartosc2', wartosc3) if string  dodaj cudzysłów, else if int nie dodawaj
			//DELETE FROM $nazwy_tabel WHERE $where_warunek
			//UPDATE $nazwy_tabel SET $kolumna1=$wartosc1, $kolumna2=$wartosc2, $kolumna3=$wartosc3  WHERE $where_warunek if string  dodaj cudzysłów, else if int nie dodawaj
		
			echo "INSERT INTO ".$komenda_tabele." (".$columns.") VALUES (".$values.")<br/><br/>"; // wpisac ta komende do bazy oraz zrobic if czy "string" czy int
			
				//tu bedzie petla odczytujaca nazwy k oraz w
			echo "UPDATE ".$komenda_tabele." SET ".$komenda_update." WHERE ".$komenda_warunki."<br/><br/>"; // poprawic  i wpisac ta komende do bazy  oraz zrobic if czy "string" czy int
				
			
			echo "DELETE FROM ".$komenda_tabele." WHERE ".$komenda_warunki."<br/><br/>"; // wpisac ta komende do bazy oraz zrobic if czy "string" czy int
				
			
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
				if (1==1)//(mysql_num_rows(mysql_query...) //TU ROBIĆ
				{
				
					
					echo $wyswietlany_komunikat."<br>";
	
					echo "<a href=".$nazwa_str_do_powrotu.">Wróć</a>";
					header( 'refresh: 5; url='.$nazwa_str_do_powrotu);
					
				}
				else
				{	
					
					
					$sql = "";	//TU ROBIĆ
					$results=mysql_query($sql);
				
				}
				
				
			} elseif ($typ_komendy == 2) {
				//if(mysql_num_rows(mysql_query("SELECT Nazwa FROM domek WHERE Nazwa = '$nazwa_domku' && Opis = '$opis_domku' && Cena= $cena_domku ")) > 0) // jeśli istnieje w bazie
				if (1==1)//(mysql_num_rows(mysql_query...) //TU ROBIĆ
				{
					echo $wyswietlany_komunikat."<br>";
					
					echo "<a href=".$nazwa_str_do_powrotu.">Wróć</a>";
					//header( 'refresh: 5; url='.$nazwa_str_do_powrotu);
					
					
				}
				else
				{	
					
					$sql = "";	//TU ROBIĆ
					$results=mysql_query($sql);
					
				}
			
			} elseif ($typ_komendy == 3) {
				//if (mysql_num_rows(mysql_query("SELECT * FROM domek WHERE Nazwa = '$nazwa_domku' AND Rezerwacja = 1 ")) == 0) //jeśli domek nie jest zakwaterowany...
				if (1==1)//(mysql_num_rows(mysql_query...)  //TU ROBIĆ
				{
					
					echo $wyswietlany_komunikat."<br>";
					
					echo "<a href=".$nazwa_str_do_powrotu.">Wróć</a>";
				
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
					echo "<a href=".$nazwa_str_do_powrotu.">Wróć</a>";
					header( 'refresh: 5; url='.$nazwa_str_do_powrotu);
				}
		}
	//SELECT $walidowane_kolumny FROM $nazwy_tabel WHERE $where_warunek
		
		
	//INSERT INTO $nazwy_tabel ($kolumna1, $kolumna2, $kolumna3) VALUES ('$wartosc1', 'wartosc2', wartosc3) if string  dodaj cudzysłów, else if int nie dodawaj
	//DELETE FROM $nazwy_tabel WHERE $where_warunek
	//UPDATE $nazwy_tabel SET $kolumna1=$wartosc1, $kolumna2=$wartosc2, $kolumna3=$wartosc3  WHERE $where_warunek if string  dodaj cudzysłów, else if int nie dodawaj
		
		
		
		//podanie parametrów i wysywolanie funkcji
		
		
	// $walidacja_nazwy_tabel = array('domek');	
		
	// $walidacja_kolumny = array('Kolumna1'
							// , 'Kolumna2'
							// , 'Kolumna3');
						
	// $walidacja_wartosci = array('Wartosc1'
							// , 'Wartosc2');
	
	// $walidacja_warunki = array('Pole1' => 'Warunek1'
							// , 'Pole2' => 'Warunek2'
							// , 'Pole3' => 'Warunek3'
							// , 'Pole4'  => 'Warunek4');				
						
		// //function walidacja_wartosci($nazwy_tabel, $kolumny, $warunki)
	
		// walidacja_wartosci($_POST['walidacja_tabela'], $_POST['walidacja_kolumna'], $_POST['walidacja_warunek']);
		
		
		// $post = array('Pole1' => 'Wartosc1'
							// , 'Pole2' => 'Wartosc2'
							// , 'Pole4'  => 'Wartosc3'); // potem zamienic na tablece post ktora podpiac - linia 292
		
		// $nazwy_kolumn = array("Nazwa", "Opis", "Cena");
		
		// $where_warunek = "Warunek";
		
		//function baza($wartosci, $nazwa_str_do_powrotu, $nazwa_tabeli, $nazwy_kolumn, $typ_komendy, $where_warunek, $wyswietlany_komunikat, $walidacja)
		
		$walidacja = 1;
		
		baza ($_POST['wartosci'], $_POST['strona_wroc'], $_POST['tabela'], $_POST['kolumna'], $_POST['typ _komendy'], $_POST['warunek'], $_POST['komunikat'], $walidacja); //tak musi byc z post
		//baza ($post, "domki.php", "domek", $nazwy_kolumn, 1, "Tu jest komunikat", $where_warunek, 1);
		}
		else
		{
			echo "<b>Nie wysłano formularza. Zostaniesz przekierowany w ciągu 5 sekund...</b>";
			header('Refresh: 5; url=domki_panel_glowny.php'); // przekieruj po 5 sek.
			
			
		}
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