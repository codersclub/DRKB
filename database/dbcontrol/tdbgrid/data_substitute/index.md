---
Title: Как сделать, чтобы в TDBGrid вместо цифр были соответствующие константы?
Date: 01.01.2007
---


Как сделать, чтобы в TDBGrid вместо цифр были соответствующие константы?
========================================================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Grid1DrawColumnCell(Sender: TObject; const Rect: TRect;
              DataCol: Integer; Column: TColumn; State: TGridDrawState);
    begin
      // ВАЖНО: имя поля большими буквами!
      if Column.Field.FieldName = 'PLATEZH' then
      begin
        Grid1.Canvas.FillRect(Rect);
        if Column.Field.AsInteger = 0 then
          Grid1.Canvas.TextOut(Rect.Left + 1, Rect.Top + 2, 'наличными')
        else
          Grid1.Canvas.TextOut(Rect.Left + 1, Rect.Top + 2, 'безнал');
      end;
    end;

Взято с <https://delphiworld.narod.ru>
