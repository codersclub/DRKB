---
Title: Проверить видимость курсора
Author: s-mike
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Проверить видимость курсора
===========================

    function IsCursorVisible: Boolean;
    begin
      Result := ShowCursor(True) > 0;
      ShowCursor(False);
    end;

