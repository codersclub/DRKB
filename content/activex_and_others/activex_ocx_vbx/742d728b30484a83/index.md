---
Title: Как зарегистрировать в компонент ActiveX?
Author: Vit
Date: 01.01.2007
---


Как зарегистрировать в компонент ActiveX?
=========================================

::: {.date}
01.01.2007
:::

запустить \"Regsvr32.exe имя\_файла\" из каталога c:\windows\system(32)

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

1. Регистрация ActiveX:

    function RegActiveX(FileName:string):HRESULT;
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

2. Регистрация Type Library:

    procedure RegisterTypeLibrary(FileName:string);
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

Здесь используется интерфейс ITypeLib и API функция RegisterTypeLib. И
то и другое объявленно в модуле ActiveX, если я не ошибаюсь.

Hint: если вы регистрируете библиотеку типов изнутри модулчя, то его имя
можно получить с помощью следующей функции:

    function GetModuleFileName: string;
    var Buffer: array[0..261] of Char;
    begin
    SetString(Result, Buffer, Windows.GetModuleFileName(HInstance,
    Buffer, SizeOf(Buffer)));
    end;

Автор: Fantasist

Взято с Vingrad.ru <https://forum.vingrad.ru>
