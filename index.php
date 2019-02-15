<!DOCTYPE html>
<html>
	<head>
		<meta charset = "UTF-8">
		<title>Analiz</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
		<script>
			function mess() {
				alert('Придется немного подождать :)')
			}
		</script>
	</head>
	<body>
	<br><br>
		<center><br><br><br>
		<form enctype="multipart/form-data" action="obrconf.php" method="POST">
			<p>URL: <input type="text" name="urls"></p>
			<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
			Выберите файл конфигурации: <input name="userfile" type="file" />
			<br><br><input type="submit" value="Отправить" onclick="mess()"/>
		</form><br>	
		<p><a href="http://diplom4kurs.azurewebsites.net/config/config.zip" download>Скачать</a> заполненый файл конфигурации</p> 
		<p><a href="stat.php">Статья</a> по заполнению файла конфигурации</p>
		</center>
	</body>
</html>