---
Title: Как сделать, чтобы форма закрывалась при нажатии Esc?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как сделать, чтобы форма закрывалась при нажатии Esc?
=====================================================

Для начала необходимо установить свойство формы KeyPreview в True.
А потом уже можно отлавливать "Esc":

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Form1.KeyPreview := True;
    end;
     
    procedure TForm1.FormKeyPress
      (Sender: TObject; var Key: Char);
    begin
      if key = #27 then Close;
    end;

