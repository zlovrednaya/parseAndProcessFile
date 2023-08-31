<?php
include('./Files/FileManager.php');
include('./Files/FileParser.php');
include('./Files/FileProcessor.php');




$fileManager = new FileManager('./people.csv','./output_texts'); //read write
$fileParser = new CSVParser($argv[1]);  //конкретный парсер
$files = new FilesOperator($argv,$fileManager,$fileParser); 
$content = $files->getFileContent(); //тут пользователи
$names = $files->getFileNames($content,'./texts'); //тут все содержимое файлов

//обработчик алгоритмов
$result = $files->process($content,$names);
echo print_r($result);




?>