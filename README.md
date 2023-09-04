# workwithfiles
https://gist.github.com/mirepnikov/3037489cae2c934d2c283be4c540bc9d

feedback

+Основная проблема - если на вход подать большой файл, то он может не поместиться в память. Тут хотелось видеть работу с файлами построчно.
^^https://ourcodeworld.com/articles/read/1155/how-to-efficiently-read-and-parse-a-huge-csv-file-line-by-line-in-php
Также есть проблемы с некоторыми конструкциями - if (...) if (...) {}, использование передачи значений по ссылкам, неочевидные места без комментариев - это все усложняет чтение кода.

Другие замечания и улучшения:
- файлы классов можно было структурировать удобнее с использованием namespace
-  +объявлять несколько интерфейсов и классов в одном файле – плохая практика; +
- хотелось бы видеть использование PSR-1 / PSR-12 в стиле написания кода;
- +хотелось видеть использование типов аргументов функции и их возвращаемых значений, использования strict_types=1;
- str_getcsv используется для разбиения CSV строки по заданным параметрам, и получается в FileParser.php использование str_getcsv и explode нужно было поменять местами;  -- не резонно
- +include в подключении классов лучше заменить на require - второй вызовет фатальную ошибку, если файла нет, в то время как include просто вернет warning; +
- +echo print_r($result) - print_r без второго аргумента true уже сам по себе выводит данные; +
- +в операторе switch можно группировать операторы case / default, так не будет дублирования кода; +
- +break после return не нужен. +
