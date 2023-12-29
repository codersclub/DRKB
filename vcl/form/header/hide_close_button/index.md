---
Title: Как скрыть кнопку [x] в заголовке окна?
Author: Fernando Silva
Date: 01.01.2007
---


Как скрыть кнопку [x] в заголовке окна?
=========================================

::: {.date}
01.01.2007
:::

Автор: Fernando Silva

Пример показывает, как при инициализации формы происходит поиск нашего
окна, а затем вычисление местоположения нужной нам кнопки в заголовке
окна.

    procedure TForm1.FormCreate(Sender: TObject);
    var
      hwndHandle: THANDLE;
      hMenuHandle: HMENU;
      iPos: Integer;
     
    begin
      hwndHandle := FindWindow(nil, PChar(Caption));
      if (hwndHandle <> 0) then
      begin
        hMenuHandle := GetSystemMenu(hwndHandle, FALSE);
        if (hMenuHandle <> 0) then
        begin
          DeleteMenu(hMenuHandle, SC_CLOSE, MF_BYCOMMAND);
          iPos := GetMenuItemCount(hMenuHandle);
          Dec(iPos);
            { Надо быть уверенным, что нет ошибки т.к. -1 указывает на ошибку }
          if iPos > -1 then
            DeleteMenu(hMenuHandle, iPos, MF_BYPOSITION);
        end;
      end;
    end;

Взято из <https://forum.sources.ru>
