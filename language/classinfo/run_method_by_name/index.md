---
Title: Как выполнить метод по его имени?
Date: 01.01.2007
Author: Sasan Adami
Source: <https://www.lmc-mediaagentur.de/dpool>
---


Как выполнить метод по его имени?
=================================

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

