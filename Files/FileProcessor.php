<?php

//обработка файлов
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




class FilesOperator {
	public $params;
	public $mode;
	public $pathFolder;
	private $fileManager;
	private $fileParser;
	private $processerComponent;
	function __construct($params,FileManagerI $fm,FileParserI $fpar){
	
		$this->fileManager = $fm;
		$this->fileParser = $fpar;
		$this->mode = $params[2];
		$this->processerComponent = $this->getProcessComponent();
		
	}
	
	public function getFileContent(){
		$fl = $this->fileManager->read();
		$content = $this->fileParser->parse($fl);
		return $content;	
	}
	
	public function getFileNames($conent,$path){
		$this->pathFolder = $path;
		$userIds=array_column($conent,'0');
		$path = $path . '/*';
		$allFileNames = $this->fileManager->getPathContent($path);
		return $allFileNames;
		
	}
	
	public function getProcessComponent(){
		switch($this->mode){
			case 'countAverageLineCount':
				return new ProcesserMath();
			case 'replaceDates':
				return new ProcesserRW($this->fileManager);
		}
	}
	
	public function processContent(&$content){
		$newContent=[];
		foreach($content as $ct){
			$newContent[$ct[0]] = $ct[1];
		}
		$content = $newContent;
		
	}
	public function processFileName($name,$content){
		$fileName= substr($name,(strlen($this->pathFolder))+1);
		$id = substr($fileName,0,strpos($fileName,'-'));
		return [
			'nameFile'=>$fileName,
			'id'=>$id,
			'nameUser'=>$content[$id]
			
		];
	}
	
	public function process($content,$fileNames){
		
		$this->processContent($content);
		$this->processerComponent->substrSymbols=strlen($this->pathFolder);
		
		foreach($fileNames as $n){
			
			$nameArr = $this->processFileName($n,$content);
			$flContent = $this->fileManager->read($n);
			$res = $this->processerComponent->processData($flContent,$nameArr,$content);
		}
		return $res;
		
	}
	
}




?>
