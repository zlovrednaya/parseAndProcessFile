<?php

//обработка файлов согласно различным алгоритмам
interface ProcesserI{
	public function processData($content,$n,$usNames);
} 
class ProcesserMath implements ProcesserI{
	public $resultArray=[];
	public $countArray=[];
	public $substrSymbols;
	public function processData($content,$n,$usNames){
		
		if(!isset($this->resultArray[$n['id']])){
			$this->countArray[$n['id']]['count']=0;
			$this->resultArray[$n['id']]['avg_len'] =0;
		}
		$this->countArray[$n['id']]['count']++;
		$this->resultArray[$n['id']]['avg_len'] =($this->resultArray[$n['id']]['avg_len']+ strlen($content))/$this->countArray[$n['id']]['count'];
		
		$this->resultArray[$n['id']]['name']=$usNames[$n['id']];
		if($this->returnValue){
			return $this->resultArray;
		}

		
	}
	
	
}
class ProcesserRW implements ProcesserI{
	public $resultArray=[];
	public $countArray=[];
	public $substrSymbols;
	private $fileManager;

	function __construct($fm){
		$this->fileManager = $fm;
	}

	public function processData($content,$n,$usNames){
		preg_match_all('/\d{4}\/\d{2}\/\d{2}/',$content,$matches);
		if(isset($matches[0]))
		if(!isset($this->resultArray[$n['id']])){
			$this->resultArray[$n['id']]['count']=0;
		}
		foreach($matches[0] as $m){
			if($m){
				$mNew = (new Datetime($m))->format('m-d-Y');
				$content = str_replace($m,$mNew,$content);
				
				$this->resultArray[$n['id']]['count']++;
				
				
						
				

			}
			

		
		}
		$this->resultArray[$n['id']]['name']=$usNames[$n['id']];
		
		$this->fileManager->write($n['nameFile'],$content);
		
		return $this->resultArray;
	
	}
}





?>
