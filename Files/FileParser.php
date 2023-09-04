<?php

namespace FileParser;

//обработка файлов
interface FileParserI{
	public function parse(string $file);
}
class CSVParser implements FileParserI{
	protected $divider;
	function __construct($div){
		$this->divider = $this->getParseDivider($div);
	}
	//получить разделитель для файла
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

	//на входе данные файла
	//на выходе массив пользователей 
	public function parse(string $file):array{
		$users = str_getcsv($file,"\n"); 
		
		if(is_array($users)){
			foreach($users as &$us){
				$us = explode($this->divider,$us);
			}
		}
		return $users;
	}


	//разделяет строки файла, представленные в массиве
	public function parseArray(array $file):array{
		
	
			foreach($file as &$us){
				$us = explode($this->divider,$us);
				
			}
			
		return $file;
	}
}




?>
