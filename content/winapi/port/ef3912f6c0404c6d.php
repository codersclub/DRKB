<h1>Печать DOS-файла в порт напрямую</h1>
<div class="date">01.01.2007</div>


<p>При печати Dos-файла в порт напрямую можно это сделать.</p>

<p> &nbsp; Например, напечатать за 2 прохода:</p>
<p> &nbsp; ESC @ - инициализация принтера</p>
<p> &nbsp; ESC G - включение режима печати за 2 прохода</p>
<p> &nbsp; ESC H - выключение режима печати за 2 прохода</p>
<pre>
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
     if ( kod&gt;=192) and ( kod=239) then 
        Result[i]:=Chr(kod-64);
     if ( kod&gt;=240) and ( kod=255) then 
        Result[i]:=Chr(kod-16);
     if kod=168 then  Result[i]:=Chr(240);
     if kod=184 then  Result[i]:=Chr(241);
    end;
   end;
</pre>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
