---
Title: Как использовать различные шрифты и стили в TMemo-объекте?
Date: 01.01.2007
---


Как использовать различные шрифты и стили в TMemo-объекте?
==========================================================

::: {.date}
01.01.2007
:::

Просто создайте собственный TxxxMemo: наследуйтесь от стандартного TMemo
и перекройте метод Paint.

Вот мой старый пример, изменяющий цвет каждой строки:

    unit Todrmemo;
    interface
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
     
    type
      TOwnerDrawMemo = class(TMemo)
      private
        { Private declarations }
        procedure WMPaint(var Message: TWMPaint); message WM_PAINT;
      protected
        { Protected declarations }
      public
        { Public declarations }
      published
        { Published declarations }
      end;
     
    procedure Register;
     
    implementation
     
    procedure TOwnerDrawMemo.WMPaint(var Message: TWMPaint);
    var
      Buffer: array[0..255] of Char;
      PS: TPaintStruct;
      DC: HDC;
      i: Integer;
      X, Y, Z: Word;
      OldColor: LongInt;
    begin
      DC := Message.DC;
      if DC = 0 then
        DC := BeginPaint(Handle, PS);
      try
        X := 1;
        Y := 1;
        SetBkColor(DC, Color);
        SetBkMode(DC, Transparent);
        OldColor := Font.Color;
        for i := 0 to Pred(Lines.Count) do
        begin
          if odd(i) then
            SetTextColor(DC, clRed)
          else
            SetTextColor(DC, OldColor);
          Z := Length(Lines[i]);
          StrPCopy(Buffer, Lines[i]);
          Buffer[Z] := #0; { реально не нужно }
          TextOut(DC, X, Y, Buffer, Z);
          Inc(Y, abs(Font.Height));
        end;
      finally
        if Message.DC = 0 then
          EndPaint(Handle, PS);
      end;
    end;
     
    procedure Register;
    begin
      RegisterComponents('Dr.Bob', [TOwnerDrawMemo]);
    end;
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
