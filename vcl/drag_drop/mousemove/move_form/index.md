---
Title: Как таскать форму за метку?
Author: TAPAKAH
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как таскать форму за метку?
===========================

    procedure TForm1.Label1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
      const SC_DragMove = $F012; { a magic number }
     
    begin
      ReleaseCapture;
      Form1.perform(WM_SysCommand, SC_DragMove, 0);
    end;

