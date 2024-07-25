---
Title: Как создать форму в форме элипса?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как создать форму в форме элипса?
=================================

    procedure TForm1.FormCreate(Sender: TObject);
    var
      Region: HRGN;
    begin
      Region := CreateEllipticRgn(0, 0, 300, 300);
      SetWindowRgn(Handle, Region, True);
    end;

