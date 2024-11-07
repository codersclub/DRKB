---
Title: Как заставить приложение Delphi отвечать на сообщения Windows?
Date: 12.12.1996
Author: Epsylon Technologies
Source: FAQ Epsylon Technologies
---


Как заставить приложение Delphi отвечать на сообщения Windows?
==============================================================

Используем `WM_WININICHANGED` в качестве примера:

Объявление метода в TForm позволит вам обрабатывать сообщение
`WM_WININICHANGED`:

    procedure WMWinIniChange(var Message: TMessage); message WM_WININICHANGE;

Код в implementation может выглядеть так:

    procedure TForm1.WMWinIniChange(var Message: TMessage);
    begin
      inherited;
    { ... ваша реакция на событие ... }
    end;

Вызов inherited метода очень важен. Обратите внимание также на то, что
для функций, объявленных с директивой message (обработчиков событий
Windows) после inherited нет имени наследуемой процедуры, потому что она
может быть неизвестна или вообще отсутствовать (в этом случае вы в
действительности вызываете процедуру DefaultHandler).

Copyright © 1996 Epsylon Technologies

Взято из FAQ Epsylon Technologies (095)-913-5608; (095)-913-2934; (095)-535-5349
