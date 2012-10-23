<h1>Как зарегистрировать в компонент ActiveX?</h1>
<div class="date">01.01.2007</div>


<p>запустить "Regsvr32.exe имя_файла" из каталога c:\windows\system(32)</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>1. Регистрация ActiveX:</p>
<pre>function RegActiveX(FileName:string):HRESULT;
var
hMod:Integer;
RegProc:function:HRESULT; //HRESULT = Longint
begin
hMod:=LoadLibrary(FileName);
if hMod=0 then
raise Exception.Create('Unable to load library"'+FileName+'". GetLastError = '+IntToStr(GetLastError));
RegProc:=GetProcAddress(hMod,'DllRegisterServer');
if RegProc=nil then
raise Exception.Create('Unable to load "DllRegisterServer" function from "'+FileName+'". GetLastError = '+IntToStr(GetLastError));
Result:=RegProc;
end;
</pre>

<p>2. Регистрация Type Library:</p>
<pre>procedure RegisterTypeLibrary(FileName:string);
var
Name: WideString;
HelpPath: WideString;
TypeLib: ITypeLib;
begin
if LoadTypeLib(PWideChar(WideString(FileName)), TypeLib)=S_OK then
begin
Name := FileName;
HelpPath := ExtractFilePath(ModuleName);
RegisterTypeLib(TypeLib, PWideChar(Name), PWideChar(HelpPath));
end;
end;
</pre>

<p>Здесь используется интерфейс ITypeLib и API функция RegisterTypeLib. И то и другое объявленно в модуле ActiveX, если я не ошибаюсь.</p>
<p>Hint: если вы регистрируете библиотеку типов изнутри модулчя, то его имя можно получить с помощью следующей функции:</p>
<pre>function GetModuleFileName: string;
var Buffer: array[0..261] of Char;
begin
SetString(Result, Buffer, Windows.GetModuleFileName(HInstance,
Buffer, SizeOf(Buffer)));
end;
</pre>

<div class="author">Автор: Fantasist</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
