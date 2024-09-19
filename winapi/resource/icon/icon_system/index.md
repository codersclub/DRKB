---
Title: Как использовать встроенные в Windows иконки в своем приложении?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как использовать встроенные в Windows иконки в своем приложении?
================================================================

Сперва необходимо узнать константы, которые соответствуют определённым
иконкам. Все они определены в API unit (windows.pas) в Delphi:

- IDI\_HAND
- IDI\_EXCLAMATION
- IDI\_QUESTION

Следующий пример рисует иконку вопроса на панели:

    var
      DC: HDC;
      Icon: HICON;
    begin
      DC := GetWindowDC(Panel1.Handle);
      Icon := LoadIcon(0, IDI_QUESTION);
      DrawIcon(DC, 5, 5, Icon);
      ReleaseDC(Panel1.Handle, DC);
    end;

