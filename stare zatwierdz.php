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
		
		if (isset($_POST['dodaj'])) //jeśli wysłano formularz (porównaj linijka 431 z pliku domki.php)
		{
			
			// dodawanie rekordu
			
			$nazwa_domku = $_POST['nazwa'];
			$cena_domku = $_POST['cena']; 
			$opis_domku = $_POST['opis']; // przypisanie zmiennych
			
			if  ((empty($nazwa_domku)) or (empty($opis_domku)) or (empty($cena_domku))) //jeśli user nie wypełnił wszystkich pól
			{
				
				echo "Nie wypełniono wszystkich pól formularza...";
				echo "<a href='domki.php'>Wróć</a>";
				header( 'refresh: 5; url=domki.php' );
				
			}
			else
			{
				
				//echo $nazwa_domku;
				//echo $opis_domku;
				
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą danych
				mysql_select_db($db_name); //wybierz bazę
				
				if(mysql_num_rows(mysql_query("SELECT Nazwa FROM domek WHERE Nazwa = '$nazwa_domku'")) > 0) //jeśli taki rekord istanieje
				{
					
					echo "Taki domek już istnieje<br>";
					//echo $stara_nazwa_domku."<br>";
					//echo $stary_opis_domku."<br>";
					//echo "na:<br>";
					//echo $nazwa_domku."<br>";
					//echo $opis_domku."<br>";
					echo "<a href='domki.php'>Wróć</a>";
					header( 'refresh: 5; url=domki.php' );
					
					
				}
				
				else
				{
					//... jeśli nie
					
					
					
					$dodawane = "INSERT INTO domek (Nazwa, Opis, Cena) VALUES ('$nazwa_domku', '$opis_domku', $cena_domku)"; //wstaw nowy rekord
					$results=mysql_query($dodawane) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error()); //zatwierdź komendę lub wyświetl błąd
					
					if ( $results  ) //jeśli powiodło się
					{
						
						echo "Pomyślnie dodano rekord do bazy<br>";
						echo $nazwa_domku."<br>";
						echo $opis_domku."<br>";
						echo "<a href='domki.php'>Wróć</a>";
						header( 'refresh: 5; url=domki.php' );
						
						
					}
					else //...a jeśli nie
					{
						
						echo "Błąd. Nie dodano rekordu do bazy";
						echo "<a href='domki.php'>Wróć</a>";
						header( 'refresh: 5; url=domki.php' );	// przekieruj po 5 sek.			
						
					}
				}
			}
		}
		if (isset($_POST['edytuj'])) // jeśli wysłano formularz (porównaj linijka 461 z pliku domki.php)
		{
			// edycja rekordu

			
			
			$nazwa_domku = $_POST['nazwa'];
			$cena_domku = $_POST['cena']; 
			$stara_cena_domku = $_POST['stara_cena']; 
			$opis_domku = $_POST['opis']; 
			$stara_nazwa_domku = $_POST['stara_nazwa']; 
			$stary_opis_domku = $_POST['stary_opis']; // przypisz zmienne
			
			//echo $nazwa_domku;
			//echo $opis_domku;
			
			
			if  ((empty($nazwa_domku)) or (empty($opis_domku ))) // jeśli nie wypełniono wszystkich pól formularza
			{
				
				echo "Nie wypełniono wszystkich pól formularza...";
				echo "<a href='domki.php'>Wróć</a>";
				header( 'refresh: 5; url=domki.php' ); // przekieruj po 5 sek.	
				
			}
			
			
			else //... a jeśli wypełniono wszystkie
			{
				
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz się z bazą a w razie nieudanej próby wyświetl błąd
				mysql_select_db($db_name); // ...wybierz bazę
				
				//
				
				if(mysql_num_rows(mysql_query("SELECT Nazwa FROM domek WHERE Nazwa = '$nazwa_domku' && Opis = '$opis_domku' && Cena= $cena_domku ")) > 0) // jeśli istnieje w bazie
				{
					
					echo "Taki domek już istnieje lub nie zeedytowano wpisu...<br>";
					//echo $stara_nazwa_domku."<br>";
					//echo $stary_opis_domku."<br>";
					//echo "na:<br>";
					//echo $nazwa_domku."<br>";
					//echo $opis_domku."<br>";
					echo "<a href='domki.php'>Wróć</a>";
					header( 'refresh: 5; url=domki.php' );
					
					
				}
				
				else // ...a jeśli nie
				{
					//
					
					$edytowany_rekord = "UPDATE domek SET Nazwa = '$nazwa_domku', Opis = '$opis_domku', Cena = '$cena_domku' WHERE Nazwa = '$stara_nazwa_domku' AND Opis = '$stary_opis_domku' ";
					$results=mysql_query($edytowany_rekord) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
					
					if ( $results)  // jeśli się powiodło edytowanie rekordu w bazie
					{
						
						echo "Pomyślnie zedytowano rekord z bazy<br>";
						echo $stara_nazwa_domku."<br>";
						echo $stary_opis_domku."<br>";
						echo $stara_cena_domku."<br>";
						echo "na:<br>";
						echo $nazwa_domku."<br>";
						echo $opis_domku."<br>";
						echo $cena_domku."<br>";
						echo "<a href='domki.php'>Wróć</a>";
						header( 'refresh: 5; url=domki.php' ); // przekieruj po 5 sek.	
						
					}
					else //... a jeśli się nie powiodło
					{
						
						echo "Błąd. Nie zedytowano rekordu z bazy";	
						echo "<a href='domki.php'>Wróć</a>";
						header( 'refresh: 5; url=domki.php' ); // przekieruj po 5 sek.	
						
					}
					
				}
			}			
		}
		if (isset($_POST['usun'])) //jeśli wysłano formularz (porównaj linijka 505 z pliku domki.php)
		{
			// usuwanie rekordu
			
			
			$id = $_POST['id']; 
			$nazwa_domku = $_POST['nazwa']; 
			$opis_domku = $_POST['opis']; //przypisz zmienne
			
			//echo $nazwa_domku;
			//echo $opis_domku;
			
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz się z bazą a w razie nieudanej próby wyświetl błąd
			mysql_select_db($db_name); // ...wybierz bazę
			
			//mysql_query(SELECT rezerwacja FROM domek WHERE Nazwa = '$nazwa_domku')
			//$zakwaterowanie=mysql_query($pobierz) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error()); //...zatwierdź komendę mysql
			
			if (mysql_num_rows(mysql_query("SELECT * FROM domek WHERE Nazwa = '$nazwa_domku' AND Rezerwacja = 1 ")) == 0) //jeśli domek nie jest zakwaterowany...
			{
				//...usuwaj domek
				
				$usuwany_rekord = "DELETE FROM domek WHERE Nazwa = '$nazwa_domku' AND Opis = '$opis_domku'"; // ...usuń rekord domku z tabeli domek
				
				//DELETE T1, T2
				//FROM T1
				//INNER JOIN T2 ON T1.key = T2.key
				//WHERE condition
				
				
				// $usuwany_rekord = "DELETE FROM domek
				// WHERE domek.ID = $id AND
				// WHERE domek.ID = promocja.ID_Domek AND
				// domek.ID = rezerwacja.ID_Domek AND
				// domek.ID = zamowienia.ID_Domek
				// JOIN promocja AS prom ON prom.ID_Domek = domek.ID
				// JOIN rezerwacja AS rez ON rez.ID_Domek = domek.ID
				// JOIN zamowienia AS zam ON zam.ID_Domek = domek.ID
				// "; // ...usuń rekord domku z tabeli domek, promocja, rezerwacja i zamowienia
				
				$results=mysql_query($usuwany_rekord) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error()); //...zatwierdź komendę mysql
				
				if ( $results  ) //  jeśli poprawnie usunięto rekord
				{
					
					echo "Usunięto rekord z bazy<br>";
					echo $nazwa_domku."<br>";
					echo $opis_domku."<br>";
					echo "<a href='domki.php'>Wróć</a>";
					header( 'refresh: 5; url=domki.php' );
					
				}
				else // a jeśli nie
				{
					
					echo "Błąd. Nie usunięto rekordu z bazy";	
					echo "<a href='domki.php'>Wróć</a>";
					header( 'refresh: 5; url=domki.php' ); // przekieruj po 5 sek.	
					
				}
				
			}
			else{
				
				echo "Nie można usunąć domku ponieważ jest aktualnie zakwaterowany...";
				echo "<a href='domki.php'>Wróć</a>";
			}	
		}	


		

		

		//else
		//	{
		//	
		//		echo Brak danych;
		//	
		//	}
		//mysql_close($connection);
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