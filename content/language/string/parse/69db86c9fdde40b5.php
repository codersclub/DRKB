<h1>Замена подстрок</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Сергей Шамайтис</div>
<pre>
function ReplaceSub(str, sub1, sub2: string): string;
var
  aPos: Integer;
  rslt: string;
begin
  aPos := Pos(sub1, str);
  rslt := '';
  while (aPos &lt;&gt; 0) do
  begin
    rslt := rslt + Copy(str, 1, aPos - 1) + sub2;
    Delete(str, 1, aPos + Length(sub1) - 1);
    aPos := Pos(sub1, str);
  end;
  Result := rslt + str;
end; 
</pre>
&nbsp;</p>
<hr />
<pre>
function ReplaceStr(const S, Srch, Replace: string): string;
{замена подстроки в строке}
var
  I: Integer;
  Source: string;
begin
  Source := S;
  Result := '';
  repeat
    I := Pos(Srch, Source);
    if I &amp;gt;
    0 then
    begin
      Result := Result + Copy(Source, 1, I - 1) + Replace;
      Source := Copy(Source, I + Length(Srch), MaxInt);
    end
    else
      Result := Result + Source;
  until I&amp;lt;
  = 0;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Замена в строке всех вхождений одной подстроки, на другую
 
Зависимости: -
Автор:       Евгений Валяев (RhinoFC), rhinofc@sniiggims.ru, ICQ:55263922, Новосибирск
Copyright:   RhinoFC
Дата:        5 июня 2002 г.
***************************************************** }
 
function StrReplace(const Str, Str1, Str2: string): string;
// str - исходная строка
// str1 - подстрока, подлежащая замене
// str2 - заменяющая строка
var
  P, L: Integer;
begin
  Result := str;
  L := Length(Str1);
  repeat
    P := Pos(Str1, Result); // ищем подстроку
    if P &gt; 0 then
    begin
      Delete(Result, P, L); // удаляем ее
      Insert(Str2, Result, P); // вставляем новую
    end;
  until P = 0;
end;
 
</pre>
&nbsp;</p>
<hr /><p>А стандартная функция StringReplace  чем не устраивает?</p>
<div class="author">Автор: Vit</div>
