---
Title: Сессия
Date: 01.01.2007
---


Сессия
======

Из объекта-источника данных можно создавать объекты-сессии. Для этого
используется метод

    function CreateSession(const punkOuter: lUnknown; const riid: TGUID;
      out ppDBSession: lUnknown}: HResult; stdcall;

интерфейса iDBCreateSession.

Сессия предназначена для обеспечения работы
транзакций и наборов рядов.
