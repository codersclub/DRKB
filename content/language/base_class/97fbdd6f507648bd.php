<h1>Глобальный объект Clipboard</h1>
<div class="date">01.01.2007</div>


<p>Последний глобальный объект, который мы рассмотрим в этой статье будет объект Clipboard, необходимый для работы с буфером обмена. Для того, чтобы начать работу с этим объектом, необходимо в разделе Uses указать модуль Clipbrd. У этого объекта всего три свойства:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Свойство </p>
</td>
<td >Описание </p>
</td>
</tr>
<tr >
<td ><p>AsText: string </p>
</td>
<td ><p>Используется для обмена информацией в текстовом виде. </p>
</td>
</tr>
<tr >
<td ><p>FormatCount: integer </p>
</td>
<td ><p>Содержит общее число форматов, которые находятся в буфере обмена в данный момент. </p>
</td>
</tr>
<tr >
<td ><p>Formats [Index: Integer]: Word </p>
</td>
<td ><p>Содержит значения идентификаторов формата, Index[0..FormatCount-1]. 
</td>
</tr>
</table>
<p>Например, чтобы при загрузке программы, в Memo помещался текст из буфера обмена, в обработчике формы OnCreate, нужно написать следующее:
<p>Memo1.Text:=Clipboard.AsText; </p>
<p>Для работы с буфером обмена существует ряд методов. Для очистки буфера используется метод Clear, для того, чтобы поместить в буфер изображение (*.BMP или *.WMF) нужно воспользоваться методом Assign (Source: TPersistent). </p>

<p class="author">Автор: Михаил Христосенко // Development и Дельфи (http://delphid.dax.ru/). </p>
