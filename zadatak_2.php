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
$greska = "";}


if ($akcija == "brisanje") {
	$id = intval($_REQUEST['id']); // Zastita od SQL injection napada - uzimamo int vrijednost parametra id
	$q = mysqli_query($conn, "DELETE FROM inspekcijsko_tijelo WHERE id=$id");
}


if ($akcija == "izmjena_potvrda" || $akcija == "dodavanje_potvrda") {
	$inspektorat = intval($_POST['inspektorat']);
$nadleznost = intval($_POST['nadleznost']);	
	
	if (isset($_POST['naziv']) && !empty($_POST['naziv']))
		$naziv = mysqli_real_escape_string($conn, $_POST['naziv']); // Zastita od SQL injection napada
	
	if (isset($_POST['kontakt_osoba']) && !empty($_POST['kontakt_osoba']))
		$kontakt_osoba = mysqli_real_escape_string($conn, $_POST['kontakt_osoba']); // Zastita od SQL injection napada
	if (isset($_POST['inspektorat']) && !empty($_POST['inspektorat']))
		$inspektorat = mysqli_real_escape_string($conn, $_POST['inspektorat']); // Zastita od SQL injection napada
	if (isset($_POST['nadleznost']) && !empty($_POST['nadleznost']))
		$nadleznost = mysqli_real_escape_string($conn, $_POST['nadleznost']); // Zastita od SQL injection napada
	
	// Provjera ispravnosti
	if ($greska == "") {
		if ($akcija == "dodavanje_potvrda")
			$q = mysqli_query($conn, "INSERT INTO inspekcijsko_tijelo VALUES (0, '$naziv', '$inspektorat', '$nadleznost', '$kontakt_osoba')");
		else {
			$id = intval($_POST['id']);
			$q = mysqli_query($conn, "UPDATE inspekcijsko_tijelo SET naziv='$naziv', inspektorat='$inspektorat', nadleznost='$nadleznost', kontakt_osoba='$kontakt_osoba' WHERE id=$id");
		}
		print mysqli_error($conn);
	} else {
		print "<p><b style='color: red'>GREŠKA: Niste naveli obavezno polje $greska!</b></p>";
}

}



?>

<h1>inspekcijsko tijelo</h1>
<table border="1" cellspacing="0">
<tr bgcolor="#ccc">
	<th>naziv_inspekcijskog_tijela</th><th>inspektorat</th><th>nadleznost</th><th>kontakt osoba</th><th>Operacije</th></th>
</tr>

<?php

$q = mysqli_query($conn, "SELECT id, naziv, inspektorat, nadleznost, kontakt_osoba FROM inspekcijsko_tijelo ORDER BY id");
print mysqli_error($conn);
while($r = mysqli_fetch_row($q)) {
	?>
	<tr>
		<td><?=$r[1]?></td><td><?=$r[2]?></td><td><?=$r[3]?></td><td><?=$r[4]?></td>
		<td><a href="?akcija=izmijeni&amp;id=<?=$r[0]?>">Izmijeni</a> * 
		<a onclick="return confirm('Da li ste sigurni da želite obrisati ovaj podatak?');" href="?akcija=brisanje&amp;id=<?=$r[0]?>">Obriši</a></td>
	</tr>
	<?php
}

?>
</table>

<?php

if ($akcija == "izmijeni") {
	print "<h3>Izmjena</h3>";
	$id = intval($_REQUEST['id']); // Zastita od SQL injection napada - uzimamo int vrijednost parametra id
	$q = mysqli_query($conn, "SELECT naziv, inspektorat, nadleznost, kontakt_osoba FROM inspekcijsko_tijelo WHERE id=$id");
	$p = mysqli_fetch_assoc($q);
	$akcija="izmjena_potvrda";
} else {
	print "<h3>Dodavanje</h3>";
	$p = array( "naziv" => "", "inspektorat" => "", "nadleznost" => "", "kontakt_osoba" => "" );
	$akcija="dodavanje_potvrda";
	$id = 0;
}

?>

<form action="zadatak_2.php" method="POST">
<input type="hidden" name="akcija" value="<?=$akcija?>">
<input type="hidden" name="id" value="<?=$id?>">
<p>Naziv: <input type="text" name="naziv" value="<?=$p['naziv']?>"><br>
Inspektorat: <select name="inspektorat">
<option>FBIH</option>
<option>RS</option>
<option>Distrikt Brcko</option>
</select><br>
Nadleznost <input type="text" name="nadleznost" value="<?=$p['nadleznost']?>"><br>
Kontakt osoba: <input type="text" name="kontakt_osoba" value="<?=$p['kontakt_osoba']?>"><br>
<input type="submit" value=" Potvrda "></form>


