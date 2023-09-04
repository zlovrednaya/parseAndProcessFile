<?php

//в этом классе производится управление работой файлов - собирает вместе операции с файлами

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
		//$fl = $this->fileManager->read();
		$fl  =$this->fileManager->readAndProcess();
	
		$content = $this->fileParser->parseArray($fl);
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
