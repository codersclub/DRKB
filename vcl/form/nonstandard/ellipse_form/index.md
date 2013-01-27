---
Title: Как создать форму в форме элипса?
Date: 01.01.2007
---


Как создать форму в форме элипса?
=================================

::: {.date}
01.01.2007
:::

    procedure TForm1.FormCreate(Sender: TObject);
    var
      Region: HRGN;
    begin
      Region := CreateEllipticRgn(0, 0, 300, 300);
      SetWindowRgn(Handle, Region, True);
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
