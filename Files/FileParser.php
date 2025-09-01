<?php

namespace FileParser;

// file processing
interface FileParserI{
	public function parse(string $file);
}
class CSVParser implements FileParserI{
	protected $divider;
	function __construct($div){
		$this->divider = $this->getParseDivider($div);
	}
	// receive csv divider
	public static function getParseDivider($divider){
		$divElt='';
		switch ($divider) {
			case 'comma':
				$divElt=',';
				break;
			default:
			case 'semicolon':
				$divElt=';';
				break;
	
		}
		return $divElt;
	}

	// input: filedata
	// output: array
	public function parse(string $file):array{
		$users = str_getcsv($file,"\n"); 
		
		if(is_array($users)){
			foreach($users as &$us){
				$us = explode($this->divider,$us);
			}
		}
		return $users;
	}


	// divide rows of array
	public function parseArray(array $file):array{
		
	
			foreach($file as &$us){
				$us = explode($this->divider,$us);
				
			}
			
		return $file;
	}
}




?>
