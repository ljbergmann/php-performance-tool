<?php
ob_start();
$startE = microtime(true);
for($i = 0; $i <= 1000; $i++)
{
  echo "this is an random string<br>";
}
$endE = microtime(true);



$startP = microtime(true);
for($i = 0; $i <= 1000; $i++)
{
  print("this is an random string<br>");
}
$endP = microtime(true);

$time2 = $endE - $startE;

$time1 = $endP - $startP;

$b = ($time2 / $time1) * 100;
echo "<br>Echo is $b % faster";
/*
* 3. Je nach dem wie die PHP-Einstellungen bzw. der Server Hardwaretechnisch ausgestattet ist sind die Werte variabel.
* 4. Echo ist zwischen 80% und 90% schneller als print. Je nach dem ob ob_start() gesetzt ist oder nicht kann der Wert auch größer als 100% sein
* 5. In Kombination mit ob_start() ist echo tatsächlich schneller als print daraus folgt das mann am besten echo() verwenden sollte wenn man viele Strings bzw. lange Strings ausgeben möchte.
*/
?>

