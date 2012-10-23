<h1>Формат файла ASCII-схемы</h1>
<div class="date">01.01.2007</div>


<p>В файле asciidrv.txt насчет последнего числа в строке схемы поля говорится:</p>

<p>"* Offset - Number of characters from the beginning of the line that the field begins. Used for FIXED format only." (Offset - количество символов он начала линии до начала поля. Используется только для фиксированного формата.).</p>

<p>С тех пор, как мой файл имеет переменный (Variable) формат, я задал в каждой строке смещение, равное нулю. После некоторых попыток, чтобы заставить это работать, я следал следующие изменения:</p>

<p>[discs]</p>
<p>filetype = varying</p>
<p>charset = ascii</p>
<p>delimiter = "</p>
<p>separator = ,</p>
<p>field1 = id,char,10,0,1</p>
<p>field2 = title,char,30,0,2</p>
<p>field3 = artist,char,30,0,3</p>
<p>...</p>
<p>field36 = song30,char,50,0,36</p>

<p>После более произвольных изменений это стало таким:</p>

<p>[discs]</p>
<p>filetype = varying</p>
<p>charset = ascii</p>
<p>delimiter = "</p>
<p>separator = ,</p>
<p>field1 = id,char,10,0,10</p>
<p>field2 = title,char,30,0,20</p>
<p>field3 = artist,char,30,0,30</p>
<p>...</p>
<p>field36 = song30,char,50,0,360</p>

<p>и внезапно все заработало! Для поля, которое игнорируется форматом файла, "Offset" несомненно дало огромный эффект.</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

