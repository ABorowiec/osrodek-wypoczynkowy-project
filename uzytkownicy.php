<html>
<head>
<META NAME="robots" CONTENT="noindex, nofollow">
<link rel="shortcut icon" href="dane\favicon.ico">
<link rel="Stylesheet" type="text/css" href="dane\style.css" />
</head>
<body>
<div id=site style="height: 1400px; border: 1px; border-style: none; border-color: #0000ff;">
<div id=mainsite style ="width: 1100px; height: 1300px; top: 100px; left: 100px; position: absolute; border: 1px; border-style: solid; border-color: #000000;">
<h1 style='text-align: center; margin-top: 10px; color: #ffffff; '>Lista użytkowników</h1>

<?php

session_start();
require_once('config.php');

if(isset($_SESSION['zalogowany']))
{
$level = $_SESSION['level'];

if ($level == 6)
{
	
if (isset($_POST['dodaj']))
{
if ($_POST['dodaj'] == 'Dodaj użytkownika')
{
	
	
	if ((!empty($_POST['user'])) and(!empty($_POST['password'])) and (!empty($_POST['password2'])) and (!empty($_POST['level'])))
	{
		$user = $_POST['user'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$obecna_data = date("Y-m-d H:i:s");
		$level = $_POST['level'];
		
		
	if ($password == $password2)
	{
	$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
	mysql_select_db($db_name);
	
	
	if(mysql_num_rows(mysql_query("SELECT username FROM users WHERE username = '$user'")) == 0)
	{
		
	$password = hash('sha256', $password, false);	
		
	$sql="INSERT INTO users(username, password, level, date_register) VALUES ('$user', '$password', '$level', '$obecna_data')";

	$data=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
	
	

	}
	else // jesli istnieje
	{
	
	$message1 = "Nie można dodać użytkownika ponieważ taka nazwa użytkownika już istnieje już w bazie...";	
	
	}
	
}
else{
	$message1 = "Hasła nie są zgodne...";
}
}
else{
	$message1 = "Nie wypełniono wszystkich pól...";
}

}
}
//else{
//	$message1 = "Whehe is my form...";
//}

if (isset($_POST['usun']))
{
if ($_POST['usun'] == 'Usuń użytkownika')
{

$user = $_POST['user'];

$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error());

mysql_select_db($db_name);

$delete = "DELETE FROM users WHERE username = '$user' ";

$results=mysql_query($delete) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$message1 =  "Usunięto użytkownika";

}

}
//else{
//	$message2 = "Whehe is my form2...";
//}

$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error());

mysql_select_db($db_name);

$superadmin = "SELECT * FROM users ORDER BY username ASC ";

$results=mysql_query($superadmin) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

echo "<div id=users>";
echo "<h2 style='margin-bottom: 10px; margin-top: 20px;'>Lista uzytkowników</h2>";
echo "<table class=tabelka>";

echo "<tr><td>Użytkownik";
echo "</td>";
echo "<td>Data logowania";
echo "</td>";
echo "<td>IP logowania";
echo "</td>";
echo "<td>Data rejestracji";
echo "</td>";
echo "<td>Typ";
echo "</td></tr>";

while ($row1 = mysql_fetch_row($results)) {

$username = $row1[0];
$level = $row1[2];
$iplogin = $row1[4];
$dateregister = $row1[5];
$datelogin = $row1[6];

switch ($level) {
    case 1:
        $usertype = "Przedstawiciel";
        break;
    case 2:
        $usertype = "Recepcjonista";
        break;
    case 3:
        $usertype = "Promotor";
        break;
	case 4:
        $usertype = "Księgowy";
        break;
	case 5:
        $usertype = "Właściciel";
        break;
	case 6:
        $usertype = "Administrator";
        break;
}
 
echo "<tr><td>".$username;
echo "</td>";
echo "<td>".$datelogin;
echo "</td>";
echo "<td>".$iplogin;
echo "</td>";
echo "<td>".$dateregister;
echo "</td>";
echo "<td>".$usertype;
echo "</td></tr>";
//echo "<td>".$row1[2];
//echo "</td>";

}

echo "</tr></table>";


$usun = "SELECT * FROM users ORDER BY username ASC ";

$results=mysql_query($usun) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());



echo"<form method='post' action='' style='margin-top: 210px; margin-bottom: 40px;'>";
echo"<SELECT name='user'>";
while ($row3 = mysql_fetch_row($results))
{
echo "<option value='". $row3[0] ."'>". $row3[0] ."</option>";
}
echo"</SELECT>";
echo"<input type='submit' name='usun' value='Usuń użytkownika' /> <br/><br/>";
if (isset($message1))
{
echo $message1;
}
echo"</form>";


echo "<form method='post' action=''>";
echo "Nazwa: <input type='text' name='user'><br/><br/>";
echo "Hasło: <input type='password' name='password'><br/><br/>";
echo "Powtórz hasło: <input type='password' name='password2'><br/><br/>";
echo"<SELECT name='level'>";
	echo"<option selected disabled>Wybierz typ użytkownika...</option>";
	echo "<option value='1'>Przedstawiciel</option>";
	echo "<option value='2'>Recepcjonista</option>";
	echo "<option value='3'>Promotor</option>";
	echo "<option value='4'>Księgowy</option>";
	echo "<option value='5'>Właściciel</option>";
	echo "<option value='6'>Administrator</option>";
	echo"</SELECT><br/><br/>";
echo "<input type='submit' value='Dodaj użytkownika' name='dodaj'> <br/><br/>";
if (isset($message2))
{
echo $message2;
}
echo "</form>";





// DIV - FORMULARZ DODAJ NOWEGO USERA;


	}
	else	
	{
	echo "<b>Nieodpowiednie uprawnienia. Zostaniesz przekierowany w ciągu 5 sekund...</b>";
	header('Refresh: 5; url=domki_panel_glowny.php');
	}


}
else
{
echo "<div id=login style='margin-top: 100px; width: 350px; text-align: center; position: absolute; margin-left: 225px; border-style: none;'><br/>";
echo "<h2 style='text-align: center; margin-top: 10px;'>Niezalogowany. Zaloguj się!</h2>";
echo "</div>";
header('Refresh: 5; url=index.php');
}



//echo "</div>";
?>


<div style='bottom: 10px; left: 350px; position: absolute; text-align: center;'>
<a href='domki_panel_glowny.php'>Powrót na stronę główną</a>
</div>

</div>
</div>
</body>
</html>