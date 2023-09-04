<?php

//обработка файлов
interface FileParserI{
	public function parse($file);
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
			case 'semicolon':
			default:
				$divElt=';';
				break;
	
		}
		return $divElt;
	}
	
	//получить на выходе массив пользователей
	public function parse($file){
		$users = str_getcsv($file,"\n"); 
		if(is_array($users)){
			foreach($users as &$us){
				$us = explode($this->divider,$us);
			}
		}
		return $users;
	}
}




?>
