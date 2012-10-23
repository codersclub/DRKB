<h1>Как найти полный путь и имя файла запущенной DLL из самой DLL?</h1>
<div class="date">01.01.2007</div>


<pre>
uses Windows; 
 
procedure ShowDllPath stdcall;
var
  TheFileName: array[0..MAX_PATH] of char;
begin
  FillChar(TheFileName, sizeof(TheFileName), #0);
  GetModuleFileName(hInstance, TheFileName, sizeof(TheFileName));
  MessageBox(0, TheFileName, 'The DLL file name is:', mb_ok);
end;
</pre>

<div class="author">Автор: Олег Кулабухов</div><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />
<pre>
function GetModuleFileNameStr(Instance: THandle): string;
var
  buffer: array [0..MAX_PATH] of Char;
begin
  GetModuleFileName( Instance, buffer, MAX_PATH);
  Result := buffer;
end;
 
GetModuleFileNameStr(Hinstance); // dll name
GetModuleFileNameStr(0); // exe name
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
