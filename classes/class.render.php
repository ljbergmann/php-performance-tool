<?php
/*
* Autor: Leon Bergmann
* Datum: 26.12.2012 12:58
* Update:
* License: LICENSE.md
*/
class renderHTML
{
	private $content;
	private $connection:
	const HOST = "https://api.github.com/markdown";
	
	public function __construct()
	{
		$this->connection = curl_init();
		curl_setopt($this->connection, CURLOPT_URL, $this->HOST);
		curl_setopt($this->connection, CURLOPT_POST, 1);
	}
}
?>
