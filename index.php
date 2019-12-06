<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "inspekcija";
$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);

if (isset($_REQUEST['akcija']))
	$akcija = $_REQUEST['akcija'];
else
	$akcija = "";


if ($akcija == "izmjena_potvrda" || $akcija == "dodavanje_potvrda") {
	// Provjera ispravnosti
	$greska = "";
	if (isset($_POST['naziv']) && !empty($_POST['naziv']))
		$naziv = mysqli_real_escape_string($conn, $_POST['naziv']); // Zastita od SQL injection napada
	else
		$greska = "naziv";
	if (isset($_POST['proizvodac']) && !empty($_POST['proizvodac']))
		$proizvodac = mysqli_real_escape_string($conn, $_POST['proizvodac']); // Zastita od SQL injection napada
	else
		$greska = "proizvodac";
	if (isset($_POST['serijski_broj']) && !empty($_POST['serijski_broj']))
		$serijski_broj = mysqli_real_escape_string($conn, $_POST['serijski_broj']); // Zastita od SQL injection napada
	else
		$serijski_broj = ""; // opcionalno
	if (isset($_POST['zemlja_porijekla']) && !empty($_POST['zemlja_porijekla']))
		$zemlja_porijekla = mysqli_real_escape_string($conn, $_POST['zemlja_porijekla']); // Zastita od SQL injection napada
	else
		$greska = "zemlja porijekla";
	if (isset($_POST['opis']) && !empty($_POST['opis']))
		$opis = mysqli_real_escape_string($conn, $_POST['opis']); // Zastita od SQL injection napada
	else
		$opis = ""; // Opcionalno
	
	if ($greska == "") {
		if ($akcija == "dodavanje_potvrda")
			$q = mysqli_query($conn, "INSERT INTO proizvod VALUES (0, '$naziv', '$proizvodac', '$serijski_broj', '$zemlja_porijekla', '$opis')");
		else {
			$id = intval($_POST['id']);
			$q = mysqli_query($conn, "UPDATE proizvod SET naziv='$naziv', proizvodac='$proizvodac', serijski_broj='$serijski_broj', zemlja_porijekla='$zemlja_porijekla', opis='$opis' WHERE id=$id");
		}
	} else {
		print "<p><b style='color: red'>GREŠKA: Niste naveli obavezno polje $greska!</b></p>";
	}
}

if ($akcija == "brisanje") {
	$id = intval($_REQUEST['id']); // Zastita od SQL injection napada - uzimamo int vrijednost parametra id
	$q = mysqli_query($conn, "DELETE FROM proizvod WHERE id=$id");
}

?>

<h1>Proizvod</h1>
<table border="1" cellspacing="0">
<tr bgcolor="#ccc">
	<th>Naziv</th><th>Proizvođač</th><th>Serijski broj</th><th>Zemlja porijekla</th><th>Opis</th><th>Operacije</th>
</tr>

<?php

$q = mysqli_query($conn, "SELECT id, naziv, proizvodac, serijski_broj, zemlja_porijekla, opis FROM proizvod ORDER BY id");
while($r = mysqli_fetch_row($q)) {
	?>
	<tr>
		<td><?=$r[1]?></td><td><?=$r[2]?></td><td><?=$r[3]?></td><td><?=$r[4]?></td><td><?=$r[5]?></td>
		<td><a href="?akcija=izmijeni&amp;id=<?=$r[0]?>">Izmijeni</a> * 
		<a onclick="return confirm('Da li ste sigurni da želite obrisati ovaj proizvod?');" href="?akcija=brisanje&amp;id=<?=$r[0]?>">Obriši</a></td>
	</tr>
	<?php
}

?>
</table>

<?php

if ($akcija == "izmijeni") {
	print "<h3>Izmjena proizvoda</h3>";
	$id = intval($_REQUEST['id']); // Zastita od SQL injection napada - uzimamo int vrijednost parametra id
	$q = mysqli_query($conn, "SELECT naziv, proizvodac, serijski_broj, zemlja_porijekla, opis FROM proizvod WHERE id=$id");
	$p = mysqli_fetch_assoc($q);
	$akcija="izmjena_potvrda";
} else {
	print "<h3>Dodavanje proizvoda</h3>";
	$p = array( "naziv" => "", "proizvodac" => "", "serijski_broj" => "", "zemlja_porijekla" => "", "opis" => "" );
	$akcija="dodavanje_potvrda";
	$id = 0;
}

?>

<form action="index.php" method="POST">
<input type="hidden" name="akcija" value="<?=$akcija?>">
<input type="hidden" name="id" value="<?=$id?>">
<p>Naziv proizvoda: <input type="text" name="naziv" value="<?=$p['naziv']?>"><br>
Proizvođač: <input type="text" name="proizvodac" value="<?=$p['proizvodac']?>"><br>
Serijski broj: <input type="text" name="serijski_broj" value="<?=$p['serijski_broj']?>"><br>
Zemlja porijekla: <input type="text" name="zemlja_porijekla" value="<?=$p['zemlja_porijekla']?>"><br>
Opis: <textarea rows="5" cols="50" name="opis"><?=$p['opis']?></textarea><br>
<input type="submit" value=" Potvrda "></form>
