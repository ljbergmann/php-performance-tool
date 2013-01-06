<?php
require_once("classes/class.controller.php");
require_once("classes/class.markdown.php");
require_once("classes/class.renderHTML.php");
require_once("classes/class.statistics.php");
echo "<pre>";
$data[0]['Test']	= "2.14576721191E-6";
$data[0]['Singel']	= "5.00679016113E-6";
$data[1]['Test']	= "9.53674316406E-7"; 
$data[1]['Singel']	= "2.14576721191E-6";
try
{
	$Controller = new Controller;
	$Controller->setRunMethod("markdown");
	$Controller->setData($data);
	$Controller->setSettings(array("formate"=>"%1.10F","Title"=>"This is an Test","Description"=>"I am testing my Controller","StatisticsMethod"=>0));
	$Controller->convertData();
	$Controller->run();
}
catch(Exception $e)
{
	echo $e->getMessage();
	echo "<br>";
	echo $e->getFile(), $e->getLine();
	echo "<br>";
}


print_r($Controller)
?>