<h1>Как в консольном приложении можно задать цвет текста?</h1>
<div class="date">01.01.2007</div>


<p>Цвет Текста задается командой SetTextColor(Color), параметр Color - целое число от 0 до 15.</p>
<p>Вывод текста в указанном месте экрана задается командой GotoXY(X,Y,Text).</p>
<p>X,Y-координаты экрана.</p>
<p>Text - переменная типа String.</p>
<p>Ответ 3:</p>
<p>Вот текст модуля, напоминающего про наш любимый ДОС (CRT-like):</p>
<pre>
unit UffCRT;
// written by Michael Uskoff, Apr 2001, St.Petersburg, RUSSIA
 
interface
 
procedure ClrScr;
procedure SetAttr(attr: word);
function GetAttr: word;
procedure GotoXY(aX, aY: integer); // zero-based coords
function WhereX: integer;
function WhereY: integer;
 
implementation
 
uses Windows;
 
var
  UpperLeft: TCoord = (X: 0; Y: 0);
  hCon: integer;
 
procedure GotoXY(aX, aY: integer);
var aCoord: TCoord;
begin
  aCoord.x := aX;
  aCoord.y := aY;
  SetConsoleCursorPosition(hCon, aCoord);
end;
 
procedure SetAttr(attr: word);
begin
  SetConsoleTextAttribute(hCon, attr);
end;
 
function WhereX: integer;
var ScrBufInfo: TConsoleScreenBufferInfo;
begin
  GetConsoleScreenBufferInfo(hCon, ScrBufInfo);
  Result := ScrBufInfo.dwCursorPosition.x;
end;
 
function WhereY: integer;
var ScrBufInfo: TConsoleScreenBufferInfo;
begin
  GetConsoleScreenBufferInfo(hCon, ScrBufInfo);
  Result := ScrBufInfo.dwCursorPosition.y;
end;
 
function GetAttr: word;
var ScrBufInfo: TConsoleScreenBufferInfo;
begin
  GetConsoleScreenBufferInfo(hCon, ScrBufInfo);
  Result := ScrBufInfo.wAttributes;
end;
 
procedure ClrScr;
var fill: integer;
  ScrBufInfo: TConsoleScreenBufferInfo;
begin
  GetConsoleScreenBufferInfo(hCon, ScrBufInfo);
  fill := ScrBufInfo.dwSize.x * ScrBufInfo.dwSize.y;
  FillConsoleOutputCharacter(hCon, ' ', fill, UpperLeft, fill);
  FillConsoleOutputAttribute(hCon, ScrBufInfo.wAttributes, fill, UpperLeft, fill);
  GotoXY(0, 0);
end;
 
initialization
  hCon := GetStdHandle(STD_OUTPUT_HANDLE);
end.
 
Теперь можно творить такое:
 
uses UffCRT;
....
ClrScr;
SetAttr($1E);
GotoXY(32, 12);
Write('Hello, master !');
ReadLn;
...
</pre>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
