---
Title: Как присвоить значение полям записи с помощью ассемблера?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как присвоить значение полям записи с помощью ассемблера?
=========================================================

    unit Main;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure Foo(var I: integer);
    begin
      { some code }
      asm
        mov eax, I
        inc dword ptr [eax]
      end;
      { i has now been incremented by one }
      { some more code }
    end;
     
    type
      TDumbRec = record
        i: integer;
        c: char;
      end;
     
    procedure ManipulateRec(var DR: TDumbRec);
    asm
      mov [eax].TDumbRec.i, 24
      mov [eax].TDumbRec.c, 's'
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      R: TDumbRec;
    begin
      ManipulateRec(R);
      ShowMessage(IntToStr(R.i));
      Caption := Caption + R.c;
    end;
     
    end.

