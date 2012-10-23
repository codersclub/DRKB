<h1>Удаление пробелов в начале строки</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Удаление пробелов в начале строки
 
Функция возвращает строку без пробелов в начале (если они были)
 
Зависимости: Windows, SysUtils
Автор:       Hastlero
Copyright:   HasTler0
Дата:        8 февраля 2003 г.
***************************************************** }
 
var
  i: Integer;
begin
  if Length(str) = 0 then
  begin
    DelSpaces := str;
    Exit;
  end;
  for i := 1 to length(str) do
  begin
    if pos(' ', str) = 1 then
      delete(str, 1, 1)
    else
    begin
      DelSpaces := str;
      Break;
    end;
  end;
end;
//Пример использования: 
 
Str := DelSpaces(Str); 
</pre>
&nbsp;</p>
<hr />
<p class="p_Heading1">Изобретателям велосипеда посвящается:</p>
<p class="p_Heading1">&nbsp;</p>
<p class="p_Heading1">TrimRight - удаляет пробелы в начале строки, в том числе и в юникодных строках</p>
<p class="p_Heading1">TrimLeft - удаляет пробелы в конце строки, в том числе и в юникодных строках</p>
<p class="p_Heading1">Trim - удаляет пробелы в начале и в коце строки, в том числе и в юникодных строках</p>
<div class="author">Автор: Vit</div>
<p class="p_Heading1">&nbsp;</p>
