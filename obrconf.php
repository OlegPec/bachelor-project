<?php

class counts
{
var $s;
function counts($mass,$text){
	$s='';
	for ($i=0,$n=1; $i<count($mass); $i++,$n++)
	{
		$arr[$i]="</".$mass[$i].">";
		$a[$mass[$i]] = substr_count($text, $arr[$i]);
		$s.="<tr><td>".$n."<td>".$mass[$i]."</td><td>".$a[$mass[$i]]."</td>";
	}
	$g="<table id='ctable' align='center' width='70%' cellspacing='10' >
	<tr> <td>N</td> <td>Название тега</td> <td>Количество</td> </tr>".$s."</table><br><br><br>";
	echo $g;
}
}

/////////////////////////////////////////////////////////
class between 
{
var $s2;
function between($mass,$text){
	$s2='';
	for ($i=0; $i<count($mass); $i++)
	{
		$arrs[$i]="</".$mass[$i].">";
		$zg[$mass[$i]] = substr_count($text, $arrs[$i]);
		if ($zg[$mass[$i]]>=0)
		{
			$tegzg = "|<$mass[$i][^>]*>(.*?)</$mass[$i]>|si";
			preg_match_all($tegzg, $text, $reszg,PREG_SET_ORDER);
					
			$b = '';
			for ($j=0; $j<$zg[$mass[$i]]; $j++)
			{
					
				$b .= $reszg[$j][1]."<br>";
						
			}
						$s2.= "<table id='toptable' align='center' width='70%' >
						<tr><td>Тег:".$mass[$i]."</td></tr><tr><td>".$b."<br></td></tr></table><br><br>";
		}
	}
	$f=$s2;
	echo $f;
}}
//////////////////////////////////////////////////////////////
class counts_nct
{
var $nc;
function counts_nct($mass_nct,$text){
	$s='';
	for ($i=0,$n=1; $i<count($mass_nct); $i++,$n++)
	{
		$arr[$i]="<".$mass_nct[$i];
		$a[$mass_nct[$i]] = substr_count($text, $arr[$i]);
		$nc.="<tr><td>".$n."<td>".$mass_nct[$i]."</td><td>".$a[$mass_nct[$i]]."</td>";
	}
	$tabnct="<table id='ncttable' align='center' width='70%' cellspacing='10' >
	<tr> <td>N</td> <td>Название тега</td> <td>Количество</td> </tr>".$nc."</table><br><br><br>";
	echo $tabnct;
}
}
//////////////////////////////////////////////////////////////
class sizeimg
{
 var $str;
 var $conimg;
 function sizeimg($ur,$text2){
	$patern='/<img[^>]+>/i';
	preg_match_all($patern, $text2, $result,PREG_SET_ORDER);
	function fsize($path) {
		$fp = fopen($path,"r");
		$inf = stream_get_meta_data($fp);
		fclose($fp);
		foreach($inf["wrapper_data"] as $v)
		if (stristr($v,"content-length"))
		{
			$v = explode(":",$v);
			return trim($v[1]);
		}
	}
	$conimg = substr_count($text2,"<img");
	$simg = "";
	echo "<table id='imgtab' align='center' width='70%' cellspacing='10'>";
	echo "<tr> <td>N</td> <td>Название картинки</td> <td>Объем изображения</td><td>Размер</td></tr>";
	for ($j=0,$k=1; $j<$conimg; $k++,$j++)
	{ 
		if(preg_match('/(src)="([^"]*)"/i',$result[$j][0],$vivod)){
		$simg .= "<tr><td>$k</td><td>".$vivod[2]."</td>";
		if (preg_match("/http:/i", $vivod[2]) || preg_match("/https:/i", $vivod[2]))
		{
			$filesize = $vivod[2];
		}
		else{
			$filesize = $ur.'/'.$vivod[2];			// путь к картинке	'http://site.com/imagename.jpg'
		} 
		$sizes = fsize($filesize);
		$kbsize = $sizes / 1024;
		if ($kbsize > 500)
		{
			$col='#ff0000';	
			$simg .= "<td bgcolor='$col'>".round($kbsize,2)."Кб</td>";
		}
		if ($kbsize > 200 && $kbsize < 500)
		{
			$col='#CE810F';
			$simg .= "<td bgcolor='$col'>".round($kbsize,2)."Кб</td>";
		}
		if ($kbsize < 200)
		{
			$col='#00ff00';	
			//echo round($kbsize)."кб";
			$simg .= "<td bgcolor='$col'>".round($kbsize,2)."Кб</td>";
		}
		list($width, $height)=getimagesize($filesize);
		$simg .= "<td>".$width."x".$height."</td></tr>";
		$summkb += $kbsize; 
		}
	}
	echo "$simg</table>";
	echo "<center>Общий объем изображений:".round($summkb,2)."Кб</center><br><br>";
 }
}
//////////////////////////////////////////////////////////////
include('top.php');

