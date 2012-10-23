<h1>Как заставить запускаться из определенной папки?</h1>
<div class="date">01.01.2007</div>


<p>Приведенный пример кода проверяет из какой папки запущена программа, если она запущена не из корневой - то переносит себя в корень и запускается оттуда.</p>
<pre>program Project1;

 
uses
Forms, classes, windows, Sysutils, ShellApi,
Unit1 in 'Unit1.pas' {Form1};
{$R *.RES}
var f:textFile;
FileName:String;
begin
if paramstr(1)&lt;&gt;'/runasis' then
begin
CopyFile(PChar(Paramstr(0)),PChar('c:\'+extractFilename(paramstr(0))),True);
shellexecute(0, 'Open', PChar(extractFilename(paramstr(0))), '/runasis', 'c:\',sw_restore);
FileName:=changefileext(paramstr(0),'.bat');
assignFile(f,FileName);
rewrite(f);
writeln(f,':1');
writeln(f,format('Erase "%s"',[paramstr(0)]));
writeln(f,format('If exist "%s" Goto 1',[paramstr(0)]));
writeln(f,format('Erase "%s"',[FileName]));
closefile(f);
ShellExecute(0, 'Open', PChar(FileName), nil, nil, sw_hide);
end
else
begin
Application.Initialize;
Application.CreateForm(TForm1, Form1);
Application.Run;
end;
end.
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
