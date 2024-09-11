---
Title: Как очистить экран в консольном приложении?
Date: 01.01.2007
---

Как очистить экран в консольном приложении?
===========================================

Вариант 1:

Author: Олег Кулабухов 

Source: <https://delphiworld.narod.ru>

Нужно просто использовать GetConsoleScreenBufferInfo() для ввода
нескольких пустых строк.

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


------------------------------------------------------------------------

Вариант 2:

Author: Krid

Source: <https://forum.sources.ru>

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
     FillConsoleOutputCharacter(ConsoleHandle,' ',
                                ConsoleInfo.dwSize.X * ConsoleInfo.dwSize.Y,
                                Coord, WrittenChars);
     SetConsoleCursorPosition(ConsoleHandle,ConsoleInfo.dwCursorPosition)
    end;

