<?php
require('./Files/FileManager.php');
require('./Files/FileParser.php');
require('./Files/FileProcessor.php');
require('./Files/FilesOperator.php');




$fileManager = new FileManager\FileManager('./people.csv','./output_texts'); //read write
$fileParser = new FileParser\CSVParser($argv[1]);  //конкретный парсер
$files = new FilesOperator\FilesOperator($argv,$fileManager,$fileParser); 
$content = $files->getFileContent(); //тут пользователи
$names = $files->getFileNames($content,'./texts'); //тут все содержимое файлов

//обработчик алгоритмов
$result = $files->process($content,$names);
echo print_r($result,true);




?>
