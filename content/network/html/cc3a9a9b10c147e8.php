<h1>Как преобразовать шестнадцатиричный цвет HTML в TColor?</h1>
<div class="date">01.01.2007</div>


<p>допустим, мы имеем переменную:</p>
<p>const BGCOLOR = '#003366';</p>
<p>и нам необходимо связать её с фоновым цветом memo либо любого другого TColor.</p>
<p>Мы можем это сделать простым вызовом функции и использовать возвращённое значение:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  Memo.Color := ConvertHtmlHexToTColor(BGCOLOR);
end;
</pre>

<p>Ниже приведён исходник этой функции, а так же код функции CheckHexForHash.</p>
<pre>unit colours;
 
interface
uses Windows, Sysutils, Graphics;
 
function ConvertHtmlHexToTColor(Color: string): TColor;
function CheckHexForHash(col: string): string;
 
implementation
 
////////////////////////////////////////////////////////////////////////////////
// ConvertHtmlHexToTColor
//
 
function ConvertHtmlHexToTColor(Color: string): TColor;
var
  rColor: TColor;
begin
  Color := CheckHexForHash(Color);
 
  if (length(color) &gt;= 6) then
    begin
{незабудьте, что TColor это bgr, а не rgb: поэтому необходимо изменить порядок}
      color := '$00' + copy(color, 5, 2) + copy(color, 3, 2) + copy(color, 1, 2);
      rColor := StrToInt(color);
    end;
 
  result := rColor;
end;
 
////////////////////////////////////////////////////////////////////////////////
// CheckHexForHash:
// Просто проверяет первый сивол строки на наличие '#' и удаляет его, если он найден
 
function CheckHexForHash(col: string): string;
begin
  if col[1] = '#' then
    col := StringReplace(col, '#', '', [rfReplaceAll]);
  result := col;
end;
end.
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
