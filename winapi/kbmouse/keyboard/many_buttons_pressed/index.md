---
Title: Если нажато более 2-х клавиш одновременно
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Если нажато более 2-х клавиш одновременно
=========================================

> I would like to detect more than 2 keys being pressed within a form.
> For example I would like to know if the user pressed time.
> The onkeydown seems to only check for one or two keys max but surely
> you can determine what keys are currently down.

You can use GetKeyState:
     
    procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    begin
      If ((GetKeyState(VK_CONTROL) AND 128)=128) and
         ((GetKeyState(VK_F5)      AND 128)=128) and
         ((GetKeyState(ord('8'))   AND 128)=128)
        then
          ShowMessage('CTRL+F5+8 Pressed');
    end;
     
    { Remember: Form1.Keypreview := TRUE }


Or you can read the entire KeyBoard Status,
and later check for the three keys:

    procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    var
       KeybState: TKeyboardState;
    begin
      GetKeyboardState(Teclado);
      If ( (KeybState[VK_CONTROL] and 128)=128 ) and
         ( (KeybState[VK_F5]      and 128)=128 ) and
         ( (KeybState[Ord('8')]   and 128)=128 )
        then
          ShowMessage('CTRL+F5+8 Pressed');
    end;

