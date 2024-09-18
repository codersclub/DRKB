---
Title: Как отключить курсор мыши?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Как отключить курсор мыши?
==========================

    //Выключение курсора
    procedure TForm1.Button1Click(Sender: TObject);
    var
      CState: Integer;
    begin
      CState := ShowCursor(True);
      while Cstate >= 0 do
        Cstate := ShowCursor(False);
    end;
     
    //Включение курсора
    procedure TForm1.Button2Click(Sender: TObject);
    var
      Cstate: Integer;
    begin
      Cstate := ShowCursor(True);
      while CState < 0 do
        CState := ShowCursor(True);
    end;


