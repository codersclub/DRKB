---
Title: Как узнать состояние клавиши CAPS LOCK?
Date: 01.01.2007
---


Как узнать состояние клавиши CAPS LOCK?
=======================================

Вариант 1:

Source: <https://forum.sources.ru>

    function IsCapsLockOn : Boolean; 
    begin 
      Result := 0 <> (GetKeyState(VK_CAPITAL) and $01); 
    end;

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure AppOnIdle(Sender: TObject; var Done: Boolean);
     
    ...
     
    procedure TForm1.AppOnIdle(Sender: TObject; var Done: Boolean);
    begin
      CheckBox1.Checked := Odd(GetKeyState(VK_CAPITAL));
      CheckBox2.Checked := Odd(GetKeyState(VK_SHIFT));
      CheckBox3.Checked := Odd(GetKeyState(VK_NUMLOCK));
      CheckBox4.Checked := Odd(GetKeyState(VK_SCROLL));
      Done := False;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Application.OnIdle := AppOnIdle;
    end;

