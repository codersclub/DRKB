---
Title: Как выполнить метод по его имени?
Date: 01.01.2007
---


Как выполнить метод по его имени?
=================================

::: {.date}
01.01.2007
:::

    { ... }
    type
      PYourMethod = ^TYourMethod;
      TYourMethod = procedure(S: string) of Object;
     
     
    procedure TMainForm.Button1Click(Sender: TObject);
    begin
      ExecMethodByName('SomeMethod');
    end;
     
     
    procedure TMainForm.ExecMethodByName(AName: string);
    var
      PAddr: PYourMethod;
      M: TMethod;
    begin
      PAddr := MethodAddress(AName);
      if PAddr <> nil then
      begin
        M.Code := PAddr;
        M.Data := Self;
        TYourMethod(M)('hello');
      end;
    end;
     
     
    procedure TMainForm.SomeMethod(S: string);
    begin
      ShowMessage(S);
    end; 

Tip by Sasan Adami

Взято из <https://www.lmc-mediaagentur.de/dpool>
