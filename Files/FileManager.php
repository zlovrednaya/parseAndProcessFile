<?php

//операции с файлами
//-чтение из файлов
//-записать в файл
interface FileManagerI{
	public function read();
	public function write($path,$content);
}

class FileManager implements FileManagerI{
	protected $pathIn;
	protected $pathOut;
	function __construct($pathIn=false,$pathOut=false){
		$this->pathIn = $pathIn;
		$this->pathOut = $pathOut;
		
	}
	public function read($path=false){
		if(!$path){
			$path = $this->pathIn;
		}
		$fl = file_get_contents($path, true);
		return $fl;
	}
	//чтение больших файлов
	public function readAndProcess($path=false){

		$handle = fopen($path,'r');
		$lineNum=1;
		while(($raw_string==fgets($handle))!==false){
			$row = str_getcsv($raw_string);
			$lineNum++;
		}

		fclose($handle);
	}
	
	public function write($fileName=false,$content){
		
		if($fileName){
			$path= $this->pathOut.'/'.$fileName;
		} else{
			$path = $this->pathOut;
		}
		file_put_contents($path,$content);
		
	}
	public function getPathContent($path){
		$allFileNames = glob($path);
		return $allFileNames;
	}
}

