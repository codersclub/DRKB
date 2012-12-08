---
Title: Как вывести текст с красивым обрезанием если не помещается?
Date: 01.01.2007
---

Как вывести текст с красивым обрезанием если не помещается?
===========================================================

::: {.date}
01.01.2007
:::

Используй вызов DrawTextEx, установив в параметре dwDTFormat значение
DT\_PATH\_ELLIPSIS.

    procedure TForm1.FormPaint(Sender: TObject);
    var
      r: TRect;
    begin
      r := Rect(20, 20, 110, 70);
      // DT_PATH_ELLIPSIS or DT_WORD_ELLIPSIS or DT_END_ELLIPSIS
      DrawTextEx(Form1.Canvas.Handle, 'Delphi World - это круто!!!',
       25, r, DT_WORD_ELLIPSIS, nil);
    end;

Взято с <https://delphiworld.narod.ru>
