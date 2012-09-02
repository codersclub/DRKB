<h1>Как очистить экран в консольном приложении?</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Олег Кулабухов&nbsp; </p>

<p>Нужно просто использовать GetConsoleScreenBufferInfo() для ввода нескольких пустых строк.</p>

<pre>
program Project1;
{$APPTYPE CONSOLE}
uses
  Windows;
{$R *.RES}
var
  sbi: TConsoleScreenBufferInfo;
  i: integer;
begin
  Writeln('A Console Applicaiton');
  Writeln('Press Enter To Clear The Screen');
  GetConsoleScreenBufferInfo(GetStdHandle(STD_OUTPUT_HANDLE),
    sbi);
  Readln;
  GetConsoleScreenBufferInfo(GetStdHandle(STD_OUTPUT_HANDLE),
    sbi);
  for i := 0 to sbi.dwSize.y do
    writeln;
  Writeln('Press Enter To End');
  Readln;
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />
<pre>
uses
  Windows;
 
procedure ClearConsoleWindow;
var
 ConsoleHandle:THandle;
 ConsoleInfo: TConsoleScreenBufferInfo;
 Coord:TCoord;
 WrittenChars:DWORD;
begin
 FillChar(ConsoleInfo,SizeOf(TConsoleScreenBufferInfo),0);
 FillChar(Coord,SizeOf(TCoord),0);
 ConsoleHandle:=GetStdHandle(STD_OUTPUT_HANDLE);
 GetConsoleScreenBufferInfo(ConsoleHandle, ConsoleInfo);
 FillConsoleOutputCharacter(ConsoleHandle,' ', ConsoleInfo.dwSize.X * ConsoleInfo.dwSize.Y, Coord, WrittenChars);
 SetConsoleCursorPosition(ConsoleHandle,ConsoleInfo.dwCursorPosition)
end;
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p class="author">Автор: Krid</p>
