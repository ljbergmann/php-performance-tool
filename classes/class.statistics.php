<?php
/*
* Autor: Leon Bergmann
* Datum: 05.01.2013 01:55
* Update:
* License: LICENSE.md
*/

class Statistics
{
	private $count;
	
	
	public function calc($data,$formate)
	{
		$result				= array();
			
		$this->count 		= count($data);
		$sortedArray		= $this->statisticsArraySort($data);
		$result['Min']		= $this->getMinMax($sortedArray);
		$result['Max']		= $this->getMinMax($sortedArray,true);
		$result['Average']	= $this->getAverage($sortedArray,$formate);
		
		return $result;
		
	}
	
	public function statisticsArraySort($data)
	{
		$tmp = array();
		for($i = 0; $i < $this->count; $i++)
		{
			if(!isset($data[$i]))
				throw new Exception("Internal statistics error: Index $i does not exists in data array");
			
			foreach($data[$i] as $key=>$element)
			{
				$tmp[$key][] = $element;
			}
		}
		
		unset($data);
		
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
	private function getAverage($data,$formate)
	{
		$result = array();
		foreach($data as $Head=>$values)
		{
			$result[$Head] = sprintf($formate,(array_sum($values) / $this->count));
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
	private function getMinMax($data,$max = false)
	{
		$result = array();
		if($max)
		{
			foreach($data as $key=>$local)
			{
				if(isset($local[($this->count - 1)]))
					$result[$key] = $local[($this->count - 1)];
				else
					throw new Exception(" Index " . $this->count - 1 ." Does not exist in local data array");
			}
		}
		else
		{
			foreach($data as $key=>$local)
			{
				 $result[$key] = $local[0];
			}

		}
		unset($tmp,$data,$count);
		return $result;
	}
	
	/**
	 * relativeDifferenceOnEvenData function.
	 * Divides the given data into arrays with 2 values and calulate the relative difference between both.
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
			$result[$keys[0]." / ".$keys[1]] =(double) ((($first-$second)/$first)*100);
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
		if($counter == 0)
		{
			return array("Error"=>"Not enough data to compare them.");
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

}
?>
