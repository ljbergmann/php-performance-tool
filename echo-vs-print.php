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
?>
