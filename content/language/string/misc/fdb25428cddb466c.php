<h1>Инкрементация строкового поля</h1>
<div class="date">01.01.2007</div>


<p>Свойства text элемента управления является строкой, в свою очередь являющейся массивом символом. Вы не можете осуществить преобразование символа в строку. Тем не менее, вы можете получить доступ ко всем символам строки через их индекс. </p>
<p>Попробуйте это:</p>
<pre>
var
  s: string;
begin
  s := RevField.text;
  s[1] := chr(ord(s[1]) + 1);
  RevField.text := s;
end;
</pre>
<p>Здесь кроется 2 проблемы:</p>
<p>Для увеличения значения вам необходимо извлекать символы из строки. </p>
<p>Хотя вы можете получить доступ к отдельным символам через выделение подстроки, данный метод не срабатывает у некоторых свойств, таких как, например, свойство TStringField Text. </p>
<p>Лучшим решением, по-видимому, будет написание специфической функции. Например, в случае, если revision-символ всегда является конечным символом строки, функция могла бы выглядеть следующим образом:</p>
<pre>
function IncrementTrailingVersionLetter(Str: string): string;
begin 
  Str[Length(Str)] := Char(Ord(Str[Length(Str)]) + 1);
  IncrementTrailingVersionLetter := Str;
end;
 
и использовать ее следующим образом:
 
with RevField do
  Text := IncrementTrailingVersionLetter(Text);
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
