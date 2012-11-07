<h1>Как выравнивать текст в документе (по ширине, по центру и т.д.)?</h1>
<div class="date">01.01.2007</div>

<p>Как выравнивать текст в документе (по ширине, по центру и т.д.)?</p>
Если выделить объект (часть объекта), то к нему можно применять операции выравнивания текста, используя методы и свойства объекта Selection. Используйте поле Alignment объекта Selection.ParagraphFormat. Например:</p>

<pre class="delphi">
W.Selection.ParagraphFormat.Alignment:=wdAlignParagraphCenter;
W.Selection.ParagraphFormat.Alignment:=wdAlignParagraphRight;
W.Selection.ParagraphFormat.Alignment:=wdAlignParagraphJustify;
</pre>
где:
<br>
WdAlignParagraphCenter=1;</p>
WdAlignParagraphRight=2;</p>
WdAlignParagraphJustify=3;</p>

