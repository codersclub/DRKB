---
Title: Как реализовать визуальный отсчет времени?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как реализовать визуальный отсчет времени?
==========================================

    var Min3: integer;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      timer1.enabled:=true;
      Min3:=3*60;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      Label1.Caption:=Format('%d : %2d',[Min3 div 60, Min3 mod 60 ]);
      Dec(Min3);
      if Min3 < 0 then
        // Что-то делаешь - 3 минуты закончились
    end;

