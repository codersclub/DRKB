---
Title: Как удалить файл после перезагрузки Windows?
Author: inko
Date: 01.01.2007
---


Как удалить файл после перезагрузки Windows?
============================================

::: {.date}
01.01.2007
:::

Я использую функцию, которая заносит в ключ реестра RunOnce командную
строку:

command.com /c del C:\\Путь\\Имя\_файла

Автор: inko

Взято с Vingrad.ru <https://forum.vingrad.ru>

В wininit добавляешь строку NUL={ПУТЬ УДАЛЯЕМОГО ФАЙЛА}

Автор: VoL

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Еще есть способ через реестр:

    uses Registry;
     

     
    procedure DeleteFileOnRestart (const FileName : String);
    var Reg : TRegistry;
    begin 
      Reg := TRegistry.Create;
      Reg.RootKey := HKEY_LOCAL_MACHINE;
      Reg.OpenKey ('Software\Microsoft\Windows\CurrentVersion\RunOnce', False);
      Reg.WriteString ('Selfdel9x','command.com /C del "' + FileName + '"');
      Reg.WriteString ('SelfdelNT','cmd /C del "' + FileName + '"');
      Reg.CloseKey;
      Reg.Free;
    end;

Тут две команды добавляются, т.к. на XP с command.com не рабоает...

Одна из них сработает, а другая пройдет в холостую...

Автор: p0s0l

Взято с Vingrad.ru <https://forum.vingrad.ru>
