---
Title: Проверить видимость курсора
Author: s-mike
Date: 01.01.2007
---

Проверить видимость курсора
===========================

::: {.date}
01.01.2007
:::

    function IsCursorVisible: Boolean;
    begin
      Result := ShowCursor(True) > 0;
      ShowCursor(False);
    end;


Автор: s-mike

Взято из <https://forum.sources.ru>
