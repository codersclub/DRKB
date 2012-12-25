---
Title: Таскаем форму за её поверхность
Date: 01.01.2007
---


Таскаем форму за её поверхность
===============================

::: {.date}
01.01.2007
:::

    unit DragMain;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs,  Messages,
      Classes, Graphics, Controls, Forms, Dialogs, StdCrtls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure ButtonClick(Sender: TObject);
      private       
        procedure WMNCHitTest(var M: TWMNCHitTest);
                     message wm_NCCHitTest;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1. WMNCHitTest(var M: TWMNCHitTest); 
     
    begin
      inherited;
      if M.Result = htClient then
        M.Result := htCaption;
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
     
    begin
      Close;
    end;
     
    end.
