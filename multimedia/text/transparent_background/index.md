---
Title: Как сделать прозрачным фон текста?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как сделать прозрачным фон текста?
==================================

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


