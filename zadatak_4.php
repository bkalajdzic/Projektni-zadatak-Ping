<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "inspekcija";
$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);

?>
<h2>Pregled izvršenih inspekcijskih kontrola</h2>

<?php

if (isset($_POST['nadlezno_inspekcijsko_tijelo'])) {
	$tijelo = intval($_POST['nadlezno_inspekcijsko_tijelo']);
	$dan_pocetak = intval($_POST['dan_pocetak']);
	$mjesec_pocetak = intval($_POST['mjesec_pocetak']);
	$godina_pocetak = intval($_POST['godina_pocetak']);
	$dan_kraj = intval($_POST['dan_kraj']);
	$mjesec_kraj = intval($_POST['mjesec_kraj']);
	$godina_kraj = intval($_POST['godina_kraj']);
	
	
	?>

<table border="1" cellspacing="0">
<tr bgcolor="#ccc">
	<th>datum</th><th>nadlezno_inspekcijsko_tijelo</th><th>kontrolisani_proizvod</th><th>rezultati_kontrole</th><th>proizvod_siguran</th>
</tr>

<?php

$q = mysqli_query($conn, "SELECT inspekcijska_kontrola.id, datum, inspekcijsko_tijelo.naziv, proizvod.naziv, rezultati_kontrole, proizvod_siguran 
FROM inspekcijska_kontrola, proizvod, inspekcijsko_tijelo
WHERE kontrolisani_proizvod=proizvod.id AND nadlezno_inspekcijsko_tijelo=inspekcijsko_tijelo.id AND nadlezno_inspekcijsko_tijelo=$tijelo
AND datum>='$godina_pocetak-$mjesec_pocetak-$dan_pocetak' AND datum<='$godina_kraj-$mjesec_kraj-$dan_kraj'
ORDER BY datum");
while($r = mysqli_fetch_row($q)) {
	?>
	<tr>
		<td><?=$r[1]?></td><td><?=$r[2]?></td><td><?=$r[3]?></td><td><?=$r[4]?></td><td><?=$r[5]?></td>
	</tr>
	<?php
}

?>
</table>

<?php

}

?>

<form action="zadatak_4.php" method="POST">
<p>Izaberite parametre izvještaja:<br>
Inspekcijsko tijelo: <SELECT name="nadlezno_inspekcijsko_tijelo"><?php
$q = mysqli_query($conn, "SELECT id, naziv FROM inspekcijsko_tijelo ORDER BY naziv");
while ($r = mysqli_fetch_row($q)) {
	print "<option value='" . $r[0] . "'";
	print ">" . $r[1] . "</option>";
}
?>
</select><br>
Početni datum: <select name="dan_pocetak"><?php 
for ($i=1; $i<=31; $i++) print "<option>$i</option>";
?></select>
<select name="mjesec_pocetak"><?php 
for ($i=1; $i<=12; $i++) print "<option>$i</option>";
?></select>
<select name="godina_pocetak"><?php 
for ($i=2000; $i<=2019; $i++) print "<option>$i</option>";
?></select><br>
Krajnji datum: <select name="dan_kraj"><?php 
for ($i=1; $i<=31; $i++) print "<option>$i</option>";
?></select>
<select name="mjesec_kraj"><?php 
for ($i=1; $i<=12; $i++) print "<option>$i</option>";
?></select>
<select name="godina_kraj"><?php 
for ($i=2000; $i<=2019; $i++) print "<option>$i</option>";
?></select><br>
<input type="submit" value="Prikaži izvještaj"></form>