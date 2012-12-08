---
Title: Как сделать фон у текста прозрачным?
Date: 01.01.2007
---

Как сделать фон у текста прозрачным?
====================================

::: {.date}
01.01.2007
:::

Для этого можно воспользоваться API функцией SetBkMode().

    procedure TForm1.Button1Click(Sender: TObject);
    var
      OldBkMode : integer;
    begin
      with Form1.Canvas do begin
        Brush.Color := clRed;
        FillRect(Rect(0, 0, 100, 100));
        Brush.Color := clBlue;
        TextOut(10, 20, 'Not Transparent!');
        OldBkMode := SetBkMode(Handle, TRANSPARENT);
        TextOut(10, 50, 'Transparent!');
        SetBkMode(Handle, OldBkMode);
      end;
    end;

Взято из <https://forum.sources.ru>
