---
Title: Как отловить смену фокуса для всех контролов?
Author: p0s0l
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как отловить смену фокуса для всех контролов?
=============================================

    procedure TForm1.ActiveControlChange(Sender: TObject);
    begin
      Caption := TScreen(Sender).ActiveForm.ActiveControl.Name;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Screen.OnActiveControlChange := ActiveControlChange;
    end;