$uploadfile = basename($_FILES['userfile']['name']);
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
	
	$confname = $_FILES['userfile']['name'];						//получаем файл конф
	$config = parse_ini_file($confname);							//подключаемся к файлу конфигурации
	if ($_POST['urls'] !== '')
	{
		$ur=trim($_POST['urls']);									//получаем url из POST
	}
	else{
		$ur=trim($config['url']);									//получаем из файла строку с url	
	};
	$clasis = $config['clasis'];									//получаем класс из строки clasis 
	$name=explode(",", $config['teg']);								//получаем массив тегов типа <b></b>
	$sizeimg = $config['sizeimg'];									//получаем ответ из строки sizeimg
	$clasis_nct = $config['class_nct'];								//получение класса nct
	$nct_nspace = str_replace(' ','',$config['no_closing_teg']);	//получение тегов nct
	$source = $config['source'];									//получение ответа на source
	unlink($confname);												//удаляем файл с сервера

echo "<center>Результат анализа для: $ur</center>";	
	

///////////////////////////////////////


if ($text = file_get_contents($ur)){				//подключаемся к url

/////////////////проверка размера загружаемой страницы////////////////
	$filename = $ur;
	$fh = fopen($filename, "r");
	while(($str = fread($fh, 1024)) != null) $fsize += strlen($str);
	$rfsize = $fsize / 1024;
	echo "<center>Размер загружаемой страницы: ".round($rfsize,2)."Кб</center>";
////////////////////////////конец проверки/////////////////////////////


///////////////////////////////проверка типа верстки сайта///////////////////////////////
	$divs ="|<div[^>]*>(.*)</div>|si";				
	preg_match_all($divs, $text, $resdiv,PREG_SET_ORDER);
	$countdiv = 0;
	for ($j=0; $j<1; $j++)
	{
		if (isset($resdiv[$j][1]))
		{
			$countdiv += strlen($resdiv[$j][1]);
		}
	}
	$contabl = substr_count($text, '</table>');
	$tabs = "|<table[^>]*>(.*?)</table>|si";
	preg_match_all($tabs, $text, $restabl,PREG_SET_ORDER);
	$counttabl = 0;
	for ($j=0; $j<$a["</table>"]; $j++)
	{
	if (isset($restabl[$j][1]))
		{
	$counttabl += strlen($restabl[$j][1]);
		}
	}
	if ($countdiv > $counttabl){
		echo "<center>Тип верстки: Блочная</center>";
	}
	else{
		echo "<center>Тип верстки: Табличная</center>";
	}
/////////////////////////////////////конец////////////////////////////////////////


$object =new $clasis($name,$text);		//вызов класса для тегов


//////////////////проверка разрешения на объем изображений/////////////////
if($sizeimg == 'yes'){
	$text2=str_replace(' ','',$text);
	echo '<div id="messg" align="center"><div id="fl"><div id="gr"></div>-оптимальный размер изображения</div>
	<div id="fl"><div id="bw"></div>-средней допустимости размер изображения</div>
	<div id="fl"><div id="red"></div>-следует оптимизировать</div></div>';
$object2 =new sizeimg($ur,$text2);};
//////////////////////////////////конец проверки////////////////////////////////////


////////////////////nct//////////////////

$name_nct=explode(",", $nct_nspace);				//сбор тегов nct в массив
$object3 =new $clasis_nct($name_nct,$text);			//вызов класса для nct

//////////////////////////////////////////////////
function rus_translit($string) {
    $converter = array(
		'Consider using' => 'Рассмотрите возможность использования',
		'does not need a' => 'не требует', 'elements to add identifying headings to all sections' => 'элементов для добавления, идентифицирующих заголовков всех разделов',
		'For guidance, see the Media Types section in the current Media Queries specification' => 
		'Для получения инструкций, смотрите раздел Media Types в спецификации Media Queries',
		'element with a' => 'элемента с', 'Deprecated media type projection' => 'Устаревший media тип',
		'A document must not include more than one' => 'Документ не должен содержать более одного',
		'attribute whose value is' => 'атрибутом, значение которого',
		'Empty heading' => 'Пустой заголовок',
		'except under certain conditions' => 'за исключением некоторых случаев',
		'Proceeding using' => 'Исходите использованием',
		'character encoding was not declared' => 'кодировка символов не была объявлена',
		'Non-space characters found without seeing a doctype first' => 'Найдены символы без пробелов, раньше доктайпа',
		'is missing a required instance of child element' => 'отсутствует обязательный экземпляр дочернего элемента',
		'attribute instead' => 'атрибут',
		'Consider specifying' => 'рассмотрите указание',
		'attribute is obsolete' => 'атрибут является устаревшим',
		'Use CSS instead' => 'Используйте взамен CSS', 'You can safely omit it' => 'Вы можете спокойно убрать его',
		'attribute on the' => 'аттрибут на', 'element is obsolete' => 'элементе, является устаревшим',
		'on element' => 'на элементе', 'Section lacks heading' => 'В разделе отсутствует заголовок',
		'for attribute' => 'для атрибута', 'Bad value' => 'Плохое значение',
		'in this context' => 'в данном контексте',
		'not allowed as child of element' => 'не допускается в качестве дочернего элемента',
        'Error' => 'Ошибка', 'Warning' => 'Предупреждение',
		'Empty' => 'Пустой', 'Element' => 'Элемент',
		'empty' => 'пустой', 'element' => 'элемент',
		'Suppressing further errors from this subtree' => 'Подавляет дальнейшие ошибки из этого поддерева',
		'Almost standards mode' => 'Почти соответствует стандартам', 
		'Expected' => 'Ожидалось', 'From line' => 'Со строки', 
		'column' => 'позиция', 'to line' => 'до строки', 
		'flow content' => 'содержание потока',
		'Contexts' => 'Контексты', 'context' => 'контекст',
		'For details, consult' => 'Для получения дополнительной информации обратитесь к',
		'guidance on providing text alternatives for images' => 'руководству по предоставлению текстовых альтернатив для изображений',
		'Stray end tag' => 'Незакрытый тег', 'attribute' => 'атрибут',
		'must have an' => 'должен иметь', 'An' => '',
		'The' => '', 'in CSS instead' => 'в CSS',
		'Use the' => 'Используйте', 'Deprecated media type' => 'Устаревший media тип',
		'Consider instead beginning the cell contents with concise text, followed by further elaboration if needed.' => '',
    );
    return strtr($string, $converter);
};
//////////////////////////////////////////////////
$countli=0;
$htmlerr = '';
if($source =='yes')
{
$w3chref="http://validator.w3.org/nu/?showsource=yes&doc=".$ur;
$w3c=file_get_contents($w3chref);
$countli = substr_count($w3c, '<li class=');
	$olblock = '|<ol[^>]*>(.*?)</ol>|si';
	preg_match_all($olblock, $w3c, $resol,PREG_SET_ORDER);
		$htmlerr = $resol[0][0]."<p>Source</p>".$resol[1][0];
}
else {
	$w3chref="http://validator.w3.org/nu/?doc=".$ur;
	$w3c=file_get_contents($w3chref);
	$countli = substr_count($w3c, '<li class=');
	$olblock = '|<ol[^>]*>(.*)</ol>|si';
	preg_match($olblock, $w3c, $resol);
	$htmlerr = $resol[0]."<br>";
};
	if($countli==0){echo '<div id="errors"><h4> Поздравляем! Ошибок в HTML не обнаружено!</h4></div><br>';}
	else {
	echo '<div id="errors"><h4> Ошибки в HTML ('.$countli.')     
			<button onclick="document.getElementById(\'scrollshtml\').style.display=\'block\'; return false;">Развернуть</button>
			<button onclick="document.getElementById(\'scrollshtml\').style.display=\'none\'; return false;">Свернуть</button>
			</h4>
	<div id="scrollshtml" style="display: none">';
	$code = '|<dl[^>]*>(.*?)</dl>|si';
	$dlrepl = preg_replace($code, '', $htmlerr);
	$htmlerr2 = rus_translit($dlrepl);
	echo $htmlerr2;
	echo '</div></div><br>';};



$w3csshref="http://jigsaw.w3.org/css-validator/validator?uri=".$ur;

$w3css=file_get_contents($w3csshref);

	$counterrcss = substr_count($w3css, '<div class="error-section">');

	$divbl = '|<div class="error-section"[^>]*>(.*?)</div>|si';
	preg_match_all($divbl, $w3css, $rescss, PREG_SET_ORDER);
	$err = '|<h3[^>]*>(.*?)</h3>|si';
	preg_match($err, $w3css, $reserr);
	$csserrmes = array();
			$csserrmes[0] = '/Sorry! We found the following errors/';
			$csserrmes[1] = '/Congratulations! No Error Found./';
			$replcssmes = array();
			$replcssmes[0] = 'К сожалению! Мы нашли следующие ошибки';
			$replcssmes[1] = 'Поздравляем! Не найдено ни одной ошибки';
	$pregreserr = preg_replace($csserrmes, $replcssmes, $reserr[1]);
	if($counterrcss==0){echo '<div id="errors"><h4>'.$pregreserr.'</h4></div>';}
	else{
	echo '<div id="errors">
            <h4>'.$pregreserr.' в CSS      
			<button onclick="document.getElementById(\'scrollscss\').style.display=\'block\'; return false;">Развернуть</button>
			<button onclick="document.getElementById(\'scrollscss\').style.display=\'none\'; return false;">Свернуть</button>
			</h4>
			<div id="scrollscss" style="display: none">
			<div class="error-section-all">';
			///////////////////////////////////////////////
	function rus_translitcss($string) {
    $converter = array(
		'Parse Error' => 'Ошибка разбора', "doesn't exist" => 'не существует',
		'File not found' => 'Файл не найден', 'only' => 'только',
		'Value Error' => 'Ошибка значения', 'can be a' => 'может быть',
		'Sorry, the at-rule' => 'Извините, но правило',
		'is not implemented' => 'не реалзовано', 'You must put a unit after your number' => 'Вы должны указать после числа единицы измерения',
		'Too many values or values are not recognized' => 'Слишком много значений или нераспознанное значение',
		'is not a cursor value' => 'не является значением cursor',
		'Feature' => 'Свойство', 'Property' => 'Свойство',
		'is not a color value' => 'не является значением color',
		'is not a border-color value' => 'не является значением border-color',
		'is not a border-top-color value' => 'не является значением border-top-color',
		'is not a background-color value' => 'не является значением background-color',
		'is not a border-right-color value' => 'не является значением border-right-color',
		'is not a border-bottom-color value' => 'не является значением border-bottom-color',
		'is not a border-left-color value' => 'не является значением border-left-color',
		'is not a font-weight value' => 'не является значением font-weight',
		'is not a font-style value' => 'не является значением font-style',
		'attempt to find a semi-colon before the property name. add it' => 'попытка найти точку с запятой до имени свойства. добавьте ее',
		'for media' => 'для среды', 'Unknown pseudo-element or pseudo-class' => 'Неизвестный псевдо-элемент или псевдо-класс',
		'Invalid ID selector' => 'Неправильный ID селектора',
		'is not a transition value' => 'не является значением transition',
		'is not a background-image value' => 'не является значением background-image',
	);
    return strtr($string, $converter);
};
	///////////////////////////////////////////////////////////
	for ($er=0; $er<$counterrcss; $er++)
	{
		$replrescss = rus_translitcss($rescss[$er][0]);
		echo $replrescss;
	}
	echo '</div></div></div>';
	}
	include('bottom.php');
}
else { echo "<center>Невозможно поключиться к URL</center>";}
}
else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}
?>