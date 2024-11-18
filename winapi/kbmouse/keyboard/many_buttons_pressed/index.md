---
Title: Если нажато более 2-х клавиш одновременно
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Если нажато более 2-х клавиш одновременно
=========================================

> Я хотел бы отследить нажатие более 2 клавиш в форме.
> Например, я хотел бы узнать, нажал ли пользователь время.
> Событие Onkeydown, похоже, проверяет только одну или две клавиши максимум,
> но вы наверняка можете определить, какие клавиши в данный момент нажаты.

Вы можете использовать GetKeyState:
     
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


Или вы можете прочитать весь статус клавиатуры, а затем проверить три клавиши:

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

