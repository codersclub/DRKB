---
Title: Как сделать прозрачным фон текста?
Date: 01.01.2007
---


Как сделать прозрачным фон текста?
==================================

::: {.date}
01.01.2007
:::

Используйте функцию SetBkMode():

    procedure TForm1.Button1Click(Sender: TObject);
    var
      OldBkMode: integer;
    begin
      with Form1.Canvas do
      begin
        Brush.Color := clRed;
        FillRect(Rect(0, 0, 100, 100));
        Brush.Color := clBlue;
        TextOut(10, 20, 'Not Transparent!');
        OldBkMode := SetBkMode(Handle, TRANSPARENT);
        TextOut(10, 50, 'Transparent!');
        SetBkMode(Handle, OldBkMode);
      end;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
