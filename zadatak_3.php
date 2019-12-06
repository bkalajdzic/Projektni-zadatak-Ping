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

}

if ($akcija == "brisanje") {
	$id = intval($_REQUEST['id']); // Zastita od SQL injection napada - uzimamo int vrijednost parametra id
	$q = mysqli_query($conn, "DELETE FROM inspekcijska_kontrola WHERE id=$id");
}

if ($akcija == "izmjena_potvrda" || $akcija == "dodavanje_potvrda") {
	
	$datum = intval($_POST['datum']);
	$nadlezno_inspekcijsko_tijelo = intval($_POST['nadlezno_inspekcijsko_tijelo']);
	$kontrolisani_proizvod = intval($_POST['kontrolisani_proizvod']);
	if (isset($_POST['rezultati_kontrole']) && !empty($_POST['rezultati_kontrole']))
		$rezultati_kontrole = mysqli_real_escape_string($conn, $_POST['rezultati_kontrole']); // Zastita od SQL injection napada
	$proizvod_siguran = intval($_POST['proizvod_siguran']);
	

	
	if ($greska == "") {
		if ($akcija == "dodavanje_potvrda")
			
			$q = mysqli_query($conn, "INSERT INTO inspekcijska_kontrola VALUES (0, '$datum', '$nadlezno_inspekcijsko_tijelo', '$kontrolisani_proizvod', '$rezultati_kontrole', '$proizvod_siguran')");
		else {
			$id = intval($_POST['id']);
			$q = mysqli_query($conn, "UPDATE inspekcijska_kontrola SET datum='$datum', nadlezno_inspekcijsko_tijelo='$nadlezno_inspekcijsko_tijelo', kontrolisani_proizvod='$kontrolisani_proizvod', rezultati_kontrole='$rezultati_kontrole', proizvod_siguran='$proizvod_siguran' WHERE id=$id");
		}
	} else {
		print "<p><b style='color: red'>GREŠKA: Niste naveli obavezno polje $greska!</b></p>";
	}
}
?>

<h1>inspekcijska kontrola</h1>
<table border="1" cellspacing="0">
<tr bgcolor="#ccc">
	<th>datum</th><th>nadlezno_inspekcijsko_tijelo</th><th>kontrolisani_proizvod</th><th>rezultati_kontrole</th><th>proizvod_siguran<th>Operacije</th></th>
</tr>

<?php

$q = mysqli_query($conn, "SELECT inspekcijska_kontrola.id, datum, inspekcijsko_tijelo.naziv, proizvod.naziv, rezultati_kontrole, proizvod_siguran 
FROM inspekcijska_kontrola, proizvod, inspekcijsko_tijelo
WHERE kontrolisani_proizvod=proizvod.id AND nadlezno_inspekcijsko_tijelo=inspekcijsko_tijelo.id ORDER BY id");
while($r = mysqli_fetch_row($q)) {
	?>
	<tr>
		<td><?=$r[1]?></td><td><?=$r[2]?></td><td><?=$r[3]?></td><td><?=$r[4]?></td><td><?=$r[5]?></td>
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
	$q = mysqli_query($conn, "SELECT datum, nadlezno_inspekcijsko_tijelo, kontrolisani_proizvod, rezultati_kontrole, proizvod_siguran FROM inspekcijska_kontrola WHERE id=$id ORDER BY id");
		print mysqli_error($conn);
	$p = mysqli_fetch_assoc($q);
	$akcija="izmjena_potvrda";
} else {
	print "<h3>Dodavanje</h3>";
	$p = array( "datum" => "", "nadlezno_inspekcijsko_tijelo" => "", "kontrolisani_proizvod" => "", "rezultati_kontrole" => "", "proizvod_siguran" => "" );
	$akcija="dodavanje_potvrda";
	$id = 0;
}

?>

<form action="zadatak_3.php" method="POST">
<input type="hidden" name="akcija" value="<?=$akcija?>">
<input type="hidden" name="id" value="<?=$id?>">
<p>Datum: <input type="text" name="datum" value="<?=$p['datum']?>"><br>
Nadlezno inspekcijsko tijelo: <SELECT name="nadlezno_inspekcijsko_tijelo"><?php
$q = mysqli_query($conn, "SELECT id, naziv FROM inspekcijsko_tijelo ORDER BY naziv");
while ($r = mysqli_fetch_row($q)) {
	print "<option value='" . $r[0] . "'";
	if ($r[0] == $p['nadlezno_inspekcijsko_tijelo']) print " SELECTED";
	print ">" . $r[1] . "</option>";
}
?>
</select><br>
Kontrolisani proizvod: <select name="kontrolisani_proizvod"><?php
$q = mysqli_query($conn, "SELECT id, naziv FROM proizvod ORDER BY naziv");
while ($r = mysqli_fetch_row($q)) {
	print "<option value='" . $r[0] . "'";
	if ($r[0] == $p['kontrolisani_proizvod']) print " SELECTED";
	print ">" . $r[1] . "</option>";
}
?>
</select><br>
Rezultati kontrole: <input type="text" name="rezultati_kontrole" value="<?=$p['rezultati_kontrole']?>"><br>
Proizvod siguran: <textarea rows="5" cols="50" name="proizvod_siguran"><?=$p['proizvod_siguran']?></textarea><br>
<input type="submit" value=" Potvrda "></form>


