<?php
error_reporting(-1);
$array[0]['if']		= 1;
$array[0]['switch']	= 2;
$array[0]['diff']	= -1;
$array[1]['if']		= 2;
$array[1]['switch']	= 4;
$array[1]['diff']	= -2;
require("class.dataMD.php");
$dataMD = new dataMD($array);
echo "<pre>";
print_r($dataMD->write());
print_r($dataMD);
?>