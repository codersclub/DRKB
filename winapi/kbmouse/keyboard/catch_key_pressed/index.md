---
Title: Перехватить нажатие клавиши на клавиатуре
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Перехватить нажатие клавиши на клавиатуре
=========================================

Для того, чтобы перехватить нажатие какой-то клавиши на клавиатуре можно
использовать зарегистрированную "горячую клавишу" (HotKey). Эта
программа пикает при нажатии "1".

    ...
    private
      procedure WMHotKey(var Msg: TWMHotKey); message WM_HOTKEY;
    ...
    const
      MyHotKey = ord('1');
     
    procedure TForm1.WMHotKey(var Msg: TWMHotKey);
    begin
      MessageBeep(0);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      RegisterHotKey(Form1.Handle, MyHotKey, 0, MyHotKey);
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      UnRegisterHotKey(Form1.Handle, MyHotKey);
    end;


