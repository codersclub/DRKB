<h1>Как показать окно свойств экрана?</h1>
<div class="date">01.01.2007</div>


<p>Для этого воспользуемся 'Rundll32.exe' и запустим её в 'shellexecute'. Не забудьте добавить 'shellapi' в Ваш список uses.</p>
<pre>function GetSystemDir: TFileName;
var
  SysDir: array[0..MAX_PATH - 1] of char;
begin
  SetString(Result, SysDir, GetSystemDirectory(SysDir, MAX_PATH));
  if Result = '' then
    raise Exception.Create(SysErrorMessage(GetLastError));
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  x: Tfilename;
begin
  x := getsystemdir;
  ShellExecute(Form11.Handle, 'open', Pchar('rundll32.exe'), 'shell32.dll,Control_RunDLL Desk.cpl,@0,3', Pchar(X), SW_normal);
end;
 
//getsystemdir это функция, которая совместима со всеми версиями windows.
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
