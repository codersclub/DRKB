---
Title: Следование за мышкой в TMemo для установки позиции курсора
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Следование за мышкой в TMemo для установки позиции курсора
==========================================================

    procedure TForm1.Memo1MouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
    begin
      Memo1.SelStart  := LoWord(SendMessage(Memo1.Handle, EM_CHARFROMPOS, 0, MakeLParam(X, Y)));
      Memo1.SelLength := 0;
    end;

