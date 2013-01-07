<?php
require_once("classes/class.controller.php");
require_once("classes/class.markdown.php");
require_once("classes/class.renderHTML.php");
require_once("classes/class.statistics.php");
echo "<pre>";

$data[0]['Factory']		= "1";
$data[0]['Singelton']	= "2";
$data[0]['Database']	= "3"; 
$data[0]['Non']			= "4";

$data[1]['Factory']		= "4";
$data[1]['Singelton']	= "3";
$data[1]['Database']	= "2"; 
$data[1]['Non']			= "1";
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


print_r($Controller);

echo file_size(memory_get_usage());
echo "<br>";
echo file_size(memory_get_peak_usage());
?>