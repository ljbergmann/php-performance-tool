<?php
/*
* Autor: Leon Bergmann
* Datum: 27.12.2012 12:52
* Update:
* License: LICENSE.md
*/

class http
{
	/**
	 * host
	 * storing the Host in to it
	 * @var mixed
	 * @access protected
	 */
	protected $host;
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param mixed $host
	 * @return void
	 */
	public function __construct($host)
	{
		if(empty($host))
		{
			throw new Exception("No host given",1);
		}
		else
		{
			$this->init($host);
		}
	}

	/**
	 * init function.
	 * 
	 * @access private
	 * @param mixed $host
	 * @return void
	 */
	private function init($host)
	{
		$this->host	= $host;
		$conn	 	= fsockopen($host, 443);
		if(!$conn)
		{
			throw new Exception("Host not responding",1);
		}
		else
		{
			$this->connection = $conn;
			unset($conn,$host);
		}
		
	}
	
	public function get($path)
	{
		fputs($this->connection,"GET ".$path." HTTP/1.1\r\n");
		fputs($this->connection,"Host: ".$this->host."\r\n");
		fputs($this->connection,"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE; rv:1.7.12) Gecko/20050919 Firefox/1.0.7\r\n");
		fputs($this->connection,"Connection: Close\r\n\r\n");
		while (!feof($this->connection))
		{
			$data .= fgets($this->connection, 128);
		}
		
		$result = explode("\r\n\r\n", $data);
		return $result;
	}
	
	public function post($path,$data)
	{
		$data	= $this->parseData($Data);
		fputs($this->connection, "POST ".$path." HTTP/1.1\r\n");
		fputs($this->connection, "Host: ".$this->host."\r\n");
		fputs($this->connection, "Content-type: application/json\r\n");
	 	fputs($this->connection, "Content-length: ". strlen($data) ."\r\n");
		fputs($this->connection, "Connection: close\r\n\r\n");
		fputs($this->connection, $data);
		while (!feof($this->connection))
		{
			$data .= fgets($this->connection, 128);
		}
		$result = explode("\r\n\r\n", $data);
		return $result[0];
	}
	private function location($header)
	{
		if(isset($header['Location']))
		{
			$url = explode("/", $header['location']);
			$result = $url;
		}
		return $result;
	}
	private function parseData($data)
	{
		return json_encode($data);
	}
}
?>
