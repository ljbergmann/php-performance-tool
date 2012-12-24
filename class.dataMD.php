<?php
/**
* Autor: Leon Bergmann
* Datum: 24.12.2012 12:50
* Update:
* 
* dataMD class.
*/
class dataMD
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
	 * __construct function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @return void
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}
	
	/**
	 * prepareFileContent function.
	 * 
	 * @access public
	 * @return array
	 */
	public function write()
	{
		$this->statistics();
		$fileContent[] = $this->markdownHeader();		
		
		$i = 1;
		foreach($this->data as $key=>$localData)
		{
			$fileContent[$i] = $key." | ";
			foreach($localData as $element)
			{
				$fileContent[$i] .= $element." | ";
			}
			$fileContent[$i] .= "\n";
			++$i;
		}
		
		
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
	
	}
	
	private function getAverage($tmp)
	{
		$result = array();
		$local	= (int)0;
		foreach($tmp as $key=>$element)
		{
			foreach($element as $a)
			{
				$local  += $a;
			}
			$local = ($local / $this->count);
			$result[$key][] = $local;
		}
		
		return $result;
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
	
	/**
	 * fileheader function.
	 * 
	 * @access private
	 * @return string
	 */
	private function markdownHeader()
	{
		$keys  = array_keys($this->data[0]);
		$keys  = "Anzahl | ".implode(" | ", $keys);
		$keys .= '\n----------';
		return $keys;
	}
}
?>
