<?php
$array	= array();
for($i = 0; $i <= 4999; $i++)
{
	ob_start();
	$s	= microtime(true);
	echo "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.tetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br>";
	$e	= microtime(true);
	ob_clean();
	ob_end_flush();
	
	$array[$i]['ob_start'] = $e - $s;
	
	$s = microtime(true);
	echo "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.tetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br>";
	$e = microtime(true);
	
	$array[$i]['no_cache']		= $e - $s;
	$array[$i]['difference']	= $array[$i]['ob_start'] - $array[$i]['no_cache'];
}

require("classes/class.markdown.php");
$dataMD = new markdown($array);
$dataMD->write();
?>