<html>
	<head>
		<meta charset = "UTF-8">
		<title>Статья по заполнению файла</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
	</head>
	<body>
		<br>
		<p>Для работы с приложение необходим config файл, который можно <a href="http://diplom4kurs.azurewebsites.net/config/config.zip" download>Скачать</a> или создать свой с расширением .ini по образцу.</p>
		<p>Образец заполнения файла:</p>
						<p>;первая строка пустая</p>
		<p>url = "http://www.adygnet.ru"              		;указывается адрес сайта через http:// или https://</p>

		<p>teg = "div,p,a,script,object,h3,h5,h2,h6"		;перечисление необходимых тегов 
						через запятую.</p>

		<p>clasis = "counts"				;класс для анализа, доступные: класс "counts"
						 подсчет указанных тегов, класс "between" 
						просмотр слов между тегами. 
						Например "&ltb&gtтекст&lt/b&gt" найдет слово "текст".</p>

		<p>no_closing_teg = "img, link"			;перечесление тегов не имеющие закрывающего тега.</p>

		<p>class_nct = "counts_nct"			;доступный класс "counts_nct" для 
						подсчета тегов указанных в no_closing_teg .</p>

		<p>sizeimg = "yes"				;указать "yes" или "no" для  проверки объема картинок.</p>

		<p>errorhtml = "yes"				;указать "yes" или "no" для проверки HTML-разметки.</p>

		<p>source = "no"				;указать "yes" или "no" для вывода source файла 
						(кода HTML-разметки) с подсветкой ошибок 
						перечисленные в результате класса errorhtml.</p>

		<p>errorcss = "yes"				;указать "yes" или "no" для проверки 
						правильности отображения CSS стилей.</p>
		<p><a href="http://diplom4kurs.azurewebsites.net/">Анализ сайта</a><p>
	</body>
</html>