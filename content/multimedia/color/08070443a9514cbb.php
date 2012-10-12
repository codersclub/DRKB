<h1>Что такое Цвет?</h1>
<div class="date">01.01.2007</div>


<p>Если Edit1.text это String то что такое Edit1.font.color?</p>
<p>TColor - это Integer, чтоб задать нужный цвет можно пользовать константы, а можно в числовом виде:</p>
<p>Edit1.font.color:=$223344</p>
<p>где 22 - яркость красного цвета, может быть в пределах от 00 до FF</p>
<p>где 33 - яркость зеленого цвета, может быть в пределах от 00 до FF</p>
<p>где 44 - яркость синего цвета, может быть в пределах от 00 до FF</p>
<p>Например:</p>
<p>Edit1.font.color:=$000000 - черный</p>
<p>Edit1.font.color:=$FFFFFF - белый</p>
<p>Edit1.font.color:=$00FF00 - зеленый</p>
<p>Всего определено 256*256*256 цветов</p>
<p>В примерах я использовал шестнадцатиричные значения так как так проще, но можно и десятичные, если разберетесь какой это цвет </p>
<p>Edit1.font.color:=123456 </p>
<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Можно использовать константы типа clred, clblack, cllime, clgreen...</p>
<p>Для работы с цветом можно использовать следующие функции</p>
<p>RGB(r,g,b:byte):tcolor //получаешь цвет по 3 составляющим</p>
<p>GetRValue(color:tcolor)</p>
<p>GetGValue(color:tcolor)//получаешь значение интенсивности цвета.</p>
<p>GetBValue(color:tcolor) </p>
<p class="author">Автор: Mikel</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr /><p>Для хранения цвета существует свой собственный тип, который называется TColor. Этот тип содержит информацию, как о самом цвете, так и том, каким образом его заменить, если, например, цветовая палитра системы не поддерживает этот цвет (скажем, установлено всего 256 цветов, а цвет, заданный в переменной, вылезает далеко за пределы этих 256 цветов). </p>
<p>Тип TColor состоит из четырех байт. Первый байт - указатель на замену цвета (о нем поговорим позже). Второй байт - яркость красного цвета от 0 до 255 (от 00 до FF). Третий байт - яркость зеленого цвета от 0 до 255 (от 00 до FF). И, наконец, четвертый байт - яркость синего цвета, также, от 0 до 255 (от 00 до FF). </p>
<p>А как Вы уже знаете, из этих трех цветов: красного, зеленого и синего, регулируя их яркость, можно составить практически любой цвет. </p>
<p>Поговорим теперь о первом байте - указателе на замену цвета. Итак, этот байт может принимать три различных значения - ноль ($00), единицу ($01) или двойку ($02). Что это значит: </p>
<p>Ноль ($00) - цвет, который не может быть воспроизведен точно, заменяется ближайшим цветом из системной палитры. </p>
<p>Единица ($01) - цвет, который не может быть воспроизведен точно, заменяется ближайшим цветом из палитры, которая установлена сейчас. </p>
<p>Двойка ($02) - цвет, который не может быть воспроизведен точно, заменяется ближайшим цветом из палитры, которую поддерживает текущее устройство вывода (в нашем случае - монитор). </p>
<p>Видимо, всегда лучше устанавливать значение первого байта равным нулю ($00), по крайней мере, так происходит при получении типа TColor при помощи функции RGB. </p>
<p>И, напоследок, несколько примеров: </p>
<p>$00FFFFFF - белый цвет;</p>
<p>$00000000 - черный цвет;</p>
<p>$00800000 - темно-красный цвет. </p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
