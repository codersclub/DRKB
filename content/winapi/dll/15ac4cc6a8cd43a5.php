<h1>Получение списка DLL, загруженных приложением</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Simon Carter</div>

<p>Иногда бывает полезно знать какими DLL-ками пользуется Ваше приложение. Давайте посмотрим как это можно сделать в Win NT/2000.</p>

<p>Пример функции</p>
<pre>
unit ModuleProcs; 
 
interface 
 
uses Windows, Classes; 
 
type 
  TModuleArray = array[0..400] of HMODULE; 
  TModuleOption = (moRemovePath, moIncludeHandle); 
  TModuleOptions = set of TModuleOption; 
 
function GetLoadedDLLList(sl: TStrings; 
  Options: TModuleOptions = [moRemovePath]): Boolean; 
 
implementation 
 
uses SysUtils; 
 
function GetLoadedDLLList(sl: TStrings; 
  Options: TModuleOptions = [moRemovePath]): Boolean; 
type 
EnumModType = function (hProcess: Longint; lphModule: TModuleArray; 
  cb: DWord; var lpcbNeeded: Longint): Boolean; stdcall; 
var 
  psapilib: HModule; 
  EnumProc: Pointer; 
  ma: TModuleArray; 
  I: Longint; 
  FileName: array[0..MAX_PATH] of Char; 
  S: string; 
begin 
  Result := False; 
 
  (* Данная функция запускается только для Widnows NT *) 
  if Win32Platform &lt;&gt; VER_PLATFORM_WIN32_NT then 
    Exit; 
 
  psapilib := LoadLibrary('psapi.dll'); 
  if psapilib = 0 then 
    Exit; 
  try 
    EnumProc := GetProcAddress(psapilib, 'EnumProcessModules'); 
    if not Assigned(EnumProc) then 
      Exit; 
    sl.Clear; 
    FillChar(ma, SizeOF(TModuleArray), 0); 
    if EnumModType(EnumProc)(GetCurrentProcess, ma, 400, I) then 
    begin 
      for I := 0 to 400 do 
        if ma[i] &lt;&gt; 0 then 
        begin 
          FillChar(FileName, MAX_PATH, 0); 
          GetModuleFileName(ma[i], FileName, MAX_PATH); 
          if CompareText(ExtractFileExt(FileName), '.dll') = 0 then 
          begin 
            S := FileName; 
            if moRemovePath in Options then 
              S := ExtractFileName(S); 
            if moIncludeHandle in Options then 
              sl.AddObject(S, TObject(ma[I])) 
            else 
              sl.Add(S); 
          end; 
        end; 
    end; 
    Result := True; 
  finally 
    FreeLibrary(psapilib); 
  end; 
end; 
 
end. 
</pre>

<p>Для вызова приведённой функции надо сделать следующее: </p>

<p>Добавить listbox на форму (Listbox1) </p>
<p>Добавить кнопку на форму (Button1) </p>

<p>Обработчик события OnClick для кнопки будет выглядеть следующим образом</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  GetLoadedDLLList(ListBox1.Items, [moIncludeHandle, moRemovePath]); 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

