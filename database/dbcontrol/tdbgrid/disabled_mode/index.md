---
Title: Как показать TDBGrid в режиме disabled?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как показать TDBGrid в режиме disabled?
=======================================

Ниже приведен пример, меняющий цвет шрифта на clGray, когда доступ к
элементу управления (в данном случае TDBGrid) запрещен (disabled).

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      DbGrid1.Enabled := false;
      DbGrid1.Font.Color := clGray;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      DbGrid1.Enabled := true;
      DbGrid1.Font.Color := clBlack;
    end;

