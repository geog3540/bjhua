<?php

// sensor.php?city=Ames&type=3

if (isset($_GET["city"])) {
	$cityname = "%".$_GET["city"]."%";
} else {
	$cityname = "%io%";
}

if (isset($_GET["type"])) {
	$stype = $_GET["type"];
} else {
	$stype = 0;
}

$database = "host=s-l112.engr.uiowa.edu dbname=inf_db22 user=inf_student22 password=engr-2022-22";

if ($stype==0) {
	$query = "SELECT * FROM sites WHERE city ILIKE $1 ORDER BY stype, city";
} else {	
	$query = "SELECT * FROM sites WHERE city ILIKE $1 AND stype = $2 ORDER BY stype, city";
}

$connection = pg_connect($database);

$result = pg_prepare($connection, "query", $query);

if ($stype==0) {
	$result = pg_execute($connection, "query", array($cityname));
} else {	
	$result = pg_execute($connection, "query", array($cityname, $stype));
}

$str = "[ ";
while ($row = pg_fetch_assoc($result)) {
	$str .= "[" . $row['id'] . ", '";
	$str .= $row['city'] . "', '";
	$str .= $row['river'] . "', ";
	$str .= $row['stype'] . ", ";
	$str .= $row['lat'] . ", ";
	$str .= $row['lng'] . "],";
}
$str = substr($str, 0, -1);
$str .= "]";

print $str;

?>