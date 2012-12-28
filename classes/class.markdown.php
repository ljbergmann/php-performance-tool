<?php
/**
* Autor: Leon Bergmann
* Datum: 24.12.2012 12:50
* Update: 25.12.2012 01:34 Uhr 
* License: LICENSE.md
* markdown class.
*/
class markdown
{
	/**
	 * filename
	 * 
	 * (default value: "data.md")
	 * 
	 * @var string
	 */
	const filename = "data.md";
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
	 * __construct function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @param mixed $title (default: null)
	 * @param mixed $description (default: null)
	 * @return void
	 */
	public function __construct($data,$title = null,$description = null)
	{
		$this->data			= $data;
		$this->title		= $title;
		$this->description	= $description;
	}
	

	/**
	 * write function.
	 * 
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
		
		chdir(dirname(dirname(dirname(__FILE__))));
		file_put_contents(self::filename, $fileContent);
	}
	
	
	/**
	 * markdownFileHead function.
	 * 
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
	 * 
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
	 * 
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
	 * 
	 * @access private
	 * @return string
	 */
	private function markdownStatistic()
	{
		$footer		= '## Statistik'."\n";
		
		$minKeys	= array_keys($this->min);
		$maxKeys	= array_keys($this->max);
		$aveKeys	= array_keys($this->average);
		
		$minKeys	= implode(" | ", $minKeys);
		$maxKeys	= implode(" | ", $maxKeys);
		$aveKeys	= implode(" | ", $aveKeys);
		
		$minData	= implode(" | ", $this->min);
		$maxData	= implode(" | ", $this->max);
		$aveData	= implode(" | ", $this->average);
		
		$footer	   .= '### min values'."\n".'#### '.$minKeys."\n".'```'."\n".$minData."\n".'```'."\n";
		$footer	   .= '### max values'."\n".'#### '.$maxKeys."\n".'```'."\n".$maxData."\n".'```'."\n";
		$footer	   .= '### average values'."\n".'#### '.$aveKeys."\n".'```'."\n".$aveData."\n".'```'." \n ";
		
		return $footer;	
	}

	
	/**
	 * statistics function.
	 * 
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
		$this->relativeDifference();
	
	}
	
	/**
	 * statisticsArraySort function.
	 * 
	 * @access private
	 * @return array
	 */
	private function statisticsArraySort()
	{
		$tmp = array();
		for($i = 0; $i < count($this->data); $i++)
		{
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
	 * 
	 * @access private
	 * @param mixed $tmp
	 * @return array
	 */
	private function getAverage($tmp)
	{
		$result = array();
		$local	= (double)0;
		foreach($tmp as $key=>$element)
		{
			foreach($element as $a)
			{
				$local  += $a;
			}
			$local			= ($local / $this->count);
			$result[$key]	= $local;
		}
		
		return $result;
	}
	
	private function relativeDifference()
	{
		$keys	= array_keys($this->average);
		$first	= $this->average[$keys[0]];
		$second	= $this->average[$keys[1]];
		
		$this->average['Relativer Unterschied']	= (( $second/ $first) - 1) * 100;
	}
		
	/**
	 * getMinMax function.
	 * 
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
				 $result[$key] = $local[($this->count - 1)];
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
	
}
?>
