---
Title: Как отключить курсор мыши?
Date: 01.01.2007
---

Как отключить курсор мыши?
==========================

::: {.date}
01.01.2007
:::

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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
