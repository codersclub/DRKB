<h1>Как пpогpаммно вывести окно свойств экpана?</h1>
<div class="date">01.01.2007</div>

Автор: Nomadic </p>
<pre>
ShellExecute(Application.Handle, 'open', 'desk.cpl', nil, nil, sw_ShowNormal); 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<p>Для этого воспользуемся 'Rundll32.exe' и запустим её в 'shellexecute'. Не забудьте добавить 'shellapi' в Ваш список uses. </p>
<pre>
//Эта функция совместима со всеми версиями Windows
function GetSystemDir: TFileName;
var
  SysDir: array [0..MAX_PATH-1] of char;
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
  ShellExecute(Form11.Handle, 'open', Pchar('rundll32.exe'),
  'shell32.dll,Control_RunDLL Desk.cpl,@0,3', Pchar(X), SW_normal);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

