<?php
session_start(); //dołącz plik z ustawieniami
require('config.php'); //
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
{	$level = $_SESSION['level'];
	$user = $_SESSION['username']; //...pobierz zienne sesyjne
	if ($level == 1 or 2 or 3 or 4 or 5 or 6) //jeśli użytkownik ma odpowiednie uprawnienia
	{
		// wartosci to wartosci przekazywane z tablicy POST wpisywane do bazy w podane nazwy kolumn
		// nazwa_str_do_powrotu to nazwa strony php do powrotu z zatwierdz.php
		// nazwa_tabeli to nazwa tabeli
		// nazwy_kolumn to nazwy kolumn tabeli w bazie
		// typ_komendy 1-INSERT,  2-UPDATE, 3-DELETE
		if (isset($_POST['submit'])) //jeśli wysłano formularz z pliku .php)		
		{
			echo"<br/><br/>";
			echo"<br/><br/>";
			function walidacja_wartosci($nazwy_wszystkich_kolumn, $nazwy_wszystkich_wartosci, $nazwy_tabel, $kolumny, $warunki) // funkcja do skonczenia return walidacja prawda/fałsz i przekaz to do funkcji baza
			{
				require('config.php'); //
				foreach ($nazwy_tabel as $tabela)
				{
					$komenda_tabele.=$tabela;
					if (next($nazwy_tabel)==true)
					{
						$komenda_tabele.=", ";
					}
				}
				foreach ($kolumny as $kolumna)
				{
					$komenda_kolumny.=$kolumna;
					if (next($kolumny)==true)
					{
						$komenda_kolumny.=", ";
					}
				}
				$p = 0;
				foreach ($warunki as $warunek)
				{
					if (!is_numeric($warunek))
					{
						$komenda_warunki.=str_replace("quote","'",$warunek);
					}
					else
					{
						$kol = $nazwy_wszystkich_kolumn[$p];
						$wart = $nazwy_wszystkich_wartosci[$p];
						$komenda_warunki.= $kol."='".$wart."'";
						$p++;
					}
					if (next($warunki)==true)
					{
						$komenda_warunki.=" AND ";
					}
				}
				//echo "SELECT ".$komenda_kolumny." FROM ".$komenda_tabele." WHERE ".$komenda_warunki."<br><br>";
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
				mysql_select_db($db_name);
				if ((mysql_num_rows(mysql_query("SELECT ".$komenda_kolumny." FROM ".$komenda_tabele." WHERE ".$komenda_warunki."")) > 0))
				{
					$wal = 0;
					return $wal;
				}
				else
				{
					$wal = 1;
					return $wal;	
				}
			}
			function baza($wartosci, $nazwa_str_do_powrotu, $nazwy_tabel, $nazwy_kolumn, $typ_komendy, $warunki, $wyswietlany_komunikat, $wyswietlany_komunikat_błedu, $walidacja)
			{
				require('config.php'); //
				if (array_key_exists('submit', $wartosci)) {
					unset($wartosci['submit']);
				}
				$i=count($wartosci);
				$p = 1;
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
					$values.="'".$wartosci_tabela."'";
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
					$komenda_warunki.=str_replace("quote","'",$warunek);
					if (next($warunki)==true)
					{
						$komenda_warunki.=" AND ";
					}
				}
				$j=count($wartosci);
				$p = 1;
				foreach (array_combine($nazwy_kolumn, $wartosci) as $kolumny_tabela => $wartosci_tabela )
				{
					$komenda_update.=$kolumny_tabela."='".$wartosci_tabela."'";
					// if (next (array_combine($nazwy_kolumn, $wartosci))==true)
					// {
					// $komenda_update.=", ";
					// }
					$p++;
					if ($p<=$j)
					{
						$komenda_update.=", ";
					}
				}
				//echo"Walidacja = ".$walidacja;
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
				mysql_select_db($db_name);
				// if (mysql_num_rows(mysql_query...)
				if ($typ_komendy == 1) {
					if ($walidacja == 0)
					{
						echo $wyswietlany_komunikat_błedu."<br/><br/>";
						echo "<a href=".$nazwa_str_do_powrotu.">Wróć</a>";
						header( 'refresh: 5; url='.$nazwa_str_do_powrotu);
					}
					else
					{	
						$sql = "INSERT INTO ".$komenda_tabele." (".$columns.") VALUES (".$values.")";
						$results=mysql_query($sql) or die ('Wykonanie zapytania nie powiodło sie. Błąd:' .mysql_error()); //zatwierdź komendę lub wyświetl błąd
						if ( $results )
						{
							echo $wyswietlany_komunikat."<br/><br/>";	
							echo "<a href=".$nazwa_str_do_powrotu.">Wróć</a>";
							header( 'refresh: 5; url='.$nazwa_str_do_powrotu);
						}
					}
				} elseif ($typ_komendy == 2) {
					if ($walidacja == 0)//(mysql_num_rows(mysql_query...) //TU ROBIĆ
					{	
						$sql = "UPDATE ".$komenda_tabele." SET ".$komenda_update." WHERE ".$komenda_warunki."";
						//echo "Komenda: ".$sql;
						$results=mysql_query($sql) or die ('Wykonanie zapytania nie powiodło sie. Błąd:' .mysql_error()); //zatwierdź komendę lub wyświetl błąd
						if ( $results )
						{
							echo $wyswietlany_komunikat."<br/><br/>";
							echo "<a href=".$nazwa_str_do_powrotu.">Wróć</a>";
							header( 'refresh: 5; url='.$nazwa_str_do_powrotu);
						}
					}
					else
					{
						echo $wyswietlany_komunikat_błedu."<br/><br/>";
						echo "<a href=".$nazwa_str_do_powrotu.">Wróć</a>";
					}
				} elseif ($typ_komendy == 3) {
					if ($walidacja == 1)//(mysql_num_rows(mysql_query...)  //TU ROBIĆ
					{
						echo $wyswietlany_komunikat_błedu."<br/><br/>";
						echo "<a href=".$nazwa_str_do_powrotu.">Wróć</a>";
					}
					else
					{
						$sql = "DELETE FROM ".$komenda_tabele." WHERE ".$komenda_warunki.""; //TU ROBIĆ
						$results=mysql_query($sql) or die ('Wykonanie zapytania nie powiodło sie. Błąd:' .mysql_error()); //zatwierdź komendę lub wyświetl błąd
						if ( $results )
						{
							echo $wyswietlany_komunikat."<br/><br/>";	
							echo "<a href=".$nazwa_str_do_powrotu.">Wróć</a>";
							header( 'refresh: 5; url='.$nazwa_str_do_powrotu);
						}
					}
				}
			}
			$strona_powrotu = $_POST['strona_wroc'];
			$x = count(array_filter($_POST['kolumna']));
			$y = count(array_filter($_POST['wartosci']));
			if ($y < $x)
			{
				echo "Nie wypełniono wszystkich pól...<br/>";
				echo "<a href=".$strona_powrotu.">Wróć</a>";
				header( 'refresh: 5; url='.$strona_powrotu);
			}
			else
			{
				$walidacja = walidacja_wartosci($_POST['kolumna'], $_POST['wartosci'], $_POST['walidacja_tabela'], $_POST['walidacja_kolumna'], $_POST['walidacja_warunek']);
				baza ($_POST['wartosci'], $_POST['strona_wroc'], $_POST['tabela'], $_POST['kolumna'], $_POST['typ_komendy'], $_POST['warunek'], $_POST['komunikat_powodzenie'], $_POST['komunikat_niepowodzenie'], $walidacja); //tak musi byc z post
			}
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
}else
{	echo "<div id=login style='margin-top: 100px;'><br/>";
	echo "<h2 style='text-align: center; margin-top: 10px;'>Nie zalogowany. Zaloguj się!</h2>";
	echo "</div>";
	header('Location: index.php');
}?>
<!--
<div style='bottom: 75px; left: 350px; position: absolute; text-align: center;'>
<a href='index.html'>Powrót na stronę główną</a>
</div>
-->
</div>
</div>
</body>
</html>