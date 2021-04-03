<?php

require_once "api.php";

$tx = getTx();
$patient = getPatients("7000001169539");

print_r($tx);


?>

