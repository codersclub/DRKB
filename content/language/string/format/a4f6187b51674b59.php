<h1>Функция замены в строке всех вхождений одной подстроки на другую</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Функция замены в строке всех вхождений одной подстроки на другую
 
В отличие от других подобных функций, эта - не зависнет, если в строке нужно 
заменить не только одно слово совершенно другим,
но и допустим, слово "Штаны" на "-Штаны-"
(Т.е. начальное слово после замены остается, но к нему добавляется какой нибудь 
символ справа, или слева. В данном случае по краям слова добавлен знак минуса).
 
Я пересмотрел много примеров, и ни один из них не справился с этой задачей.
(Может я плохо искал?).
 
Зависимости: Windows, SysUtils
Автор:       Матюшкин Сергей, seregam@ua.fm, ICQ:162733776, Днепропетровск
Copyright:   Sergey_M
Дата:        26 мая 2003 г.
***************************************************** }
 
function Replace(Str, X, Y: string): string;
{Str - строка, в которой будет производиться замена.
 X - подстрока, которая должна быть заменена.
 Y - подстрока, на которую будет произведена заменена}
 
var
  buf1, buf2, buffer: string;
  i: Integer;
 
begin
  buf1 := '';
  buf2 := Str;
  Buffer := Str;
 
  while Pos(X, buf2) &gt; 0 do
  begin
    buf2 := Copy(buf2, Pos(X, buf2), (Length(buf2) - Pos(X, buf2)) + 1);
    buf1 := Copy(Buffer, 1, Length(Buffer) - Length(buf2)) + Y;
    Delete(buf2, Pos(X, buf2), Length(X));
    Buffer := buf1 + buf2;
  end;
 
  Replace := Buffer;
end;
Пример использования: 
 
procedure TForm1.Button1Click(Sender: TObject);
var
  a: Integer;
begin
  for a := 0 to Memo1.Lines.Count do
    Memo1.Lines[a] := Replace(Memo1.Lines[a], 'Штаны', '-Штаны-');
end;
</pre>
</p>
<hr />
<p class="p_Heading1">Всё значительно проще! В Борланд уже всё сделали до нас:</p>
<pre>
//заменить первое вхождение подстроки с учётом регистра
S:=StringReplace(ИсходнаяСтрока, ЧтоЗаменять, НаЧтоЗаменять, []) 
 
 
//заменить все вхождения подстроки с учётом регистра
S:=StringReplace(ИсходнаяСтрока, ЧтоЗаменять, НаЧтоЗаменять, [rfReplaceAll]) 
 
 
//заменить первое вхождение подстроки без учёта регистра
S:=StringReplace(ИсходнаяСтрока, ЧтоЗаменять, НаЧтоЗаменять, [rfIgnoreCase]) 
 
 
//заменить все вхождения подстроки без учёта регистра
S:=StringReplace(ИсходнаяСтрока, ЧтоЗаменять, НаЧтоЗаменять, [rfReplaceAll, rfIgnoreCase]) 
 
</pre>
<div class="author">Автор: Vit</div>
</p>
