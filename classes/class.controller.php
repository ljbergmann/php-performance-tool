<?php
/*
* Autor: Leon Bergmann
* Datum: 04.01.2013 01:21
* Update:
* License: LICENSE.md
*/

class controller
{
	// Data
	private $data;
	// Internal Objects
	private $markdown;
	private $statistics;
	private $renderHTML;
	// Internal settings
	private $settings;
	private $runMethod;

	
	public function __construct()
	{
		if(class_exists("markdown") and class_exists("Statistics") and class_exists("renderHTML"))
		{
			$this->markdown		= new Markdown;
			$this->statistics	= new Statistics;
			$this->renderHTML	= new renderHTML;
		}
		else
		{
			throw new Exception("Not all needed classes are given");
		}
	}
	
	public function setRunMethod($methods)
	{
		$this->runMethod = $methods;
	}
	
	public function setSettings($settings)
	{
		if(!is_array($settings))
		{
			throw new Exception("Bad settings formate");
		}
		else
		{
			$this->settings = $settings;
		}
	}
	
	public function setData($data)
	{
		if(!is_array($data))
		{
			throw new Exception("The data formate is not correct");
		}
		else
		{
			$this->data = $data;
		}
	}
			
	public function run()
	{
		$this->markdown->setStatisticsData($this->statistics->calc($this->data,$this->settings['formate']));
		switch($this->runMethod)
		{
			case "markdown":
				$this->markdown->setData($this->data);
				$this->markdown->setTitle($this->settings['Title']);
				$this->markdown->setDescription($this->settings['Description']);
				$this->markdown->setDataDir(__DIR__);
				$this->markdown->write();
				break;
			case "html":
				// parse to HTML
				break;
			case "html+picture":
				// parese to HTML and Picture
				break;
			case "markdown+picture":
				// parse to Markdown and Picture
				break;
			case "picture":
				// parse the data to an Picture
				break;
		}
	
	}
	
	
	public function convertData()
	{
		$data 	= $this->data;
		$tmp	= array();
		$i		= 0;
		foreach($data as $element)
		{
			foreach($element as $key=>$subElement)
			{
				
				$tmp[$i][$key] = sprintf($this->settings['formate'],$subElement);
				
			}
			$i++;
		}
		
		unset($data);
		$this->data = $tmp;
		unset($tmp);
	}
}
?>
