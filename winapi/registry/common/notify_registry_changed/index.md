---
Title: Как уведомить все приложения, что реестр был изменен?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как уведомить все приложения, что реестр был изменен?
=====================================================

Для этого можно послать в систему широковещательное сообщение
WM\_WININICHANGE, указав в нём, что изменения касаются реестра.
Большинство приложений, работа которых связана с реестром, должны
реагировать на сообщение WM\_WININICHANGE.

Пример:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SendMessage(HWND_BROADCAST,WM_WININICHANGE,0,LongInt(PChar('RegistrySection')));
    end;

