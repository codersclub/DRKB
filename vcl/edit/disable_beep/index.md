---
Title: Как заставить TEdit не пикать при нажатии недопустимых клавиш?
Date: 01.01.2007
---


Как заставить TEdit не пикать при нажатии недопустимых клавиш?
==============================================================

Вариант 1:

Source: <https://forum.sources.ru>

Перехватите событие KeyPress и установите key = #0 для недопустимых
клавиш.

    procedure TForm1.Edit1KeyPress(Sender: TObject; var Key: Char);
    begin
      if ((UpCase(Key) < 'A') or (UpCase(Key) > 'Z')) then Key := #0;
    end; 


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    // Either disable the Beep in the OnKeyPress handler: 
     
    procedure TForm1.Edit1KeyPress(Sender: TObject; var Key: Char);
     begin
       if key = #13 then // #13 = Return 
      begin
         key := #0;
         // Code... 
      end;
     end;
     
    // Or in the OnKeyDown-Handler: 
     
    procedure TForm1.Edit1KeyDown(Sender: TObject; var Key: Word;
       Shift: TShiftState);
     var
       Mgs: TMsg;
     begin
       if Key = VK_RETURN then
         PeekMessage(Mgs, 0, WM_CHAR, WM_CHAR, PM_REMOVE);
     end;

