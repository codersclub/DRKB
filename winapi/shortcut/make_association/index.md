---
Title: Как связать определенное расширение файлов с моим приложением?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как связать определенное расширение файлов с моим приложением?
==============================================================

В Win32 необходимо создать новую запись в реестре в корневом ключе
HKEY\_CLASSES\_ROOT, которая будет указывать на расширение файла,
командную строку и иконку, которая будет отображаться для этого
расширения. В Win16, просто включить расширение файла и командную строку
в секцию [Extensions] в Win.ini.

Пример:

    uses 
      Registry, {For Win32} 
      IniFiles; {For Win16} 
     
    {Для Win32} 
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      reg: TRegistry; 
    begin 
      reg := TRegistry.Create; 
      reg.RootKey := HKEY_CLASSES_ROOT; 
      reg.LazyWrite := false; 
      {Add Program Support} 
      reg.OpenKey('.bor\shell\open\command', true); 
      {Имя файла будет передавать в приложение как первый параметр}
      reg.WriteString('', 'C:\Program Files\Borland\Delphi 3\Project1.exe %1'); 
      {Добавляем отображаемую иконку}
      reg.CloseKey; 
      reg.OpenKey('.bor\DefaultIcon',true); 
      {Для отображения используем первую иконку в нашем приложении}
      reg.WriteString('', 'C:\Program Files\Borland\Delphi 3\Project1.exe,0');
      reg.CloseKey; 
      reg.free; 
    end; 
     
    {Для Win16} 
    procedure TForm1.Button2Click(Sender: TObject); 
    var 
      WinIni : TIniFile; 
      WinIniFileName : array[0..MAX_PATH] of char; 
      s : array[0..64] of char; 
    begin 
      GetWindowsDirectory(WinIniFileName, sizeof(WinIniFileName)); 
      StrCat(WinIniFileName, '\win.ini'); 
      WinIni := TIniFile.Create(WinIniFileName); 
      WinIni.WriteString('Extensions', 
                         'bor', 
                         'C:\PROGRA~1\BORLAND\DELPHI~1\PROJECT1.EXE ^.bor'); 
      WinIni.Free; 
      StrCopy(S, 'Extensions'); 
      SendMessage(HWND_BROADCAST, WM_WININICHANGE, 0, LongInt(@S)); 
    end;

