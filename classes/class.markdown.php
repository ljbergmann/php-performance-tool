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
	 * average
	 * 
	 * @var mixed
	 * @access private
	 */
	private $average;
	/**
	 * max
	 * 
	 * @var mixed
	 * @access private
	 */
	private $max;
	/**
	 * min
	 * 
	 * @var mixed
	 * @access private
	 */
	private $min;
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
	 * groups
	 * 
	 * (default value: false)
	 * 
	 * @var bool
	 * @access private
	 */
	private $groups = false;
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @param mixed $title (default: null)
	 * @param mixed $description (default: null)
	 * @return void
	 */
	public function __construct($data = null, $title = null, $description = null)
	{
		$this->filename = dirname(__FILE__) ." /data.md";
		$this->data		= $data;
		$this->title	= $title;
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
	
	public function setStatisticsMethod(bool $method)
	{
		$this->statisticsMethod = $method;
	}
	
	/**
	 * write function.
	 * writing the data into the file
	 * @access public
	 * @return void
	 */
	public function write()
	{
		$this->statistics();
		$fileContent[] 	= $this->markdownFileHead();
		$fileContent[]	= $this->markdownDataHeader();
		$fileContent[]	= $this->markdownData();
		$fileContent[]	= $this->markdownStatistic();
		
		$fileContent	= implode("\n", $fileContent);
		
		file_put_contents($this->filename, $fileContent);
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
			$head  .= '# $this->title';
			$head  .= '---------'."\n";
		}
		else
		{
			$head	= '---------'."\n";
			$head  .= '# Data'."\n";
			$head  .= '---------'."\n";
		}
		if(!is_null($this->description))
		{
			$head = $this->description."\n";
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
		
		$minKeys	= array_keys($this->min);
		$maxKeys	= array_keys($this->max);
		$aveKeys	= array_keys($this->average);
		$relKeys	= array_keys($this->relative);
		
		$minKeys	= implode(" | ", $minKeys);
		$maxKeys	= implode(" | ", $maxKeys);
		$aveKeys	= implode(" | ", $aveKeys);
		$relKeys	= implode(" | ", $relKeys);
		
		$minData	= implode(" | ", $this->min);
		$maxData	= implode(" | ", $this->max);
		$aveData	= implode(" | ", $this->average);
		$relData	= implode(" | ", $this->relative);
		
		$footer	   .= '### min values'."\n".'#### '.$minKeys."\n".'```'."\n".$minData."\n".'```'."\n";
		$footer	   .= '### max values'."\n".'#### '.$maxKeys."\n".'```'."\n".$maxData."\n".'```'."\n";
		$footer	   .= '### average values'."\n".'#### '.$aveKeys."\n".'```'."\n".$aveData."\n".'```'." \n ";
		$footer	   .= '### relative Difference'."\n".'#### '.$relKeys."\n".'```'."\n".$relData."\n".'```'." \n ";
		
		return $footer;	
	}

	
	/**
	 * statistics function.
	 * do the statistics stuff
	 * @access private
	 * @return void
	 */
	private function statistics()
	{
		$sortedArray	= $this->statisticsArraySort();
		
		$this->count	= count($this->data);
		$this->max		= $this->getMinMax($sortedArray,true);
		$this->min		= $this->getMinMax($sortedArray);
		$this->average	= $this->getAverage($sortedArray);
		
		if($this->groups)
			$this->relative	= $this->relativeDifferenceGroup();
		else
			$this->relative = $this->relativeDifference();
	}
	
	/**
	 * statisticsArraySort function.
	 * Return an array with the sorted data inside.
	 * @access private
	 * @return array
	 */
	private function statisticsArraySort()
	{
		$tmp = array();
		for($i = 0; $i < count($this->data); $i++)
		{
			if(!isset($this->data[$i]))
				throw new Exception("Internal statistics error: Index $i does not exists in data array");
			
			foreach($this->data[$i] as $key=>$element)
			{
				$tmp[$key][] = $element;
			}
		}
		
		foreach($tmp as $key=>$sub)
		{
			$tmps = $sub;
			sort($tmps);
			unset($tmp[$key]);
			$tmp[$key] = $tmps;
			unset($tmps);
			
		}
		
		return $tmp;
	}

	
	/**
	 * getAverage function.
	 * Returns the average of the data;
	 * @access private
	 * @param mixed $tmp
	 * @return array
	 */
	private function getAverage($tmp)
	{
		$result = array();
		$local	= (int)0;
		foreach($tmp as $key=>$element)
		{
			foreach($element as $a)
			{
				if(!is_numeric($a))
				{
					throw new Exception("Value ".(is_array($a) ? "'Array'" : $a)." is not a number!");
				}
				$local  += $a;
			}
			$local = ($local / $this->count);
			$result[$key] = $local;
		}
		
		return $result;
	}
	
		
	/**
	 * getMinMax function.
	 * Returns the min- or maximum value.
	 * @access private
	 * @param bool $max (default: false)
	 * @return array
	 */
	private function getMinMax($tmp,$max = false)
	{
		$result = array();
		if($max)
		{
			foreach($tmp as $key=>$local)
			{
				if(isset($local[($this->count - 1)]))
					$result[$key] = $local[($this->count - 1)];
				else
					throw new Exception(" Index " . $this->count - 1 ." Does not exist in local data array");
			}
		}
		else
		{
			foreach($tmp as $key=>$local)
			{
				 $result[$key] = $local[0];
			}

		}
		unset($tmp);
		return $result;
	}
	
	/**
	 * relativeDifferenceOnEvenData function.
	 * Divides the given datan into arrays with 2 values and calulate the relative difference between both.
	 * @access private
	 * @return array
	 */
	private function relativeDifferenceGroup()
	{
		if(count($this->average) % 2 != 0)
		{
			return array('Error'=>"The given data not contains enough data to build groups with equal pieces.");
		}
		$group		= array_chunk($this->average,2,true);
		$result		= array();
		foreach($group as $element)
		{
			$keys	= array_keys($element);
			$first	= $element[$keys[0]];
			$second	= $element[$keys[1]];
			$result[$keys[0]." / ".$keys[1]] = ((($first-$second)/$first)*100);
			unset($keys);
		}
		unset($group);
		return  $result;
		
	}
	
	/**
	 * relativeDifference function.
	 * Return an array with the relative Difference between the given data rows.
	 * @access private
	 * @return void
	 */
	private function relativeDifference()
	{
		
		$counter = count($this->average) - 1;
		if($count == 0)
		{
			return array("Error"=>"Not enough data to compare them.")
		}
		$tmp 	 = $this->average;
		$keys	 = array_keys($tmp);
		for($i=0;$i < $counter;$i++)
		{
			if($i < $counter)
				$b = $i + 1;
			else
				break;
			$first	= $tmp[$keys[$i]];
			$second = $tmp[$keys[$b]];
			
			$result[$keys[$i]." / ".$keys[$b]] = (double) ((($first - $second)/$first) *100);
			unset($first,$second);
		}
		unset($keys,$tmp,$counter);
		return $result;
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
