---
Title: Как назначить событие на увеличение / уменьшение TSpinEdit с помощью стрелочек?
Author: p0s0l
Date: 01.01.2007
---


Как назначить событие на увеличение / уменьшение TSpinEdit с помощью стрелочек?
===============================================================================

::: {.date}
01.01.2007
:::

У TSpinEdit.Button есть дополнительные события, которые не показаны в
инспекторе объектов, например, OnUpClick и OnDownClick\...

    unit Unit1;

     
    interface
    uses
     Windows, Messages, SysUtils, Classes, Graphics, 
     Controls, Forms, Dialogs, StdCtrls, Spin;
     
    type
     TForm1 = class(TForm)
       SpinEdit1: TSpinEdit;
       procedure FormCreate(Sender: TObject);
     public
       procedure OnButtonUpClick(Sender: TObject);
    end;
     
    var
     Form1: TForm1;
     
    implementation
     
     {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     SpinEdit1.Button.OnUpClick := OnButtonUpClick;
    end;
     
    procedure TForm1.OnButtonUpClick(Sender: TObject);
    begin
     MessageDlg('Up Button was clicked.', mtInformation,
       [mbOk], 0);
    end;
     
    end.

Автор: p0s0l

Взято с Vingrad.ru <https://forum.vingrad.ru>
