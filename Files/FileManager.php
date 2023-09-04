<?php

//операции с файлами
//-чтение из файлов
//-записать в файл
interface FileManagerI{
	public function read();
	public function write($content,$path);
}

class FileManager implements FileManagerI{
	protected $pathIn;
	protected $pathOut;
	function __construct($pathIn=false,$pathOut=false){
		$this->pathIn = $pathIn;
		$this->pathOut = $pathOut;
		
	}

	//чтение маленьких файлов
	public function read($path=false):string{
		if(!$path){
			$path = $this->pathIn;
		}
		$fl = file_get_contents($path, true);
		return $fl;
	}
	//чтение больших файлов CSV
	public function readAndProcess($path=false):array{

		if(!$path){
			$path = $this->pathIn;
		}
	
		$handle = fopen($path,'r');
		$lineNum=1;
		$row=[];
		while(($raw_string=fgets($handle))!==false){
			$row =array_merge($row,str_getcsv($raw_string));
			
			$lineNum++;
		}

		fclose($handle);
		return $row;
		
	}
	
	public function write($content,$fileName=false){
		
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

