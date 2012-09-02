<h1>Свойства шрифта Style и Color в виде строки</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Dennis Passmore </p>

<p>Как мне получить значение Font.Style и Font.Color в виде строки, я хотел бы присвоить его заголовку компонента Label, но style и color не являются строковыми величинами. </p>

<p>Есть масса способов это сделать, но я использую следующий способ:</p>

<pre>
const
  fsTextName: array[TFontStyle] of string[11] = ('fsBold', 'fsItalic', 'fsUnderline', 'fsStrikeOut');
  fpTextName: array[TFontPitch] of string[10] = ('fpDefault','fpVariable','fpFixed');
</pre>


<p>Позже, в коде, я так использую эти имена:</p>

<pre>
var
  TFPitch: TFontPitch;
  TFStyle: TFontStyle;
  FString: String;
...
 
FString := '';
for TFStyle := fsBold to fsStrikeOut do
  if TFStyle in Canvas.Font.Style then
    Fstring := Fstring+fsTextName[TFStyle]+',';
if FString&lt;&gt;'' then
  dec(FString[0]); { убираем лишний разделитель ',' }
something := FString;
 
FString := fpTextName[Canvas.Font.Pitch];
something := FString;
</pre>

<p>Примерно также нужно поступить и с именованными цветами типа TColor.</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<p class="note">Примечание Vit</p>
<p>Описанный здесь способ относится скорее к тем которые указывают как не надо делать. Эта задача решается намного изящнее здесь:</p>

<a href="1015.htm">Как получить строковое значение перечисляемого типа?</a> </p>
