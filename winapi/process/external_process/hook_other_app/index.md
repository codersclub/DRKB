---
Title: Как перехватывать события, посланные другим приложениям?
Date: 01.01.2007
Author: Даниил Карапетян <delphi4all@narod.ru>
Source: https://delphi4all.narod.ru
---

Как перехватывать события, посланные другим приложениям?
========================================================

Для отслеживания каких-то событий во всей Windows нужно установить
ловушку (hook).

Например, такая ловушка может отслеживать все события,
связанные с мышью, где бы ни находился курсор. Можно отслеживать и
события клавиатуры.

Для ловушки нужна функция, которая, после установки ловушки
при помощи SetWindowsHookEx, будет вызываться при каждом нужном событии.
Эта функция получает всю информацию о событии. UnhookWindowsHookEx
уничтожает ловушку.

Эта программа отслеживает все сообщения, связанные с мышью и
клавиатурой.

CheckBox1 показывает состояние левой клавиши мыши,  
CheckBox2 показывает состояние правой клавиши мыши,  
а CheckBox3 показывает, нажата ли какая-либо клавиша на клавиатуре.

    var
      HookHandle: hHook;
     
    function HookProc(Code: integer; WParam: word; LParam: Longint): Longint; stdcall;
    var
      msg: PEVENTMSG;
    begin
      if Code >= 0 then begin
        result := 0;
        msg := Pointer(LParam);
        with Form1 do
          case msg.message of
            WM_MOUSEMOVE: Caption := IntToStr(msg.ParamL) + #32 + IntToStr(msg.ParamH);
            WM_LBUTTONDOWN: CheckBox1.Checked := true;
            WM_LBUTTONUP: CheckBox1.Checked := false;
            WM_RBUTTONDOWN: CheckBox2.Checked := true;
            WM_RBUTTONUP: CheckBox2.Checked := false;
            WM_KEYUP: CheckBox3.Checked := false;
            WM_KEYDOWN: CheckBox3.Checked := true;
          end;
      end else
        result := CallNextHookEx(HookHandle, code, WParam, LParam);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Form1.FormStyle := fsStayOnTop;
      CheckBox1.Enabled := false;
      CheckBox1.Caption := 'left button';
      CheckBox2.Enabled := false;
      CheckBox2.Caption := 'right button';
      CheckBox3.Enabled := false;
      CheckBox3.Caption := 'keyboard';
      HookHandle := SetWindowsHookEx(WH_JOURNALRECORD, @HookProc, HInstance, 0);
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      if HookHandle <> 0 then
        UnhookWindowsHookEx(HookHandle);
    end;

