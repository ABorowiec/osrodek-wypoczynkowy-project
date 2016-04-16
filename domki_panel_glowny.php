<?php
session_start();
require_once('config.php');
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

if(isset($_SESSION['zalogowany']))
{

function wyloguj()
{
$_SESSION = array();
session_destroy();
header('Location: index.php');
}

if (isset($_GET['wyloguj'])){
if ($_GET['wyloguj'] == 'yes') { 
    wyloguj(); 
	} 
}


$level = $_SESSION['level'];
$username = $_SESSION['username'];

echo "<div style='margin-top: 50px; margin-left: 570px; position: absolute; border: 1px; border-style: none; border-color: #ffffff; font-weight: bold;;'><br/>";
echo "Witaj &nbsp <span style='color: #0000ff;'>".$username."</span><br/>";
echo"<a href='?wyloguj=yes'>Wyloguj</a>";
echo "</div>";
//echo "<h2 style='text-align: center; margin-top: 10px;'>Panel pracownika</h2>";

switch ($level) {
    case 1:
        $usertype = "przedstawiciela";
        break;
    case 2:
        $usertype = "recepcjonisty";
        break;
    case 3:
        $usertype = "promotora";
        break;
	case 4:
        $usertype = "księgowego";
        break;
	case 5:
        $usertype = "właściciela";
        break;
	case 6:
        $usertype = "administratora";
        break;
}

echo "<h2 style='text-align: center; margin-top: 10px;'>Panel ".$usertype."</h2>";


$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error());

mysql_select_db($db_name);

$pokaz = "SELECT * FROM dzialy WHERE LEV_DOSTEPU = $level ORDER BY DZIAL ASC ";

$results=mysql_query($pokaz) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());


echo "<table><tr>";

while ($row1 = mysql_fetch_row($results)) {
	
		
		$adres = $row1[1];
		$link = $row1[2];
		
		echo "<td><a href='".$adres."'>".$link."</a></td>";
		
	
	
	
}

echo "</tr></table>";

//echo "<table id=tables><tr>";

//echo "<td><a href=domki.php>Domki</a></td>";
//echo "<td><a href=dostepne_srodki.php>Dostępne środki</a></td>";
//echo "<td><a href=rezerwacje.php>Rezerwacje</a></td>";
//echo "<td><a href=oferty.php>Oferty</a></td>";
//echo "<td><a href=usterki.php>Usterki></td>";

//echo "</tr><tr>";

//echo "<td><a href=firmy.php>Firmy</a></td>";
//echo "<td><a href=niezbedne_srodki.php>Niezbędne środki</a></td>";
//echo "<td><a href=kontrakty.php>Kontrakty</a></td>";
//echo "<td><a href=promocje.php>Promocje</a></td>";
//echo "<td><a href=klienci.php>Klienci</a></td>";


//echo "</tr></table>";

//echo "<div id=login style='margin-top: 200px;'><br/>";
//echo "<table><tr>";
//echo "<td><a href='sc_gallery.php'>Edycja galerii</a><br/></td>";
//echo "</tr><tr>";
//echo "<td><a href='sc_users.php'>Edycja użytkowników</a><br/></td>";
//echo "</tr></table></div>";
}
else
{
echo "<div id=login style='margin-top: 100px;'><br/>";
echo "<h2 style='text-align: center; margin-top: 10px;'>Nie zalogowany. Zaloguj się!</h2>";
echo "</div>";
header('Location: index.php');
}

 // <div style='bottom: 75px; left: 350px; position: absolute; text-align: center;'>
 // <a href='index.html'>powrót na stronę główną</a>
 // </div>
?>



</div>
</div>
</body>
</html>