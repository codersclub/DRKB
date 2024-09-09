---
Title: Печать DOS-файла в порт напрямую
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---


Печать DOS-файла в порт напрямую
================================

При печати Dos-файла в порт напрямую можно это сделать.

Например, напечатать за 2 прохода:

- ESC @ - инициализация принтера
- ESC G - включение режима печати за 2 прохода
- ESC H - выключение режима печати за 2 прохода

        Var FileOut : TextFile;
            filename : String [128];
        ....
        Filename:='PRN';
        AssignFile(Fileout,Filename);
        ...
        Write(FileOut,Chr(27)+'@');
        Str1:=AnToAs(chr(27)+'G'+'Double'+chr(27)+'H');
        Writeln(FileOut,Str1);
        ...
        {преобразование Ansi to Ascii}
        function AnToAs(s: String) : String;
        Var i,kod : Integer;
        begin
         Result:=s;
         for i:=1 to length(s) do
         begin
          kod:=Ord(s[i]);
          if  kod  13 then Result[i]:=' ';
          if ( kod>=192) and ( kod=239) then 
             Result[i]:=Chr(kod-64);
          if ( kod>=240) and ( kod=255) then 
             Result[i]:=Chr(kod-16);
          if kod=168 then  Result[i]:=Chr(240);
          if kod=184 then  Result[i]:=Chr(241);
         end;
        end;

