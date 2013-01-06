<?php
/**
* Autor: Leon Bergmann, saftmeister
* Datum: 24.12.2012 12:50
* Update: 31.12.2012 01:49 Uhr  
* License: LICENSE.md
* markdown class.
*/

class Markdown
{
	/**
	 * filename
	 * 
	 * (default value: "data.md")
	 * 
	 * @var string
	 */
	private $filename;

	/**
	 * count
	 * 
	 * @var mixed
	 * @access private
	 */
	private $count;
	/**
	 * data
	 * 
	 * @var mixed
	 * @access private
	 */
	private $data;
	/**
	 * title
	 * 
	 * @var mixed
	 * @access private
	 */
	private $title;
	/**
	 * description
	 * 
	 * @var mixed
	 * @access private
	 */
	private $description; 
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @param mixed $title (default: null)
	 * @param mixed $description (default: null)
	 * @return void
	 */
	public function __construct()
	{
		$this->filename = dirname(__FILE__) ." /data.md";
	}

	/**
	 * Set the data values
	 * @param array $data
	 */
	public function setData(array $data)
	{
		$this->data		= $data;
	}
	
	/**
	 * setStatisticsData function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return void
	 */
	public function setStatisticsData($data)
	{
		$this->statisticsData = $data;
	}
	
	/**
	 * Set the title
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = strval($title);
	}
	
	/**
	 * Set the description
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = strval($description);
	}
		
	public function setDataDir($dir)
	{
		$this->setDataPathAbsolute($dir . '/data.md');
	}
	
	/**
	 * setDataPathAbsolute function.
	 * set the data path
	 * @access public
	 * @param mixed $path
	 * @return void
	 */
	public function setDataPathAbsolute($path)
	{
		if(!is_dir(dirname($path)))
			throw new Exception("Directory " . dirname($path) . " does not exist!");
		$this->filename =  $path;
	}
	
	/**
	 * write function.
	 * writing the data into the file
	 * @access public
	 * @return void
	 */
	public function write()
	{
		$fileContent[] 	= $this->markdownFileHead();
		$fileContent[]	= $this->markdownDataHeader();
		$fileContent[]	= $this->markdownData();
		$fileContent[]	= $this->markdownStatistic();
		
		$fileContent	= implode("\n", $fileContent);
		
		file_put_contents($this->filename, $fileContent);
	}
	
	/**
	 * markdownFileHead function.
	 * Creating the head of the document.
	 * @access private
	 * @return string
	 */
	private function markdownFileHead()
	{
		
		if(!is_null($this->title))
		{
			$head	= '---------'."\n";
			$head  .= '# '.$this->title."\n";
			$head  .= '---------'."\n";
		}
		else
		{
			$head	= '---------'."\n";
			$head  .= '# '."Data"."\n";
			$head  .= '---------'."\n";
		}
		if(!is_null($this->description))
		{
			$head .= $this->description."\n";
		}
		
		return $head;
	}
	

	/**
	 * markdownData function.
	 * Prepare the given data for output
	 * @access private
	 * @return string
	 */
	private function markdownData()
	{
		$fileContent[] = '```'."\n";
		$i = 1;
		foreach($this->data as $localData)
		{
			$fileContent[$i] = $i." | ";
			$fileContent[$i] .= implode(" | ", $localData);
			$fileContent[$i] .= "\n";
			++$i;
		}
		$fileContent[] = '```'."\n";
		$result		   = implode($fileContent);
		
		unset($fileContent,$i);
		
		return $result;
	}
	/**
	 * markdownDataHeader function.
	 * Creating the header of the document.
	 * @access private
	 * @return string
	 */
	private function markdownDataHeader()
	{
		$keys  = array_keys($this->data[0]);
		$keys  = "## Anzahl | ".implode(" | ", $keys)."\n";
		return $keys;
	}
	/**
	 * markdownStatistic function.
	 * Creating the footer of the document. The footer contains the howl statistics stuff.
	 * @access private
	 * @return string
	 */
	private function markdownStatistic()
	{
		$footer		= '## Statistik'."\n";
		
		$minKeys	= array_keys($this->statisticsData['Min']);
		$maxKeys	= array_keys($this->statisticsData['Max']);
		$aveKeys	= array_keys($this->statisticsData['Average']);
		//$relKeys	= array_keys($relative);
		
		$minKeys	= implode(" | ", $minKeys);
		$maxKeys	= implode(" | ", $maxKeys);
		$aveKeys	= implode(" | ", $aveKeys);
		//$relKeys	= implode(" | ", $relKeys);
		
		$minData	= implode(" | ", $this->statisticsData['Min']);
		$maxData	= implode(" | ", $this->statisticsData['Max']);
		$aveData	= implode(" | ", $this->statisticsData['Average']);
		//$relData	= implode(" | ", $relative);
		
		$footer	   .= '### min values'."\n".'#### '.$minKeys."\n".'```'."\n".$minData."\n".'```'."\n";
		$footer	   .= '### max values'."\n".'#### '.$maxKeys."\n".'```'."\n".$maxData."\n".'```'."\n";
		$footer	   .= '### average values'."\n".'#### '.$aveKeys."\n".'```'."\n".$aveData."\n".'```'." \n";
		//$footer	   .= '### relative Difference'."\n".'#### '.$relKeys."\n".'```'."\n".$relData."\n".'```'." \n";
		
		return $footer;	
	}
		
		
	/**
	 * Return the last modification time of data file
	 * @return integer The timestamp of last modification
	 */
	public function lastModified()
	{
		if(file_exists($this->filename) && ($stats = stat($this->filename)) != FALSE)
		{
			return intval($stats['mtime']);
		}
		else
		{
			return 0;
		}
	}
	
	public function clean()
	{
		if(file_exists($this->filename))
			return unlink($this->filename);
		
		return 1;
	}
}
?>
