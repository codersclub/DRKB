---
Title: Эмулирование мыши / клавиатуры через SendInput()
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Эмулирование мыши / клавиатуры через SendInput()
================================================

    procedure TForm1.Button1Click(Sender: TObject);
     
    var
      TI:TInput;
      MI: TMouseInput;
      P:TPoint;
    begin
      GetCursorPos(P);
      MI.dx := P.X;
      MI.dy := P.Y;
      MI.mouseData := 0;
      MI.dwFlags := MOUSEEVENTF_RIGHTDOWN ;
      MI.time := 10;
      TI.mi := MI;
      TI.Itype := INPUT_MOUSE;
      SendInput(1, TI, SizeOf(TInput));
      MI.dwFlags:=MOUSEEVENTF_RIGHTUP;
      TI.mi := MI;
      SendInput(1, TI, SizeOf(TInput));
    end;

    procedure TForm1.Button1Click(Sender: TObject);
    const
      SomeText = 'SendInput test.';
    var
      TI: TInput;
      KI: TKeybdInput;
      I: Integer;
    begin
      Edit1.SetFocus;
      TI.Itype := INPUT_KEYBOARD;
      for I := 1 to Length(SomeText) do
      begin
        KI.wVk := Ord(UpCase(SomeText[I]));
        KI.dwFlags := 0;
        TI.ki := KI;
        SendInput(1, TI, SizeOf(TI));
        KI.dwFlags := KEYEVENTF_KEYUP;
        TI.ki := KI;
        SendInput(1, TI, SizeOf(TI));
      end;
    end;

