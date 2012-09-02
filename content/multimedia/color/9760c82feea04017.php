<h1>Как преобразовать шестнадцатиричный цвет HTML в TColor?</h1>
<div class="date">01.01.2007</div>


<pre>
unit colours;
 
interface
uses
  Windows, Sysutils, Graphics;
 
  function ConvertHtmlHexToTColor(Color: string):TColor ;
  function CheckHexForHash(col: string):string ;
 
implementation
 
 
function ConvertHtmlHexToTColor(Color: string):TColor ;
var
  rColor: TColor;
begin
  Color := CheckHexForHash(Color);
 
  if (length(color) &gt;= 6) then
  begin
    {незабудьте, что TColor это bgr, а не rgb: поэтому необходимо изменить порядок}
    color := '$00' + copy(color,5,2) + copy(color,3,2) + copy(color,1,2);
    rColor := StrToInt(color);
  end;
 
  result := rColor;
end;
 
 
// Просто проверяет первый сивол строки на наличие '#' и удаляет его, если он найден
function CheckHexForHash(col: string):string ;
begin
  if col[1] = '#' then
    col := StringReplace(col,'#','',[rfReplaceAll]);
  result := col;
end;
 
end.
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
