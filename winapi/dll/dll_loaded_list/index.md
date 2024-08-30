---
Title: Получение списка DLL, загруженных приложением
Author: Simon Carter
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Получение списка DLL, загруженных приложением
=============================================

Иногда бывает полезно знать какими DLL-ками пользуется Ваше приложение.
Давайте посмотрим как это можно сделать в Win NT/2000.

Пример функции

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
      if Win32Platform <> VER_PLATFORM_WIN32_NT then 
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
            if ma[i] <> 0 then 
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

Для вызова приведённой функции надо сделать следующее:

- Добавить listbox на форму (Listbox1)
- Добавить кнопку на форму (Button1)

Обработчик события OnClick для кнопки будет выглядеть следующим образом

    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      GetLoadedDLLList(ListBox1.Items, [moIncludeHandle, moRemovePath]); 
    end; 

