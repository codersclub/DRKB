---
Title: TMemo со свойствами Row и Col
Date: 01.01.2007
---


TMemo со свойствами Row и Col
=============================

::: {.date}
01.01.2007
:::

Наследник TMemo со свойствами row & col:

    unit C_rcmemo;
     
    interface
     
    uses
     
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
     
    type
     
      TRCMemo = class(TMemo)
      private
        { Private declarations }
        function GetRow: Integer;
        procedure SetRow(value: Integer);
        function GetCol: Integer;
        procedure SetCol(value: Integer);
        function GetPosn: LongInt;
        procedure SetPosn(value: LongInt);
      protected
        { Protected declarations }
      public
        { Public declarations }
      published
        { Published declarations }
        property Row: Integer read GetRow write SetRow;
        property Col: Integer read GetCol write SetCol;
        property Posn: LongInt read GetPosn write SetPosn;
      end;
     
    procedure Register;
     
    implementation
     
    function TRCMemo.GetRow: Integer;
    begin
     
      Result := Perform(EM_LINEFROMCHAR, $FFFF, 0);
    end;
     
    procedure TRCMemo.SetRow(value: Integer);
    begin
     
      SelStart := GetCol + Perform(EM_LINEINDEX, Value, 0);
    end;
     
    function TRCMemo.GetCol: Integer;
    begin
     
      Result := SelStart - Perform(EM_LINEINDEX, GetRow, 0);
    end;
     
    procedure TRCMemo.SetCol(value: Integer);
    begin
     
      SelStart := Perform(EM_LINEINDEX, GetRow, 0) + Value;
    end;
     
    function TRCMemo.GetPosn: LongInt;
    var
      ro, co: Integer;
    begin
     
      ro := GetRow;
      co := SelStart - Perform(EM_LINEINDEX, ro, 0);
      Result := MakeLong(co, ro);
    end;
     
    procedure TRCMemo.SetPosn(value: LongInt);
    begin
     
      SelStart := Perform(EM_LINEINDEX, HiWord(Value), 0) + LoWord(Value);
    end;
     
    procedure Register;
    begin
     
      RegisterComponents('NJR', [TRCMemo]);
    end;
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
