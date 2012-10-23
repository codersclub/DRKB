<h1>Фильтрованный поиск в строке</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: David Stidolph </div>

<p>Есть множество задач, где необходимо использование так называемой "дикой карты", то есть поиск в строке по фильтру, когда в качестве поиска используется подстрока с символом "*" (звездочка). Например, если необходимо выяснить наличие подстроки 'St' с какими-либо символами перед ней, то в качестве параметра для поиска задается подстрока вида '*St'. Звездочка может присутствовать как в начале/конце подстроки, так и по обеим ее сторонам. Также при составлении фильтра вместо любого одиночного символа возможна подстановка знака вопроса.</p>
<p>Пока функция может только сообщать о наличии необходимых вложений, но было бы интересно получить ваши примеры, которые могли бы и возвращать искомую подстроку.</p>
<pre>{
Данная функция осуществляет сравнение двух строк. Первая строка
может быть любой, но она не должна содержать символов соответствия (* и ?).
Строка поиска (искомый образ) может содержать абсолютно любые символы.
Для примера: MatchStrings('David Stidolph','*St*') возвратит True.
 
Автор оригинального C-кода Sean Stanley
Автор портации на Delphi David Stidolph
}
 
function MatchStrings(source, pattern: string): Boolean;
var
  pSource: array[0..255] of Char;
  pPattern: array[0..255] of Char;
 
  function MatchPattern(element, pattern: PChar): Boolean;
 
    function IsPatternWild(pattern: PChar): Boolean;
    var
      t: Integer;
    begin
      Result := StrScan(pattern, '*') &lt;&gt; nil;
      if not Result then
        Result := StrScan(pattern, '?') &lt;&gt; nil;
    end;
 
  begin
    if 0 = StrComp(pattern, '*') then
      Result := True
    else if (element^ = Chr(0)) and (pattern^ &lt;&gt; Chr(0)) then
      Result := False
    else if element^ = Chr(0) then
      Result := True
    else
    begin
      case pattern^ of
        '*': if MatchPattern(element, @pattern[1]) then
            Result := True
          else
            Result := MatchPattern(@element[1], pattern);
        '?': Result := MatchPattern(@element[1], @pattern[1]);
      else
        if element^ = pattern^ then
          Result := MatchPattern(@element[1], @pattern[1])
        else
          Result := False;
      end;
    end;
  end;
 
begin
  StrPCopy(pSource, source);
  StrPCopy(pPattern, pattern);
  Result := MatchPattern(pSource, pPattern);
end;
 
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>

